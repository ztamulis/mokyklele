@extends("layouts.landing")

@section("title", "Užsakymo suvestinė")

@section("content")
    @if(!isset($error))
        <h1 class="content--title">Užsakymas</h1>
        <div class="text--center">
            <b>{{ $group->name }} {{ $group->time->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b>
            <br>
            {{ $group->display_name }}
            <br>
            <span>Kursas vyks: {{\Carbon\Carbon::parse($group->start_date)->format("m.d")}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}} ({{$group->course_length}}
                @if($group->course_length == 1)
                    pamoka)
                @elseif($group->course_length > 1 && $group->course_length < 10)
                    pamokos)
                @elseif($group->course_length > 9 && $group->course_length < 21)
                    pamokų)
                @elseif($group->course_length == 21)
                    pamoka)
                @elseif($group->course_length > 21)
                    pamokos)
                @endif
                </span>
            <br>
        </div>
    @endif

    <div class="text-center">
        <h3 style="color: #54efd1;">{{ $message }}</h3>
        @if(!isset($error))
            <a href="/dashboard" class="button">Prisijungti</a>
        @endif
    </div>
@endsection