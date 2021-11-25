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
    <title>@yield("title") Mokykėlė pasaka</title>

{{--    <link rel="stylesheet" type="text/css" href="/css/landing.css">--}}
    <link rel="stylesheet" href="/assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome5-overrides.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
    <script src="{{asset('assets/js/meetings-custom.js')}}"></script>

    <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/fabfe9adf90a89d713bc481e6/7f56a19bd8725469b6f8342d6.js");</script>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7XK43G"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
            </ul>
            <ul class="right-menu">
                <li>
                    <a class="only--mobile" href="/dashboard">
                        {{Auth::user()->name}} {{Auth::user()->surname}} profilis
                    </a>
                    <ul class="nav navbar-nav flex-nowrap" >
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-item dropdown no-arrow">
                                <a class="dropdown-toggle nav-link messages" data-toggle="dropdown" aria-expanded="false" href="#">
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
                                        <a class=" @if(Request::is('dashboard/payments')) active @endif " href="/dashboard/payments"><i class="fas fa-money-bill"></i><span>Apmokėjimai</span>
                                            <a class=" @if(Request::is('dashboard/meetings')) active @endif " href="/dashboard/meetings"><i class="fa fa-calendar-check-o"></i><span>Susitikimai</span></a>
                                            <a class=" @if(Request::is('dashboard/introductions')) active @endif " href="/dashboard/introductions"><i class="fa fa-cc-discover"></i><span>Vieši susitikimai</span></a>
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

    <div class="container" id="content">
        @yield("content")
    </div>

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
</div>

@php
    if(\Session::has("modal_title")){
        $modal_title = \Session::get("modal_title");
    }
    if(\Session::has("modal_content")){
        $modal_content = \Session::get("modal_content");
    }
@endphp
@if(isset($modal_title) && isset($modal_content))
    <div class="landing--modal">
        <div class="landing--modal--inner">
            <div class="close">X</div>
            <img src="images/landing/planet.webp">
            <div class="landing--modal--text">
                <h2>{{ $modal_title }}</h2>
                {!! $modal_content !!}
            </div>
        </div>
    </div>
@endif

@if(!Cookie::get("user_timezone"))
    <?php
                $ipinfo = json_decode(file_get_contents("http://ip-api.com/json/".Request::ip()));
                $country = $ipinfo->country;
                $timezone = $ipinfo->timezone;
    $country = 'Lithuania';
                $country = Location::get(Request::ip())->countryName;
    ?>
    <div class="landing--modal">
        <div class="landing--modal--inner">
            <img src="/images/landing/planet.webp">
            <div class="landing--modal--text">
                <form method="POST" action="/set-region">
                    @csrf
                    <input type="hidden" name="url" value="{{ Request::url() }}">
                    <h2>Pasirinkite savo laiko zoną</h2>
                    <select class="form-control" name="timezone" required>

                    </select>
                    <button type="submit" class="landing--modal--button">Patvirtinti</button>

                    <script>
                        var user_timezone = moment.tz.guess();
                        console.log(user_timezone);
                        var selectHtml = "";
                        var timezones = moment.tz.names();
                        for (var i = 0; i < timezones.length; i++) {
                            var timezone = timezones[i];
                            if(timezone.indexOf("/") !== -1 && timezone.indexOf("Etc/") == -1)
                                selectHtml += "<option value='"+timezone+"' "+(timezone == user_timezone ? "selected" : "")+">"+timezone+"</option>";
                        }
                        $("[name=timezone]").html(selectHtml);
                    </script>
                </form>
            </div>
        </div>
    </div>
@endif
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="/js/jssor.slider.min.js"></script>
@if (isset($errors) && $errors->any())
    @php
        $errorsStr = "";
        foreach ($errors->all() as $error) {
            if(Illuminate\Support\Str::contains($error,'terms.')) {
                $errorsStr .= "Prašome sutikti su Pasakos privatumo politika. ";
            } elseif(Illuminate\Support\Str::contains($error,'student age')) {
                $errorsStr .= "Prašome nurodyti vaiko amžiaus grupę. ";
            } else {
                $errorsStr .= $error;
            }
        }
    @endphp
    <script>alert("Klaida! {{ $errorsStr }}");</script>
@endif
<script>
    $(document).ready(function() {
        $("#courses-list").load( "courses" );
        $("#free-lessons-form").load( "free-l-form" );
        $("#courses-free").load( "courses_free" );
        $("#question-form").load( "question_form" );
    });
    if(window.location.href.endsWith('change-timezone')) {
        window.location.href = "/";
    }
    $(".mobile--menu").click(function() {
        $(this).toggleClass("active");
        $(this).parent().toggleClass("active");
    });

    $(".mobile--arrow--down").click(function () {
        $(this).toggleClass("active");
        $(this).parent().find(".mv--dropdown").toggleClass("active");
    });

    $(".landing--modal--inner .close").click(function () {
        $(this).parent().parent().fadeOut();
    });

    var sliders = [];
    $(".carousel").html("").removeAttr("data-initialized");

    function responsiveJssor(){
        $(".carousel").each(function() {
            responsiveJssorOne($(this));
        });
    }

    function responsiveJssorOne(one) {
        var width = one.parent().width();
        one.css("width", width);
        one.children("div").css("width", width);
        var id = parseInt(one.attr("data-initialized"));
        if(sliders[id]) {
            sliders[id].$ScaleWidth(width);
        }else{
            console.log("Slider #"+id+" does not exist");
        }
    }

    $(window).bind("resize", responsiveJssor);

    setInterval(function () { // carousel tick
        $(".carousel").each(function() {
            if(!$(this).is("[data-initialized]")){

                var id = $("[data-initialized]").length ? $("[data-initialized]").length : 0;
                $(this).attr("id", "jssor_"+id);
                $(this).css({
                    "height": 300,
                    "width": 950
                });

                var html = "<div data-u='slides' style='height: 300px;width: 950px'>";

                for (var i = 0; i < 10; i++) {
                    if($(this).attr("data-image"+i) && $(this).attr("data-image"+i).length){
                        html += "<div><img data-u='image' src='"+$(this).attr("data-image"+i)+"' /></div>";
                    }
                }

                html += "</div>";

                $(this).html(html);

                var jssorSlider = new $JssorSlider$("jssor_"+id, { $AutoPlay: 1 });
                sliders.push(jssorSlider);

                setTimeout(function() {
                    responsiveJssorOne($("#jssor_"+id));
                }, 100);

                $(this).attr("data-initialized", id);
                $(this).children().attr("data-vvveb-disabled", true);

                new MutationObserver(function(mutations) {
                    console.log("Mutation for carousel detected");
                    $("#jssor_"+id).html("").removeAttr("data-initialized");
                }).observe(document.getElementById("jssor_"+id), {
                    attributes: true,
                    attributeFilter: ['data-image1','data-image2','data-image3','data-image4','data-image5','data-image6','data-image7','data-image8','data-image9','data-image10'] });
            }
        });
    },300);


</script>
</body>
</html>