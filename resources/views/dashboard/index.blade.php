<x-user>
    <div class="client--dashboard">
        @if(Auth::user()->role != "teacher")
            <div class="dashboard--misc--buttons">
                <a href="/dashboard/user-rewards" class="dashboard--button">
                    Apdovanojimai
                </a>
                <a href="/lietuviu-kalbos-pamokos" class="dashboard--button dashboard--button--main">
                    <img src="/images/icons/plus.svg"> Lietuvių kalbos pamokos
                </a>
            </div>
        @endif

        <h3>Labas!</h3>
        <p>Sveikiname prisijungus prie virtualios lituanistinės mokyklėlės.</p>
        <div class="lessons-list">
            @foreach(Auth::user()->getGroupedCoursesGroups() as $weekday => $groups)
                @foreach($groups as $group)
                    @php
                        $nextLesson = \App\Http\Controllers\GroupController::nextLesson($group);
                    @endphp
                    <div class="lesson-area {{ $group->type }}">
                        <a href="/dashboard/groups/{{$group->slug}}"><h3>{{Auth::user()->role !== 'user' ? '#'.$group->id : ''}} {{$group->name}}</h3></a>
                        @if($nextLesson)
                            <div class="info">{{ App\TimeZoneUtils::updateTime($nextLesson->date_at->timezone(Cookie::get("user_timezone", "Europe/London")), $nextLesson->updated_at)->format('Y-m-d H:i') }} ({{ Cookie::get("user_timezone", "Europe/London") }})</div>
                        @else
                            <div class="info">Kita pamoka: nėra</div>
                        @endif
                        <div class="row d-flex justify-content-center mb-2">
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
                        <div class="row d-flex justify-content-center">
                            <a href="/dashboard/groups/{{$group->slug}}">
                                <button class="btn-groups btn blue mx-1">Informacija</button>
                            </a>
                            @if($nextLesson)
                                <a @if($nextLesson->join_link) href="{{ $nextLesson->join_link }}" target="_blank" @else href="/dashboard/groups/{{$group->id}}#joinmeeting" @endif>
                                    <button class="btn-groups btn green mx-1">Prisijungti</button>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
                @php $bilingualismGroups = Auth::user()->getGroupedConsultationGroups()  @endphp
                @if(!empty($bilingualismGroups))
                <h3 class="day mt-2">Dvikalbystės konsulstacijos</h3>
                    @foreach($bilingualismGroups as $weekday => $groups)
                        @foreach($groups as $group)
                            @php
                                $nextLesson = \App\Http\Controllers\GroupController::nextLesson($group);
                            @endphp
                            <div class="lesson-area {{ $group->type }}">
                                <a href="{{route('groups-consultation', $group->slug)}}"><h3>{{Auth::user()->role !== 'user' ? '#'.$group->id : ''}} {{$group->name}}</h3></a>
                                @if($nextLesson)
                                    <div class="info">{{ App\TimeZoneUtils::updateTime(
                                    $nextLesson->date_at->timezone(Cookie::get("user_timezone", "Europe/London")), $nextLesson->updated_at)
                                    ->format('Y-m-d H:i') }} ({{ Cookie::get("user_timezone", "Europe/London") }})
                                    </div>
                                @else
                                    <div class="info">Kita pamoka: nėra</div>
                                @endif
                                <div class="row d-flex justify-content-center">
                                    <a href="{{route('groups-consultation', $group->slug)}}">
                                        <button class="btn-groups btn blue mx-1">Informacija</button>
                                    </a>
                                    @if($nextLesson)
                                        <a @if($nextLesson->join_link) href="{{ $nextLesson->join_link }}" target="_blank" @else href="/dashboard/groups/{{$group->id}}#joinmeeting" @endif>
                                            <button class="btn-groups btn green mx-1">Prisijungti</button>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endif
            @if((\App\Http\Controllers\UserController::hasGroup() && !\App\Http\Controllers\UserController::hasDemoLesson())
    || (!empty($meetings)))
                <div class="meetings">
                    <h3 class="day">Nemokami susitikimai</h3>
                    @foreach($meetings as $meeting)
                        <div class="meeting-block justify-content-center mt-4">
                            <div class="icon color background--blue">
                                @if($meeting->photo)
                                    <img src="uploads/meetings/{{ $meeting->photo }}" alt="">
                                @endif
                            </div>
                            <h3>{{$meeting->name}}</h3>
                            @if ($meeting->show_date)
                                <div class="info"><span>{{$meeting->date_at->timezone(Cookie::get("user_timezone", "Europe/London"))->format("Y-m-d")}}</span>
                                    {{App\Models\Group::getWeekDay($meeting->date_at->timezone(Cookie::get("user_timezone", "Europe/London"))->dayOfWeek)}},
                                    <span>{{ App\TimeZoneUtils::updateTime($meeting->date_at->timezone(Cookie::get("user_timezone", "Europe/London")), $meeting->updated_at)->format('H:i') }}</span>
                                    ({{Cookie::get("user_timezone", "Europe/London")}})</div>
                            @endif
                            <div class="desc">{!! strip_tags($meeting->description) !!}</div>
                            <a href="{{ $meeting->join_link }}">
                                <button class="btn-groups btn green">Prisijungti</button>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


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

</x-user>