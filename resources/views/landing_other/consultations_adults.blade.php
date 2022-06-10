
<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite konsultaciją</h2>
        <h5 style="color: red; "> Konsultacijų laikas nurodomas Jūsų vietiniu laiku <small>({{ Cookie::get("user_timezone", "Europe/London") }})</small> 24 val. formatas</h5>

    </div>
    <div class="learning--group--select--selector">
        @php
            $groupsGrouped  = \App\Models\Group::where("paid", 1)->where("hidden", 0)
            ->where("age_category", '=', 'adults')
            ->where("type", '=', 'bilingualism_consultation')
            ->get()
            ->groupBy("type");
            $type = ' ';
            if (isset($groupsGrouped['bilingualism_consultation'])) {
                $type = 'bilingualism_consultation';
            }
        @endphp

        @if(isset($groupsGrouped['type']))
            <div class="learning--group--select--item active" data-filter-consultations="bilingualism_consultation">
                Dvikalbystės konsultacijos
            </div>
        @endif



    </div>
    @foreach(\App\Models\Group::where("paid", 1)->where("hidden",0)
    ->where("age_category", '=', 'adults')
    ->where("type", '=', 'bilingualism_consultation')
    ->orderBy("weight","ASC")->get() as $group)
        <div class="learning--group--select--row" data-group-adults="{{ $group->type }}">
            <div class="color background--{{ $group->type }}"></div>
            <div class="text">
                <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else href="/select-group/order/{{ $group->slug }}" @endif >{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "Europe/London"))->format("H:i") }}</b></a>
                @if($group->time_2)
                    / <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else href="/select-group/order/{{ $group->slug }}" @endif ><b>{{ $group->time_2->timezone(Cookie::get("user_timezone", "Europe/London"))->format("H:i") }}</b></a>
                @endif
                <br>
                <span>{{ $group->display_name }}</span>
            </div>
            <div class="date">
                @php $descriptionData = $group->getGroupStartDateAndCount() @endphp
                @if (!empty($descriptionData) && isset($descriptionData['eventsCount']))
                    {{\Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d")}}

                @endif
            </div>
                @if ($group->price > 0)
                <div class="price text-right">
                    £{{ $group->adjustedPrice() }}
                </div>
                @else
                <div class="free--lesson">
                    Nemokama
                </div>
                @endif
            <div class="actions">
                @if($group->students()->count() >= $group->slots)
                    <a class="button button-disabled course--select--button text-white">
                        Vietų nebėra
                    </a>
                @else
                    @if ($group->adjustedPrice() > 0)
                        <a href="/select-group/order/{{ $group->slug }}" class="button course--select--button text-white">
                            Pasirinkti
                        </a>
                    @else
                        <a href="/select-group/order/free/{{ $group->slug }}" class="button course--select--button text-white">
                            Pasirinkti
                        </a>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
</div>
<script>
    function dataFilterConsultations(group) {
        $("[data-group-adults]").hide();
        $("[data-group-adults='"+group+"']").show();
        $("[data-filter-consultations]").removeClass("active");
        $("[data-filter-consultations='"+group+"']").addClass("active");
    }
    $("[data-filter-consultations]").click(function () {
        dataFilterConsultations($(this).attr("data-filter-consultations"));
    });
    dataFilterConsultations('{{$type}}');
</script>
