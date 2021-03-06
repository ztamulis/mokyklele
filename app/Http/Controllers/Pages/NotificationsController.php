<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Introduction;
use App\Models\Meeting;
use App\Models\SettingsModels\NotificationEmailContent;
use App\Models\UserNotifications;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class NotificationsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
        if (Auth::user()->role == "user") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $notifications = UserNotifications::where("id", ">", 0);
        if ($request->input("search")) {
            $notifications = $notifications->where("email", "LIKE", "%".$request->input("search")."%");
        }

        $notifications = $notifications->has('group')->orderBy("send_from_time", "ASC");
        return view("dashboard.cms-pages.notifications.index")->with("notifications",
            $notifications->paginate(15)->withQueryString());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.meetings_public.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return void
     */
    public function store(Request $request) {

    }

    /**
     * Display the specified resource.
     *
     * @param  Introduction  $introduction
     * @return void
     */
    public function show(Introduction $introduction) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  NotificationEmailContent  $notificationEmailContent
     * @return Response
     */
    public function edit(NotificationEmailContent $notificationEmailContent) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $meetings = Meeting::where('date_at', '>', Carbon::now())->get();
        return view("dashboard.cms-pages.notifications.edit")->with("notificationEmailContent",
            $notificationEmailContent)
            ->with("meetings", $meetings);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  NotificationEmailContent  $notificationEmailContent
     * @return Factory|View|RedirectResponse
     */
    public function update(Request $request, NotificationEmailContent $notificationEmailContent) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }


        $notificationEmailContent->free_lesson_yellow_and_green = (string) $request->input("free_lesson_yellow_and_green");
        $notificationEmailContent->free_lesson_yellow_and_green_meeting_id = $request->input("free_lesson_yellow_and_green_meeting_id");
        $notificationEmailContent->free_lesson_yellow_and_green_subject = $request->input("free_lesson_yellow_and_green_subject");


        $notificationEmailContent->free_lesson_red_and_blue = (string) $request->input("free_lesson_red_and_blue");
        $notificationEmailContent->free_lesson_red_and_blue_meeting_id = $request->input("free_lesson_red_and_blue_meeting_id");
        $notificationEmailContent->paid_lesson_red_and_blue_subject = $request->input("paid_lesson_red_and_blue_subject");


        $notificationEmailContent->free_lesson_adults = (string) $request->input("free_lesson_adults");
        $notificationEmailContent->free_lesson_adults_meeting_id = $request->input("free_lesson_adults_meeting_id");
        $notificationEmailContent->free_lesson_adults_subject = $request->input("free_lesson_adults_subject");

        $notificationEmailContent->paid_lesson_yellow_and_green = (string) $request->input("paid_lesson_yellow_and_green");
        $notificationEmailContent->paid_lesson_yellow_and_green_meeting_id = (string) $request->input("paid_lesson_yellow_and_green_meeting_id");
        $notificationEmailContent->paid_lesson_yellow_and_green_subject = $request->input("paid_lesson_yellow_and_green_subject");

        $notificationEmailContent->paid_lesson_red_and_blue = $request->input("paid_lesson_red_and_blue");
        $notificationEmailContent->paid_lesson_red_and_blue_subject = $request->input("paid_lesson_red_and_blue_subject");
        $notificationEmailContent->paid_lesson_red_and_blue_meeting_id = $request->input("paid_lesson_red_and_blue_meeting_id");


        $notificationEmailContent->paid_lesson_adults = $request->input("paid_lesson_adults");
        $notificationEmailContent->paid_lesson_adults_meeting_id = $request->input("paid_lesson_adults_meeting_id");
        $notificationEmailContent->paid_lesson_adults_subject = $request->input("paid_lesson_adults_subject");

        $notificationEmailContent->bilingualism_consultation_subject = $request->input("bilingualism_consultation_subject");
        $notificationEmailContent->bilingualism_consultation_meeting_id = $request->input("bilingualism_consultation_meeting_id");
        $notificationEmailContent->bilingualism_consultation = $request->input("bilingualism_consultation");

        $notificationEmailContent->save();

        Session::flash('message', "Laiškai sėkmingai atnaujinti");
        return Redirect::to('dashboard/reminders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Factory|View|RedirectResponse
     */
    public function destroy(int $id) {
        $userNotifications = UserNotifications::findOrFail($id);
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $userNotifications->delete();
        Session::flash('message', "Automatinis laiškas sėkmingai ištrintas");
        return Redirect::to('dashboard/reminders');
    }
}
