<x-user>

    @php
        $groupMessage = false;
        $groupMessageSession = Session::get('groupMessage');
    if (!empty($groupMessageSession)) {
        $groupMessage = $groupMessageSession;
         Session::put('groupMessage', '');
    }

    @endphp

    <div class="modal-spinner"><!-- Place at bottom of page --></div>
    <div class="container" id="content">
            <div class="lesson-head">
                <div class="circle group--color group--{{ $group->type }}"></div>
                <div class="lesson-info">
                    <a onclick="goToHomeTab()" style="cursor: pointer">
                    <div class="title">{{ $group->name }}</div>
                    <?php $nextLesson = \App\Http\Controllers\GroupController::nextLesson($group); ?>
                    </a>

                    @if ($nextLesson)
                        <div class="time">{{ App\TimeZoneUtils::updateTime($nextLesson->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i"), $nextLesson->updated_at) }} {{ Cookie::get("user_timezone", "GMT") }}</div>
                    @endif
                    <small></small>

                    <div class="age-info">{{ $group->display_name }}
                        @if(Auth::user()->role != 'user')
                            (#g{{$group->id}})
                        @endif
                    </div>
                </div>
                @php  \Carbon\Carbon::setLocale('lt'); @endphp

                <div class="login-btn-area">
                    @if($nextLesson && $nextLesson->zoom_meeting_id)
                        <a href="#" zoom-join>Prisijungti į pamoką</a>
                    @endif
                    @if($nextLesson && $nextLesson->join_link)
                        <a href="{{ $nextLesson->join_link }}" target="_blank">Prisijungti į pamoką</a>
                    @endif

                </div>
            </div>
            <div class="row text-center" id="flash-message" style="display: block;">
                <div class="text-center">
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>
            </div>
            <section class="main-tabs-area">
                <div class="tabs">
                    <button class="tablinks active" data-country="tab-1">Namų darbai</button>
                    <button class="tablinks" data-country="tab-2">Pokalbiai ir nariai</button>
                    <button class="tablinks d-lg-none" data-country="tab-3">Informacija</button>
                    <button class="tablinks" data-country="tab-4">Apdovanojimai</button>
                </div>

                <!-- Tab content -->
                    <div class="wrapper_tabcontent">
                        <div id="tab-1" class="tabcontent active">
                            <div class="row no-gutters w-100">
                                <div class="main-tab-area col-lg-7 col-sm-12 col-12">
                                    <div class="main-info">
                                        <h3>Namų darbai</h3>
                                        <div class="subtitle">Pamokos refleksija ir paskirtos užduotys</div>
                                        @if(Auth::user()->role != "user")
                                            <button  class="btn-groups btn blue new-post" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">Naujas įrašas</button>
                                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                                <div class="author-comment pl-0">
                                                    <form action="{{route('homework-store')}}" new-homework-file method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <textarea class="editor" placeholder="komentuoti" name="file_name" rows="1" id="ckeditor" style="width: 100%;overflow-y: hidden; border: 0px"></textarea>
                                                        <input type="hidden" name="group_id" value="{{$group->id}}">
                                                        <div class="edit-buttons" id="home-work-main-store">
                                                            <div class="left-col mt-2">
                                                                <button id="button" name="file-homework-store" type="button" value="Upload" onclick="addHomeworkFile('home-work-main-store');" class="btn-groups btn blue attachment align-bottom">Prisegti dokumentą</button>
                                                                <input name="file" type="file" id="file-homework-store" style="display:none;"/>
                                                            </div>
                                                            <div class="right-col mt-2">
                                                                <button type="submit" class="btn-groups btn blue post">Skelbti</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <ul id="homework-list-main" class="list-unstyled">
                                    @php $groupFiles = $group->files()->orderBy('created_at', 'desc')->get();
                                    $groupFilesCount = $groupFiles->count();
                                    @endphp
                                    @foreach($groupFiles as $file)
                                        <li class="homework-list" style=" display:none;">
                                        <div class="author-comment" id="homework-file-main-{{$file->id}}">
                                            <div class="author">{{$file->user->name}} {{$file->user->surname}}</div>
                                            <div class="date">{{ $file->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d") }}</div>
    <!--                                        --><?php //$displayName = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $file->display_name); ?>
                                            <div class="desc">@php echo $file->display_name; @endphp</div>
                                            @if (!empty($file->name))
                                                <div class="attachments">
                                                    <div class="attachment">
                                                        <a target="_blank" href="{{ url("/uploads/".$file->name) }}" class="file">Prisegtas dokumentas</a>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(Auth::user()->role == "admin" || (Auth::user()->role == 'teacher' && Auth::user()->id === $file->user_id))
                                                <div class="edit-buttons">
                                                    <div class="left-col">
                                                        <button data-toggle="modal" onclick="addCkeditor('text-area-edit-'+{{$file->id}})" type="button" data-target="#edit-modal-{{$file->id}}" class="btn-groups btn blue edit">Redaguoti</button>
                                                    </div>
                                                    <div class="right-col">
                                                        <form delete-homework action="{{route('delete-homework-file', $file->id)}}" method="POST">
                                                            @method('POST')
                                                            @csrf
                                                            <input type="hidden" name="group_id" value="{{$group->id}}">
                                                            <button type="submit" class="btn-groups btn blue remove-post">Ištrinti</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="modal fade" id="edit-modal-{{ $file->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{route('homework-edit', $file->id)}}" homework-edit-file method="POST" enctype="multipart/form-data">
                                                            <div class="author-comment">
                                                                <div class="author">{{$file->user->name}} {{$file->user->surname}}</div>
                                                                <div class="date mb-2">{{ $file->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }}</div>
                                                                <input type="hidden" name="group_id" value="{{$group->id}}">
                                                                <div class="desc edit">
                                                                    <textarea name="file_name" id="text-area-edit-{{$file->id}}" class="editor" rows="5" style="width: 100%;overflow-y: hidden; border: 0px" >{{$file->display_name}}</textarea>
                                                                </div>
                                                                <div class="edit-buttons mt-2" id="homework-add-file-{{$file->id}}">
                                                                    <div class="left-col">
                                                                        <button type="button" onclick="addHomeworkFile('homework-add-file-'+{{$file->id}})" name="file-homework-edit-input-{{$file->id}}" class="btn-groups btn blue attachment">Prisegti dokumentą</button>
                                                                        <input name="file" id="file-homework-edit-input-{{$file->id}}" value="{{$file->name}}" type="file" style="display:none;">
                                                                    </div>
                                                                    <div class="right-col">
                                                                        @if (!empty($file->name))
                                                                            <div class="attachments pl-2" id="homework-add-file-{{$file->id}}">
                                                                                <div class="attachment">
                                                                                    <a target="_blank" href="{{ url("/uploads/".$file->name) }}" class="file">Prisegtas dokumentas</a>
                                                                                    <a onclick="deleteEditHomeworkFile('homework-add-file-'+{{$file->id}})" class="remove-attachment"></a>
                                                                                    <input type="hidden" name="oldFile" value="1">
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn-groups btn blue post active">Skelbti</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <form  method="POST" action="{{ route('comments.store') }}" comments-form id="comment-post-{{$file->id}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="comment-form">
                                                    <input type="hidden" name="commentable_encrypted_key" value="{{ $file->getEncryptedKey() }}"/>
                                                    <textarea name="message" class="comment" rows="1" cols="50" placeholder="komentuoti"></textarea>
    {{--                                                <input type="text" class="comment" placeholder="Komentuoti" value="" name="message">--}}
                                                    <input type="hidden" name="group_id" value="{{$group->id}}">
                                                    <label  onclick="addCommentFile('comment-post-'+{{$file->id}})" class="file"></label>
                                                    <input type="file" name="file" id="file-attachment-post-{{ $file->id }}" class="file-attachment" />
                                                    <button type="submit" class="submit" id="submit"></button>
                                                </div>
                                            </form>
                                            <x-comment-custom :model="$file"/>
                                        </div>
                                    </li>
                                    @endforeach
                                    </ul>
                                    @if($groupFilesCount > 3)
                                        <div id="loadMore-homework" class="text-center fa-bold mb-2" style="cursor: pointer;">Rodyti daugiau</div>
                                    @endif
                                </div>
                                <div class="sidebar-area col-lg-5 col-sm-12 col-12">
                                    <div class="information-block tab-content-display-none">
                                        <h3>Informacija</h3>
                                        <div class="desc">{!! $group->information !!}</div>
                                    </div>
                                    @php $events = $group->events()->where("date_at", ">" ,\Carbon\Carbon::now('utc')->subMinutes(30)->format('Y-m-d H:i:s'))->orderBy("date_at","ASC")->get(); @endphp
                                        <div class="schedule-block">
                                            <div class="dashboard--block">
                                                <h3>Tvarkaraštis</h3>
                                                @if (!$events->isEmpty())

                                                <div class="dashboard--timetable">
                                                    @foreach($events as $event)
                                                        <div class="dashboard--time">
                                                            <?php
                                                            $eventDate = $event->date_at->timezone(Cookie::get("user_timezone", "GMT"));
                                                            ?>
                                                            <div class="dashboard--time--date">{{ mb_strtoupper(mb_substr($eventDate->translatedFormat("F"),0,3)) }}<br><span>{{ $eventDate->format("d") }}</span></div>
                                                            <div class="dashboard--time--info">
                                                                <b>{{ $event->name }}</b> ∙ {{ $event->teacher->name }} {{ $event->teacher->surname }}<br>
                                                                {{\App\TimeZoneUtils::updateTime($eventDate->format("Y-m-d H:i"), $event->updated_at)}}                                                    </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="dashboard--time">
                                                            Tvarkaraščio nėra.
                                                    </div>
                                                @endif

                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tabcontent">
                            <div class="row no-gutters w-100">
                                <div class="main-tab-area col-lg-7 col-sm-12 col-12">
                                    <div class="main-info">
                                        <h3>Pokalbiai ir nariai</h3>
                                        <div class="subtitle">Bendraukite su grupės draugais</div>
                                    </div>

                                    <div class="chat-form">
                                        <div class="comments-list">
                                            <div class="mb-5">
                                                <form  method="POST" class="align-bottom" new-group-message action="{{ route('create-message-conversations') }}" id="group-message-store" enctype="multipart/form-data">
                                                    @csrf
                                                    @method("OPTIONS")
                                                    <div class="comment-form">
                                                        <textarea type="text" class="comment" placeholder="Rašyti"  name="text" style="width: 100%;overflow-y: hidden; border: 0px"></textarea>
                                                        <input type="hidden" name="groupID" value="{{$group->id}}">
                                                        <label onclick="addCommentFile('group-message-store')" class="file"></label>
                                                        <input  type="file" name="file" id="file-attachment-group-message-store" class="file-attachment" />
                                                        <button type="submit" class="submit" id="submit">
                                                    </div>
                                                </form>
                                            </div>
                                            @php $messages = $group->group_message()->orderBy("id", "Desc")->get(); @endphp
                                            @if (!$messages->isEmpty())
                                                @foreach($messages as $msg)
                                                    <?php
                                                    $student = null;
                                                    if($msg->author && count($msg->author->studentsInGroup($group)))
                                                        $student = $msg->author->studentsInGroup($group)[0];

                                                    ?>
                                                    <div class="comment-area" id="group-message-list-{{$msg->id}}">
                                                        <div class="author-icon">
                                                            @if($student && $student->photo)
                                                                <img class="user-photo-group" src="/uploads/students/{{ $student->photo }}" alt="Avatar">
                                                            @elseif($msg->author && $msg->author->photo)
                                                                <img class="user-photo-group" src="/uploads/users/{{ $msg->author->photo }}" alt="Avatar">
                                                            @else
                                                                <span class="icon-user"></span>
                                                            @endif
                                                        </div>
                                                        <div class="author-info">
                                                            <div class="author">
                                                                @if($student)
                                                                    <b>{{ $student->name }}</b> ∙ <br>
                                                                    @if($student->birthday){{ $student->age }} ∙ @endif {{ $msg->author->name }} {{ $msg->author->surname }}
                                                                @elseif($msg->author)
                                                                    <b>{{ $msg->author->name }} {{ $msg->author->surname }}</b><br>
                                                                @endif
                                                            </div>
                                                            <div class="time">{{$msg->updated_at->diffForHumans()}}</div>
                                                        </div>
                                                        <div class="comment">
                                                            <div class="text">
                                                                <?php $msg->message = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $msg->message);
                                                                 ?>
                                                                    <div class="desc edit">{!! nl2br($msg->message) !!}</div>
                                                            </div>
                                                            @if($msg->file)
                                                            <div class="attachments">
                                                                <div class="attachment">
                                                                    <a href="{{ url('uploads/group-messages/'.$msg->file)}}"  target="_blank" class="file">Prisegtas dokumentas</a>
                                                                </div>
                                                            </div>
                                                            @endif
                                                                @if($msg->author_id == Auth::user()->id || Auth::user()->role == 'admin')
                                                                    <div class="edit-buttons mt-2">
                                                                        <div class="left-col" style="float: left;">
                                                                            <button data-toggle="modal" onclick="addCkeditor('text-area-group-message-'+{{$msg->id}})" data-target="#edit-group-messages-{{$msg->id}}" class="btn-groups btn blue edit">Redaguoti</button>
                                                                        </div>
                                                                        <div class="right-col">
                                                                            <form delete-group-message action="{{route('delete-group-message', $msg->id)}}" method="POST">
                                                                                @method('POST')
                                                                                @csrf
                                                                                <input type="hidden" name="group_id" value="{{$group->id}}">
                                                                                <button type="submit" class="btn-groups btn blue remove-post">Ištrinti</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="edit-group-messages-{{ $msg->id }}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form action="{{route('edit-group-message', $msg->id)}}" edit-group-message-form  method="POST" enctype="multipart/form-data">
                                                                        <div class="author-comment">
                                                                            <div class="author">{{$msg->author->name}} {{$msg->author->surname}}</div>
                                                                            <div class="date mb-2">{{ $msg->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }}</div>
                                                                            <input type="hidden" name="group_id" value="{{$group->id}}">
                                                                            <div class="desc edit" style="word-break: break-word;"><textarea name="message" id="text-area-group-message-{{$msg->id}}" rows="5" style="width: 100%;overflow-y: hidden; border: 0px">{!! nl2br($msg->message) !!}</textarea></div>
                                                                            <div class="edit-buttons mt-2" id="group-message-add-file-{{$msg->id}}">
                                                                                <div class="left-col">
                                                                                    <button type="button" onclick="addHomeworkFile('group-message-add-file-'+{{$msg->id}})" name="group-message-edit-input-{{$msg->id}}" class="btn-groups btn blue attachment">Prisegti dokumentą</button>
                                                                                    <input name="file" id="group-message-edit-input-{{$msg->id}}" value="{{$msg->file}}" type="file" style="display:none;">
                                                                                </div>
                                                                                <div class="right-col">
                                                                                    @if($msg->file)
                                                                                        <div class="attachments pl-2" id="group-message-add-file-{{$msg->id}}">
                                                                                            <div class="attachment">
                                                                                                <a target="_blank" href="{{ url("/uploads/".$msg->file) }}" class="file">Prisegtas dokumentas</a>
                                                                                                <a onclick="deleteEditHomeworkFile('group-message-add-file-'+{{$msg->id}})" class="remove-attachment"></a>
                                                                                                <input type="hidden" name="chat-file" value="1">
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                    <button type="submit" class="btn-groups btn blue post active">Skelbti</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                @endforeach
                                            @else
                                                <div class="desc text-center">Nėra įrašų.</div>
                                            @endif

                                        </div>

                                        </div>
                                    </div>
                                <div class="sidebar-area col-lg-5 col-sm-12 col-12">
                                    <div class="members-block">
                                        <h3>Nariai</h3>
    {{--                                    <div class="subtitle">{!! $group->information !!}</div>--}}
                                        <div class="members-list">
                                            @foreach($group->students as $student)
                                                <div class="member">
                                                    <div class="author-icon">
                                                        @if($student->photo)
                                                            <img src="/uploads/students/{{ $student->photo }}">
                                                        @else
                                                            <span class="icon-user"></span>
                                                        @endif
                                                    </div>
                                                    <div class="author-info">
                                                        <div class="author-nick">{{$student->name}}</div>
                                                        <div class="author-fullname">
                                                            @if($student->birthday){{ $student->age }} ∙ @endif @if($student->user) {{ $student->user->name }} {{ $student->user->surname }} @endif
                                                        </div>
                                                    </div>
                                                    <button class="btn-groups btn blue" value="{{$student->id}}" data-toggle="modal" data-target="#sendMessageModal" data-user-name="{{ $student->name }}" data-user-id="{{ $student->id }}">Siųsti žinutę</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-4" class="tabcontent">
                            @php $rewards = $group->getGroupRewards(); @endphp
                            @if(!empty($rewards))
                                <div class="row mt-5 no-gutters">
                                    @foreach ($group->getGroupRewards() as $reward)
                                        <div class="col-md-12">
                                            <label class="form-check-label"><img src="/uploads/rewards/{{ $reward->file }}" style="height: 25px">{{$reward->user_name}}- {{ $reward->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                        <div id="tab-3" class="tabcontent d-lg-none">
                            <div class="row mt-5 no-gutters">
                                <div class="sidebar-area col-lg-5 col-sm-12 col-12">
                                    <div class="information-block">
                                        <h3>Informacija</h3>
                                        <div class="desc">{!! $group->information !!}</div>
                                    </div>
                            </div>
                        </div>

            </div>
            </section>
        </div>


    <!-- Modal -->
    <div class="modal fade" id="sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCensubscription_itemsterTitle" aria-hidden="true">
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
                    <button type="button" class="btn-groups btn btn-secondary" data-dismiss="modal">Atšaukti</button>
                    <button type="button" class="btn-groups btn btn-primary send--message">Išsiųsti</button>
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
    <script src="//cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            var size_li = $("#homework-list-main li.homework-list").length;
            var x=3;
            $('#homework-list-main li.homework-list:lt('+x+')').show();
            $('#loadMore-homework').click(function () {
                x= (x+3 <= size_li) ? x+3 : size_li;
                $('#homework-list-main li.homework-list:lt('+x+')').show();
            });
            $('#showLess-homework').click(function () {
                x=(x-3<0) ? 3 : x-3;
                $('#homework-list-main li.homework-list').not(':lt('+x+')').hide();
            });
        });
    </script>
    <script>
        $('[data-target="#sendMessageModal"]').click(function () {
            var name = $(this).attr("data-user-name");
            var id = $(this).attr("data-user-id");
            var html = "<p>Žinutė naudotojui "+name+":</p>";
            html += "<textarea class='form-control' id='messagenote'></textarea>";
            html += "<br><p>Prisegti dokumentą (maksimalus dokumento dydis - 20 Mb):</p>";
            html += '<input type="file" name="file" id="user_message_file" class="form-control-file mt-3" accept=".doc,.docx,.xls,.xlsx,.pdf,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4">';
            $("#sendMessageModal .modal-body").html(html);
            $("#sendMessageModal .modal-footer").show();

            var uploadField = document.getElementById("user_message_file");

            uploadField.onchange = function() {
                if(this.files[0].size > 20971520){
                    alert("Dokumentas per didelis!");
                    this.value = "";
                };
            };

            $("#sendMessageModal .send--message").unbind().click(function() {

                var fd = new FormData();
                var files = $("#user_message_file")[0].files;
                if(files.length){
                    fd.append('file',files[0]);
                }

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
                fd.append("_token", "{{ csrf_token() }}");
                fd.append("user_id", id);
                fd.append("message", message);
                fd.append("user_from", "{{ count($student_names) ? join(", ", $student_names) : Auth::user()->name . " " . Auth::user()->surname }}");

                $.ajax({
                    url: "/dashboard/groups/message",
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        data = JSON.parse(data);
                        if(data.status == "success"){
                            $("#sendMessageModal .modal-body").html(data.message);
                        }else{
                            $("#sendMessageModal .modal-body").html("Klaida! "+data.message);
                        }
                    }
                });
            });
        });
        function addCkeditor(id) {
            if ($('#cke_'+id).length != 1) {
                CKEDITOR.replace( id, {
                } );
            }

        }
        $( document ).ready(function() {
            CKEDITOR.replace( 'ckeditor', {
            } );

            var groupMessage = @json($groupMessage);
                if(groupMessage == true) {
                $('[data-country="tab-2"]').click();
            }
        });

        //
        $("[comments-form],[homework-edit-file], [edit-group-message-form], [new-group-message], [delete-homework], [delete-group-message], [delete-comment], [comment-reply], [comment-edit]").submit(function() {
            var pass = true;
            //some validations

            if(pass == false){
                return false;
            }
            var body = $("body");

            body.addClass("loading");

            return true;
        });
        function thisFileUpload(element) {
            document.getElementById(element.name).click();
        };

        function goToHomeTab() {
             $('[data-country="tab-1"]').click();
        }

        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight) + "px";
        }

        $("[zoom-join]").click(function() {
            joinMeeting(this);
        });
        function joinMeeting(button) {
            if($("#zoomModal iframe").attr("src") != "{{ url("/dashboard/events/".($nextLesson ? $nextLesson->id : '')."/zoom") }}"){
                $("#zoomModal iframe").attr("src", "{{ url("/dashboard/events/".($nextLesson ? $nextLesson->id : '')."/zoom") }}");
            }
            $("#zoomModal").modal("show");
            setTimeout(function() {
                $(button).html("Grįžti į pamoką");
            },500);
        }
        setTimeout(function() {
            if(window.location.hash) {
                var hash = window.location.hash.substring(1);
                if(hash == "joinmeeting"){
                    joinMeeting($("[zoom-join]"));
                }
            }
        },500);

        function addHomeworkFile(id) {
            var mainDiv = $('#'+id);
            mainDiv.find('input:file').click();
            if (mainDiv.find('div.attachment').length === 0) {
                $('#'+mainDiv.find('input:file').attr('id')).unbind();
                $('#'+mainDiv.find('input:file').attr('id')).unbind().change(function(e) {
                    if($(this).prop('files')[0].size > 20971520) {
                        alert("Dokumentas per didelis!");

                    } else {
                        mainDiv.find('.right-col').prepend('<div class="attachments">\n' +
                            '<div class="attachment">\n' +
                            '<a class="file">Prisegtas dokumentas</a>\n' +
                            '<a onclick="deleteEditHomeworkFile(\''+id+'\')" class="remove-attachment"></a>\n' +
                            '</div>\n' +
                            '</div>')
                    }
                });

            }
        }

        function addCommentFile(id) {
            var mainDiv = $('#'+id);
            mainDiv.find('input:file').click();
            if (mainDiv.find('div.attachment').length < 1) {
                $('#'+mainDiv.find('input:file').attr('id')).unbind();
                $('#'+mainDiv.find('input:file').attr('id')).unbind().change(function(e) {
                    if($(this).prop('files')[0].size > 20971520) {
                        alert("Dokumentas per didelis!");

                    } else {
                        mainDiv.append('<div class="attachments mt-2">\n' +
                            '<div class="attachment">\n' +
                            '<a class="file">Prisegtas dokumentas</a>\n' +
                            '<a onclick="deleteEditHomeworkFile(\''+id+'\')" class="remove-attachment" style="cursor: pointer"></a>\n' +
                            '</div>\n' +
                            '</div>')
                    }
                });

            }
        }

        function deleteEditHomeworkFile(id) {
            var mainDiv = $('#'+id);

            mainDiv.find('div.attachments').remove();
            mainDiv.find('input:file').val('');
        }

        function deleteHomeworkFile(element) {
            document.getElementById('file-homework-store').value = '';
            element.parentNode.parentNode.remove();
        }




        CKEDITOR.on('instanceReady', function( ev ) {
            var blockTags = ['div','h1','h2','h3','h4','h5','h6','p','pre','li','blockquote','ul','ol',
                'table','thead','tbody','tfoot','td','th',];

            for (var i = 0; i < blockTags.length; i++)
            {
                ev.editor.dataProcessor.writer.setRules( blockTags[i], {
                    indent : false,
                    breakBeforeOpen : true,
                    breakAfterOpen : false,
                    breakBeforeClose : false,
                    breakAfterClose : true
                });
            }
        });
    </script>
    </x-user>

{{--https://stackoverflow.com/questions/15389833/laravel-redirect-back-to-original-destination-after-login/39595605#39595605--}}