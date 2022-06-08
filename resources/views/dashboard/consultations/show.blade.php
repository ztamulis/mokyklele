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
                        <div class="time">{{ App\TimeZoneUtils::updateTime($nextLesson->date_at->timezone(Cookie::get("user_timezone", "Europe/London")), $nextLesson->updated_at)->format('Y-m-d H:i') }} {{ Cookie::get("user_timezone", "Europe/London") }}</div>
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
                        <a href="{{ $nextLesson->join_link }}" target="_blank">Prisijungti</a>
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
                <div class="sidebar-area col-lg-5 col-sm-12 col-12 d-lg-none">
                    <div class="row no-gutters">
                        <div class="sidebar-area col-lg-5 col-sm-12 col-12">
                            <div class="information-block">
                                <h3>Pranešimai</h3>
                                <div class="desc">{!! $group->information !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper_tabcontent">
                    <div id="tab-1" class="tabcontent active">
                        <div class="row no-gutters w-100">
                            <div class="main-tab-area col-lg-7 col-sm-12 col-12">
                                <div class="main-info">
                                    <h3>Informacija</h3>
                                    @if(Auth::user()->role != "user")
                                        <button  class="btn-groups btn blue new-post" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">Naujas įrašas</button>
                                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                                            <div class="author-comment pl-0" style="border: 1px solid #dee2e6;">
                                                <form action="{{route('consultation-homework-store')}}" new-homework-file method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <textarea class="editor" placeholder="komentuoti" name="file_name" rows="1" id="ckeditor-voc" style="width: 100%;overflow-y: hidden; border: 0px"></textarea>
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
                                        <div class="date">{{ $file->created_at->timezone(Cookie::get("user_timezone", "Europe/London"))->format("Y-m-d") }}</div>
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
                                                    <form delete-homework action="{{route('consultation-delete-homework-file', $file->id)}}" method="POST">
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
                                                    <form action="{{route('consultation-homework-edit', $file->id)}}" homework-edit-file method="POST" enctype="multipart/form-data">
                                                        <div class="author-comment">
                                                            <div class="author">{{$file->user->name}} {{$file->user->surname}}</div>
                                                            <div class="date mb-2">{{ $file->created_at->timezone(Cookie::get("user_timezone", "Europe/London"))->format("Y-m-d H:i") }}</div>
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
                                            <div class="comment-form" style="border: 1px solid #dee2e6;">
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
                                        @if(!$loop->last)
                                            <hr style="border-top: 2px solid rgb(12 52 232 / 68%)!important;">
                                        @endif
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
                                    <h3>Pranešimai</h3>
                                    <div class="desc">{!! $group->information !!}</div>
                                </div>
                                @php $events = $group->events()->where("date_at", ">" ,\Carbon\Carbon::now('utc')->subMinutes(30)->format('Y-m-d H:i:s'))->orderBy("date_at","ASC")->get(); @endphp
                                    <div class="schedule-block">
                                        <div class="dashboard--block">
                                            <h3>Konsultacijų datos</h3>

                                        @if (!$events->isEmpty())

                                            <div class="dashboard--timetable">
                                                @foreach($events as $event)
                                                    <div class="dashboard--time">
                                                        <?php
                                                        $eventDate = $event->date_at->timezone(Cookie::get("user_timezone", "Europe/London"));
                                                        ?>
                                                        <div class="dashboard--time--date">{{ mb_strtoupper(mb_substr($eventDate->translatedFormat("F"),0,3)) }}<br><span>{{ $eventDate->format("d") }}</span></div>
                                                        <div class="dashboard--time--info">
                                                            <b>{{ $event->name }}</b> ∙ {{ $event->teacher->name }} {{ $event->teacher->surname }}<br>
                                                            {{\App\TimeZoneUtils::updateTime($eventDate, $event->updated_at)->format('Y-m-d H:i')}}                                                    </div>
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

            </section>
        </div>
    <script src="//cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script>
        $( document ).ready(function() {
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
            CKEDITOR.config.font_defaultLabel = 'Roboto';
            CKEDITOR.config.font_names = 'Roboto;Arial;Arial Black;Comic Sans MS;Courier New;Helvetica;Impact;Tahoma;Times New Roman;Verdana';
            CKEDITOR.replace( 'ckeditor', {
            } );
            CKEDITOR.replace( 'ckeditor-voc', {
            } );

            var groupMessage = @json($groupMessage);
                if(groupMessage == true) {
                $('[data-country="tab-2"]').click();
            }
            CKEDITOR.on("instanceReady", function(event) {
                var blockTags = ['div','h1','h2','h3','h4','h5','h6','p','pre','li','blockquote','ul','ol',
                    'table','thead','tbody','tfoot','td','th',];

                for (var i = 0; i < blockTags.length; i++)
                {
                    event.editor.dataProcessor.writer.setRules( blockTags[i], {
                        indent : false,
                        breakBeforeOpen : true,
                        breakAfterOpen : false,
                        breakBeforeClose : false,
                        breakAfterClose : true
                    });
                }
                event.editor.on("beforeCommandExec", function(event) {
                    // Show the paste dialog for the paste buttons and right-click paste
                    if (event.data.name == "paste") {
                        event.editor._.forcePasteDialog = true;
                    }
                    // Don't show the paste dialog for Ctrl+Shift+V
                    if (event.data.name == "pastetext" && event.data.commandData.from == "keystrokeHandler") {
                        event.cancel();
                    }
                })
            });
            $("[zoom-join]").click(function() {
                joinMeeting(this);
            });
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
        function addCkeditor(id) {
            if ($('#cke_'+id).length != 1) {
                CKEDITOR.replace( id, {
                } );
            }

        }
        function thisFileUpload(element) {
            document.getElementById(element.name).click();
        };


        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight) + "px";
        }


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
    </script>
    </x-user>

{{--https://stackoverflow.com/questions/15389833/laravel-redirect-back-to-original-destination-after-login/39595605#39595605--}}