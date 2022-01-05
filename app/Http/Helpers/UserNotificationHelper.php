<?php


namespace App\Http\Helpers;


use Carbon\Carbon;

class UserNotificationHelper {


    public static function emailFreeLesson($group, $user) {
        \Carbon\Carbon::setLocale('lt');
        $firstEvent = $group->events()->orderBy('date_at', 'asc')->first();
        $firstEventDate = $firstEvent->date_at->setTimezone($user->time_zone);
        $dayOfWeekKey = $firstEventDate->dayOfWeek;

        $meetingDate = Carbon::parse('2022-01-16 17:30')->timezone('Europe/London')->setTimezone($user->time_zone);
        $meetingHtml = '<p>Sveiki,</p>
<p>ačiū, kad užsiregistravote į nemokamą&nbsp;Pasakos pamoką - <strong>'.$group->color().' </strong>grupė. Primename, kad Jūsų pamoka vyks <strong>rytoj, </strong>
<strong>'.$group->getWeekDayGramCase($dayOfWeekKey).',&nbsp;'.$firstEventDate->format('H:i').'</strong>
<strong>('.$user->time_zone.')</strong>. Į pamoką pra&scaron;ome vaikų pasiimti savo mėgstamą žaislą, kad jį galėtų parodyti kitiems mokiniams ir mokytojai. 
<span style="text-decoration: underline;">Rekomenduojamos grupės pasiūlymą gausite per dvi dienas</span>.</p>
<p>Savo <a href="https://mokyklelepasaka.lt/login">Pasakos paskyroje</a>patogiai prisijungsite į pamoką spausdami žalią mygtuką <em>prisijungti (į pamoką). </em><span style="text-decoration: underline;">Tinklapyje pamokų valandos rodomos Jūsų vietos laiku, 24 valandų formatu</span>.</p>
<p><strong>SVARBU:</strong> pra&scaron;ome prane&scaron;ti i&scaron; anksto, jeigu negalite dalyvauti testinėje pamokoje &mdash; vietų skaičius ribotas, o laukiančių eilėje &mdash; daug! Pamokoje gali dalyvauti tik registruoti vaikai.</p>
<p>Taip pat kviečiame į susitikimą, kurio metu papasakosime apie kursą ir atsakysime į Jūsų klausimus.</p>
<p>Susitikimas vyks <strong>sausio '.$meetingDate->format('d').' d.</strong><strong>'.$meetingDate->format('H:i').' ('.$user->time_zone.')</strong>. Savo <a href="https://mokyklelepasaka.lt/login">Pasakos paskyroje</a> patogiai prisijungsite į susitikimą spausdami žalią mygtuką <em>prisijungti.</em></p>';
        return $meetingHtml;

    }

    public static function emailPaidLesson($group, $user) {
        \Carbon\Carbon::setLocale('lt');
        $firstEvent = $group->events()->orderBy('date_at', 'asc')->first();
        $firstEventDate = $firstEvent->date_at->setTimezone($user->time_zone);
        $dayOfWeekKey = $firstEventDate->dayOfWeek;
        $meetingDate = Carbon::parse('2022-01-22 17:30')->timezone('Europe/London')->setTimezone($user->time_zone);
        $html = '<p>Sveiki,&nbsp;</p>
<p>nekantraujame pradėti pavasario kursą!</p>
<p>Jūsų <strong>'.$group->color().'&nbsp;</strong>pamoka prasidės <strong>rytoj,&nbsp;</strong><strong>'.$group->getWeekDayGramCase($dayOfWeekKey).' </strong><strong>, '.$firstEventDate->format('H:i').' </strong>('.$user->time_zone.').</p>
<p>Savo&nbsp;<a href="https://mokyklelepasaka.lt/login">Pasakos paskyroje</a>&nbsp;patogiai prisijungsite į pamoką spausdami žalią mygtuką <em>prisijungti (į pamoką). </em><span style="text-decoration: underline;">Tinklapyje pamokų valandos rodomos Jūsų vietos laiku, 24 valandų formatu</span>.&nbsp;</p>
<p>Kviečiame į susirinkimą <strong>tėvų / globėjų susirinkimą</strong> apie pavasario kursą su Pasakos ugdymo vadovės asistentu Jonu. Susirinkimas vyks <strong>sausio '.$meetingDate->format('d').' d., </strong><strong>'.$meetingDate->format('H:i').' ('.$user->time_zone.')</strong>. Savo&nbsp;<a href="https://mokyklelepasaka.lt/login">Pasakos paskyroje</a>&nbsp;patogiai prisijungsite į susitikimą spausdami žalią mygtuką <em>prisijungti.</em></p>
<p><strong>Atmintinė tėvams:</strong></p>
<p>- kursas baigiasi balandžio 3-10 d.;</p>
<p>- <strong>Pasakos paskyroje</strong> rasite prisijungimą į pamoką, mokytojos refleksiją, namų darbus;</p>
<p>- labai pra&scaron;ome nevėluoti į pamoką, todėl prisijunkite keletą minučių anksčiau, i&scaron;bandykite interneto ry&scaron;į, sureguliuokite garsą ir mikrofoną;</p>
<p>- jei vaikui yra daugiau nei 4 metai, pra&scaron;ome tėvelių pamokoje nedalyvauti, nors Jūsų vaikas ir nekalba lietuvi&scaron;kai. Vaikai geriausiai mokosi ir dalyvauja pamokoje, kai yra vieni;</p>
<p>- pasirūpinkite, kad vaikas sėdėtų patogiai, pamoką stebėtų i&scaron; savo kambario, ramioje aplinkoje be pa&scaron;alinių trukdžių;</p>
<p>- į pamoką mokinys turėtų visada atsine&scaron;ti sąsiuvinį, ra&scaron;iklį, spalvotų pie&scaron;tukų;</p>';
        if ($group->type === 'blue') {
            $html .= '<p>- <strong>mėlynų</strong> grupių mokiniams kartais gali prireikti papildomo įrenginio (telefono, plan&scaron;etės), kai žaidžiamas interaktyvus žaidimas;</p>';
        }
        if ($group->type ==='red') {
            $html .= '<p>- <strong>raudonų</strong> grupių mokiniams kartais gali prireikti papildomo įrenginio (telefono, plan&scaron;etės), kai žaidžiamas interaktyvus žaidimas;</p>';
        }
        $html .= '<p>- jei pamokėlėse tuo pačiu metu dalyvauja keli Jūsų vaikai, <span style="text-decoration: underline;">rekomenduojame prisijungti i&scaron; skirtingų įrenginių</span>;</p>
<p>- jei po kelių pamokų Jums atrodo, kad<strong> vaikui per sunku ar per lengva</strong>, susisiekite su mumis - pasistengsime pasiūlyti alternatyvą.</p>
<p><span style="text-decoration: underline;">- informuokite (labas@mokyklelepasaka.com) apie Jūsų vaiko specialiuosius poreikius, pvz., autizmo spektras, disleksija, hiperaktyvumas ir kt. Mokytojai atitinkamai pasiruo&scaron; pamokoms</span>.</p>';
        return $html;
    }

    public function emailFreeLessonAdults($group, $user) {
        \Carbon\Carbon::setLocale('lt');
        $firstEvent = $group->events()->orderBy('date_at', 'asc')->first();
        $firstEventDate = $firstEvent->date_at->setTimezone($user->time_zone);
        $dayOfWeekKey = $firstEventDate->dayOfWeek;
        return '<div>Thank you for booking a free lesson with Pasaka. We cannot wait to see you at the lesson!<br /><br />Your booking details:&nbsp;<br />Free lesson for adults</div>
<div><strong>Wednesdays (X)</strong></div>
<div>The lesson will start on&nbsp;<strong>'.$firstEventDate->format('m-d').'</strong></div>
<div>Time of the lesson:&nbsp;<strong>'.$firstEventDate->format('H:i').' ('.$user->time_zone.')<br /></strong><br />Use your Pasaka account to&nbsp;access your online classes&nbsp;(click the button \'prisijungti į pamoką\'), homework and chat with other members.<br /><br />See you soon!</div>';

    }





}