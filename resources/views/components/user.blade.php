<!doctype html>
<html>
<head>
    <title>Pasaka</title>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KWBT9QM');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Mokyklėlė Pasaka</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">


    {{--    <script src="./assets/js/jquery-3.4.1.min.js"></script>--}}
    {{--    <script src="./assets/js/bootstrap.min.js"></script>--}}




    <link rel="stylesheet" href="/css/dashboard_custom.css">
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    {{--<link href="http://pagination.js.org/dist/2.1.5/pagination.css" rel="stylesheet">--}}

    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">



    <script src="/assets/js/jquery.min.js"></script>

    <script src="/assets/js/custom.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>


    <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/ba87b46b2fade810dbf4e011d/126d0ec7c020f24a27f2bb97d.js");</script>
</head>

<body>
<div class="wrapper">
    <header>
        <div class="logo">
            <a href="/">
                <img src="{{ asset('images/logo.svg') }}" alt="logo">
            </a>
        </div>
        <nav>
            <div class="mobile--menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="left-menu">
                <li>
                    <a href="/apie-pamokas">
                        Apie pamokas
                    </a>
                    <div class="arrow-down"></div>
                    <div class="mv--dropdown">
                        <ul>
                            <li>
                                <a href="/lietuviu_kalbos_pamokos">Lietuvių kalbos pamokos</a>
                            </li>
                            <li>
                                <a href="/patarimai-tevams">Patarimai tėvams</a>
                            </li>
                            <li>
                                <a href="/kaina">Kaina</a>
                            </li>
                        </ul>
                    </div>
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
            </ul>
            <ul class="right-menu">
                <li>
                    <a class="only--mobile" href="/dashboard">
                        {{Auth::user()->name}} {{Auth::user()->surname}} profilis
                    </a>
                    <ul class="nav navbar-nav flex-nowrap">
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-item dropdown no-arrow">
                                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                                    <span class="icon-message-circle-lines"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in">
                                    <h6 class="dropdown-header">Žinutės</h6>
                                    @foreach(\App\Http\Controllers\MessageController::messages() as $message)

                                    <a class="d-flex align-items-center dropdown-item" href="/dashboard/messages/{{$message->id}}">
                                        <div class="font-weight-bold">
                                            <div class="text-truncate">
                                                <span> {{substr(strip_tags($message->message),0,80)."..."}}</span>
                                            </div>
                                            <p class="small text-gray-500 mb-0">{{ $message->author->name }} {{ $message->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }}</p>
                                        </div>
                                    </a>
                                    @endforeach
{{--                                    <a class="d-flex align-items-center dropdown-item" href="/dashboard/messages/4100">--}}
{{--                                        <div class="font-weight-bold">--}}
{{--                                            <div class="text-truncate">--}}
{{--                                                <span> Sveiki, mes ką tik priisijungėme prie jūsų 😊 ir nelabai žinom kaip reikia prisij...</span>--}}
{{--                                            </div>--}}
{{--                                            <p class="small text-gray-500 mb-0">Rūta 2021-10-06</p>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
{{--                                    <a class="d-flex align-items-center dropdown-item" href="/dashboard/messages/3528">--}}
{{--                                        <div class="font-weight-bold">--}}
{{--                                            <div class="text-truncate">--}}
{{--                                                <span> Alyos klases piesinukas.</span>--}}
{{--                                            </div>--}}
{{--                                            <p class="small text-gray-500 mb-0">Kristina 2021-09-26</p>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
{{--                                    <a class="d-flex align-items-center dropdown-item" href="/dashboard/messages/3252">--}}
{{--                                        <div class="font-weight-bold">--}}
{{--                                            <div class="text-truncate">--}}
{{--                                                <span> Nerandu nuorodos kur prisijungti</span>--}}
{{--                                            </div>--}}
{{--                                            <p class="small text-gray-500 mb-0">Inga 2021-09-24</p>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
{{--                                    <a class="d-flex align-items-center dropdown-item" href="/dashboard/messages/3250">--}}
{{--                                        <div class="font-weight-bold">--}}
{{--                                            <div class="text-truncate">--}}
{{--                                                <span> Ačiū už priminimą!</span>--}}
{{--                                            </div>--}}
{{--                                            <p class="small text-gray-500 mb-0">Rūta 2021-09-23</p>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
                                    <a class="text-center dropdown-item small text-gray-500" href="/dashboard/messages/create">Rašyti naują pranešimą</a>
                                    <a class="text-center dropdown-item small text-gray-500" href="/dashboard/messages">Rodyti visus pranešimus</a>
                                    <div class="mobile-close"></div>
                                </div>
                            </div>
                        </li>
                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown">
                            <div class="nav-item dropdown">
                                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                                    <span class="icon-user"></span>
                                    <span class="d-none d-lg-inline ml-1">{{Auth::user()->name}} {{Auth::user()->surname}}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated--grow-in">
                                    <a class="@if(Request::is('dashboard')) active @endif " href="/dashboard"><i class="fas fa-tachometer-alt"></i><span>Paskyra</span></a>
                                    <a class=" @if(Request::is('dashboard/attendance')) active @endif " href="/dashboard/attendance"><i class="fa fa-bell"></i><span>Lankomumas</span></a>
                                    <a class=" @if(Request::is('dashboard/events*')) active @endif " href="/dashboard/events"><i class="fa fa-calendar"></i><span>Užsiėmimai</span></a>

                                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                                        <a class="@if(Request::is('dashboard/rewards')) active @endif " href="/dashboard/rewards"><i class="fa fa-trophy"></i><span>Apdovanojimai</span></a>
                                    @endif
                                    @if(Auth::user()->role == "admin")
                                        <a class="@if(Request::is('dashboard/groups*')) active @endif " href="/dashboard/groups"><i class="fa fa-users"></i><span>Grupių valdymas</span></a>
                                        <a class=" @if(Request::is('dashboard/users*')) active @endif " href="/dashboard/users"><i class="fa fa-user-md"></i><span>Naudotojų valdymas</span></a>
                                        <a class=" @if(Request::is('dashboard/tableData')) active @endif " href="/dashboard/tableData"><i class="fa fa-files-o"></i><span>Duomenų lentelė</span></a>
                                        {{--                        <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/messages/create')) active @endif " href="/dashboard/messages/create"><i class="fa fa-newspaper-o"></i><span>Rašyti žinutę</span></a></li>--}}
                                        <a class=" @if(Request::is('dashboard/payments')) active @endif " href="/dashboard/payments"><i class="fas fa-money-bill"></i><span>Apmokėjimai</span>
                                            <a class=" @if(Request::is('dashboard/meetings')) active @endif " href="/dashboard/meetings"><i class="fa fa-calendar-check-o"></i><span>Susitikimai</span></a>
                                            {{--                        <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/navbar')) active @endif " href="/dashboard/navbar"><i class="fa fa-navicon"></i><span>Meniu juosta</span></a></li>--}}
                                            <a class=" @if(Request::is('dashboard/wbuilder')) active @endif " href="/dashboard/wbuilder"><i class="fa fa-database"></i><span>Redaguoti puslapius</span></a>
                                            <a class=" @if(Request::is('dashboard/teacher-statistics')) active @endif " href="/dashboard/teacher-statistics"><i class="fa fa-bell"></i><span>Mokytojų statistika</span></a>
                                            <a class=" @if(Request::is('dashboard/coupons')) active @endif " href="/dashboard/coupons"><i class="fa fa-cc-discover"></i><span>Nuolaidų kuponai</span></a>
                                            <a class=" @if(Request::is('questions-form')) active @endif " href="/questions-form"><i class="fa fa-question"></i><span>Suaugusiųjų kursų forma</span></a>
                                            <a class=" @if(Request::is('register-free/admin')) active @endif " href="/register-free/admin"><i class="fa fa-registered"></i><span>Nemokamos pamokos forma</span></a>
                                            @endif
                                            <a href="/dashboard/profile">Nustatymai</a>

                                            <div class="dropdown-divider"></div>
                                            <form method="POST" action="/logout">
                                                <input type="hidden" name="_token" value="4o1WRFafmb97y4CGzftAVDmzqw2MLsAl2HaSB3IW">
                                                <a href="#" onclick="event.preventDefault();this.closest('form').submit();" class="dropdown-item">
                                                    Atsijungti
                                                </a>
                                            </form>
                                            <div class="mobile-close"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="clear"></div>
    </header>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KWBT9QM"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    {{ $slot }}

{{--<script src="http://pagination.js.org/dist/2.1.5/pagination.min.js"></script>--}}
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'ckeditor', {
        } );
    </script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300
        });
    });
</script>

    <footer>
        <div class="container">
            <div class="bottom-menu">
                <a href="/" class="homepage">Pasaka Ltd.</a>
                <a href="/kontaktai">Kontaktai</a>
                <a href="/privatumo-politika">Privatumo politika</a>
                <a href="/zoom-naudojimas">Kaip naudotis Zoom?</a>
                <a href="/nemokama-pamoka">Registruotis nemokamai pamokai</a>
                <a href="/change-timezone">Pakeisti laiko zoną</a>
            </div>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <a href="https://www.facebook.com/Pasaka-102279084831340/?modal=admin_todo_tour" class="social"><span class="icon-fb"></span></a>
                </div>
            </div>
        </div>
    </footer>
</html>