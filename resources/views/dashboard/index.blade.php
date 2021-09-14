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
                    @if((\App\Http\Controllers\UserController::hasGroup() && !\App\Http\Controllers\UserController::hasDemoLesson())
            || (Auth::user()->role === 'admin' && !empty($meetings)))
                    @foreach($meetings as $meeting)
                        <div class="group--item">
                            <div class="group--icon">
                                <div class="color background--blue" @if($meeting->photo) style="background-image: url('/uploads/meetings/{{ $meeting->photo }}')" @endif ></div>
                            </div>
                            <div class="group--info" >
                                <h3>{{$meeting->name}}</h3>
                                {!! strip_tags($meeting->description) !!}
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