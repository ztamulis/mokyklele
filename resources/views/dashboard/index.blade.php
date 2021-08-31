<x-app-layout>

    <div class="client--dashboard">
        @if(Auth::user()->role != "teacher")
        <div class="dashboard--misc--buttons">
            <a href="/dashboard/user-rewards" class="dashboard--button">
                Apdovanojimai
            </a>
            <a href="/lietuviu_kalbos_pamokos" class="dashboard--button dashboard--button--main">
                <img src="/images/icons/plus.svg"> Užsakyti kursą
            </a>
        </div>
        @endif
                <h3>Labas!</h3>
                <p>Sveikiname prisijungus prie virtualios lituanistinės mokyklėlės.</p>
                <div class="group--list">
                    @foreach(Auth::user()->getGroupedGroups() as $weekday => $groups)

                        <h3>{{Auth::user()->getWeekDayName($weekday)}}</h3>
                        @foreach($groups as $group)
                        <div class="group--item" data-href="/dashboard/groups/{{$group->id}}">
                            <div class="group--icon">
                                <div class="color background--{{ $group->type }}"></div>
                            </div>
                            <div class="group--info">
                                <h3>{{$group->name}}</h3>
                                <p>
                                @if(\App\Http\Controllers\GroupController::nextLesson($group))
                                    <p>Kita pamoka: {{ \App\Http\Controllers\GroupController::nextLesson($group)->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }} <small>({{ Cookie::get("user_timezone", "GMT") }})</small> </p>
                                @else
                                    <p>Kita pamoka: nėra</p>
                                    @endif
                                    </p>
                            </div>
                            <div class="group--students">
                                @foreach(Auth::user()->students()->where("group_id", $group->id)->get() as $student)
                                    <div class="group--student">
                                        <div class="group--student--image" @if($student->photo) style="background-image: url('/uploads/students/{{ $student->photo }}')" @endif ></div>
                                        <div class="group--student--name">
                                            <span>{{ $student->name }}</span>
                                            <br>
                                            {{ $student->age }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="group--actions">
                                <a href="/dashboard/groups/{{$group->id}}" class="dashboard--button btn-success">
                                    Grupė
                                </a>
                            </div>
                            <div class="group--actions">
                                @php
                                    $nextLesson = \App\Http\Controllers\GroupController::nextLesson($group);
                                @endphp
                                @if($nextLesson)
                                    <a @if($nextLesson->join_link) href="{{ $nextLesson->join_link }}" target="_blank" @else href="/dashboard/groups/{{$group->id}}#joinmeeting" @endif class="dashboard--button dashboard--button--main">
                                        Prisijungti
                                    </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                @endforeach
            @if(\App\Http\Controllers\UserController::hasGroup() && !\App\Http\Controllers\UserController::hasDemoLesson())
                    @foreach($meetings as $meeting)
                        <div class="group--item">
                            <div class="group--icon">
                                <div class="color background--blue" @if($meeting->photo) style="background-image: url('/uploads/meetings/{{ $meeting->photo }}')" @endif ></div>
                            </div>
                            <div class="group--info">
                                <h3>{{$meeting->name}}</h3>
                                {!! $meeting->description !!}
                            </div>
                            <div class="group--students text--center">
                                <span>{{$meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i")}}</span>
                                <br>
                                {{ Cookie::get("user_timezone", "GMT") }}
                            </div>
                            {{-- @if(\App\Http\Controllers\MeetingController::nextMeetingButton($meeting)) // use if meeting link should appear only on meeting day --}}
                            <div class="group--actions">
                                <a href="{{ $meeting->join_link }}" class="dashboard--button dashboard--button--main">
                                    Prisijungti
                                </a>
                            </div>
                            {{-- @endif --}}
                        </div>
                    @endforeach
                @endif
            </div>
    </div>


{{--            <h3>Labas!</h3>--}}
{{--        <p>Sveikiname prisijungus prie virtualios lituanistinės mokyklėlės.</p>--}}
{{--        <div class="group--list">--}}
{{--            @if(Auth::user()->role != "admin")--}}

{{--            @foreach(Auth::user()->getGroups() as $group)--}}
{{--                <div class="group--item" data-href="/dashboard/groups/{{$group->id}}">--}}
{{--                    <div class="group--icon">--}}
{{--                        <div class="color background--{{ $group->type }}"></div>--}}
{{--                    </div>--}}
{{--                    <div class="group--info">--}}
{{--                        <h3>{{$group->name}}</h3>--}}
{{--                        <p>--}}
{{--                            @if(\App\Http\Controllers\GroupController::nextLesson($group))--}}
{{--                                <p>Kita pamoka: {{ \App\Http\Controllers\GroupController::nextLesson($group)->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }} <small>({{ Cookie::get("user_timezone", "GMT") }})</small> </p>--}}
{{--                            @else--}}
{{--                                <p>Kita pamoka: nėra</p>--}}
{{--                            @endif--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                    <div class="group--students">--}}
{{--                        @foreach(Auth::user()->students()->where("group_id", $group->id)->get() as $student)--}}
{{--                            <div class="group--student">--}}
{{--                                <div class="group--student--image" @if($student->photo) style="background-image: url('/uploads/students/{{ $student->photo }}')" @endif ></div>--}}
{{--                                <div class="group--student--name">--}}
{{--                                    <span>{{ $student->name }}</span>--}}
{{--                                    <br>--}}
{{--                                    {{ $student->age }}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                    <div class="group--actions">--}}
{{--                    <a href="/dashboard/groups/{{$group->id}}" class="dashboard--button btn-success">--}}
{{--                        Grupė--}}
{{--                    </a>--}}
{{--                    </div>--}}
{{--                    <div class="group--actions">--}}
{{--                        @php--}}
{{--                        $nextLesson = \App\Http\Controllers\GroupController::nextLesson($group);--}}
{{--                        @endphp--}}
{{--                        @if($nextLesson)--}}
{{--                            <a @if($nextLesson->join_link) href="{{ $nextLesson->join_link }}" target="_blank" @else href="/dashboard/groups/{{$group->id}}#joinmeeting" @endif class="dashboard--button dashboard--button--main">--}}
{{--                                Prisijungti--}}
{{--                            </a>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--            @if(\App\Http\Controllers\UserController::hasGroup() && !\App\Http\Controllers\UserController::hasDemoLesson())--}}
{{--                @foreach($meetings as $meeting)--}}
{{--                    <div class="group--item">--}}
{{--                        <div class="group--icon">--}}
{{--                            <div class="color background--blue" @if($meeting->photo) style="background-image: url('/uploads/meetings/{{ $meeting->photo }}')" @endif ></div>--}}
{{--                        </div>--}}
{{--                        <div class="group--info">--}}
{{--                            <h3>{{$meeting->name}}</h3>--}}
{{--                            {!! $meeting->description !!}--}}
{{--                        </div>--}}
{{--                        <div class="group--students text--center">--}}
{{--                            <span>{{$meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i")}}</span>--}}
{{--                            <br>--}}
{{--                            {{ Cookie::get("user_timezone", "GMT") }}--}}
{{--                        </div>--}}
{{--                        --}}{{-- @if(\App\Http\Controllers\MeetingController::nextMeetingButton($meeting)) // use if meeting link should appear only on meeting day --}}
{{--                        <div class="group--actions">--}}
{{--                            <a href="{{ $meeting->join_link }}" class="dashboard--button dashboard--button--main">--}}
{{--                                Prisijungti--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        --}}{{-- @endif --}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--            @endif--}}

{{--        </div>--}}
{{--    </div>--}}
{{--    @if(\App\Http\Controllers\UserController::hasGroup() && !\App\Http\Controllers\UserController::hasDemoLesson())--}}
{{--        <div class="row mt-4">--}}
{{--            <div class="col-xl-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col">--}}
{{--                                <h2 class="text-center text-dark">Susitikimai<br></h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @if(!count($meetings))--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-xl-6 offset-xl-3">--}}
{{--                                    <p>Nėra jokių susitikimų!</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            @foreach($meetings as $meeting)--}}
{{--                                <div class="row mt-4">--}}
{{--                                    <div class="col">--}}
{{--                                        <h3>{{$meeting->name}}</h3><br>--}}
{{--                                        <p>Susitikimo data: {{$meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i")}} <small>({{ Cookie::get("user_timezone", "GMT") }})</small> </p><br>--}}
{{--                                        <p>{!!  $meeting->description !!}</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-xl-3">--}}
{{--                                        @if(\App\Http\Controllers\MeetingController::nextMeetingButton($meeting))--}}
{{--                                            <a class="btn btn-primary btn-block" href="{{ \App\Http\Controllers\MeetingController::nextMeetingButton($meeting)->join_link }}">Prisijungti prie susitikimo</a>--}}
{{--                                        @else--}}
{{--                                            --}}{{--                                                            <a class="btn btn-primary btn-block" href="#">Prisijungti prie susitikimo</a>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row mt-4">--}}
{{--            <div class="col-xl-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col">--}}
{{--                                <h2 class="text-center text-dark">Apdovanojimai<br></h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}


{{--                    <div class="row">--}}
{{--                        <div class="col-xl-12">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col">--}}
{{--                                            <h2 class="text-center text-dark">Mano pamokos</h2>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    @if(!\App\Http\Controllers\UserController::hasGroup())--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-xl-6 offset-xl-3">--}}
{{--                                            <a class="btn btn-info btn-block" href="/pavasario-kursas">Užsakyti pamokas</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    @else--}}
{{--                                        @if(Auth::user()->getGroups()->count() <= 0 && Auth::user()->role == "teacher")--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col">--}}
{{--                                                    <span class="text-center text-dark">Neturite jokių priskirtų pamokų!</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @else--}}
{{--                                            @foreach(Auth::user()->getGroups() as $group)--}}
{{--                                                <div class="row mt-4">--}}
{{--                                                    <div class="col-xl-1">--}}
{{--                                                        <div class="color background--{{ $group->type }}"></div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-xl-5">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                <h4>{{$group->name}}</h4>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                @if(\App\Http\Controllers\GroupController::nextLesson($group))--}}
{{--                                                                    <p>Sekanti pamoka: {{ \App\Http\Controllers\GroupController::nextLesson($group)->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }} <small>({{ Cookie::get("user_timezone", "GMT") }})</small> </p>--}}
{{--                                                                @else--}}
{{--                                                                    <p>Sekanti pamoka: nėra</p>--}}
{{--                                                                @endif--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                <p>{{ $group->events->count() }} {{ $group->lessonsText($group->events->count()) }}</p>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-xl-3">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                <h4>Vaikai</h4>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                @foreach(Auth::user()->students()->where("group_id", $group->id)->get() as $student)--}}
{{--                                                                    <p> {{ $student->name }}</p>--}}
{{--                                                                @endforeach--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-xl-3 align-self-center">--}}
{{--                                                        <a class="btn btn-primary btn-block" href="/dashboard/groups/{{$group->id}}">Grupė</a>--}}
{{--                                                        @if(\App\Http\Controllers\GroupController::nextLessonButton($group))--}}
{{--                                                            <a class="btn btn-primary btn-block" href="/dashboard/groups/{{$group->id}}#joinmeeting">Prisijungti prie pamokos</a>--}}
{{--                                                        @endif--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


    <script>
        $(".group--actions--button").click(function() {
            var visible = $(this).parent().find(".group--actions--dropdown").is(":visible");
            $(".group--actions--dropdown").hide();
            if(!visible){
                $(this).parent().find(".group--actions--dropdown").show();
            }
        });
        $("[data-href]").click(function(){
            window.location.href = $(this).attr("data-href");
        }).find(".group--actions").click(function(e) {
            e.stopPropagation();
        });
    </script>

</x-app-layout>