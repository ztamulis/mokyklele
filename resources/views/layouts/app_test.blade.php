<!DOCTYPE html>
<html>
<head>
    <title>@yield("title") Mokykėlė pasaka</title>

    <link rel="stylesheet" type="text/css" href="/css/landing.css">
    <link href="http://pagination.js.org/dist/2.1.5/pagination.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome5-overrides.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="wrapper">

    <header>
        <div class="logo">
            <a href="/">
                <img src="/images/web_logo.webp" alt="logo">
            </a>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="/apie-pamokas">
                        Apie pamokas
                        <div class="dropdown">
                            <ul>
                                <li>
                                    <a href="/pavasario-kursas">Pavasario kursas</a>
                                </li>
                                <li>
                                    <a href="/kaina">Kaina</a>
                                </li>
                            </ul>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/susitikimai">
                        Susitikimai
                    </a>
                </li>
                <li>
                    <a href="/nemokama-pamoka">
                        Nemokama pamoka
                    </a>
                </li>
                <li>
                    <a href="/komanda">
                        Komanda
                    </a>
                </li>
                <li>
                    <a href="/kontaktai">
                        Kontaktai
                    </a>
                </li>
                <li>
                    @if(Auth::check())
                        <a href="/dashboad">
                            Valdymas
                        </a>
                    @else
                        <a href="/login">
                            Prisijungti
                        </a>
                    @endif
                </li>
            </ul>
        </nav>
        <div class="clear"></div>
    </header>

    <section class="navigation">
        <ul>
            <li class="nav-item"><a class="nav-link @if(Request::is('dashboard')) active @endif " href="/dashboard"><i class="fas fa-tachometer-alt"></i><span>Pagrindinis puslapis</span></a></li>
            @if(Auth::user()->role == "admin")
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/attendance')) active @endif " href="/dashboard/attendance"><i class="fa fa-bell"></i><span>Lankomumas</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/events*')) active @endif " href="/dashboard/events"><i class="fa fa-calendar"></i><span>Užsiėmimai</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/announcements')) active @endif " href="/dashboard/announcements"><i class="fa fa-newspaper-o"></i><span>Rašyti žinutę / naujienlaiškį</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/groups*')) active @endif " href="/dashboard/groups"><i class="fa fa-users"></i><span>Grupių valdymas</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/users*')) active @endif " href="/dashboard/users"><i class="fa fa-user-md"></i><span>Naudotojų valdymas</span></a></li>
                {{--<li class="nav-item"><a class="nav-link @if(Request::is('dashboard/navbar')) active @endif " href="/dashboard/navbar"><i class="fa fa-navicon"></i><span>Meniu juosta</span></a></li>--}}
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/wbuilder')) active @endif " href="/dashboard/wbuilder"><i class="fa fa-database"></i><span>Redaguoti puslapius</span></a></li>
            @endif
            <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/profile')) active @endif " href="/dashboard/profile"><i class="fas fa-user"></i><span>Mano paskyra</span></a></li>
        </ul>
    </section>

    <div class="main--content">
        {{ $slot }}
    </div>

    <footer>
        <div class="footer--wrapper">
            <ul>
                <li><b>Pasaka Ltd.</b></li>
                <li><a href="/kontaktai">Kontaktai</a></li>
                <li><a href="/privatumo-politika">Privatumo politika</a></li>
                <li><a href="/zoom-naudojimas">Kaip naudotis Zoom?</a></li>
                <li><a href="/nemokama-pamoka">Registruotis nemokamai pamokai</a></li>
                <li><a href="https://www.facebook.com/Pasaka-102279084831340/?modal=admin_todo_tour"><img src="/images/icons/fb-icon.webp"></a></li>
            </ul>
        </div>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="http://pagination.js.org/dist/2.1.5/pagination.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
</script>

</body>
</html>