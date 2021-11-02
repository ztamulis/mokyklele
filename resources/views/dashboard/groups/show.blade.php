<x-app-layout>

    <div class="client--dashboard">
        <div class="dashboard--misc--buttons">
            <?php $nextEvent = \App\Http\Controllers\GroupController::nextLesson($group); ?>
            @if($nextEvent && $nextEvent->zoom_meeting_id)
                <a href="#" zoom-join class="dashboard--button dashboard--button--main">
                    Prisijungti į pamoką
                </a>
            @endif
            @if($nextEvent && $nextEvent->join_link)
                <a href="{{ $nextEvent->join_link }}" target="_blank" class="dashboard--button dashboard--button--main">
                    Prisijungti į pamoką
                </a>
            @endif
            @if($nextEvent && Auth::user()->role != "user" && !$nextEvent->zoom_meeting_id)
                <a href="/dashboard/create-zoom-meeting/{{ $nextEvent->id }}" class="dashboard--button dashboard--button--main">
                    Sukurti Zoom susitikimą
                </a>
            @endif
        </div>
        <div class="client--dashboard--title">
            <div class="client--dashboard--color group--color group--{{ $group->type }}"></div>
            <div class="client--dashboard--title--text">
                <h3>{{$group->name}}
                    <small>
                        @php
                            $nextLesson = \App\Http\Controllers\GroupController::nextLesson($group);
                        @endphp
                        @if (!empty($nextLesson))
                            {{ App\TimeZoneUtils::updateTime(\App\Http\Controllers\GroupController::nextLesson($group)->date_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i")) }} <small>({{ Cookie::get("user_timezone", "GMT") }})</small>
                        @endif
                    </small>
                </h3>
                <p>{!! $group->display_name !!}</p>
            </div>
        </div>

        @if(isset($message))
            <div class="dashboard--alert">
                <div class="dashboard--alert--image">
                    <img src="/images/icons/information.svg">
                </div>
                <div class="dashboard--alert--text">
                    <h3>Pranešimas</h3>
                    <p>{{ $message }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="dashboard--alert">
                <div class="dashboard--alert--image">
                    <img src="/images/icons/warning.svg">
                </div>
                <div class="dashboard--alert--text">
                    <h3>Klaida!</h3>
                    <p>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </p>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-6">
                <div class="dashboard--block">
                    <h3>Informacija</h3>
                    <p>
                        {!! $group->information !!}
                    </p>
                </div>
                <div class="dashboard--block no--padding">
                    <div class="dashboard--block--inner dashboard--block--header">
                        <h3>Namų darbai ir refleksija</h3>
                        Peržiūrėkite įkeltus mokytojo dokumentus
                    </div>
                    <div id="homework-files" class="files dashboard--scrolling--wrapper message-block-overflow">
                        @foreach($group->files as $file)
                            <?php

                            $fileNameExploded = explode(".", $file->name);
                            $fileExtension = $fileNameExploded[count($fileNameExploded)-1];
                            ?>
                            <div id="homework-main-{{$file->id}}">
                                <div class="dashboard--block--hr"></div>
                                <?php $displayName = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $file->display_name); ?>
                                @if(Auth::user()->role != 'user')
                                    <b><textarea class="dashboard--media" id="homework-message-{{$file->id}}" oninput="auto_grow(this)" name="message" style="border-width: 0px; width: 100%; height: 100%; color: black;" ><?php $displayName = $displayName ?? str_replace(".".$fileExtension, "", $file->display_name); echo strip_tags($displayName); ?></textarea></b>
                                @else
                                    <b> <span class="dashboard--media" style="color: black;"><?php $displayName = $displayName ?? str_replace(".".$fileExtension, "", $file->display_name); echo $displayName; ?></span></b><br>
                                @endif
                                <div class="row" style="margin-top: 30px;">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12" style="padding-left: 30px;<?= Auth::user()->role == 'user' ? 'margin-bottom: 12px;' : ''?>">
                                                <div class="row">
                                                    <div class="col-md-6 chat--div">
                                                        <span class="timezone-group-span">{{ $file->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }}</span>
                                                    </div>
                                                    <div class="col-md-6 chat--div" id="add-document-{{$file->id}}">
                                                        @if (!empty($file->name))
                                                            <u id="file-label-{{$file->id}}">
                                                                <a class="" href="{{ url("/uploads/".$file->name) }}" target="_blank">Prisegtas dokumentas</a>
                                                            </u>
                                                            @if(Auth::user()->role != "user")
                                                                <span id="close-btn-{{$file->id}}" onclick="deleteFile({{$file->id}})" class="close-btn-groups">x</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 right--buttons--block">
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-12 chat--div" >
                                                    </div>
                                                    @if(Auth::user()->role != "user")

                                                        <div class="col-md-3 col-sm-12 chat--div" >
                                                            <button type="button" class="dashboard--send--message--button dashboard--upload-file--button"  onclick="homeWorkChatFileName({{$file->id}}, this)">
                                                                <img src="/images/icons/upload.svg">
                                                            </button>
                                                            <input id="upload-photo-{{$file->id}}" data-homework-file-{{$file->id}} name="upload_file" type="file" class="dashboard--media--input" value="{{$file->name}}" style="display: none;"/>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 chat--div" >
                                                            <button type="submit" onclick="homeWorkChatEdit({{$file->id}})" class="dashboard--send--message--button file--upload--button">
                                                                <img src="/images/icons/paper-plane.svg">
                                                            </button>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 chat--div">
                                                            @if(Auth::user()->role != "user")
                                                                <a data-file-delete="{{ $file->id }}" class="dashboard--media--delete"><img src="/images/icons/trash.svg"> Ištrinti</a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear--fix"></div>
                            </div>

                        @endforeach


                    </div>
                    @if(Auth::user()->role != "user")
                        <div class="dashboard--block--hr"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <form data-upload>
                                    <textarea oninput="auto_grow(this)" id="home-work-input" name="file_name" type="text" class="dashboard--send--message--input" placeholder="Įrašykite namų darbus" ></textarea>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label id="upload-label" for="upload-photo" class="mb-5 mr-5 dasboard-add-document-button" ><b>Pridėti dokumentą</b></label>
                                                    <input id="upload-photo" name="upload_file" type="file" class="dashboard--media--input" style="display: none;"/>
                                                </div>
                                                <div class="col-md-4 add-document-new" id="homework-new-file-add-document">

                                                </div>
                                                <div class="col-md-2 offset-1">
                                                    <button type="submit" class="dashboard--send--message--button file--upload--button">
                                                        <img src="/images/icons/paper-plane.svg">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="dashboard--block">
                    <h3>Nariai</h3>
                    Kurse esantys nariai
                    <div class="dashboard--user--list">
                        @foreach($group->students as $student)
                            <div class="dashboard--user">
                                @if($student->user_id != Auth::user()->id)
                                    <div class="dashboard--misc--buttons dashboard--user--actions">
                                        <button class="dashboard--button dashboard--button--main only--desktop" value="{{$student->id}}" data-toggle="modal" data-target="#sendMessageModal" data-user-name="{{ $student->name }}" data-user-id="{{ $student->id }}">
                                            Siųsti žinutę
                                        </button>
                                        <button class="dashboard--button dashboard--button--main only--mobile" value="{{$student->id}}" data-toggle="modal" data-target="#sendMessageModal" data-user-name="{{ $student->name }}" data-user-id="{{ $student->id }}">
                                            <img src="/images/icons/paper-plane.svg">
                                        </button>
                                    </div>
                                @endif
                                <div class="dashboard--user--photo" @if($student->photo) style="background-image: url('/uploads/students/{{ $student->photo }}')" @endif></div>
                                <div class="dashboard--user--info">
                                    <b>{{$student->name}}</b><br>
                                    @if($student->birthday){{ $student->age }} ∙ @endif @if($student->user) {{ $student->user->name }} {{ $student->user->surname }} @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="dashboard--block no--padding ">
                    <div class="dashboard--block--inner dashboard--block--header">
                        <h3>Pokalbiai</h3>
                        Bendraukite su grupės draugais.
                    </div>
                    <div class="dashboard--block--hr"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dashboard--scrolling--wrapper message-block-overflow" data-chat-messages>

                                @foreach($group->group_message()->orderBy("id", "ASC")->get() as $msg)
                                    <?php
                                    $student = null;
                                    if($msg->author && count($msg->author->studentsInGroup($group)))
                                        $student = $msg->author->studentsInGroup($group)[0];
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="user--message">
                                                <div class="user--message--info">
                                                    <div class="user--message--photo" @if($student && $student->photo) style="background-image: url('/uploads/students/{{ $student->photo }}')" @elseif($msg->author && $msg->author->photo) style="background-image: url('/uploads/users/{{ $msg->author->photo }}')" @endif ></div>
                                                    <div class="user--message--name">
                                                        @if($student)
                                                            <b>{{ $student->name }}</b> ∙ {{ $msg->lithuanianDate() }}<br>
                                                            @if($student->birthday){{ $student->age }} ∙ @endif {{ $msg->author->name }} {{ $msg->author->surname }}
                                                        @elseif($msg->author)
                                                            <b>{{ $msg->author->name }} {{ $msg->author->surname }}</b> ∙ {{ $msg->lithuanianDate() }}<br>
                                                            {{ $msg->author->name }} {{ $msg->author->surname }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($msg->author_id == Auth::user()->id)
                                        <form method="POST" action="/dashboard/groups/message/{{$msg->id}}/edit" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="dashboard--media" >
                                                        <?php $msg->message = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $msg->message); ?>
                                                        <textarea oninput="auto_grow(this)"  name="message" style="border-width: 0px; width: 100%; height: 100%; color: black;" ><?php echo strip_tags($msg->message) ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="dashboard--media">
                                                            <p style="color: black;">
                                                                <?php $msg->message = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $msg->message);
                                                                echo $msg->message; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-12" style="padding-left: 30px;">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
{{--                                                                <div class="col-md-6" style="padding-left:0px; padding-right:0px;" >--}}
{{--                                                                    <span class="timezone-group-span"></span>--}}
{{--                                                                </div>--}}
                                                                <div class="col-md-6"  id="add-chat-document-{{$msg->id}}" style="padding-left: 6px; padding-right:0px; font-size: 10px;">
                                                                    @if($msg->file)
                                                                        <u id="file-label-chat-{{$msg->id}}">
                                                                            <a href="{{ url('uploads/group-messages/'.$msg->file)}}" style="color: #000;" target="_blank">Prisegtas dokumentas </a>
                                                                            <input id="chat-file-{{$msg->id}}" name="chat-file" type="hidden" value="1">
                                                                        </u>
                                                                        @if(Auth::user()->role != "user")
                                                                            <span id="close-chat-btn-{{$msg->id}}" onclick="deleteFileChat({{$msg->id}})" class="close-btn-groups">x</span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($msg->author_id == Auth::user()->id || Auth::user()->role == 'admin')
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12 right--buttons--block">
                                                                        <div class="row">
                                                                            <div class="col-md-3 col-sm-12 chat--div">
                                                                            </div>
                                                                            <div class="col-md-3  col-sm-12 chat--div">
                                                                                <input type="hidden" name="groupID" value="{{$group->id}}">
                                                                                <input id="data-chat-file-input-{{$msg->id}}" type="file" name="file" style="display: none;" data-chat-file-{{$msg->id}} accept=".doc,.docx,.xls,.xlsx,.pdf,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4">
                                                                                <button type="button" class="dashboard--send--message--button dashboard--upload-file--button" onclick="chatFileName({{$msg->id}}, this)">
                                                                                    <img src="/images/icons/upload.svg">
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-md-3  col-sm-12 chat--div">
                                                                                <button type="submit" class="dashboard--send--message--button">
                                                                                    <img src="/images/icons/paper-plane.svg">
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-md-3  col-sm-12 chat--div" >
                                                                                <a data-message-delete="{{ $msg->id }}" class="dashboard--media--delete"><img src="/images/icons/trash.svg"> Ištrinti</a>
                                                                                <div class="clear--fix"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if($msg->author_id == Auth::user()->id)
                                        </form>
                                    @endif


                                    <div class="dashboard--block--hr"></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="dashboard--block--hr"></div>
                        {{--                    <div class="dashboard--send--message">--}}
                        <div class="col-md-12">
                            <div class="dashboard--block--hr"></div>
                            <form method="POST" action="/dashboard/groups/createMessage" enctype="multipart/form-data">
                                @csrf
                                @method("OPTIONS")
                                <textarea oninput="auto_grow(this)" type="text" name="text" class="dashboard--send--message--input" placeholder="Įrašykite žinutę..."></textarea>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="hidden" name="groupID" value="{{$group->id}}">
                                                <label id="upload-label" for="upload-chat-file" class="mb-5 mr-5 dasboard-add-document-button" ><b>Pridėti dokumentą</b></label>
                                                <input id="upload-chat-file" type="file" name="file" style="display:none;" data-chat-file accept=".doc,.docx,.xls,.xlsx,.pdf,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4">
                                                <div class="file--name" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="col-md-4 add-document-new" id="new-file-add-document">

                                            </div>
                                            <div class="col-md-2 offset-1" style="margin-left: 10px;">
                                                <button type="submit" class="dashboard--send--message--button">
                                                    <img src="/images/icons/paper-plane.svg">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="dashboard--block">
                    <h3>Tvarkaraštis</h3>
                    <div class="dashboard--timetable">
                        <?php
                        setlocale(LC_TIME, 'lt_LT');
                        \Carbon\Carbon::setLocale('lt');
                        ?>
                        @foreach($group->events()->where("date_at", ">" ,\Carbon\Carbon::now('utc')->addHours(3))->orderBy("date_at","ASC")->get() as $event)
                            <div class="dashboard--time">
                                <?php
                                $eventDate = $event->date_at->timezone(Cookie::get("user_timezone", "GMT"));
                                /*$today = date("Y-m-d H:i");
                                $summerday = date("Y-03-28 5:00");
                                $winterday = date("Y-10-31 5:00");
                                if($today >= $summerday){
                                    $eventDate = $event->date_at->timezone(Cookie::get("user_timezone", "GMT"))->subHour();
                                }else if($today == $winterday){
                                    $eventDate = $event->date_at->timezone(Cookie::get("user_timezone", "GMT"))->addHour();
                                }*/
                                ?>
                                <div class="dashboard--time--date">{{ mb_strtoupper(mb_substr($eventDate->translatedFormat("F"),0,3)) }}<br><span>{{ $eventDate->format("d") }}</span></div>
                                <div class="dashboard--time--info">
                                    <b>{{ $event->name }}</b> ∙ {{ $event->teacher->name }} {{ $event->teacher->surname }}<br>
                                    {{ \App\TimeZoneUtils::updateTime($eventDate->format("Y-m-d H:i")) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
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

    <script>
        $("[data-chat-messages] .dashboard--block--hr:last-child").remove();
        $("[data-chat-messages]").scrollTop(999999999);

        function homeWorkChatFileName(id) {

            $('[data-homework-file-'+id+']').unbind().click();
            $('[data-homework-file-'+id+']').unbind().change(id, function() {
                if($('#upload-photo-'+id).prop('files')[0].size > 20971520) {
                    alert("Dokumentas per didelis!");
                } else {
                    if ($('#file-label-'+id).find('a').length === 0) {
                        var appenderString = '<u id="file-label-'+id+'">' +
                            '<a class="" target="_blank">Prisegtas dokumentas</a>' +
                            '</u><span id="close-btn-'+id+'" onclick="deleteFile('+id+')" class="close-btn-groups">x</span>';
                        $('#add-document-'+id).append(appenderString);
                    } else {
                        $('#file-label-'+id).find('a').html('Prisegtas dokumentas');
                        $('#close-btn-'+id).html('x');
                    }

                }
            });
        }

        function chatFileName(id) {
            $('[data-chat-file-'+id+']').unbind().click();
            $('[data-chat-file-'+id+']').unbind().change(id, function() {
                if($('#data-chat-file-input-'+id).prop('files')[0].size > 20971520) {
                    alert("Dokumentas per didelis!");
                    // $('#data-chat-file-input-'+id).val('');

                } else {

                    if ($('#file-label-chat-'+id).find('a').length === 0) {
                        var appenderString = '<u id="file-label-chat-'+id+'">' +
                            '<a class="" target="_blank">Prisegtas dokumentas</a>' +
                            '</u><span id="close-chat-btn-'+id+'" style="color: #000; onclick="deleteFileChat('+id+')" class="close-btn-groups">x</span>';
                        $('#add-chat-document-'+id).append(appenderString);
                    } else {
                        $('#file-label-chat-'+id).find('a').html('Prisegtas dokumentas');
                        $('#close-chat-btn-'+id).html('x');
                    }

                }
            });
        }





        // $("[data-chat-file]").change(function() {
        //     if(this.files[0].size > 20971520) {
        //         alert("Dokumentas per didelis!");
        //         this.value = "";
        //     }
        //     var filename = $(this)[0].files.length ? $(this)[0].files[0].name : "";
        //     $(".file--name").html(filename).show();
        // });
        // $(".file--name").click(function() {
        //     $("[data-chat-file]").val('');
        //     $(this).hide();
        // })
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
                {{--$.post("/dashboard/groups/message",{_token: "{{ csrf_token() }}", user_id: id, message: message, user_from: "{{ join(", ", $student_names) }}"}, function (data) {--}}
                {{--    data = JSON.parse(data);--}}
                {{--    if(data.status == "success"){--}}
                {{--        $("#sendMessageModal .modal-body").html(data.message);--}}
                {{--    }else{--}}
                {{--        $("#sendMessageModal .modal-body").html("Klaida! "+data.message);--}}
                {{--    }--}}
                {{--});--}}
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $(function() {
                $('textarea').each(function() {
                    $(this).height($(this).prop('scrollHeight'));
                });
            });

            $(".clickableElement").click(function() {
                $(".nav a").removeClass("active");

                $("#members, #timetable, #chat, #media, #attendance, #information").hide();

                if($(this).text() == "Pokalbiai"){
                    $(this).addClass("active");

                    $("#chat").toggle();
                }
                if($(this).text() == "Nariai"){
                    $(this).addClass("active");

                    $("#members").toggle();
                }
                if($(this).text() == "Mokytojo media"){
                    $(this).addClass("active");

                    $("#media").toggle();
                }

                if($(this).text() == "Tvarkaraštis"){
                    $(this).addClass("active");

                    $("#timetable").toggle();
                }

                if($(this).text() == "Lankomumas"){
                    $(this).addClass("active");

                    $("#attendance").toggle();
                }

                if($(this).text() == "Informacija"){
                    $(this).addClass("active");

                    $("#information").toggle();
                }
            });
            console.log($("#homework-files").scrollTop(90000000000));
            $("#homework-files").scrollTop(90000000000);

            $("[data-upload]").submit(function(event){
                event.preventDefault();
                file = '';

                var form_data = new FormData();

                if (typeof $("#upload-photo").prop('files')[0] !== 'undefined') {
                    var file = $("#upload-photo").prop('files')[0];
                }
                var file_name = $("#home-work-input").val();

                form_data.append('file', file);
                form_data.append('file_name', file_name);
                form_data.append('_token', "{{ csrf_token() }}");
                form_data.append('group_id', "{{ $group->id }}");
                $(".progress").show();
                $(".file--upload--button").hide();
                $(".progress .progress-bar").css("width", 0);
                $.ajax({
                    url: '/dashboard/groups/upload', // point to server-side PHP script
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        if(myXhr.upload){
                            myXhr.upload.addEventListener('progress',progress, false);
                        }
                        return myXhr;
                    },
                    success: function(response){
                        $(".progress").hide();
                        $(".file--upload--button").show();
                        response = JSON.parse(response);
                        var displayName = response.display_name;
                        // if(!displayName) {
                        //     displayName = response.file.replace("." + extension, "");
                        // }
                        var prependString = '' +
                            '                                <b><textarea class="dashboard--media" id="homework-message-'+response.file.id+'" oninput="auto_grow(this)" name="message" style="border-width: 0px; width: 100%; height: 100%; color: black;" >'+displayName+'</textarea></b>'+
                            '                            <div class="row" style="margin-top: 30px;">'+
                            '                                <div class="col-md-6">'+
                            '                                    <div class="row">'+
                            '                                        <div class="col-md-12" style="padding-left: 30px;">'+
                            '                                            <div class="row">'+
                            '                                                <div class="col-md-6 chat--div">'+
                            '                                                    <span class="timezone-group-span">'+response.date+'</span>'+
                            '                                                </div>'+
                            '                                                <div class="col-md-6 chat--div" style="font-size: 10px;">\n';
                        if (response.file !== '') {
                            prependString += '<u id="file-label-'+response.id+'">' +
                                '<a class="" href="/uploads/'+response.file+'" target="_blank">Prisegtas dokumentas</a>' +
                                '</u><span id="close-btn-'+response.id+'" onclick="deleteFile('+response.id+')" class="close-btn-groups">x</span>';
                        }
                        prependString += ''+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '                                    </div>'+
                            '                                </div>'+
                            '                                <div class="col-md-6">'+
                            '                                    <div class="row">'+
                            '                                        <div class="col-md-12 right--buttons--block">'+
                            '                                            <div class="row">'+
                            '                                                <div class="col-md-3 col-sm-12 chat--div" >'+
                            '                                                </div>'+
                            '                                                    <div class="col-md-3 col-sm-12 chat--div" >'+
                            '                                                        <button type="button" class="dashboard--send--message--button dashboard--upload-file--button"  onclick="homeWorkChatFileName('+response.id+', this)">'+
                            '                                                            <img src="/images/icons/upload.svg">'+
                            '                                                        </button>'+
                            '                                                        <input id="upload-photo-'+response.id+'" data-homework-file-'+response.id+' name="upload_file" type="file" class="dashboard--media--input" value="'+response.file+'" style="display: none;"/>'+
                            '                                                    </div>'+
                            '                                                    <div class="col-md-3 col-sm-12 chat--div" >'+
                            '                                                        <button type="submit" onclick="homeWorkChatEdit('+response.id+')" class="dashboard--send--message--button file--upload--button">'+
                            '                                                            <img src="/images/icons/paper-plane.svg">'+
                            '                                                        </button>'+
                            '                                                    </div>'+
                            '                                                    <div class="col-md-3 col-sm-12 chat--div" >'+
                            '                                                            <a data-file-delete="'+response.id+'" class="dashboard--media--delete"><img src="/images/icons/trash.svg"> Ištrinti</a>'+
                            '                                                    </div>'+
                            '                                            </div>'+
                            '                                        </div>'+
                            '                                    </div>'+
                            '                                </div>'+
                            '                            </div>'+
                            '                            <div class="clear--fix"></div>';
                        $('#upload-photo').val('');
                        $('#home-work-input').val('');

                        $(".files").append(prependString);
                        // rebindFileEvents();
                    },
                    error: function (response) {
                        $(".progress").hide();
                        $(".file--upload--button").show();
                        alert("Klaida įkeliant bylą!");
                    }
                });
            });



            $('#upload-chat-file').unbind();
            $('#upload-chat-file').unbind().change(function() {
                console.log($('#upload-chat-file').prop('files'));
                if($('#upload-chat-file').prop('files')[0].size > 20971520) {
                    alert("Dokumentas per didelis!");
                    // $('#data-chat-file-input-'+id).val('');

                } else {
                    if ($('#new-file-add-document').find('a').length === 0) {
                        var appenderString = '<u id="file-label-chat">' +
                            '<a class="" target="_blank">Prisegtas dokumentas</a>' +
                            '</u><span id="close-chat-btn" style="color: #000;" onclick="deleteNewFileChat()" class="close-btn-groups">x</span>';
                        $('#new-file-add-document').append(appenderString);
                    } else {
                        $('#new-file-add-document').find('a').html('Prisegtas dokumentas');
                        $('#close-chat-btn').html('x');
                    }

                }
            });

            $('#upload-photo').unbind();
            $('#upload-photo').unbind().change(function() {
                console.log($('#upload-photo').prop('files'));
                if($('#upload-photo').prop('files')[0].size > 20971520) {
                    alert("Dokumentas per didelis!");
                    // $('#data-chat-file-input-'+id).val('');

                } else {
                    if ($('#homework-new-file-add-document').find('a').length === 0) {
                        var appenderString = '<u id="file-label-chat">' +
                            '<a class="" target="_blank">Prisegtas dokumentas</a>' +
                            '</u><span id="close-chat-btn" style="color: #000;" onclick="deleteHomeworkNewFileChat()" class="close-btn-groups">x</span>';
                        $('#homework-new-file-add-document').append(appenderString);
                    } else {
                        $('#homework-new-file-add-document').find('a').html('Prisegtas dokumentas');
                        $('#homework-new-file-add-document').html('x');
                    }

                }
            });
        });
        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight)+"px";
        }

        function deleteFile(id) {
            $('#upload-photo-'+id).val('');
            $('#file-label-'+id).find('a').html('');
            $('#file-label-'+id).find('a').removeAttr('href');
            $('#close-btn-'+id).html('');

            // self.html('');
        }

        function deleteFileChat(id) {
            $('#file-label-chat-'+id).find('a').html('');
            $('#file-label-chat-'+id).find('a').removeAttr('href');
            $('#chat-file-'+id).remove();
            $('#close-chat-btn-'+id).html('');
        }

        function deleteNewFileChat() {
            $('#new-file-add-document').html('');
        }

        function deleteHomeworkNewFileChat() {
            $('#homework-new-file-add-document').html('');
        }

        function homeWorkChatEdit(id) {
            var file = '';
            var oldFile = 0;
            if (typeof $("#upload-photo-"+id).prop('files')[0] !== 'undefined') {
                file = $("#upload-photo-"+id).prop('files')[0];
            }

            if (typeof $('#file-label-'+id).find('a').attr('href') !== 'undefined') {
                oldFile = 1;
            }

            var file_name = $("#homework-message-"+id).val();
            var form_data = new FormData();
            form_data.append('file', file);
            form_data.append('oldFile', oldFile);
            form_data.append('message', file_name);
            form_data.append('_token', "{{ csrf_token() }}");
            form_data.append('group_id', "{{ $group->id }}");
            form_data.append('id', id);
            $(".progress").show();
            $(".file--upload--button").hide();
            $(".progress .progress-bar").css("width", 0);
            $.ajax({
                url: '/dashboard/groups/homework/'+id+'/edit', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){
                        myXhr.upload.addEventListener('progress',progress, false);
                    }
                    return myXhr;
                },
                success: function(response){
                    response = JSON.parse(response);
                    console.log(response.name);
                    if (response.name !== '') {
                        $('#file-label-'+response.id).find('a').attr('href', '/uploads/'+response.name);
                    }
                    $(".progress").hide();
                    $(".file--upload--button").show();
                    rebindFileEvents();
                    alert('Sekmingai pataisytas irasas');
                },
                error: function (response) {
                    $(".progress").hide();
                    $(".file--upload--button").show();
                    alert("Klaida įkeliant bylą!");
                }
            });
        }



        function rebindFileEvents() {
            $("[data-file-delete]").click(function (){
                var element = $(this);
                $(this).html("...").addClass("btn-disabled");
                var id = $(this).attr("data-file-delete");
                $.post("/dashboard/groups/upload/"+id+"/delete", {_token: "{{ csrf_token() }}"}, function (data) {
                    data = JSON.parse(data);
                    if(data.status == "success"){
                        alert(data.message);
                        $('#homework-main-'+id).remove();
                        element.prev().remove();
                        element.prev().remove();
                        element.remove();
                    }else{
                        alert("KLAIDA! "+data.message);
                    }
                });
            });
        }

        rebindFileEvents();

        function rebindChatEvents() {
            $("[data-message-delete]").click(function (){
                $(this).html("...").addClass("btn-disabled");
                var id = $(this).attr("data-message-delete");
                $.post("/dashboard/groups/message/"+id+"/delete", {_token: "{{ csrf_token() }}"}, function (data) {
                    if(data.message != undefined){
                        alert(data.message);
                    }else{
                        alert("Žinutė sėkmingai ištrinta!");
                    }
                    window.location = window.location.href;
                });
            });
        }

        rebindChatEvents();

        function progress(e){

            if(e.lengthComputable){
                var max = e.total;
                var current = e.loaded;

                var percentage = (current * 100)/max;
                $(".progress .progress-bar").css("width", percentage);

            }
        }

    </script>
    <script>
        $("[zoom-join]").click(function() {
            joinMeeting(this);
        });
        function joinMeeting(button) {
            if($("#zoomModal iframe").attr("src") != "{{ url("/dashboard/events/".($nextEvent ? $nextEvent->id : '')."/zoom") }}"){
                $("#zoomModal iframe").attr("src", "{{ url("/dashboard/events/".($nextEvent ? $nextEvent->id : '')."/zoom") }}");
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
    </script>

</x-app-layout>
{{--https://stackoverflow.com/questions/15389833/laravel-redirect-back-to-original-destination-after-login/39595605#39595605--}}