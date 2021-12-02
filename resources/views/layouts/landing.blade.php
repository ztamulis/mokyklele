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
    <title>@yield("title") Mokyklėlė pasaka</title>

    <link rel="stylesheet" type="text/css" href="/css/landing.css">
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
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
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
                    <img src="{{ url("images/logo.svg") }}" alt="logo">
                </a>
            </div>
            <nav>
                <div class="mobile--menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
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
                    <!--<li>
                        <a href="/apie-pamokas">
                            Apie pamokas
                            <div class="mv--dropdown">
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
                    </li>-->
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
                                            <h6 class="dropdown-header">Žinutės</h6>
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
                                            <img class="border rounded-circle img-profile" src="{{ Auth::user()->photo ? "/uploads/users/".Auth::user()->photo : "/images/icons/avatar.png" }}" />
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
            @yield("content")
        </div>

        <footer>
            <div class="footer--wrapper">
                <ul>
                    <li><b>Pasaka Ltd.</b></li>
                    <li><a href="/kontaktai">Kontaktai</a></li>
                    <li><a href="/privatumo-politika">Privatumo politika</a></li>
                    <li><a href="/zoom-naudojimas">Kaip naudotis Zoom?</a></li>
                    <li><a href="/nemokama-pamoka">Registruotis nemokamai pamokai</a></li>
                    <li><a href="/change-timezone">Pakeisti laiko zoną</a></li>
                    <li><a href="https://www.facebook.com/Pasaka-102279084831340/?modal=admin_todo_tour" target="_blank"><img src="/images/icons/fb-icon.webp"></a></li>
                </ul>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.$easing.js"></script>
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
            $("#courses-adults-free").load( "courses_adults_free" );
            $("#courses-adults").load( "courses_adults" );
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