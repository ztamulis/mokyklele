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
            @php $descriptionData = $group->getGroupStartDateAndCount() @endphp
            @if (!empty($descriptionData) && isset($descriptionData['eventsCount']))

            <span>Kursas vyks: {{\Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d")}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}} ({{$descriptionData['eventsCount']}}
                 @if($descriptionData['eventsCount'] == 1)
                        pamoka)
                    @elseif($descriptionData['eventsCount'] > 1 && $descriptionData['eventsCount'] < 10)
                        pamokos)
                    @elseif($descriptionData['eventsCount'] > 9 && $descriptionData['eventsCount'] < 21)
                        pamokų)
                    @elseif($descriptionData['eventsCount'] > 21)
                        pamokos)
                    @elseif($descriptionData['eventsCount'])
                        pamoka)
                    @endif


                </span>
            @endif

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