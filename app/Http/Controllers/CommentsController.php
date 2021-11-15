<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditRequest;
use App\Http\Requests\SaveRequest;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
	 * @return array|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function store(SaveRequest $request) {
		$this->authorize($this->policyPrefix . '.store');

		try {
			$decryptedModelData = decrypt($request->commentable_encrypted_key);
			$commentableId = $decryptedModelData['id'];
			$modelPath = $decryptedModelData['type'];

		} catch (DecryptException $e) {
			throw new \DomainException('Decryption error');
		}

		if (!CommentService::modelIsExists($modelPath)) {
			throw new \DomainException('Model don\'t exists');
		}

		if (!CommentService::isCommentable(new $modelPath)) {
			throw new \DomainException('Model is\'t commentable');
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

            $newfilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "-" . \Illuminate\Support\Facades\Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

            $file->storeAs(\App\Models\Comment::$FILE_PATH, $newfilename);
            $comment->file = $newfilename;
            $comment->save();
        }

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
			throw new \DomainException('Model don\'t exists');
		}

		if (!CommentService::isCommentable(new $modelPath)) {
			throw new \DomainException('Model is\'t commentable');
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
	 * @return array|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function update(EditRequest $request, Comment $comment)
	{
		$this->authorize($this->policyPrefix . '.edit', $comment);

		CommentService::updateComment(
			$comment,
			CommentService::htmlFilter($request->message)
		);

        if($comment->file){
            Storage::delete(\App\Models\Comment::$FILE_PATH.$comment->file);
        }

        $file = request()->file('file');
        if (!empty($file)) {
            $newfilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "-" . \Illuminate\Support\Facades\Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs(\App\Models\Comment::$FILE_PATH, $newfilename);
            $comment->file = $newfilename;
            $comment->save();
        }
		return $request->ajax()
			? ['success' => true, 'comment' => new CommentResource($comment)]
			: redirect()->to(url()->previous() . '#comment-' . $comment->id);
	}

	/**
	 * Deletes a comment.
	 * @param Request $request
	 * @param Comment $comment
	 * @return array|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
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
		} catch (\DomainException $e) {
			$response = response(['message' => $e->getMessage()], 401);
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
	 * @return array|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @throws \Illuminate\Validation\ValidationException
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
            $newfilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "-" . \Illuminate\Support\Facades\Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

            $file->storeAs(\App\Models\Comment::$FILE_PATH, $newfilename);
            $reply->file = $newfilename;
            $reply->save();
        }

		return $request->ajax()
			? ['success' => true, 'comment' => new CommentResource($reply)]
			: redirect()->to(url()->previous() . '#comment-' . $reply->id);
	}

}
