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

<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">

<style>

</style>

    <link rel="stylesheet" href="{{asset('css/dashboard_custom.1646138749630.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://pagination.js.org/dist/2.1.5/pagination.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome5-overrides.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
    <meta http-equiv="expires" content="0">
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.1646138753136.css')}}">
    <link href="{{'css/smart-wizard-cached.css'}}" rel="stylesheet" type="text/css" />

    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    <script src="{{asset('assets/js/jquery.min.js')}}"></script>

    <script src="{{asset('assets/js/meetings-custom.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="{{asset('assets/js/theme.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote-cleaner@1.0.0/summernote-cleaner.js"></script>
    <script type="text/javascript" src="{{'assets/js/jquery.smartWizard.js'}}"></script>


    <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/ba87b46b2fade810dbf4e011d/126d0ec7c020f24a27f2bb97d.js");</script>
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
                <li>
                    <a href="/apie-pamokas">
                        Apie pamokas
                    </a>
                    <div class="arrow-down"></div>
                    <div class="mv--dropdown">
                        <ul>
                            <li>
                                <a href="/lietuviu-kalbos-pamokos">Lietuvių kalbos pamokos</a>
                            </li>
                            <li>
                                <a href="/suaugusiuju-kursai">Kursai suaugusiems</a>
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
                @if(!Auth::check())
                    <li>
                        <a href="/login">
                            Prisijungti
                        </a>
                    </li>
                @endif
            </ul>
            <ul class="right-menu">
                <li>
                    @if(Auth::check())
                        <a class="only--mobile" href="/dashboard">
                            {{ Auth::user()->name }} {{ Auth::user()->surname }} profilis
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
                                                    <p class="small text-gray-500 mb-0">{{$message->author ? $message->author->name : ""}} {{ $message->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }}</p>
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
                                        <img class="border rounded-circle img-profile img-fluid" src="{{ Auth::user()->photo ? "/uploads/users/".Auth::user()->photo : "/images/icons/avatar.png" }}" />
                                        <span class="d-none d-lg-inline ml-1">{{Auth::user()->name}} {{Auth::user()->surname}}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right animated--grow-in">
                                        <a class="@if(Request::is('dashboard')) active @endif " href="/dashboard"><i class="fas fa-tachometer-alt"></i><span>Paskyra</span></a>

                                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                                            <a class=" @if(Request::is('dashboard/attendance')) active @endif " href="/dashboard/attendance"><i class="fa fa-bell"></i><span>Lankomumas</span></a>
                                            <a class=" @if(Request::is('dashboard/events*')) active @endif " href="/dashboard/events"><i class="fa fa-calendar"></i><span>Užsiėmimai</span></a>
                                            <a class="@if(Request::is('dashboard/rewards')) active @endif " href="/dashboard/rewards"><i class="fa fa-trophy"></i><span>Apdovanojimai</span></a>
                                        @endif
                                        @if(Auth::user()->role == "admin")
                                            <a class="@if(Request::is('dashboard/groups*')) active @endif " href="/dashboard/groups"><i class="fa fa-users"></i><span>Grupių valdymas</span></a>
                                            <a class=" @if(Request::is('dashboard/users*')) active @endif " href="/dashboard/users"><i class="fa fa-user-md"></i><span>Naudotojų valdymas</span></a>
                                            <a class=" @if(Request::is('dashboard/tableData')) active @endif " href="/dashboard/tableData"><i class="fa fa-files-o"></i><span>Duomenų lentelė</span></a>
                                            <a class=" @if(Request::is('dashboard/payments')) active @endif " href="/dashboard/payments"><i class="fas fa-money-bill"></i><span>Apmokėjimai</span>
                                                <a class=" @if(Request::is('dashboard/meetings')) active @endif " href="/dashboard/meetings"><i class="fa fa-calendar-check-o"></i><span>Susitikimai</span></a>
                                                <a class=" @if(Request::is('dashboard/wbuilder')) active @endif " href="/dashboard/wbuilder"><i class="fa fa-database"></i><span>Redaguoti puslapius</span></a>
                                                <a class=" @if(Request::is(route('pages.index'))) active @endif " href="{{route('pages.index')}}"><span>Redaguoti puslapių informacija</span></a>
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
                    @endif
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
                    <button type="submit" class="button btn-lg w-100">Patvirtinti</button>

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

<script src="https://raw.githubusercontent.com/jedfoster/Readmore.js/master/readmore.js"></script>
@if (isset($errors) && $errors->any())
    @php
        $errorsStr = "";
        foreach ($errors->all() as $error) {
            if(Illuminate\Support\Str::contains($error,'terms.')) {
                $errorsStr .= "Prašome sutikti su Pasakos privatumo politika. ";
            } elseif(Illuminate\Support\Str::contains($error,'student age')) {
                $errorsStr .= "Prašome nurodyti vaiko am žiaus grupę. ";
            } else {
                $errorsStr .= $error;
            }
        }
    @endphp
    <script>alert("Klaida! {{ $errorsStr }}");</script>
@endif
<script>
    $(document).ready(function() {
        var btnFinish = $('<button type="submit"></button>').text('Pateikti').attr('id','finish-button')
            .addClass('btn btn-primary btn-sm ml-sm-1 mt-xs-3 mt-1 d-none');
        var wizard = $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'dots',
            autoAdjustHeight:true,
            transitionEffect:'fade',
            showStepURLhash: false,
            labelFinish:'Finish',  // label for Finish button
            labelCancel:'Cancel',
            toolbarSettings: {
                toolbarPosition: 'bottom', // none, top, bottom, both
                toolbarButtonPosition: 'center', // left, right, center
                toolbarExtraButtons: [btnFinish],
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                enableFinishButton: true,
            },
            lang: { // Language variables for button
                next: 'Pirmyn >',
                previous: '< Atgal',
                finish: 'Pateikti'
            }

        });
        $(wizard).on("leaveStep", function(e, anchorObject, stepIndex, nextStepIndex, stepDirection) {
            if(nextStepIndex == 'forward' && (anchorObject.prevObject.length - 2) === stepIndex){
                $('#finish-button').removeClass('d-none');
                console.log('yesss');
            }else{
                $('#finish-button').addClass('d-none');
            }
        });


        $(".readmore-link").click(function(e) {
            // record if our text is expanded
            var isExpanded = $(e.target).hasClass("expand");

            //close all open paragraphs
            $(".readmore.expand").removeClass("expand");
            $(".readmore-link.expand").removeClass("expand");

            // if target wasn't expand, then expand it
            if (!isExpanded) {
                $(e.target).parent(".readmore").addClass("expand");
                $(e.target).addClass("expand");
            }
        });

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