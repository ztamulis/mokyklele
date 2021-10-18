<x-app-layout>

    <div class="client--dashboard">
        @if($message->author && $message->author->id != Auth::user()->ido && $message->canBeAnswered)
        <div class="dashboard--misc--buttons">
            <a href="/dashboard/messages/create?to={{ $message->author->id }}" class="dashboard--button dashboard--button--main">
                Atsakyti
            </a>
        </div>
        @endif

        <div class="client--dashboard--title">
            <h3>Pranešimo peržiūra</h3>
            <p>nuo @if($message->author) {{ $message->author->name }} {{ $message->author->surname }} ∙ @endif @if($message->user) gavėjas {{ $message->user->name }} {{ $message->user->surname }} ∙ @endif {{$message->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i")}}</p>
        </div>

        <div class="message--preview dashboard--block">
            <div class="message--text">

                <?php $message->message = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $message->message); ?>
                    <?php echo $message->message ?>
            </div>
            <div class="message--author">
                <div class="group--icon">
                    <div class="color background--blue" style="background-image: url('{{ $message->author && count($message->author->students) && $message->author->students[0]->photo ? "/uploads/students/".$message->author->students[0]->photo : (($message->author && $message->author->photo) ? "/uploads/users/".$message->author->photo : "/images/icons/avatar.png") }}')"></div>
                </div>
                <div class="group--info">
                    @if($message->author)
                        @if($message->author->role == "admin")
                            <h3>Pasaka</h3>
                        @elseif($message->author->role == 'teacher')
                            <h3>{{ $message->author->name }} {{ $message->author->surname }}</h3>
                        @else
                            <h3>{{ $message->author->roleText() }} {{ $message->author->name }} {{ $message->author->surname }}</h3>
                        @endif
                    @endif
                    <p>
                        {{$message->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i")}}
                    </p>
                </div>
            </div>
        </div>

        @if($message->file)

        <div class="dashboard--block no--padding">
            <div class="dashboard--block--inner dashboard--block--header">
                <h3>Prisegtas dokumentas</h3>
                Čia galite matyti prie žinutės prisegtą dokumentą.
            </div>
            <div class="files">
                <div class="dashboard--block--hr"></div>
                <?php
                $fileNameExploded = explode(".", $message->file);
                $fileExtension = $fileNameExploded[count($fileNameExploded)-1];
                ?>
                <a href="{{ url("/uploads/messages/".$message->file) }}" target="_blank" class="dashboard--media">
                    <img src="/images/icons/next-arrow.svg" class="dashboard--media--arrow">
                    <b>{{str_replace(".".$fileExtension, "", $message->file) }}</b><br>
                    {{ $message->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i") }} ∙ {{ mb_strtoupper($fileExtension) }} dokumentas
                </a>
                <div class="clear--fix"></div>
            </div>
        </div>

        @endif
    </div>

{{--                    <h3 class="text-dark mb-1">Žinutė</h3>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col">--}}
{{--                                            <p>{!! $messages->message !!}</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-xl-5 offset-xl-7">--}}
{{--                                            <p><strong>Pranešimas nuo:</strong> <span class="text-monospace text-dark">{{$messages->author->roleText()}}</span>&nbsp;  {{$messages->author->name}}</p>--}}
{{--                                            <p class="text-monospace">{{$messages->created_at->format("Y-m-d")}}</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
</x-app-layout>