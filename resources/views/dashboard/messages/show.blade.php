<x-user>
    <div class="client--dashboard">
        @if(isset($messages[0]) && $messages[0]->author && $messages[0]->author->id != Auth::user()->id && $messages[0]->canBeAnswered)
            <div class="dashboard--misc--buttons">
                <a href="/dashboard/messages/create?to={{ $messages[0]->author->id }}" class="dashboard--button dashboard--button--main">
                    Atsakyti
                </a>
            </div>
        @elseif(isset($messages[0]) $messages[0]->user && $messages[0]->user->id != Auth::user()->id && $messages[0]->canBeAnswered)
            <div class="dashboard--misc--buttons">
                <a href="/dashboard/messages/create?to={{ $messages[0]->user->id }}" class="dashboard--button dashboard--button--main">
                    Atsakyti
                </a>
            </div>
        @endif
    @foreach($messages as $message)
        @if($loop->first)
            <div class="message--preview dashboard--block mt-5">
        @endif

        <div class="client--dashboard--title font-weight-bold text-dark mt-5">
            <p>
            <img class="border rounded-circle img-profile img-fluid" src="{{ $message->author && count($message->author->students) && $message->author->students[0] && $message->author->students[0]->photo ? "/uploads/students/".$message->author->students[0]->photo : "/images/icons/avatar.png" }}" />
                nuo @if($message->author) {{ $message->author->name }} {{ $message->author->surname }} ∙ @endif @if($message->user) gavėjas {{ $message->user->name }} {{ $message->user->surname }} ∙ @endif {{$message->created_at->timezone(Cookie::get("user_timezone", "GMT"))->format("Y-m-d H:i")}}
            </p>
        </div>

            <div class="message--text" style="  word-wrap: break-word;
">
                <?php $messageText = strip_tags($message->message) ?>
                <?php $messageText = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $messageText); ?>
                    <?php echo  $messageText ?>
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
            @if($loop->last)

        </div>
@endif
        @endforeach
    </div>
</x-user>