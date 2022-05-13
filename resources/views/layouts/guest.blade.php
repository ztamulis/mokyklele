<!DOCTYPE html>
<html>
<head>
    <title>@yield("title") Mokyklėlė pasaka</title>

    <link rel="stylesheet" type="text/css" href="/css/landing.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="wrapper">

    <header>
        <div class="logo">
            <a href="/">
                <img src="{{ url("images/logo.svg") }}" alt="logo">
            </a>
        </div>
        <nav>
            <ul>
              
                @foreach(\App\Models\Navbar::navBar() as $nav)
                    @if(property_exists($nav,'children'))
                        <li>
                            <a href="{{$nav->href}}">
                                {{$nav->text}}
                            </a>
                            <div class="mobile--arrow--down"></div>
                            <div class="mv--dropdown">
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
                
                    <li>
                        @if(Auth::check())
                            <a class="only--mobile" href="/dashboard">
                                {{ Auth::user()->name }} {{ Auth::user()->surname }} profilis
                            </a>
                            <ul class="nav navbar-nav flex-nowrap">
                                <li class="nav-item dropdown no-arrow mx-1">
                                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-envelope fa-fw"></i>
                                            @if(\App\Http\Controllers\MessageController::unreadMessages())
                                                <span class="badge badge-danger badge-counter">{{\App\Http\Controllers\MessageController::unreadMessages()}}</span>
                                            @endif
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in">
                                            <h6 class="dropdown-header text-white">Žinutės</h6>
                                            @foreach(\App\Http\Controllers\MessageController::messages() as $message)
                                                <a class="d-flex align-items-center dropdown-item" href="/dashboard/messages/{{$message->id}}">
                                                    <div class="font-weight-bold">
                                                        <div class="text-truncate">
                                                            <span>@if(!$message->seen)<i class="fa fa-exclamation" style="color: var(--danger); margin-right: 5px;"></i>@endif {{ $message->messageTruncated }}</span>
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
{{--                                            <img class="border rounded-circle img-profile" src="{{ Auth::user()->photo ? url("/uploads/users/".Auth::user()->photo) : "/images/icons/avatar.png" }}" />--}}
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

</body>
</html>