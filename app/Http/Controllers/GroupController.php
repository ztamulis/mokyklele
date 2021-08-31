<?php

namespace App\Http\Controllers;

use App\Models\GroupMessage;
use App\Models\Student;
use App\Models\Group;
use App\Models\File;
use App\Models\Message;
use App\TimeZoneUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Mail;
use Cookie;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $groups= Group::where("id", ">", 0);
        if($request->input("search")){
            $groups= $groups->where("name", "LIKE", "%" . $request->input("search") . "%");
        }
        return view("dashboard.groups.index")->with("groups", $groups->paginate(15)->withQueryString());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.groups.create")->with("groups", Group::orderBy("weight", "ASC")->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
            'slots' => 'required|integer',
            'type' => 'required|string',
            'course_length' => 'required|integer|max:52|min:1',
            'time' => 'required',
        ]);

        $group = new Group;
        $group->name = $request->input("name");
        $group->display_name = $request->input("display_name");
        $group->description = $request->input("description");
        $group->information = $request->input("information");
        $group->price = $request->input("price");
        $group->slots = $request->input("slots");
        $group->type = $request->input("type");
        $group->paid = $request->input("paid");
        $group->course_length = $request->input("course_length");
        $group->hidden = $request->input("hidden") ? 1 : 0;

        $time = \Carbon\Carbon::parse(date("Y-m-d") . " " . $request->input("time"));

        if($request->input("time_2")){
            $time_2 = \Carbon\Carbon::parse(date("Y-m-d") . " " . $request->input("time_2"));
        }

        if($request->input("start_date")){
            $group->start_date = \Carbon\Carbon::parse($request->input("start_date"));
        }
        if($request->input("end_date")){
            $group->end_date = \Carbon\Carbon::parse($request->input("end_date"));
        }

        if(TimeZoneUtils::isSummerTime()){
            $time = $time->subHour();
            if(!empty($request->input("time_2"))){
                $time_2 = $time_2->subHour();
            }
        }
        $group->time = $time;
        if(empty($request->input("time_2"))){
            $group->time_2 = null;
        }else{
            $group->time_2 = $time_2;
        }
        $group->save();

        foreach($request->input("weight") as $w) {
            $arr = explode("|", $w);
            if($arr[1] == -1){
                $group->weight = $arr[0];
                $group->save();
            }else {
                $g = Group::find($arr[1]);
                $g->weight = $arr[0];
                $g->save();
            }
        }

        $group->stripe_plan = Str::slug("plan-".$group->id . "-" . $request->input("name"));

        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));

        \Stripe\Plan::create(array(
            "amount" => $group->price*100,
            "interval" => "week",
            "interval_count" => $group->course_length,
            "product" => array(
                "name" => $request->input("name")
            ),
            "currency" => "gbp",
            "id" => $group->stripe_plan
        ));

        $group->save();

        Session::flash('message', "Grupė sėkmingai pridėta");
        return Redirect::to('dashboard/groups');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {

        return view("dashboard.groups.show")->with("group", $group)->with("groups", Group::paginate(15));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.groups.edit")->with("group", $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
            'slots' => 'required|integer',
            'type' => 'required|string',
            'course_length' => 'required|integer|max:52|min:1',
            'time' => 'required',
        ]);

        if($request->input("start_date")){
            $group->start_date = \Carbon\Carbon::parse($request->input("start_date"))->format('Y-m-d H:i');
        }
        if($request->input("end_date")){
            $group->end_date = \Carbon\Carbon::parse($request->input("end_date"))->format('Y-m-d H:i');
        }

        $group->name = $request->input("name");
        $group->display_name = $request->input("display_name");
        $group->description = $request->input("description");
        $group->information = $request->input("information");
        $group->price = $request->input("price");
        $group->slots = $request->input("slots");
        $group->type = $request->input("type");
        $group->paid = $request->input("paid");
        $group->course_length = $request->input("course_length");
        $group->hidden = $request->input("hidden") ? 1 : 0;

        $time = \Carbon\Carbon::parse(date("Y-m-d") . " " . $request->input("time"));

        if(!empty($request->input("time_2"))){
            $time_2 = \Carbon\Carbon::parse(date("Y-m-d") . " " . $request->input("time_2"));
        }

        if(TimeZoneUtils::isSummerTime()){
            $time = $time->subHour();
            if(!empty($request->input("time_2"))){
                $time_2 = $time_2->subHour();
            }
        }
        $group->time = $time;
        if(empty($request->input("time_2"))){
            $group->time_2 = null;
        }else{
            $group->time_2 = $time_2;
        }
        $group->save();

        foreach($request->input("weight") as $w) {
            $arr = explode("|", $w);
            if($arr[1] == -1){
                $group->weight = $arr[0];
                $group->save();
            }else {
                $g = Group::find($arr[1]);
                $g->weight = $arr[0];
                $g->save();
            }
        }

        Session::flash('message', "Grupė sėkmingai atnaujinta");
        return Redirect::to('dashboard/groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $group->delete();

        Session::flash('message', "Grupė sėkmingai ištrinta");
        return Redirect::to('dashboard/groups');
    }

    public function createMessage(Request $request){
        $request->validate([
//            'text' => 'required|string|max:2000',
            'groupID' => 'required|int'
        ]);

        $gId = $request->input("groupID");
        $group = Group::find($gId);

        if(Auth::user()->role == "user" && !Auth::user()->checkGroup($gId)){
            //if(Auth::user()->role == "user" || !Auth::user()->checkGroup($gId)){
            return view("dashboard.groups.show")->with("message", "Žinutės išsiųsti nepavyko.")->with("group", $group)->with("groups", Group::paginate(2));
        }else {
            $group_message = new GroupMessage();
            $group_message->message = $request->input("text");
            $group_message->author_id = Auth::user()->id;
            $group_message->group_id = $gId;
            if($request->file("file")){
                $request->validate([
                    'file' => ['max:20000', 'mimes:doc,docx,xls,xlsx,pdf,ppt,pptx,jpg,jpeg,png,gif,mp4']
                ]);

                $file = $request->file("file");

                $newfilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "-" . Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

                $file->storeAs("uploads/group-messages", $newfilename);

                $group_message->file = $newfilename;
            }

            $group_message->save();

            $teachers = $this->getTeachersWithLessons($group);

            $html = "<p>Sveiki,<br>". Auth::user()->name. " ". Auth::user()->surname. "įkėlė naują pranešimą į pokalbius <br>";
            if (!empty($group_message->message)) {
                $html .= "Žinutė: ".$group_message->message;
            }
            if (!empty($group_message->file)) {
                $html .=  "<br>Prisegtas dokumentas: <a href='".\Config::get('app.url')."/uploads/group-messages/".$group_message->file."'>".\Config::get('app.url')."/uploads/group-messages/".$group_message->file."</a>";

            }
//            <br>Peržiūrėti galite čia: <a href='".\Config::get('app.url')."/dashboard/groups/".$request->input("group_id")."'>".\Config::get('app.url')."/dashboard/groups/".$group_message->group_id."</a>
            $html .="</p><p>Linkėjimai,<br>Pasakos komanda</p>";

            foreach($teachers as $email) {
                Mail::send([], [], function ($message) use ($html, $email, $group) {
                    $message
                        ->to($email)
                        ->subject("Pokalbiai | grupė: ".  $group->name)
                        ->setBody($html, 'text/html');
                });
            }

            return back()->with("message", "Žinutė sėkmingai išsiųsta")->with("group", $group)->with("groups", Group::paginate(15));
        }
    }

    public static function nextLesson($group){
        $event = $group->events()->where("date_at", ">" ,\Carbon\Carbon::now('utc')->subMinutes(120))->orderBy("date_at","ASC")->first();
        if(isset($event)){
            return $event;
        }
        return null;
    }

    public static function nextLessonButton($group){
        $event = $group->events()->where("date_at", "<" ,\Carbon\Carbon::now('utc')->addMinutes(10))->where("date_at", "<" ,\Carbon\Carbon::now('utc')->endOfDay())->where("date_at", ">" ,\Carbon\Carbon::now('utc')->startOfDay())->first();
//        dd(\Carbon\Carbon::now('UTC')->subMinutes(10)->toDateTimeString());
        if(isset($event)) {
            return $event;
        }
        return null;
    }

    private function getTeachersWithLessons($group) {
        if (empty($group->events())) {
            return [];

        }

        $lessons = $group->events()->where("date_at", ">" ,\Carbon\Carbon::now('utc'))->orderBy("date_at","ASC")->get();
        $teachers = [];
        foreach ($lessons as $lesson) {
            $teacher = $lesson->teacher()->first()->toArray();
            if (!isset($teachers[$teacher['id']]) && Auth::user()->id != $teacher['id']) {
                $teachers[$teacher['id']] = $teacher['email'];
            }
        }
        return $teachers;
    }

    public function editGroupHomework(Request $request, $id) {
        if(Auth::user()->role == "user"){
            return json_encode(["status" => "error", "message" => "Not allowed"]);
        }

        if (empty($request->input("message")) && (empty($request->file('file')) && !(bool)$request->input('oldFile'))) {
            return json_encode(["status" => "error", "message" => "Nieko neįvesta"]);

        }
        $originalFile = File::find($id);

        if(empty($originalFile)) {
            return json_encode(["status" => "error", "message" => "Byla nerasta."]);
        }
        if (!empty($originalFile->name) && !empty($request->file())) {
            $this->deleteHomeworkFile($originalFile);
            $file = $request->file('file');
            $file->storeAs("uploads", $file->getClientOriginalName());
            $filename = $file->getClientOriginalName();
            $originalFile->name = $filename;
        }

        if (empty($request->file()) && !empty($originalFile->name) && !$request->input('oldFile')) {
            $this->deleteHomeworkFile($originalFile);
            $originalFile->name = '';
        }

        if (!empty($request->file()) && empty($originalFile->name)) {
            $file = $request->file('file');
            $file->storeAs("uploads", $file->getClientOriginalName());
            $filename = $file->getClientOriginalName();
            $originalFile->name = $filename;

        }

        $originalFile->display_name = $request->input('message');

        if (empty($request->input('message'))) {
            $originalFile->display_name = ' ';
        }
        $originalFile->save();

        $studentBygroup = Student::where('group_id', '=', $request->input("group_id"))->get();
        $html = "<p>Sveiki,<br>". Auth::user()->name. " ". Auth::user()->surname. " pataisė namų darbus. <br>";
        if (!empty($originalFile->display_name)) {
            $html .= "Žinutė: ".$originalFile->display_name;
        }
        if (!empty($originalFile->name)) {
            $html .=  "Prisegtas dokumentas: <a href='".\Config::get('app.url')."/uploads/".$originalFile->name."'>".\Config::get('app.url')."/uploads/".$originalFile->name."</a>";
        }
//        <br>Peržiūrėti galite čia: <a href='".\Config::get('app.url')."/dashboard/groups/".$request->input("group_id")."'>".\Config::get('app.url')."/dashboard/groups/".$request->input("group_id")."</a>
        $html .= "</p><p>Linkėjimai,<br>Pasakos komanda</p>";
        foreach($studentBygroup as $student) {
            Mail::send([], [], function ($message) use ($html, $student, $originalFile) {
                $message
                    ->to($student->user->email)
                    ->subject("Namų darbai | grupė: ".  $student->group->name)
                    ->setBody($html, 'text/html');
            });
        }
        return json_encode(["status"=>"success", 'id' => $originalFile->id, 'name' => $originalFile->name]);
    }

    private function deleteHomeworkFile(File $file) {
        Storage::delete("uploads/".$file->name);
        return true;
    }

    private function deleteChatFile(GroupMessage $groupMessage) {
        Storage::delete("uploads/group-messages/".$groupMessage->file);
        return true;
    }

    public function uploadFile(Request $request){

        if(Auth::user()->role == "user"){
            return json_encode(["status" => "error", "message" => "Not allowed"]);
        }

        if (empty($request->input("file_name")) && empty($request->file('file'))) {
            return json_encode(["status" => "error", "message" => "Nieko neįvesta"]);

        }

        $file = $request->file('file');
        $fileObj = new File;
        $filename = '';
        if (!empty($file)) {
            $request->validate([
                'file' => ['max:20000', 'mimes:doc,docx,xls,xlsx,pdf,ppt,pptx,jpg,jpeg,png,gif,mp4']
            ]);
            $file->storeAs("uploads", $file->getClientOriginalName());
            $filename = $file->getClientOriginalName();
            $fileObj->name = $filename;
        }


        $fileObj->display_name = $request->input("file_name");
        $fileObj->group_id = $request->input("group_id");
        $fileObj->user_id = Auth::user()->id;
        $fileObj->save();
        $createdAt = $fileObj->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i");

        $fileObj->display_name = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $fileObj->display_name);


        $studentBygroup = Student::where('group_id', '=', $request->input("group_id"))->get();
        $html = "<p>Sveiki,<br>". Auth::user()->name. " ". Auth::user()->surname. " įkėlė namų darbus <br>";
        if (!empty($fileObj->display_name)) {
            $html .= "Žinutė: ".$fileObj->display_name;
        }
        if (!empty($fileObj->name)) {
            $html .=  "<br>Prisegtas dokumentas: <a href='".\Config::get('app.url')."/uploads/".$fileObj->name."'>".\Config::get('app.url')."/uploads/".$fileObj->name."</a>";

        }

//        <br>Peržiūrėti galite čia: <a href='".\Config::get('app.url')."/dashboard/groups/".$request->input("group_id")."'>".\Config::get('app.url')."/dashboard/groups/".$request->input("group_id")."</a>
        $html .= "</p><p>Linkėjimai,<br>Pasakos komanda</p>";

        foreach($studentBygroup as $student) {
            Mail::send([], [], function ($message) use ($html, $student) {
                $message
                    ->to($student->user->email)
                    ->subject("Namų darbai | grupė: ".  $student->group->name)
                    ->setBody($html, 'text/html');
            });
        }
        return json_encode(["status"=>"success", "date" => $createdAt, "file"=>$filename, "id" => $fileObj->id, "display_name" => $fileObj->display_name]);
    }

    public function deleteFile(Request $request, $id){
        if(Auth::user()->role == "user"){
            return json_encode(["status" => "error", "message" => "Not allowed"]);
        }

        $file = File::find($id);
        if(!$file) {
            return json_encode(["status" => "error", "message" => "Byla nerasta. (jau ištrinta?)"]);
        }

        Storage::delete("uploads/".$file->name);

        $file->delete();

        return json_encode(["status"=>"success","message"=>"Byla sėkmingai ištrinta."]);
    }

    public function deleteMessage(Request $request, $id){
//        if(Auth::user()->role == "user"){
//            return json_encode(["status" => "error", "message" => "Not allowed"]);
//        }

        $groupMessage = GroupMessage::find($id);
        if(!$groupMessage) {
            return json_encode(["status" => "error", "message" => "Žinutė nerasta. (jau ištrinta?)"]);
        }

        if($groupMessage->file){
            Storage::delete("uploads/group-messages/".$groupMessage->file);
        }

        $groupMessage->delete();

        return json_encode(["status"=>"success","message"=>"Žinutė sėkmingai ištrinta."]);
    }

    public function editMessage(Request $request, $id){

//        if(Auth::user()->role == "user"){
//            return json_encode(["status" => "error", "message" => "Not allowed"]);
//        }
        $originalGroupMessage = GroupMessage::find($id);
        if(!$originalGroupMessage) {
            return json_encode(["status" => "error", "message" => "Žinutė nerasta."]);
        }

        if (!empty($originalGroupMessage->file) && !empty($request->file())) {
            $this->deleteChatFile($originalGroupMessage);
            $file = $request->file('file');

            $file->storeAs("uploads/group-messages", $file->getClientOriginalName());
            $filename = $file->getClientOriginalName();
            $originalGroupMessage->file = $filename;
        }

        if (empty($request->file) && !empty($originalGroupMessage->file) && $request->input('chat-file') !== '1') {
            $this->deleteChatFile($originalGroupMessage);
            $originalGroupMessage->file = '';
        }

        if (!empty($request->file) && empty($originalGroupMessage->file)) {
            $file = $request->file('file');
            $file->storeAs("uploads/group-messages", $file->getClientOriginalName());
            $filename = $file->getClientOriginalName();
            $originalGroupMessage->file = $filename;
        }
        $originalGroupMessage->message = $request->input('message');
        if (empty($request->input('message'))) {
            $originalGroupMessage->message = '';

        }
        $originalGroupMessage->save();
        $group = Group::find($originalGroupMessage->group_id);
        $teachers = $this->getTeachersWithLessons($group);

        $html = "<p>Sveiki,<br>". Auth::user()->name. " ". Auth::user()->surname. " pataisė pranešimą į pokalbius <br>";
        if (!empty($originalGroupMessage->message)) {
            $html .= "Žinutė: ".$originalGroupMessage->message;
        }
        if (!empty($originalGroupMessage->file)) {
            $html .=  "<br>Prisegtas dokumentas: <a href='".\Config::get('app.url')."/uploads/group-messages/".$originalGroupMessage->file."'>".\Config::get('app.url')."/uploads/group-messages/".$originalGroupMessage->file."</a>";

        }

//       <br>Peržiūrėti galite čia: <a href='".\Config::get('app.url')."/dashboard/groups/".$request->input("group_id")."'>".\Config::get('app.url')."/dashboard/groups/".$originalGroupMessage->group_id."</a>
        $html .= "</p><p>Linkėjimai,<br>Pasakos komanda</p>";

        foreach($teachers as $email) {
            Mail::send([], [], function ($message) use ($html, $email, $group) {
                $message
                    ->to($email)
                    ->subject("Pokalbiai | grupė: ".  $group->name)
                    ->setBody($html, 'text/html');
            });
        }


        return back()->with("message", "Žinutė sėkmingai readaguota")->with("group", $group)->with("groups", Group::paginate(15));

    }

    public function message(Request $request) {
        $request->validate([
            'message' => 'required|string|max:2000',
            'user_id' => 'required|int',
            'user_from' => 'required|string|max:255'
        ]);

        $student = Student::find($request->input("user_id"));
        if(!$student || empty($student->user)){
            return json_encode(["status" => "error", "message" => "Mokinys nerastas."]);
        }

        $message = new Message;
        $message->message = "<b>Žinutė nuo " . $request->input("user_from") . ":</b><p>" . strip_tags($request->input("message")."</p>");
        $message->author_id = Auth::user()->id;
        if($request->file("file")){
            $request->validate([
                'file' => ['max:20000', 'mimes:doc,docx,xls,xlsx,pdf,ppt,pptx,jpg,jpeg,png,gif,mp4']
            ]);

            $file = $request->file("file");

            $newfilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "-" . Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

            $file->storeAs("uploads/messages", $newfilename);

            $message->file = $newfilename;
        }

        $message->user_id = $student->user->id;
        $message->seen = 0;

        $message->save();

        return json_encode(["status"=>"success","message"=>"Žinutė sėkmingai išsiųsta."]);
    }

    public function generateZoomSignature(Request $request) {
        $api_key = env("ZOOM_API_KEY");
        $api_secret = env("ZOOM_API_SECRET");
        $role = Auth::user()->role == "user" ? 0 : 1;
        $group_id = $request->input("group_id");

        //Set the timezone to UTC
        date_default_timezone_set("UTC");

        $time = time() * 1000 - 30000;//time in milliseconds (or close enough)

        $data = base64_encode($api_key . $group_id . $time . $role);

        $hash = hash_hmac('sha256', $data, $api_secret, true);

        $_sig = $api_key . "." . $group_id . "." . $time . "." . $role . "." . base64_encode($hash);

        //return signature, url safe base64 encoded
        return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
    }
}
