@extends("layouts.landing")

@section("title", "Užsakymo suvestinė")

@section("content")
    @if(!isset($error))
        <h2 class="content--title">Registracijos patvirtinimas</h2>
        <div class="text--center">
            <b>{{\Carbon\Carbon::parse($group->start_date)->format("m.d")}}d., {{ $group->name }} {{ $group->time->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }} (laikas nurodomas jūsų vietiniu  <small>({{ Cookie::get("user_timezone", "GMT") }}</small>)</b>
            <br>
            {{ $group->display_name }}
            <br>
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