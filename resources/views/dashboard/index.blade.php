<x-user>

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
        <div class="lessons-list">
            @foreach(Auth::user()->getGroupedGroups() as $weekday => $groups)
                @foreach($groups as $group)
                    @php
                        $nextLesson = \App\Http\Controllers\GroupController::nextLesson($group);
                    @endphp
                    <div class="lesson-area {{ $group->type }}">
                        <a href="/dashboard/groups/{{$group->slug}}"><h3>{{Auth::user()->role !== 'user' ? '#'.$group->id : ''}} {{$group->name}}</h3></a>
                        @if($nextLesson)
                            <div class="info">{{ App\TimeZoneUtils::updateTime($nextLesson->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i"), $nextLesson->updated_at) }} ({{ Cookie::get("user_timezone", "GMT") }})</div>
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
                                <button class="btn blue mx-1">Grupė</button>
                            </a>
                            @if($nextLesson)
                                <a @if($nextLesson->join_link) href="{{ $nextLesson->join_link }}" target="_blank" @else href="/dashboard/groups/{{$group->id}}#joinmeeting" @endif>
                                    <button class="btn green mx-1">Prisijungti</button>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
            @if((\App\Http\Controllers\UserController::hasGroup() && !\App\Http\Controllers\UserController::hasDemoLesson())
    || (Auth::user()->role === 'admin' && !empty($meetings)))
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
                            <div class="info"><span>{{$meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d")}}</span>
                                {{App\Models\Group::getWeekDay($meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->dayOfWeek)}},
                                <span>{{ App\TimeZoneUtils::updateTime($meeting->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i"), $meeting->updated_at) }}</span>
                                ({{Cookie::get("user_timezone", "GMT")}})</div>
                            <div class="desc">{!! strip_tags($meeting->description) !!}</div>
                            <a href="{{ $meeting->join_link }}">
                                <button class="btn green">Prisijungti</button>
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