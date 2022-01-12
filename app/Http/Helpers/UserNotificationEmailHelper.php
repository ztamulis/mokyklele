<?php


namespace App\Http\Helpers;


use App\Models\Group;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;

class UserNotificationEmailHelper {
    public static function getFinishedEmail(
        Group $group,
        User $user,
        string $emailType,
        ?Meeting $meeting,
        string $emailContent
    ) {
        \Carbon\Carbon::setLocale('lt');
        $firstEvent = $group->events()->orderBy('date_at', 'asc')->first();
        $firstEventDate = $firstEvent->date_at->setTimezone($user->time_zone);
        $dayOfWeekKey = $firstEventDate->dayOfWeek;
        $emailContent = str_replace('{grupe}', $group->color(), $emailContent);
        $emailContent = str_replace('{grupes-savaites-diena}', $group->getWeekDayGramCase($dayOfWeekKey), $emailContent);
        $emailContent = str_replace('{pamokos-laikas}', $firstEventDate->format('H:i'), $emailContent);
        $emailContent = str_replace('{vartotojo-laiko-juosta}', $user->time_zone, $emailContent);
        $emailContent = str_replace('{grupe-kilmininko-linksnis}', $group->getGroupTypeGenitiveCase(), $emailContent);
        $emailContent = str_replace('{pamokos-diena-angliskai}', $firstEventDate->formatLocalized('%A'), $emailContent);

        if (!empty($meeting)) {
            $meetingDate = Carbon::parse($meeting->date_at)->timezone('Europe/London')
                ->setTimezone($user->time_zone);

            $emailContent = str_replace('{susitikimo-menesis-kilmininkas}', $group->getMonthGenitiveCase($firstEventDate->month), $emailContent);
            $emailContent = str_replace('{susitikimo-diena-skaicius}', $meetingDate->format('d'), $emailContent);
            $emailContent = str_replace('{susitikimo-valanda}', $meetingDate->format('H:i'), $emailContent);
        }

        return $emailContent;

    }

    public static function getEmailFreeLessonGreenAndYellow($group, $user) {
        \Carbon\Carbon::setLocale('lt');
        $firstEvent = $group->events()->orderBy('date_at', 'asc')->first();
        $firstEventDate = $firstEvent->date_at->setTimezone($user->time_zone);
        $dayOfWeekKey = $firstEventDate->dayOfWeek;
        $meetingDate = Carbon::parse('2022-01-16 17:30')->timezone('Europe/London')
            ->setTimezone($user->time_zone);
        return '<div>
<p dir="ltr">Sveiki,</p>
<p dir="ltr">ačiū, kad užsiregistravote į nemokamą&nbsp;Pasakos pamoką - <strong>'.$group->color().'</strong>
 grupė. Primename, kad Jūsų pamoka vyks <strong>rytoj, '.$group->getWeekDayGramCase($dayOfWeekKey).',&nbsp;'.$firstEventDate->format('H:i').' ('.$user->time_zone.')</strong>.</p>
<ul>
<li>Į pamoką pra&scaron;ome vaikų pasiimti savo mėgstamą žaislą, kad jį galėtų parodyti kitiems mokiniams ir mokytojai. <span style="text-decoration: underline;">Rekomenduojamos grupės pasiūlymą gausite per dvi dienas</span>.</li>
<li>Savo <a href="https://mokyklelepasaka.lt/login" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://mokyklelepasaka.lt/login&amp;source=gmail&amp;ust=1641552815053000&amp;usg=AOvVaw3-Up1lurE8d8JJ2q-y4xBT">Pasakos paskyroje</a> patogiai prisijungsite į pamoką spausdami žalią mygtuką <em>prisijungti (į pamoką)</em>. <span style="text-decoration: underline;">Tinklapyje pamokų valandos rodomos Jūsų vietos laiku, 24 valandų formatu</span>.</li>
<li><strong>SVARBU</strong>: pra&scaron;ome prane&scaron;ti i&scaron; anksto, jeigu negalite dalyvauti testinėje pamokoje &mdash; vietų skaičius ribotas, o laukiančių eilėje &mdash; daug! Taip pat pamokoje gali dalyvauti tik registruoti vaikai.</li>
</ul>
<p dir="ltr">Taip pat kviečiame į susitikimą, kurio metu papasakosime apie kursą ir atsakysime į Jūsų klausimus. Susitikimas vyks 
<strong>sausio '.$meetingDate->format('d').' d. '.$meetingDate->format('H:i').' ('.$user->time_zone.')</strong>. Savo <a href="https://mokyklelepasaka.lt/login" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://mokyklelepasaka.lt/login&amp;source=gmail&amp;ust=1641552815054000&amp;usg=AOvVaw39ZM0d7k3hruDGTQGqdQeX">Pasakos paskyroje</a> patogiai prisijungsite į susitikimą spausdami žalią mygtuką <em>prisijungti</em>.</p>
</div>
<div>Tai yra automatinis lai&scaron;kas. Jei kils klausimų&nbsp;lauksime&nbsp;lai&scaron;kų į&nbsp;<a href="mailto:labas@mokyklelepasaka.com" target="_blank">labas@mokyklelepasaka.com</a>.&nbsp;</div>';
    }

    public static function getEmailFreeLessonBlueAndRed($group, $user) {
        \Carbon\Carbon::setLocale('lt');
        $firstEvent = $group->events()->orderBy('date_at', 'asc')->first();
        $firstEventDate = $firstEvent->date_at->setTimezone($user->time_zone);
        $dayOfWeekKey = $firstEventDate->dayOfWeek;
        $meetingDate = Carbon::parse('2022-01-16 17:30')->timezone('Europe/London');
        return '<p dir="ltr">Sveiki,</p>
<p dir="ltr">ačiū, kad užsiregistravote į nemokamą&nbsp;Pasakos pamoką - <strong>'.$group->color().'&nbsp;</strong>grupė. Primename, kad Jūsų pamoka vyks 
<strong>rytoj, '.$group->getWeekDayGramCase($dayOfWeekKey).',&nbsp;'.$firstEventDate->format('H:i').' ('.$user->time_zone.')</strong>.</p>
<ul>
<li>Vaikų pra&scaron;ome pamokoje turėti dar vieną papildomą įrenginį, nes bus žaidžiama viktorina (pavyzdžiui, į pamoką jungtis per kompiuterį, bet dar su savimi turėti telefoną ar plan&scaron;etę).</li>
<li><span style="text-decoration: underline;">Rekomenduojamos grupės pasiūlymą gausite per dvi dienas</span>.</li>
<li>Savo <a href="https://mokyklelepasaka.lt/login" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://mokyklelepasaka.lt/login&amp;source=gmail&amp;ust=1641556708130000&amp;usg=AOvVaw32J9BoZ-xpzO5O_B7b2HEv">Pasakos paskyroje</a> patogiai prisijungsite į pamoką spausdami žalią mygtuką <em>prisijungti (į pamoką)</em>. <span style="text-decoration: underline;">Tinklapyje pamokų valandos rodomos Jūsų vietos laiku, 24 valandų formatu</span>.</li>
<li><strong>SVARBU</strong>: pra&scaron;ome prane&scaron;ti i&scaron; anksto, jeigu negalite dalyvauti testinėje pamokoje &mdash; vietų skaičius ribotas, o laukiančių eilėje &mdash; daug! Taip pat pamokoje gali dalyvauti tik registruoti vaikai.</li>
</ul>
<p dir="ltr">Taip pat kviečiame į susitikimą, kurio metu papasakosime apie kursą ir atsakysime į Jūsų klausimus. Susitikimas vyks 
<strong>sausio '.$meetingDate->format('d').' d. '.$meetingDate->format('H:i').' ('.$user->time_zone.')</strong>. Savo <a href="https://mokyklelepasaka.lt/login" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://mokyklelepasaka.lt/login&amp;source=gmail&amp;ust=1641556708130000&amp;usg=AOvVaw32J9BoZ-xpzO5O_B7b2HEv">Pasakos paskyroje</a> patogiai prisijungsite į susitikimą spausdami žalią mygtuką prisijungti.</p>
<div>Tai yra automatinis lai&scaron;kas. Jei kils klausimų&nbsp;lauksime&nbsp;lai&scaron;kų į&nbsp;<a href="mailto:labas@mokyklelepasaka.com" target="_blank">labas@mokyklelepasaka.com</a>.&nbsp;</div>';
    }


    public static function getEmailPaidLesson($group, $user) {
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

    public function getEmailFreeLessonAdults($group, $user) {
        \Carbon\Carbon::setLocale('lt');
        $firstEvent = $group->events()->orderBy('date_at', 'asc')->first();
        $firstEventDate = $firstEvent->date_at->setTimezone($user->time_zone);
        return '<div>
<div>Hello,<br />&nbsp;<br />Thank you for booking a free lesson at Pasaka! A gentle reminder - your class is tomorrow,&nbsp;<strong>'.$firstEventDate->formatLocalized('%A').' at '.$firstEventDate->format('H:i').' ('.$user->time_zone.').&nbsp;</strong></div>
<div>
<ul>
<li>Please bring one additional device to your lesson (either a smartphone or a tablet) - you will need this for a quiz (learning lithuanian with us is fun!).</li>
<li>To join the class log&nbsp;in&nbsp;your&nbsp;<a href="http://www.mokyklelepasaka.com/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.mokyklelepasaka.com&amp;source=gmail&amp;ust=1641556708130000&amp;usg=AOvVaw0v_wis83m4aHxxkeoTTmDD">Pasaka</a>&nbsp;account and press the green button ( "join the lesson"). Class hours on the website are displayed in your local time in a 24-hour format.</li>
<li>We will send you an email with a recommended group offer within two days.</li>
</ul>
</div>
<div>All the best,</div>
<div>Pasaka&nbsp;</div>
</div>';
    }





}