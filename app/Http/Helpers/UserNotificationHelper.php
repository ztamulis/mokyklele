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


        $meetingHtml = '<p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Sveiki,</span></p>
<p dir="ltr" style="line-height:1.2;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">&nbsp;</p>
<p dir="ltr" style="line-height:1.2;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">ačiū, kad užsiregistravote į nemokamą Pasakos pamoką -&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">'.$group->color().'</span><span style="font-size:10pt;font-family:Arial;color:#f1c232;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">grupė. Primename, kad Jūsų pamoka vyks&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">rytoj,&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">'.$group->getWeekDayGramCase($dayOfWeekKey).',&nbsp;'.$firstEventDate->format('H:i').'</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">('.$user->time_zone.')</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">. Į pamoką pra&scaron;ome vaikų pasiimti savo mėgstamą žaislą, kad jį galėtų parodyti kitiems mokiniams ir mokytojai.&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Rekomenduojamos grupės pasiūlymą gausite per dvi dienas.</span>
</p>
<p dir="ltr" style="line-height:1.2;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">&nbsp;</p>
<p dir="ltr" style="line-height:1.2;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Savo</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<a href="https://mokyklelepasaka.lt/login" style="text-decoration:none;">
<span style="font-size:10pt;font-family:Arial;color:#1155cc;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Pasakos paskyroje</span>
</a>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">patogiai prisijungsite į pamoką spausdami žalią mygtuką&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">prisijungti (į pamoką).&nbsp;</span><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Tinklapyje pamokų valandos rodomos Jūsų vietos laiku, 24 valandų formatu</span></p>
<p dir="ltr" style="line-height:1.2;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">&nbsp;
</p>
<p dir="ltr" style="line-height:1.2;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial;color:#ff0000;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">SVARBU:</span><span style="font-size:10pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;pra&scaron;ome prane&scaron;ti i&scaron; anksto, jeigu negalite dalyvauti testinėje pamokoje &mdash; vietų skaičius ribotas, o laukiančių eilėje &mdash; daug! Taip pat pamokoje gali dalyvauti tik registruoti vaikai.</span>
</p>
<p dir="ltr" style="line-height:1.2;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
&nbsp;</p>
<p dir="ltr" style="line-height:1.44;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Taip pat kviečiame į susitikimą, kurio metu papasakosime apie kursą ir atsakysime į Jūsų klausimus.</span>
</p>
<p>
<span style="font-size:10pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Susitikimas vyks&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">sausio '.$meetingDate->format('d').' d.</span><span style="font-size:10pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">'.$meetingDate->format('H:i').' ('.$user->time_zone.')</span>
<span style="font-size:10pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">.&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Savo</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<a href="https://mokyklelepasaka.lt/login" style="text-decoration:none;"><span style="font-size:10pt;font-family:Arial;color:#1155cc;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Pasakos paskyroje</span></a>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">patogiai prisijungsite į susitikimą spausdami žalią mygtuką&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">prisijungti.</span>
</p>';
        return $meetingHtml;
    }

    public static function emailPaidLesson($group, $user) {
        \Carbon\Carbon::setLocale('lt');
        $firstEvent = $group->events()->orderBy('date_at', 'asc')->first();
        $firstEventDate = $firstEvent->date_at->setTimezone($user->time_zone);
        $dayOfWeekKey = $firstEventDate->dayOfWeek;
        $meetingDate = Carbon::parse('2022-01-22 17:30')->timezone('Europe/London')->setTimezone($user->time_zone);
        $html = '<p dir="ltr" style="line-height:2.0736;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Sveiki,&nbsp;</span>
</p>
<p dir="ltr" style="line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">nekantraujame pradėti pavasario kursą!</span>
</p>
<p dir="ltr" style="line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Jūsų&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">'.$group->color().'</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">pamoka prasidės&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">rytoj,</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">'.$group->getWeekDayGramCase($dayOfWeekKey).'</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">, '.$firstEventDate->format('H:i').'&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">('.$user->time_zone.')</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">.</span>
</p>
<p dir="ltr" style="line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">&nbsp;</p>
<p dir="ltr" style="line-height:1.44;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Savo</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<a href="https://mokyklelepasaka.lt/login" style="text-decoration:none;">
<span style="font-size:10pt;font-family:Arial;color:#1155cc;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Pasakos paskyroje</span>
</a>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">patogiai prisijungsite į pamoką spausdami žalią mygtuką&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">prisijungti (į pamoką).&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Tinklapyje pamokų valandos rodomos Jūsų vietos laiku, 24 valandų formatu</span>
<span style="font-size:10pt;font-family:Calibri,sans-serif;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
</p>
<p dir="ltr" style="line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">&nbsp;</p>
<p dir="ltr" style="line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Kviečiame į susirinkimą&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">tėvų / globėjų susirinkimą</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;apie pavasario kursą su Pasakos ugdymo vadovės asistentu Jonu. Susirinkimas vyks&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">sausio '.$meetingDate->format('d').' d.,&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">'.$meetingDate->format('H:i').' ('.$user->time_zone.')</span>
<span style="font-size:10pt;font-family:Arial;color:#ff00ff;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">.&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Savo</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<a href="https://mokyklelepasaka.lt/login" style="text-decoration:none;"><span style="font-size:10pt;font-family:Arial;color:#1155cc;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Pasakos paskyroje</span>
</a>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">patogiai prisijungsite į susitikimą spausdami žalią mygtuką&nbsp;</span>
<span style="font-size:11pt;font-family:Arial;color:#222222;background-color:#ffffff;font-weight:400;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">prisijungti.</span>
</p>
<p dir="ltr" style="line-height:2.0736;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
</p>
<p dir="ltr" style="line-height:2.0736;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Atmintinė tėvams:</span>
</p>
<p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">- kursas baigiasi balandžio 3-10 d.;</span>
</p>
<p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">-&nbsp;</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Pasakos paskyroje</span>
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;rasite prisijungimą į pamoką, mokytojos refleksiją, namų darbus;</span>
</p>
<p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">- labai pra&scaron;ome nevėluoti į pamoką, todėl prisijunkite keletą minučių anksčiau, i&scaron;bandykite interneto ry&scaron;į, sureguliuokite garsą ir mikrofoną;</span>
</p>
<p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;">
<span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">- jei vaikui yra daugiau nei 4 metai, pra&scaron;ome tėvelių pamokoje nedalyvauti, nors Jūsų vaikas ir nekalba lietuvi&scaron;kai. Vaikai geriausiai mokosi ir dalyvauja pamokoje, kai yra vieni;</span>
</p>
<p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">- pasirūpinkite, kad vaikas sėdėtų patogiai, pamoką stebėtų i&scaron; savo kambario, ramioje aplinkoje be pa&scaron;alinių trukdžių;</span></p>
<p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">- į pamoką mokinys turėtų visada atsine&scaron;ti sąsiuvinį, ra&scaron;iklį, spalvotų pie&scaron;tukų;</span></p>';
        if ($group->type === 'blue') {
            $html .='<p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:0pt 0pt 11pt 0pt;"><span style="font-size:10pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">-&nbsp;</span><span style="font-size:10pt;font-family:Arial;color:#0000ff;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">mėlynų</span><span style="font-size:10pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;grupių mokiniams kartais gali prireikti papildomo įrenginio (telefono, plan&scaron;etės), kai žaidžiamas interaktyvus žaidimas;</span></p>';
        }
        if ($group->type ==='red') {
            $html .= '- raudonų grupių mokiniams kartais gali prireikti papildomo įrenginio (telefono, planšetės), kai žaidžiamas interaktyvus žaidimas;';
        }
        $html .= '<p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">- jei pamokėlėse tuo pačiu metu dalyvauja keli Jūsų vaikai,&nbsp;</span><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">rekomenduojame prisijungti i&scaron; skirtingų įrenginių</span><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">;</span></p>
        <p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">- jei po kelių pamokų Jums atrodo, kad</span><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;vaikui per sunku ar per lengva</span><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">, susisiekite su mumis - pasistengsime pasiūlyti alternatyvą.</span></p>
        <p dir="ltr" style="line-height:1.7999999999999998;text-align: justify;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:0pt 0pt 11pt 0pt;"><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">- informuokite (</span><span style="font-size:10pt;font-family:Arial;color:#1155cc;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">labas@mokyklelepasaka.com</span><span style="font-size:10pt;font-family:Arial;color:#222222;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">) apie Jūsų vaiko specialiuosius poreikius, pvz., autizmo spektras, disleksija, hiperaktyvumas ir kt. Mokytojai atitinkamai pasiruo&scaron; pamokoms.</span></p>';
        return $html;
    }

}