
<div class="card">
    <div class="row">
        <div class="col-xl-10 offset-xl-1">
            @if(isset($message))
                <div class="row">
                    <div class="col-xl-8 offset-xl-2">
                        <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
                    </div>
                </div>
            @endif
            <div class="group--description">
                <?php $nextEvent = \App\Http\Controllers\GroupController::nextLessonButton($group); ?>
                @if($nextEvent && $nextEvent->zoom_meeting_id)
                    <div class="group--next--button">
                        {{--                                <a class="btn btn-primary" href="{{ $nextEvent->join_link }}">Prisijungti į pamoką</a>--}}
                        <a class="btn btn-primary" zoom-join>Prisijungti į pamoką</a>
                    </div>
                @endif
                @if($nextEvent && Auth::user()->role != "user" && !$nextEvent->zoom_meeting_id)
                    <div class="group--next--button">
                        <a class="btn btn-primary" href="/dashboard/create-zoom-meeting/{{ $nextEvent->id }}">Sukurti Zoom Meeting</a>
                    </div>
                @endif
                <div class="group--color group--color--big floating group--{{ $group->type }}"></div>
                <h3 class="text-dark mt-4">{{$group->name}}  <small>{{ \App\Http\Controllers\GroupController::nextLesson($group)->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</small></h3>
                <div>{!! $group->display_name !!}</div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <nav class="navbar-light navbar-expand-md group--navbar">
                        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navcol-1">
                            <ul class="nav navbar-nav">
                                @if(\App\Http\Controllers\GroupController::nextLessonButton($group))
                                    {{--                                            <li class="nav-item"><a class="nav-link text-info" href="{{ \App\Http\Controllers\GroupController::nextLessonButton($group)->join_link }}">Prisijungti į pamoką</a></li>--}}
                                @else
                                    {{--                                                        <li class="nav-item"><a class="nav-link text-danger" href="#">Prisijungti į pamoką</a></li>--}}
                                @endif
                                <li class="nav-item"><a class="nav-link clickableElement active" href="#">Pokalbiai</a></li>
                                <li class="nav-item"><a class="nav-link clickableElement" href="#">Mokytojo media</a></li>
                                <li class="nav-item"><a class="nav-link clickableElement" href="#">Nariai</a></li>
                                <li class="nav-item"><a class="nav-link clickableElement" href="#">Tvarkaraštis</a></li>
                                @if(Auth::user()->role == "admin" || Auth::user()->role == "teacher")
                                    <li class="nav-item"><a class="nav-link clickableElement" href="#">Lankomumas</a></li>
                                @endif
                                <li class="nav-item"><a class="nav-link clickableElement" href="#">Informacija</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row" id="chat">
                        <div class="col">
                            <div class="row">
                                <div class="col-xl-12">
                                    <form method="POST" action="/dashboard/groups/{{$group->id}}">
                                        @csrf
                                        @method("OPTIONS")
                                        <div class="form-row">
                                            <div class="col-xl-12">
                                                <div class="form-group" style="background: #fff">
                                                    <input type="hidden" name="groupID" value="{{$group->id}}">
                                                    <div class="chat--input">
                                                        <div class="student--image" @if(count(Auth::user()->studentsInGroup($group)) && Auth::user()->studentsInGroup($group)[0]->photo) style="background-image: url('/uploads/students/{{ Auth::user()->studentsInGroup($group)[0]->photo }}')" @endif ></div>
                                                        <input class="form-control" type="text" name="text" placeholder="Įrašykite žinutę...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row" style="overflow: auto;">
                                        <div class="col">
                                            @foreach($group->group_message()->orderBy("id", "DESC")->get() as $msg)
                                                <div class="col chat--message">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="student--image" @if(count($msg->author->studentsInGroup($group)) && $msg->author->studentsInGroup($group)[0]->photo) style="background-image: url('/uploads/students/{{ $msg->author->studentsInGroup($group)[0]->photo }}')" @endif ></div>
                                                            <div class="chat--message--info">
                                                                <b>{{$msg->author->name}}</b>
                                                                {{--                                                                    <span class="badge badge-pill badge-info">{{$msg->author->roleText()}}</span>--}}
                                                                <br><span>{{$msg->created_at->format("Y-m-d H:i")}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p>{{ strip_tags($msg->message) }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="members" style="display: none;">
                        <div class="col">
                            <form>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-xl-4 offset-xl-0">
                                            <input type="text" class="form-control" />
                                        </div>
                                        <div class="col align-self-center">
                                            <button class="btn btn-dark btn-sm" type="button">Ieškoti</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="form-row">
                                <div class="col">
                                    <hr />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                            @foreach($group->students as $student)
                                                <tr class="d-flex">
                                                    <td class="col-1 text-center">
                                                        <div class="student--image" @if($student->photo) style="background-image: url('/uploads/students/{{ $student->photo }}')" @endif ></div>
                                                    </td>
                                                    <td class="col-9">
                                                        {{$student->name}}<br>
                                                        <small>{{ $student->user->name }} {{ $student->user->surname }}</small>
                                                    </td>
                                                    <td class="col-2">
                                                        <button class="btn btn-dark btn-sm" value="{{$student->id}}" data-toggle="modal" data-target="#sendMessageModal" data-user-name="{{ $student->name }}" data-user-id="{{ $student->id }}">
                                                            Siųsti žinutę
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Siųsti žinutę</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Atšaukti</button>
                                        <button type="button" class="btn btn-primary send--message">Išsiųsti</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            $('[data-target="#sendMessageModal"]').click(function () {
                                var name = $(this).attr("data-user-name");
                                var id = $(this).attr("data-user-id");
                                var html = "<p>Žinutė naudotojui "+name+":</p>";
                                html += "<textarea class='form-control' id='messagenote'></textarea>";
                                $("#sendMessageModal .modal-body").html(html);

                                $("#sendMessageModal .send--message").unbind().click(function() {
                                    $("#sendMessageModal .modal-footer").hide();
                                    var message = $("#sendMessageModal .modal-body textarea").val();
                                    $("#sendMessageModal .modal-body").html("Žinutė siunčiama <i class='fas fa-spinner fa-spin'></i>");
                                    $('#messagenote').summernote();
                                    <?php
                                    $student_names = [];
                                    foreach(Auth::user()->students()->where("group_id", $group->id)->get() as $student){
                                        $student_names[] = $student->name;
                                    }
                                    ?>
                                    $.post("/dashboard/groups/message",{_token: "{{ csrf_token() }}", user_id: id, message: message, user_from: "{{ join(", ", $student_names) }}"}, function (data) {
                                        data = JSON.parse(data);
                                        if(data.status == "success"){
                                            $("#sendMessageModal .modal-body").html(data.message);
                                        }else{
                                            $("#sendMessageModal .modal-body").html("Klaida! "+data.message);
                                        }
                                    });
                                });
                            });
                        </script>
                    </div>

                    <div class="row" id="media" style="display: none;">
                        @if(Auth::user()->role != "user")
                            <div class="col-xl-6">
                                <form data-upload>
                                    <h2>Įkelti naują bylą</h2>
                                    <div class="form-row">
                                        <div class="col-xl-10 ">
                                            <div class="form-group"><input name="upload_file" type="file" class="form-control-file"/></div>
                                        </div>
                                        <div class="col align-self-center">
                                            <div class="form-group"><button class="btn btn-success btn-sm file--upload--button" type="submit">Įkelti</button></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="progress" style="display: none;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        <div class="col-xl-12">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody class="files">
                                                @foreach($group->files as $file)
                                                    <tr>
                                                        <td>{{ $file->name }}</td>
                                                        <td>
                                                            <a href="{{ url("/uploads/".$file->name) }}" class="btn btn-success btn-sm" target="_blank">Atsisiųsti / Rodyti</a>
                                                            @if(Auth::user()->role != "user")
                                                                <a data-file-delete="{{ $file->id }}" class="btn btn-danger btn-sm">Ištrinti</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--                                            <div class="form-row">--}}
                            {{--                                                <div class="col-xl-4 offset-xl-8">--}}
                            {{--                                                    <nav>--}}
                            {{--                                                        <ul class="pagination">--}}
                            {{--                                                            <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>--}}
                            {{--                                                            <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
                            {{--                                                            <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
                            {{--                                                            <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
                            {{--                                                            <li class="page-item"><a class="page-link" href="#">4</a></li>--}}
                            {{--                                                            <li class="page-item"><a class="page-link" href="#">5</a></li>--}}
                            {{--                                                            <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>--}}
                            {{--                                                        </ul>--}}
                            {{--                                                    </nav>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                        </div>
                    </div>

                    <div class="row" id="timetable" style="display: none;">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Laikas</th>
                                        <th>Pavadinimas</th>
                                        <th>Mokytojas</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($group->events()->where("date_at", ">" ,\Carbon\Carbon::now('utc')->addHours(3))->orderBy("date_at","ASC")->get() as $event)
                                        <tr>
                                            <td>{{ $event->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }}</td>
                                            <td>{{ $event->name }}</td>
                                            <td>{{ $event->teacher->name }} {{ $event->teacher->surname }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="information" style="display: none;">
                        <div class="col">
                            {!! $group->information !!}
                        </div>
                    </div>


                    @if(Auth::user()->role != "user")
                        <div class="row" id="attendance" style="display: none;">
                            <div class="col">
                                <?php
                                $current_event = \App\Http\Controllers\GroupController::nextLessonButton($group);

                                $current_event_students = [];
                                if($current_event){
                                    foreach ($current_event->groups as $group) {
                                        foreach ($group->students as $student){
                                            $current_event_students[] = $student;
                                        }
                                    }
                                }
                                ?>
                                @if($current_event)
                                    <h3 class="text-dark mb-4">Dabartinis užsiėmimas: {{ $current_event->name }}</h3>
                                    <div>
                                        <form action="/dashboard/events/{{ $current_event->id }}/attendances" method="POST">
                                            @csrf
                                            @foreach($current_event_students as $student)
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-{{ $student->id }}" name="students[]" value="{{ $student->id }}" @if(\App\Models\Attendance::where("student_id", $student->id)->where("event_id",$current_event->id)->count()) checked @endif ><label class="form-check-label" for="formCheck-{{ $student->id }}">{{ $student->name }}</label></div>
                                            @endforeach
                                            <div class="form-group"><button class="btn btn-primary" type="submit">Įrašyti lankomumą</button></div>
                                        </form>
                                    </div>
                                @else
                                    <h3 class="text-dark mb-4">Šiuo metu joks užsiėmimas nevyksta</h3>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: calc(90vw + 33px);">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Zoom Susitikimas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">_</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="about:blank" style="width: 90vw; height: 85vh; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>