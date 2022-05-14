@extends("layouts.landing")

@section("title", "Pavasario kursas")

@section("content")

    <div class="landing--col--even-1">
        <img src="images/landing/p.webp">
    </div>
    <div class="landing--col--even-2">
        <h1>Pavasario kursas</h1>
        <p>
            Ar pasiruošę patirti nuotykius ir atrasti lietuvių kalbą žaismingai?<br>
            Prisijunkite prie mūsų 14 savaičių kurso, kurio metu vaikai lavins lietuvių kalbos kalbėjimo, rašymo ir skaitymo įgūdžius, mokysis gramatikos linksmai per šiuolaikinę lietuvišką literatūrą, muziką bei interaktyvius žaidimus. <a href="#register">Registruotis</a>
        </p>
    </div>
    <div class="clear"></div>
    <p>
        - Vyresni vaikai kartu gaus EMA elektroninių pratybų prisijungimą, kur rinks taškus už įveiktas užduotis<br>
        - Kurso viduryje bei pabaigoje tėvai turės individualų virtualų susitikimą su Pasakos ugdymo vadove Egle, kurio metu aptars vaiko progresą bei pristayts tolimesnį mokymosi planą<br>
        - Visiems <b>Pasakos</b> mokiniams dovanojame susitikimus su Lietuvos kūrėjais, kad pažintis su Lietuva būtų dar įdomesnė! <a href="/susitikimai">Daugiau apie tai čia</a>
    </p>
    <div class="learning--group--select--wrapper">
        <div class="learning--group--select--title">
            <h2>Išsirinkite grupę</h2>
            <b>Svarbu:</b> Visų pamokų laikas nurodomas Didžiosios Britanijos laiku (GMT)
        </div>
        <div class="learning--group--select--selector">
            <div class="learning--group--select--item active" data-filter="yellow">
                Geltona (2-4m.)
            </div>
            <div class="learning--group--select--item" data-filter="green">
                Žalia (5-6m.)
            </div>
            <div class="learning--group--select--item" data-filter="blue">
                Mėlyna (7-9m.)
            </div>
            <div class="learning--group--select--item" data-filter="red">
                Raudona (10-13m.)
            </div>
            <div class="learning--group--select--item" data-filter="individual">
                Individualios pamokos
            </div>
        </div>
        <div id="loadCourses" data-vvveb-disabled>
            {{--@foreach(\App\Models\Group::where("type", "NOT LIKE", "free")->get() as $group)
            <div class="learning--group--select--row" data-group="{{ $group->type }}">
                <div class="color background--{{ $group->type }}"></div>
                <div class="text">
                    <a href="/select-group/{{ $group->id }}">{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "Europe/London"))->format("H:i") }}</b></a><br>
                    <span>{{ $group->display_name }}</span>
                </div>
                <div class="price">
                    £{{ $group->price }}
                </div>
                <div class="actions">
                    <a href="/select-group/{{ $group->id }}" class="button">
                        Pasirinkti
                    </a>
                </div>
            </div>
            @endforeach--}}
        </div>
    </div>
    <div class="landing--col--even-1">
        <h2>Kada vyksta pamokos?</h2>
        <p>
            Pamokos vyksta kartą per savaitę, pamokos trukmė – 30-40min.
            <br>
            Pamokų laikas visada nurodomas Didžiosios Britanijos laiku (GMT).
        </p>
        <p>
            Pavasario kurse pamokų Šv.Velykų savaitgalį (balandžio 3-4d.) nebus.
        </p>
        <p>
            <a href="/apie-pamokas">Daugiau apie pamokas →</a>
        </p>
    </div>
    <div class="landing--col--even-2">
        <h2>Kalbos mokėjimo lygiai</h2>
        <p>
            Siekdami geriausio mokymosi rezultato, vyresnius nei 4 metų vaikus į grupes skirstome pagal kalbos mokėjimo lygį. <span class="color--green">Žalias</span> grupes skirstome į:
            <br>
            1 lygis - nekalba lietuviškai
            2 lygis - kalba ir mokosi skaityti
            <span class="color--blue">Mėlynas</span> ir <span class="color--red">raudonas</span> grupes skirstome į:
            1 lygis - nekalba lietuviškai
            2 lygis - kalba lietuviškai
            3 lygis - kalba ir skaito lietuviškai
        </p>
    </div>
    <div class="clear"></div>
    <div class="landing--col--even-1">
        <h2>Kiek kainuoja pamokos?</h2>
        <p>
            Kurso (14 pamokų) kaina – £119
        </p>
        <p>
            Praleidus pamoką, ji nėra nukeliama, sustabdyti kurso jo eigoje galimybės nėra.
        </p>
    </div>
    <div class="landing--col--even-2">
        <h2>
            Turiu daugiau nei vieną vaiką. Ar reikia mokėti už kiekvieno vaiko pamokas?
        </h2>
        <p>
            Jeigu broliai/sesės yra toje pačioje <b>Pasakos</b> klasėje (grupės skirstomos pagal amžių), mokėti reikės tik už vieną vaiką.
        </p>
    </div>
    <div class="clear"></div>
    <h2 class="content--title">Netinka nei vienas siūlomas laikas?</h2>
    <p class="text--center"><a href="/kontaktai">Susisiekime</a> ir mes padarysime viską, ką galime, kad surastume jums tinkamiausią pamokų laiką.</p>

    <script>
        function filterBy(group) {
            $("[data-group]").hide();
            $("[data-group='"+group+"']").show();
            $("[data-filter]").removeClass("active");
            $("[data-filter='"+group+"']").addClass("active");
        }
        $("[data-filter]").click(function () {
            filterBy($(this).attr("data-filter"));
        });
        filterBy("yellow");

        $(document).ready(function() {
            $("#loadCourses").load( "courses" );
        });
    </script>
@endsection