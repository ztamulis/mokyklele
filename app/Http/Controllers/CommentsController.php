<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditRequest;
use App\Http\Requests\SaveRequest;
use App\Models\File;
use App\Models\User;
use Auth;
use Config;
use DomainException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use tizis\laraComments\Entity\Comment;
use tizis\laraComments\Http\Requests\GetRequest;
use tizis\laraComments\Http\Resources\CommentResource;
use tizis\laraComments\UseCases\CommentService;
use tizis\laraComments\UseCases\VoteService;
use Illuminate\Contracts\Encryption\DecryptException;

class CommentsController extends Controller
{
	use AuthorizesRequests;

	protected $commentService;
	protected $voteService;
	protected $policyPrefix;

	/**
	 * CommentsController constructor.
	 * @param VoteService $voteService
	 */
	public function __construct(VoteService $voteService) {
		$this->middleware(['web', 'auth'], ['except' => ['get']]);
		$this->policyPrefix = config('comments.policy_prefix');
		$this->voteService = $voteService;
	}

	/**
	 * Creates a new comment for given model.
	 * @param SaveRequest $request
	 * @return array|RedirectResponse
	 * @throws AuthorizationException
	 */
	public function store(SaveRequest $request) {
		$this->authorize($this->policyPrefix . '.store');

		try {
			$decryptedModelData = decrypt($request->commentable_encrypted_key);
			$commentableId = $decryptedModelData['id'];
			$modelPath = $decryptedModelData['type'];

		} catch (DecryptException $e) {
			throw new DomainException('Decryption error');
		}

		if (!CommentService::modelIsExists($modelPath)) {
			throw new DomainException('Model don\'t exists');
		}

		if (!CommentService::isCommentable(new $modelPath)) {
			throw new DomainException('Model is\'t commentable');
		}

		$model = $modelPath::findOrFail($commentableId);

		$comment = CommentService::createComment(
			new Comment(),
			Auth::user(),
			$model,
			CommentService::htmlFilter($request->message)
		);
        $file = request()->file('file');
        if (!empty($file)) {
            $filename = $file->hashName();

            $newfilename = pathinfo($filename, PATHINFO_FILENAME) . "-" . \Illuminate\Support\Facades\Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

            $file->storeAs(\App\Models\Comment::$FILE_PATH, $newfilename);
            $comment->file = $newfilename;
            $comment->save();
        }


        $this->SendNotificationEmail($comment);
        return $request->ajax()
			? [
				'success' => true,
				'comment' => new CommentResource($comment)
			]
			: redirect()->to(url()->previous() . '#comment-' . $comment->id);
	}

	/**
	 * @param GetRequest $request
	 * @return array
	 */
	public function get(GetRequest $request): array
	{
		$decryptedModelData = decrypt($request->commentable_encrypted_key);

		$modelId = $decryptedModelData['id'];
		$modelPath = $decryptedModelData['type'];

		$orderBy = CommentService::orderByRequestAdapter($request);

		if (!CommentService::modelIsExists($modelPath)) {
			throw new DomainException('Model don\'t exists');
		}

		if (!CommentService::isCommentable(new $modelPath)) {
			throw new DomainException('Model is\'t commentable');
		}

		$model = $modelPath::where('id', $modelId)->first();

		return [
			'success' => true,
			'comments' => CommentResource::collection(
				$model->commentsWithChildrenAndCommenter()
					->parentless()
					->orderBy($orderBy['column'], $orderBy['direction'])
					->get()
			),
			'count' => $model->commentsWithChildrenAndCommenter()->count()
		];
	}

	/**
	 * @param Comment $comment
	 * @param Request $request
	 * @return array
	 */
	public function show(Comment $comment, Request $request): array
	{
		return [
			'comment' => $request->input('raw') ? $comment : new CommentResource($comment)
		];
	}

	/**
	 * Updates the message of the comment.
	 * @param EditRequest $request
	 * @param Comment $comment
	 * @return array|RedirectResponse
	 * @throws AuthorizationException
	 */
	public function update(EditRequest $request, Comment $comment)
	{
		$this->authorize($this->policyPrefix . '.edit', $comment);

		CommentService::updateComment(
			$comment,
			CommentService::htmlFilter($request->message)
		);
        $file = request()->file('file');

        if($comment->file && !empty($request->file())
            || $comment->file && empty(request()->file()) && !request()->input('oldFile')) {
            Storage::delete(\App\Models\Comment::$FILE_PATH.$comment->file);
            $comment->file = '';
            $comment->save();
        }

        if (!empty($file)) {
            $filename = $file->hashName();

            $newfilename = pathinfo($filename, PATHINFO_FILENAME) . "-" . \Illuminate\Support\Facades\Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs(\App\Models\Comment::$FILE_PATH, $newfilename);
            $comment->file = $newfilename;
            $comment->save();
        }
        $this->SendNotificationEmail($comment);

		return $request->ajax()
			? ['success' => true, 'comment' => new CommentResource($comment)]
			: redirect()->to(url()->previous() . '#comment-' . $comment->id);
	}

	/**
	 * Deletes a comment.
	 * @param Request $request
	 * @param Comment $comment
	 * @return array|RedirectResponse
	 * @throws AuthorizationException
	 */
	public function destroy(Request $request, Comment $comment)
	{
		$this->authorize($this->policyPrefix . '.delete', $comment);

        if($comment->file){
            Storage::delete(\App\Models\Comment::$FILE_PATH.$comment->file);
        }

		try {
			CommentService::deleteComment($comment);
			$response = response(['message' => 'success']);
		} catch (DomainException $e) {
			$response = response(['message' => $e->getMessage()], 401);
		}
        if (json_decode($response->content())->message === 'Comment has replies') {
            Session::flash('message', 'Komentaras turi atsakym??.');
            Session::flash('alert-class', 'alert-danger');
        }

		if ($request->ajax()) {
			return $response;
		}

		return redirect()->back();
	}

    /**
     * Reply to comment
     *
     * @param Request $request
     * @param Comment $comment
     * @return array|RedirectResponse
     * @throws AuthorizationException
     */
	public function reply(Request $request, Comment $comment)
	{
		$this->authorize($this->policyPrefix . '.reply', $comment);
		$reply = CommentService::createComment(
			new Comment(),
			Auth::user(),
			$comment->commentable,
			CommentService::htmlFilter($request->message),
			$comment
		);

        $file = request()->file('file');

        if (!empty($file)) {
            $filename =  preg_replace('/\s+/', '_', $file->getClientOriginalName());

            $newfilename = pathinfo($filename, PATHINFO_FILENAME) . "-" . \Illuminate\Support\Facades\Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

            $file->storeAs(\App\Models\Comment::$FILE_PATH, $newfilename);
            $reply->file = $newfilename;
            $reply->save();
        }
        $this->SendNotificationEmail($reply);


		return $request->ajax()
			? ['success' => true, 'comment' => new CommentResource($reply)]
			: redirect()->to(url()->previous() . '#comment-' . $reply->id);
	}


    private function SendNotificationEmail($record) {
        $file = File::where('id', $record->commentable_id)->first();

        $commenters[] = $file->user_id;
        $groupName = $file->group()->first()->name;
        $html = "<p>Sveiki,<br> Po J??s?? ??ra??u grup??je ".$groupName." yra naujas komentaras:<br>
         Autorius:  ".Auth::user()->name ." ". Auth::user()->surname."<br>";

        if (!empty($record->comment)) {
            $html .= "??inut??: ".$record->comment;
        }
        if (!empty($record->file)) {
            $html .=  "<br>Prisegtas dokumentas: <a href='". Config::get('app.url')."/uploads/homework-comments".$record->file."'>". Config::get('app.url')."/uploads/homework-comments".$record->file."</a>";

        }


        $html .="<br>Per??i??r??ti galite ??ia: <a href='". Config::get('app.url')."/dashboard/groups/".$file->group()->first()->slug. "#comment-". $record->id."'>". Config::get('app.url')."/dashboard/groups/".$file->group()->first()->slug."</a>
            </p><p>Link??jimai<br>Pasakos komanda</p>";
        $user = User::where('id', $file->user_id)->where('id', '!=', Auth::user()->id)->first();
        if (!empty($user->email)) {
            Mail::send([], [], function ($message) use ($html, $user, $groupName) {
                $message
                    ->to($user->email)
//                    ->to('zygintas.tamulis@gmail.com')
                    ->subject("Komentaras | grup??: ".  $groupName)
                    ->setBody($html, 'text/html');
            });
        }
    }

}
