<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller  {

    public function index(Request $request) {
        $messages = Message::where('id', '>', 0);
        if($request->input("search")) {
            $messages = $messages->where(
                function ($query) use ($request) {
                    return $query->whereHas('author', function ($query) use ($request) {
                        return $query->where("email", "LIKE", "%" . $request->input("search") . "%");
                    });
                });
        } else {
            $messages = $messages->has('author');
        }

        $messages = $messages->where(
            function($query) {
                return $query
                    ->where('user_id', Auth::user()->id)
                    ->orWhere('author_id', Auth::user()->id);
            })
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('author_id');

        return view("dashboard.messages.index")->with("messages", $messages);
    }

    public function sentMessages(Request $request) {
        $messages = Auth::user()->sentMessages();
        if($request->input("search")) {
            $messages = $messages->where(
                function ($query) use ($request) {
                    return $query->whereHas('user', function ($query) use ($request) {
                        return $query->where("email", "LIKE", "%" . $request->input("search") . "%");
                    });
                });
        } else {
            $messages = $messages->has('user');
        }

        $messages = $messages->orderBy("created_at", "DESC")->groupBy('user_id');
        return view("dashboard.messages.sent")->with("messages", $messages->paginate(200)->withQueryString());
    }

    public function show(Message $message) {
        if($message->user_id != Auth::user()->id && $message->author_id != Auth::user()->id && Auth::user()->role != "admin")
            return view("dashboard.error")->with("error", "No permission");


        $this->seen($message);
        $messages = Message::whereRaw('(author_id = '.$message->author_id.' AND user_id = '.$message->user_id.') OR (author_id = '.$message->user_id.' AND user_id = '.$message->author_id.')')
            ->has('author')
            ->orderByDesc('created_at')
            ->get();

        return view("dashboard.messages.show")->with("messages", $messages);
    }

    public function create(Request $request)
    {
        return view("dashboard.messages.create")->with("users", MessageController::getAvailableRecipients());
    }

    /**
     * Destroy message
     * @param Message $message
     * @return mixed
     */
    public function destroy(Message $message)
    {
        $message->delete();
        $message = Message::where("user_id", Auth::user()->id);
        return view("dashboard.messages.index")->with("message", "??inut?? s??kmingai i??trinta")->with("messages", $message->get());
    }

    /**
     * Set message as seen
     * @param Message $message
     */
    public function seen(Message $message) {
        $messages = Message::where('user_id', Auth::user()->id)->where('author_id', $message->author_id)
            ->where('seen', 0)
            ->get();
        if (!empty($messages)) {
            foreach ($messages as $message) {
                $message->seen = 1;
                $message->save();
            }
        }
    }

    /**
     * @deprecated
     *
     * Send newsletter to users.
     *
     * @param Request $request
     * @return mixed
     */
    public function sendNew(Request $request){
        $request->validate([
            'text' => 'required|string|max:2000',
        ]);

        $html = $request->input("text");

        foreach(User::where("newsletter", 1)->get() as $user) {
            Mail::send([], [], function ($message) use ($html, $user) {
                $message
                    ->to($user->email)
                    ->subject("Mokykl??l??s Pasakos Naujienlai??kis")
                    ->setBody($html, 'text/html');
            });
        }

        return view("dashboard.messages.create")->with("message", "Naujienlai??kis i??si??stas!")->with("users", User::all());
    }


    /**
     * Send message to other user / users
     * @param Request $request
     * @return mixed
     */
    public function sendMessage(Request $request){
        $request->validate([
            'text' => 'required|string|max:65535',
            'check' => 'required'
        ]);

        $newfilename = null;

        if($request->file("file")){
            $request->validate([
                'file' => ['max:20000', 'mimes:doc,docx,xls,xlsx,pdf,ppt,pptx,jpg,jpeg,png,gif,mp4']
            ]);

            $file = $request->file("file");

            $newfilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "-" . Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

            $file->storeAs("uploads/messages", $newfilename);
        }
        
        foreach($request->input("check") as $userId) {
            if($userId != Auth::user()->id){
                $message = new Message;
                $message->message = $request->input("text");
                $message->file = $newfilename;
                $message->author_id = Auth::user()->id;
                $message->user_id = $userId;
                $message->seen = 0;

                $message->save();
            }else{
                Session::flash('message', "Tu??negali??si??sti??sau ??inut??s!");
                return Redirect::to('dashboard/messages/create');
            }
        }

        Session::flash('message', "??inut?? i??si??sta!");
        return Redirect::to('dashboard/messages/create');
    }

    /**
     * Get message count
     * @param int $seen
     * @return mixed
     */
    public static function unreadMessages($seen = 0){
        return Message::where("user_id", Auth::user()->id)->where("seen", $seen)->count();
    }

    /**
     * Get last user messages
     * @param int $l return limit
     * @return mixed
     */
    public static function messages($l=6){
        $messages = Message::where('user_id', Auth::user()->id)->orWhere('author_id', Auth::user()->id)
            ->has('author')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('author_id');
            $firstMessages = [];
            $key = 0;
            foreach($messages as $message) {
                $key++;
                if ($key > 5) {
                    break;
                }
                $firstMessages[] = $message[0];
            }
            $messages = $firstMessages;
        return $messages;
    }

    /**
     * Get all available recipients for current user.
     * @return mixed
     */
    public static function getAvailableRecipients() {
        $userIds = [];
        if(Auth::user()->role == "admin"){
            $userIds = User::pluck("id");
        }else{
            foreach (Auth::user()->getGroups() as $group) {
                foreach ($group->students as $student){
                    if($student->user && !in_array($student->user->id, $userIds)){
                        $userIds[] = $student->user->id;
                    }
                }
                foreach ($group->events as $event) {
                    if($event->teacher && is_object($event->teacher) && !in_array($event->teacher->id, $userIds)){
                        $userIds[] = $event->teacher->id;
                    }
                }
            }
            if(Auth::user()->role == "teacher") {
                foreach (User::where("role", "LIKE", "admin")->orWhere("role", "LIKE", "teacher")->get() as $user) {
                    if(!in_array($user->id, $userIds)){
                        $userIds[] = $user->id;
                    }
                }
            }
            if(Auth::user()->role !== "teacher") {
                $userIds = array_merge($userIds, User::where("role", "LIKE", "admin")->pluck('id')->toArray());
            }
        }
        return User::find($userIds);
    }

}
