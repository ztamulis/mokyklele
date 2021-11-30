@if(isset($reply) && $reply === true)
    <div id="comment-{{ $comment->id }}" class="media">
        @else
            <li id="comment-{{ $comment->id }}" class="media mt-3" style=" display:none;">
                @endif
                <div class="author-icon"><span class="icon-user"></span></div>

                <div class="media-body">
                    <h8 class="mt-0 mb-1">
                        {{ $comment->commenter->name }}
                        <small class="text-muted">- {{ $comment->created_at->diffForHumans() }}</small>
                    </h8>
                    <div class="desc" >
                        {!! $comment->comment!!}
                    </div>
                    <div class="edit-buttons">
                        <div class="left-col">
                            @if (!empty($comment->file))
                                <div class="attachments pl-1" id="homework-comment-edit-file-{{$comment->id}}">
                                    <div class="attachment">
                                        <a target="_blank" href="{{ url("/uploads/homework-comments/".$comment->file) }}" class="file"></a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="right-col">
                            <button  data-toggle="collapse"  aria-expanded="false" aria-controls="multiCollapseExample1" data-target="#comment-modal-{{ $comment->id }}"
                                    class="btn blue reply">Atsakyti
                            </button>
                            @can('comments.edit', $comment)
                                <button data-toggle="collapse" data-target="#comment-edit-{{ $comment->id }}"
                                        class="btn blue reply">Readaguoti
                                </button>
                            @endcan

                            @can('comments.delete', $comment)
                                <button
                                   onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->id }}').submit();"
                                   class="btn blue remove-post">Ištrinti</button>
                                <form delete-comment id="comment-delete-form-{{ $comment->id }}"
                                      action="{{route('comments.delete', $comment->id)  }}" method="POST" style="display: none;" >
                                    @method('DELETE')
                                    @csrf
                                </form>
                            @endcan
                        </div>
                    </div>

                    <div class="collapse multi-collapse" id="comment-modal-{{ $comment->id }}">
                        <form class="" method="POST" enctype="multipart/form-data" comment-reply action="{{ route('comments.reply', $comment->id) }}">
                            @csrf
                            <div class="comment-form">
                            <textarea oninput="auto_grow(this)" type="text" rows="1" class="comment" placeholder="Komentuoti" name="message" ></textarea>

                            <label  onclick="addCommentFile('comment-modal-'+{{$comment->id}})" class="file"></label>
                            <input type="file" name="file" id="file-attachment-reply-{{ $comment->id }}" class="file-attachment" />
                            <button type="submit" class="submit" id="submit"></button>
                            </div>
                        </form>
                    </div>
                    <div class="collapse multi-collapse" id="comment-edit-{{ $comment->id }}" comment-edit>
                        <form class="" method="POST" id="homework-comment-edit-{{$comment->id}}" enctype="multipart/form-data" action="{{ route('comments.update', $comment->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="comment-form">
                                <textarea oninput="auto_grow(this)" type="text" rows="1" class="comment" name="message" >@php echo strip_tags($comment->comment)@endphp</textarea>
                                <label  onclick="addCommentFile('comment-edit-'+{{$comment->id}})" class="file"></label>
                                <input type="file" name="file" id="file-attachment-post-{{ $comment->id }}" class="file-attachment" />
                                <button type="submit" class="submit" id="submit"></button>
                            </div>
                            @if ($comment->file)
                                <div class="attachments mt-2">
                                    <div class="attachment">
                                        <a target="_blank" href="{{ url("/uploads/".$comment->file) }}" class="file">Prisegtas dokumentas</a>
                                        <a onclick="deleteEditHomeworkFile('homework-comment-edit-'+{{$comment->id}})" class="remove-attachment"></a>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
{{--                    <p>--}}
{{--                    @can('comments.vote', $comment)--}}

{{--                        <form action="{{route('comments.vote', $comment->id)  }}" method="POST"--}}
{{--                              style="display: inline-block">--}}
{{--                            @csrf--}}
{{--                            <input type="hidden" name="vote" value="0"/>--}}
{{--                            <button type="submit">--}}
{{--                                -1--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    @endcan--}}
{{--                    @can('comments.vote', $comment)--}}

{{--                        <form action="{{route('comments.vote', $comment->id)  }}" method="POST"--}}
{{--                              style="display: inline-block">--}}
{{--                            @csrf--}}
{{--                            <input type="hidden" name="vote" value="1"/>--}}
{{--                            <button type="submit">--}}
{{--                                +1--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                        @endcan--}}
{{--                        </p>--}}


                        <br/>

                        @foreach($comment->allChildrenWithCommenter as $child)
                            @include('components.comment.comment-custom', [
                                    'comment' => $child,
                                    'reply' => true
                                ])
                        @endforeach
                </div>

    {!! isset($reply) && $reply === true ? '</div>' : '</li>' !!}
