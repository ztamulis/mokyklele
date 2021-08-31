<x-app-layout>
    <div class="client--dashboard">
        <div class="dashboard--misc--buttons">
            <a href="/dashboard/messages/sent" class="dashboard--button">
                Išsiųstos žinutės
            </a>
            <a href="/dashboard/messages/create" class="dashboard--button dashboard--button--main">
                <img src="/images/icons/plus.svg"> Siųsti žinutę
            </a>
        </div>

        <h3>Gauti pranešimai</h3>
        <p>Jūsų pranešimų dėžutėje yra {{ Auth::user()->messages()->has('author')->count() }} pranešim.</p>

        @if(isset($message))
            <div class="dashboard--alert">
                <div class="dashboard--alert--image">
                    <img src="/images/icons/warning.svg">
                </div>
                <div class="dashboard--alert--text">
                    <h3>Pranešimas</h3>
                    <p>{{ $message }}</p>
                </div>
            </div>
        @endif

        <div class="group--list">
            @foreach(Auth::user()->messages()->has('author')->orderBy("id", "DESC")->get() as $message)
            <div class="group--item" data-href="/dashboard/messages/{{ $message->id }}">
                <div class="group--icon">
                    <div class="color background--blue" style="background-image: url('{{ $message->author && count($message->author->students) && $message->author->students[0] && $message->author->students[0]->photo ? "/uploads/students/".$message->author->students[0]->photo : "/images/icons/avatar.png" }}')"></div>
                </div>
                <div class="group--info">
                    @if($message->author)
                        @if($message->author->role == "admin")
                            <h3>Pasaka</h3>
                        @else
                            <h3> {{ $message->author->name }} {{ $message->author->surname }}</h3>
                        @endif
                    @endif
                    <p>
                        {{substr(strip_tags($message->message),0,60)."..."}}
                    </p>
                </div>
                <div class="group--students text--center">
                    <span>{{$message->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i")}}</span>
                    <br>
                    {{ Cookie::get("user_timezone", "GMT") }}
                </div>
                <div class="group--actions">
                    <div class="group--actions--button">
                        <img src="/images/icons/more.svg">
                    </div>
                    <div class="group--actions--dropdown" style="display: none;">
                        <a href="/dashboard/messages/{{ $message->id }}" class="group--action">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20.533" height="14" viewBox="0 0 20.533 14">
                                <g id="visibility" transform="translate(0 -74.667)">
                                    <g id="Group_68" data-name="Group 68" transform="translate(0 74.667)">
                                        <g id="Group_67" data-name="Group 67" transform="translate(0 0)">
                                            <path id="Path_44" data-name="Path 44" d="M173.467,170.667a2.8,2.8,0,1,0,2.8,2.8A2.8,2.8,0,0,0,173.467,170.667Z" transform="translate(-163.2 -166.467)" fill="#aeaeae"/>
                                            <path id="Path_45" data-name="Path 45" d="M10.267,74.667A11.038,11.038,0,0,0,0,81.667a11.029,11.029,0,0,0,20.533,0A11.034,11.034,0,0,0,10.267,74.667Zm0,11.667a4.667,4.667,0,1,1,4.667-4.667A4.668,4.668,0,0,1,10.267,86.334Z" transform="translate(0 -74.667)" fill="#aeaeae"/>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            Peržiūrėti
                        </a>
                        <form action="/dashboard/messages/{{ $message->id }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti žinutę?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="group--action">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.808" height="17" viewBox="0 0 13.808 17">
                                    <g id="trash" transform="translate(-48)">
                                        <path id="Path_36" data-name="Path 36" d="M60.481,2.125H57.56V1.593A1.6,1.6,0,0,0,55.966,0H53.839a1.6,1.6,0,0,0-1.59,1.593v.532H49.328A1.329,1.329,0,0,0,48,3.453V5.316a.531.531,0,0,0,.531.531h.291l.458,9.636A1.592,1.592,0,0,0,50.871,17h8.062a1.592,1.592,0,0,0,1.592-1.517l.462-9.644h.291a.531.531,0,0,0,.531-.531V3.445A1.329,1.329,0,0,0,60.481,2.125Zm-7.17-.531a.532.532,0,0,1,.528-.532h2.125a.532.532,0,0,1,.531.531v.532H53.311ZM49.062,3.458a.266.266,0,0,1,.266-.266H60.481a.266.266,0,0,1,.266.266V4.78H49.068ZM59.468,15.433a.531.531,0,0,1-.531.506H50.871a.531.531,0,0,1-.531-.506l-.456-9.594H59.927Z" fill="#262626"/>
                                        <path id="Path_37" data-name="Path 37" d="M240.531,215.966a.531.531,0,0,0,.531-.531v-6.9a.531.531,0,1,0-1.062,0v6.9a.53.53,0,0,0,.532.531Z" transform="translate(-185.627 -201.096)" fill="#262626"/>
                                        <path id="Path_38" data-name="Path 38" d="M320.531,215.966a.53.53,0,0,0,.531-.531v-6.9a.531.531,0,1,0-1.062,0v6.9a.53.53,0,0,0,.532.531Z" transform="translate(-262.972 -201.096)" fill="#262626"/>
                                        <path id="Path_39" data-name="Path 39" d="M160.531,215.966a.531.531,0,0,0,.531-.531v-6.9a.531.531,0,1,0-1.062,0v6.9a.531.531,0,0,0,.532.531Z" transform="translate(-108.283 -201.096)" fill="#262626"/>
                                    </g>
                                </svg>
                                Ištrinti
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
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
{{--    --}}
{{--    @if(isset($message))--}}
{{--        <div class="row">--}}
{{--            <div class="col-xl-8 offset-xl-2">--}}
{{--                <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    <h3 class="text-dark mb-1">Visos žinutės</h3>--}}
{{--    <div class="row">--}}
{{--        <div class="col">--}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table table-striped">--}}
{{--                    <tbody>--}}
{{--                        @foreach(\App\Http\Controllers\MessageController::messages(16) as $message)--}}
{{--                            <tr>--}}
{{--                                <td>{{$message->id}}</td>--}}
{{--                                <td><span class="text-monospace">{{$message->author->roleText()}}</span>  <span class="text-dark">{{$message->author->name}}</span></td>--}}
{{--                                <td>--}}
{{--                                    <a href="/dashboard/messages/{{ $message->id }}" class="btn btn-success btn-sm" type="button" style="margin: 0px 4px 0px;">Peržiūrėti</a>--}}
{{--                                    <form action="/dashboard/messages/{{ $message->id }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti žinutė?')" style="display: inline-block;">--}}
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
{{--                                        <button class="btn btn-danger btn-sm" type="submit">Ištrinti</button>--}}
{{--                                    </form>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-xl-3 offset-xl-9">--}}
{{--            <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">--}}
{{--                {{ $messages->links('components.pagination') }}--}}
{{--            </nav>--}}
{{--        </div>--}}
{{--    </div>--}}
</x-app-layout>