<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Mokyklėlė Pasaka</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/dashboard_custom.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="/assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome5-overrides.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="http://pagination.js.org/dist/2.1.5/pagination.css" rel="stylesheet">
</head>

<body id="page-top">
<div id="wrapper">
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="/dashboard">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Pasaka</span></div>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
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
            <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
        </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <ul class="nav navbar-nav flex-nowrap ml-auto">
                        <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                            <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto navbar-search w-100">
                                    <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                        <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow mx-1">
                            <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-envelope fa-fw"></i><span class="badge badge-danger badge-counter">{{\App\Http\Controllers\MessageController::unreadMessages()}}</span></a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in">
                                    <h6 class="dropdown-header">Žinutės</h6>
                                    @foreach(\App\Http\Controllers\MessageController::messages() as $message)
                                        <a class="d-flex align-items-center dropdown-item" href="/dashboard/messages/{{$message->id}}">
                                            <div class="font-weight-bold">
                                                <div class="text-truncate">
                                                    <span>@if(!$message->seen)<i class="fa fa-exclamation" style="color: var(--danger);"></i>@endif{{substr(strip_tags($message->message),0,80)."..."}}</span>
                                                </div>
                                                <p class="small text-gray-500 mb-0">{{$message->author->name}} {{$message->created_at->format("Y-m-d")}}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                    <a class="text-center dropdown-item small text-gray-500" href="/dashboard/messages">Rodyti visus pranešimus</a>
                                </div>
                            </div>
                            <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
                        </li>
                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span></a>
                                <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in"><a class="dropdown-item" href="/dashboard/profile"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Nustatymai</a>
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
            <div class="container-fluid">
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
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="/assets/js/theme.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="http://pagination.js.org/dist/2.1.5/pagination.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
</script>
</body>

</html>