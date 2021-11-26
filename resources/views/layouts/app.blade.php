<!DOCTYPE html>
<html>

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-P7XK43G');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Mokyklėlė Pasaka</title>
    <link rel="stylesheet" href="/assets/bootstrapold/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/dashboard_custom.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="/assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome5-overrides.min.css">
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
    <script src="/assets/bootstrapold/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="/js/jquery-sortable-lists.js"></script>
    <script src="/js/jquery-menu-editor.js"></script>
    <script src="/js/bootstrap-iconpicker.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/ba87b46b2fade810dbf4e011d/126d0ec7c020f24a27f2bb97d.js");</script>
</head>

<body id="page-top">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7XK43G"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="wrapper">
    @if(Auth::user()->role == "admin" || Auth::user()->role == "teacher")
    <nav class="navbar align-items-start sidebar accordion p-0">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand mt-1" href="/">
                <img src="{{ url("images/logo.svg") }}">
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item"><a class="nav-link @if(Request::is('dashboard')) active @endif " href="/dashboard"><i class="fas fa-tachometer-alt"></i><span>Pagrindinis puslapis</span></a></li>
            <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/attendance')) active @endif " href="/dashboard/attendance"><i class="fa fa-bell"></i><span>Lankomumas</span></a></li>
            <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/events*')) active @endif " href="/dashboard/events"><i class="fa fa-calendar"></i><span>Užsiėmimai</span></a></li>

            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/rewards')) active @endif " href="/dashboard/rewards"><i class="fa fa-trophy"></i><span>Apdovanojimai</span></a></li>
            @endif
            @if(Auth::user()->role == "admin")
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/groups*')) active @endif " href="/dashboard/groups"><i class="fa fa-users"></i><span>Grupių valdymas</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/users*')) active @endif " href="/dashboard/users"><i class="fa fa-user-md"></i><span>Naudotojų valdymas</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/tableData')) active @endif " href="/dashboard/tableData"><i class="fa fa-files-o"></i><span>Duomenų lentelė</span></a></li>
{{--                        <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/messages/create')) active @endif " href="/dashboard/messages/create"><i class="fa fa-newspaper-o"></i><span>Rašyti žinutę</span></a></li>--}}
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/payments')) active @endif " href="/dashboard/payments"><i class="fas fa-money-bill"></i><span>Apmokėjimai</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/introductions')) active @endif " href="/dashboard/introductions"><i class="fa fa-calendar-check-o"></i><span>Vieši susitikimai</span></a></li>

                    {{--                        <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/navbar')) active @endif " href="/dashboard/navbar"><i class="fa fa-navicon"></i><span>Meniu juosta</span></a></li>--}}
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/wbuilder')) active @endif " href="/dashboard/wbuilder"><i class="fa fa-database"></i><span>Redaguoti puslapius</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/teacher-statistics')) active @endif " href="/dashboard/teacher-statistics"><i class="fa fa-bell"></i><span>Mokytojų statistika</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/coupons')) active @endif " href="/dashboard/coupons"><i class="fa fa-cc-discover"></i><span>Nuolaidų kuponai</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('questions-form')) active @endif " href="/questions-form"><i class="fa fa-question"></i><span>Suaugusiųjų kursų forma</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Request::is('register-free/admin')) active @endif " href="/register-free/admin"><i class="fa fa-registered"></i><span>Nemokamos pamokos forma</span></a></li>
            @endif
            <li class="nav-item"><a class="nav-link @if(Request::is('dashboard/profile')) active @endif " href="/dashboard/profile"><i class="fas fa-user"></i><span>Mano paskyra</span></a></li>
            </ul>
{{--            <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>--}}
        </div>
    </nav>
    @endif
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white mb-4 topbar static-top @if(Auth::user()->role == "user") user--nav @endif ">
                <div class="container-fluid">
                    @if(Auth::user()->role != "user") <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button> @endif

                    @if(Auth::user()->role == "user")
                    <div class="mobile--logo">
                        <a href="/">
                            <img src="{{ url("images/logo.svg") }}" alt="logo">
                        </a>
                    </div>
                    @endif
                    <nav class="main--nav">
                        <ul>
                            @if(Auth::user()->role == "user")
                            <li>
                                <div class="logo">
                                    <a href="/">
                                        <img src="{{ url("images/logo.svg") }}" alt="logo">
                                    </a>
                                </div>
                            </li>
                            @endif

                            @foreach(\App\Models\Navbar::navBar() as $nav)
                                @if(property_exists($nav,'children'))
                                    <li>
                                        <a href="{{$nav->href}}">
                                            {{$nav->text}}
                                        </a>
                                        <div class="mobile--arrow--down"></div>
                                        <div class="dropdown">
                                            <ul>
                                                @foreach($nav->children as $child)
                                                    <li>
                                                        <a href="{{$child->href}}">{{$child->text}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{$nav->href}}">
                                            {{$nav->text}}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                          {{--   <li>
                                <a href="/apie-pamokas">
                                    Apie pamokas
                                </a><div class="dropdown"><a href="/apie-pamokas">
                                    </a><ul><a href="/apie-pamokas">
                                        </a><li><a href="/apie-pamokas">
                                            </a><a href="/pavasario-kursas">Pavasario kursas</a>
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
                            </li> --}}
                        </ul>
                    </nav>
                    <ul class="nav navbar-nav flex-nowrap">
                        <li class="nav-item dropdown no-arrow mx-1">
                            <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-envelope fa-fw"></i>
                                     @if(\App\Http\Controllers\MessageController::unreadMessages())
                                        <span class="badge badge-danger badge-counter">{{\App\Http\Controllers\MessageController::unreadMessages()}}</span>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in">
                                    <h6 class="dropdown-header">Žinutės</h6>
                                    @foreach(\App\Http\Controllers\MessageController::messages() as $message)
                                        <a class="d-flex align-items-center dropdown-item" href="/dashboard/messages/{{$message->id}}">
                                            <div class="font-weight-bold">
                                                <div class="text-truncate">
                                                    <span>@if(!$message->seen)<i class="fa fa-exclamation" style="color: var(--danger); margin-right: 5px;"></i>@endif {{substr(strip_tags($message->message),0,80)."..."}}</span>
                                                </div>
                                                <p class="small text-gray-500 mb-0">{{$message->author ? $message->author->name : ""}} {{$message->created_at->format("Y-m-d")}}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                    <a class="text-center dropdown-item small text-gray-500" href="/dashboard/messages/create">Rašyti naują pranešimą</a>
                                    <a class="text-center dropdown-item small text-gray-500" href="/dashboard/messages">Rodyti visus pranešimus</a>
                                </div>
                            </div>
                            <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
                        </li>
                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-item dropdown no-arrow">
                                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                                    <img class="border rounded-circle img-profile img-fluid" src="{{ Auth::user()->photo ? "/uploads/users/".Auth::user()->photo : "/images/icons/avatar.png" }}" />
                                    <span class="d-none d-lg-inline ml-2 text-gray-600 small">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>
                                </a>
                                <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in">
                                    <a class="dropdown-item" href="/dashboard"><i class="fas fa-book fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Paskyra</a>
                                    <a class="dropdown-item" href="/dashboard/profile"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Nustatymai</a>
                                    <div class="dropdown-divider"></div>
                                    <form method="POST" action="/logout">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault();this.closest('form').submit();" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Atsijungti
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="@if(Auth::user()->role == "user") container @else container-fluid @endif">
                {{ $slot }}
            </div>
        </div>
{{--        <footer class="bg-white sticky-footer">--}}
{{--            <div class="container my-auto">--}}
{{--                <div class="text-center my-auto copyright"><span>Copyright © Mokyklėlė Pasaka {{ date("Y") }}</span></div>--}}
{{--            </div>--}}
{{--        </footer>--}}
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
</div>
{{--<script src="http://pagination.js.org/dist/2.1.5/pagination.min.js"></script>--}}
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300
        });
    });
</script>
</body>

</html>