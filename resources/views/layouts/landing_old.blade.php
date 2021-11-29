<!DOCTYPE html>
<html>
<head>
    <title>@yield("title") Mokyklėlė pasaka</title>

    <link rel="stylesheet" type="text/css" href="/css/landing.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
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
                        <a href="/dashboard">
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
                    <li><a href="https://www.facebook.com/Pasaka-102279084831340/?modal=admin_todo_tour"><img src="/images/icons/fb-icon.webp"></a></li>
                </ul>
            </div>
        </footer>
    </div>

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
//            $country = Location::get(Request::ip())->countryName;
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
                                if(timezone.indexOf("/") !== -1)
                                    selectHtml += "<option value='"+timezone+"' "+(timezone == user_timezone ? "selected" : "")+">"+timezone+"</option>";
                            }
                            $("[name=timezone]").html(selectHtml);
                        </script>
                    </form>
                </div>
            </div>
        </div>
    @endif

</body>
</html>