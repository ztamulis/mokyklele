<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Group;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Config;
use Mail;

class BilingualismConsultationController extends Controller {
    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function show(string $slug) {

        return view("dashboard.consultations.show")->with("group", Group::where('slug', $slug)->first());
    }

    public function uploadFile(Request $request) {
        $groupId = $request->input("group_id");
        $group = Group::where('id', $request->input("group_id"))->first();
        if (Auth::user()->role == "user") {
            Session::flash('message', 'Neturite teisių');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back()->with("group", $group)->with("groups", Group::paginate(15));
        }
        $displayText = $request->input("file_name");
        if (empty($displayText) && empty($request->file('file'))) {
            Session::flash('message', 'Laukeliai tušti!');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back()->with("group", $group)->with("groups", Group::paginate(15));
        }

        Log::info('konsultacijos upload upload');
        Log::info('user id', ['user' => Auth::user()->id]);
        Log::info(Carbon::now()->format('Y-m-d H:i:s'));
        Log::info('failas', ['file' => $request->file('file')]);
        Log::info('grupes_id', ['file' => $request->input("group_id")]);
        Log::info('textas', ['text' => $displayText]);


        $file = $request->file('file');

        $fileObj = new File;
        if (!empty($file)) {
            $request->validate([
                'file' => ['max:20000', 'mimes:doc,docx,xls,xlsx,pdf,ppt,pptx,jpg,jpeg,png,gif,mp4,txt'],
            ]);
            $filename = $file->hashName();
            Log::info('failas', ['filename' => $filename]);

            $file->storeAs("uploads", $filename);
            $fileObj->name = $filename;
        }


        $fileObj->display_name = $displayText;
        $fileObj->group_id = $groupId;
        $fileObj->user_id = Auth::user()->id;
        $fileObj->save();


        $studentBygroup = Student::where('group_id', '=', $request->input("group_id"))->get();
        $html = "<p>Sveiki,<br>".Auth::user()->name." ".Auth::user()->surname." įkėlė informacijos į konsultacijos užsiėmimus. <br>";
        if (!empty($fileObj->display_name)) {
            $html .= "Žinutė: ".$fileObj->display_name;
        }
        if (!empty($fileObj->name)) {
            $html .= "<br>Prisegtas dokumentas: <a href='".Config::get('app.url')."/uploads/".$fileObj->name."'>".Config::get('app.url')."/uploads/".$fileObj->name."</a>";

        }

        $html .= "<br>Peržiūrėti ir atsakyti mokytojai galite čia: <a href='".Config::get('app.url')."/dashboard/groups/consultations/".$fileObj->group()->first()->slug."'>".Config::get('app.url')."/dashboard/groups/consultations/".$fileObj->group()->first()->slug."</a>
        </p><p>Linkėjimai<br>Pasakos komanda</p>";
//        dd($request->input(), $request->file(), $studentBygroup);

        foreach ($studentBygroup as $student) {
            $studentGroup = $student->group()->where('id', $request->input("group_id"))->first();
            $groupName = $studentGroup->name;
            $student = $student->user()->first();
            if (empty($student)) {
                continue;
            }
            $email = $student->email;
            $html = stripslashes($html);
            Mail::send([], [], function ($message) use ($html, $groupName, $email) {
                $message
                    ->to($email)
                    ->subject("Konsultacija informacija | grupė: ".$groupName)
                    ->setBody($html, 'text/html; charset=UTF-8');
            });
        }
        Session::flash('message', 'Konsultacijos informacija patalpinta!');
        Session::flash('alert-class', 'alert-success');
        return Redirect::to(url()->previous().'#content');
    }

    /**
     * @param  File  $file
     * @return bool
     */
    private function deleteHomeworkFile(File $file) {
        Log::info('delete file');
        Log::info('Delete file id', ['id' => $file->id]);
        Log::info('Delete file name', ['id' => $file->name]);
        Log::info('Delete file group id', ['id' => $file->group_id]);
        Storage::delete("uploads/".$file->name);
        return true;
    }

    public function deleteFile(Request $request, $id) {
        $group = Group::where('id', $request->input("group_id"))->first();

        if (Auth::user()->role == "user") {
            Session::flash('message', 'Neturite teisių');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back()->with("group", $group)->with("groups", Group::paginate(15));
        }

        $file = File::find($id);
        if (!$file) {
            Session::flash('message', 'Byla nerasta!');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::to(url()->previous().'#content')->with("group", $group);
        }

        Storage::delete("uploads/".$file->name);

        $file->delete();

        Session::flash('message', 'Informacija ištrinta!');
        Session::flash('alert-class', 'alert-success');
        return Redirect::to(url()->previous().'#content')->with("group", $group);
    }

    /**
     * @param  Request  $request
     * @param $id
     * @return RedirectResponse
     */
    public function editGroupHomework(Request $request, $id) {
        $group = Group::where('id', $request->input("group_id"))->first();
        if (empty($request->input("file_name")) && (empty($request->file('file')) && !(bool) $request->input('oldFile'))) {
            Session::flash('message', 'Nieko neįvesta!');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back()->with("group", $group);

        }
        $originalFile = File::find($id);
        Log::info('konsultacijos edit');
        Log::info('file id', ['fileId' => $id]);
        Log::info('user id', ['user' => Auth::user()->id]);

        if (empty($originalFile)) {
            Session::flash('message', 'Byla nerasta.');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back()->with("group", $group)->with("groupMessage", false);
        }

        Log::info('senas failas', ['text' => $originalFile->name]);

        if (!empty($originalFile->name) && !empty($request->file('file'))) {
            $this->deleteHomeworkFile($originalFile);
            $file = $request->file('file');
            $filename = $file->hashName();
            $file->storeAs("uploads", $filename);
            $originalFile->name = $filename;
        }

        if (empty($request->file('file')) && !empty($originalFile->name) && !$request->input('oldFile')) {
            $this->deleteHomeworkFile($originalFile);
            $originalFile->name = '';
        }

        if (!empty($request->file('file')) && empty($originalFile->name)) {
            $file = $request->file('file');
            $filename = $file->hashName();

            $file->storeAs("uploads", $filename);
            $originalFile->name = $filename;

        }
        Log::info(Carbon::now()->format('Y-m-d H:i:s'));
        Log::info('failas', ['file' => $request->file('file')]);
        Log::info('naujas failas', ['file' => $request->file('file')]);
        Log::info('grupes_id', ['file' => $request->input("group_id")]);
        $originalFile->display_name = $request->input('file_name');

        if (empty($request->input('file_name'))) {
            $originalFile->display_name = ' ';
        }

        $originalFile->save();

        $studentBygroup = Student::where('group_id', '=', $request->input("group_id"))->get();
        $html = "<p>Sveiki,<br>".Auth::user()->name." ".Auth::user()->surname." pataisė konsultacijų informaciją. <br>";
        if (!empty($originalFile->display_name)) {
            $html .= "Žinutė: ".$originalFile->display_name;
        }
        if (!empty($originalFile->name)) {
            $html .= "Prisegtas dokumentas: <a href='".Config::get('app.url')."/uploads/".$originalFile->name."'>".Config::get('app.url')."/uploads/".$originalFile->name."</a>";
        }
        $html .= "<br>Peržiūrėti ir atsakyti mokytojai galite čia: <a href='".Config::get('app.url')."/dashboard/groups/consultations/".$originalFile->group()->first()->slug."'>".Config::get('app.url')."/dashboard/groups/consultations/".$originalFile->group()->first()->slug."</a>
        </p><p>Linkėjimai<br>Pasakos komanda</p>";
        foreach ($studentBygroup as $student) {
            Mail::send([], [], function ($message) use ($html, $student, $originalFile) {
                $message
                    ->to($student->user->email)
                    ->subject("Namų darbai | grupė: ".$student->group->name)
                    ->setBody($html, 'text/html');
            });
        }
        Session::flash('message', 'Informacija readaguota sėkmingai.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->to(url()->previous().'#homework-file-main-'.$originalFile->id);
    }
}
