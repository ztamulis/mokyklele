@extends("layouts.landing_new")@section("title", "Susitikimai")@section("content")

    <div class="row mt-5">
        <div class="col-md-6 col-sm-12">
            <h1 class="meetings-h">Susitikimai</h1>
            <p class="meetings-text">
                Kviečiame Pasakos vaikus į įdomius virtualius susitikimus su kūrybingais žmonėmis iš Lietuvos!
                Kas gali būti smagiau, nei lavinti lietuvių kalbą tyrinėjant ir pažįstant Lietuvos kultūrą?
            </p>
        </div>
        <div class="col-md-6 col-sm-12">
            <img class="img-fluid meetings-main-img" src="https://mokyklelepasaka.rfox.cloud/uploads/page-uploads/1-O1C5ub4AT3aklINJ.png">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tabs-meetings">
                <button class="tablinks-meetings active" data-country="tab-1">Visi susitikimai</button>
                <button class="tablinks-meetings" data-country="tab-2">Praėję susitikimai</button>
                <button class="tablinks-meetings" data-country="tab-3">Susitikimai kurse</button>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="wrapper_tabcontent">
            <div id="tab-1" class="tabcontent-meetings active">
                <div class="row">
                    @foreach ($meetings as $meeting)
                        <div class="col-md-6 col-lg-4">
                            @if($meeting->photo)
                                <div>
                                <img class="img-fluid meeting-img" src="/uploads/introductions/{{ $meeting->photo }}">
                                </div>
                            @endif
                            <div class="meeting-content-align">
                                <div class="mt-3">
                                    <h3 class="mt-3 meeting-name">{{$meeting->name}}</h3>
                                </div>
                                <div class="meeting-date"><span><b>{{$meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d")}}</b></span>
                                    {{App\Models\Group::getWeekDay($meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->dayOfWeek)}},<br>
                                    <span><b>{{ App\TimeZoneUtils::updateTime($meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i"), $meeting->updated_at) }}</b></span>
                                    ({{Cookie::get("user_timezone", "GMT")}})</div>
                                <div class="meeting-description mt-3">{!! $meeting->description !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="tab-2" class="tabcontent-meetings">
                <div class="row">
                    @foreach ($before as $meeting)
                        <div class="col-md-6 col-lg-4">
                            @if($meeting->photo)
                                <div>
                                    <img class="img-fluid meeting-img" src="/uploads/introductions/{{ $meeting->photo }}">
                                </div>
                            @endif
                            <div class="meeting-content-align">
                                <div class="mt-3">
                                    <h3 class="mt-3 meeting-name">{{$meeting->name}}</h3>
                                </div>
                                <div class="meeting-date"><span><b>{{$meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d")}}</b></span>
                                    {{App\Models\Group::getWeekDay($meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->dayOfWeek)}},<br>
                                    <span><b>{{ App\TimeZoneUtils::updateTime($meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i"), $meeting->updated_at) }}</b></span>
                                    ({{Cookie::get("user_timezone", "GMT")}})</div>
                                <div class="meeting-description mt-3">{!! $meeting->description !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="tab-3" class="tabcontent-meetings">
                <div class="row">
                    @foreach ($coming as $meeting)
                        <div class="col-md-6 col-lg-4">
                            @if($meeting->photo)
                                <div>
                                    <img class="img-fluid meeting-img" src="/uploads/introductions/{{ $meeting->photo }}">
                                </div>
                            @endif
                            <div class="meeting-content-align">
                                <div class="mt-3">
                                    <h3 class="mt-3 meeting-name">{{$meeting->name}}</h3>
                                </div>
                                <div class="meeting-date"><span><b>{{$meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d")}}</b></span>
                                    {{App\Models\Group::getWeekDay($meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->dayOfWeek)}},<br>
                                    <span><b>{{ App\TimeZoneUtils::updateTime($meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i"), $meeting->updated_at) }}</b></span>
                                    ({{Cookie::get("user_timezone", "GMT")}})</div>
                                <div class="meeting-description mt-3">{!! $meeting->description !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

