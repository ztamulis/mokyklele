<?php


namespace App\Http\Traits;


use App\Models\Group;
use App\Models\UserNotifications;
use Carbon\Carbon;

trait CheckoutEmailsTrait
{

    private function sendCheckoutSessionSucceededUserMessage($group, $user) {
        $timezone = \Cookie::get("user_timezone", "GMT");
        if (!empty($user->time_zone)) {
            $timezone = $user->time_zone;
        }


        $groupData = $group->getGroupStartDateAndCount();
        if (isset($groupData['startDate'])) {
            $startDate = \Carbon\Carbon::parse($groupData['startDate'])->format("m.d");
        } else {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->start_date)->format("m.d");
        }

        $email_title = "Registracijos patvirtinimas";
        $email_content = "<p>Sveiki,<br>".
            "džiaugiamės, kad prisijungsite prie Pasakos pamokų!<br>".
            "Jūsų detalės apačioje:<br>".
            $group->name."<br>".
            $group->display_name." ".$group->time->timezone($timezone)->format("H:i")." (".$timezone.")<br>".
            "Kursas vyks  ". $startDate." - ". \Carbon\Carbon::parse($group->end_date)->format("m.d")." (".$group->course_length." sav.)<br>".
            "Savo <a href='".\Config::get('app.url')."/login'>Pasakos paskyroje</a> patogiai prisijungsite į pamokas, rasite namų darbus ir galėsite bendrauti su kitais nariais. </p>".
            "<p>Iki pasimatymo,<br> Pasakos komanda </p>";

        \Mail::send([], [], function ($message) use ($email_title, $email_content, $user) {
            $message
                ->to($user->email)
                ->subject($email_title)
                ->setBody($email_content, 'text/html');
        });
    }

    private function getRegisterFreeUserMessage($group, $user) {

        $timezone = \Cookie::get("user_timezone", "GMT");
        if (!empty($user->time_zone)) {
            $timezone = $user->time_zone;
        }


        $email_title = "Registracijos į nemokamą pamoką patvirtinimas";
        $email_content = "<p>Sveiki,<br>".
            "ačiū, kad registravotės į nemokamą Pasakos pamoką! Jūsų nemokamos pamokos detalės čia:<br>".
            $group->name."<br>".
            $group->display_name." ".$group->time->timezone($timezone)->format("H:i")." (".$timezone.")<br>".
            "Į pamoką prisijungsite iš savo <a href='".\Config::get('app.url')."/login'>Pasakos paskyros</a>.</p>".
            "<p>Grupes tolimesniam mokymuisi skirstome ne tik pagal amžių, bet ir pagal kalbos mokėjimo lygį - taip galime užtikrinti, kad mokiniai pasieks geriausių rezultatų ir drąsiau jausis pamokoje.<br>".
            "Nemokamos pamokos metu mokytoja įvertins vaiko kalbos mokėjimo lygį ir vėliau mes pasiūlysime tinkamiausią grupę jūsų vaikui.<br>".
            "<small>Jei negalėsite dalyvauti pamokoje, labai prašome iš anksto pranešti - vietų skaičius ribotas, o norinčiųjų daug!</small></p>".
            "<p>Iki pasimatymo,<br> Pasakos komanda </p>";

        return [
            'email_title' => $email_title,
            'email_content' => $email_content,
        ];
    }

    private function sendOrderConfirmAdminEmail($group, $student_names, $student_birthDays, $user) {
        $teachers = $this->getTeachersWithLessons($group);
        $email_title_admin = "Kurso užsakymas";
        if ($group->paid) {
            $paid = 'Taip';
        } else {
            $paid = 'Ne';
        }
        $time = $group->time->timezone('Europe/London')->format("H:i");

        $groupData = $group->getGroupStartDateAndCount();
        if (isset($groupData['startDate'])) {
            $startDate = \Carbon\Carbon::parse($groupData['startDate'])->format('Y-m-d');
        } else {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->start_date)->format('Y-m-d');
        }

        $email_content_admin = "<h1>Kurso užsakymas</h1><p> Klientas ".  $user->name. " " .$user->surname .
            "<br> El. paštas: ".$user->email.
            "<br>Grupė: ".$group->name .
            "<br>Grupės ID: ".$group->id .
            "<br>Grupės tipas: ".$group->type .
            "<br>Mokama: ".$paid .
            "<br>Skirta: ".Group::$FOR_TRANSLATE[$group->age_category] .
            "<br>laikas: ".$time .
            "<br>Pradžia: ".$startDate .
            "<br>Mokytoja(-os): ".join(" ", $teachers).
            " <br>Vaikas(-ai): ".join(" ", $student_names).
            " <br>Amžius: ".join(" ", $student_birthDays).
            ".</p>";

        \Mail::send([], [], function ($message) use ($email_title_admin, $email_content_admin, $user) {
            $message
                ->to(\Config::get('app.email'))
                ->subject($email_title_admin)
                ->setBody($email_content_admin, 'text/html');
        });
    }

    private function getTeachersWithLessons($group) {
        if (empty($group->events())) {
            return [];

        }
        $lessons = $group->events()->where("date_at", ">" ,\Carbon\Carbon::now('utc'))->orderBy("date_at","ASC")->get();
        $teachers = [];
        foreach ($lessons as $lesson) {
            $teacher = $lesson->teacher()->first()->toArray();
            if (!isset($teachers[$teacher['id']])) {
                $teachers[$teacher['id']] = $teacher['name'] . ' ' . $teacher['surname'];
            }
        }
        return $teachers;
    }

}