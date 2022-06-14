
<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite grupę</h2>
        <h6 style="color: red; "> Pamokų valandos rodomos Jūsų vietos laiku <small>({{ Cookie::get("user_timezone", "Europe/London") }})</small> 24 val. formatu</h6>
    </div>
    <div class="learning--group--select--selector">
        @php
            $groupsGrouped  = \App\Models\Group::where("paid", 1)->where("hidden", 0)
            ->where("age_category", '=', 'adults')
            ->where("type", '!=', 'bilingualism_consultation')
            ->get()
            ->groupBy("type");
            $type = ' ';
            if (isset($groupsGrouped['yellow'])) {
            $type = 'yellow';
            } elseif(isset($groupsGrouped['green'])) {
                $type = 'green';

            } elseif(isset($groupsGrouped['blue'])) {
                $type = 'blue';

            } elseif(isset($groupsGrouped['red'])) {
                $type = 'red';
            }elseif(isset($groupsGrouped['no_type'])) {
                $type = 'no_type';
            } elseif(isset($groupsGrouped['individual'])) {
                $type = 'individual';
            }
        @endphp

        @if(isset($groupsGrouped['yellow']))
            <div class="learning--group--select--item active" data-filter-adults="yellow">
                Geltona (2-4m.)
            </div>
        @endif

        @if(isset($groupsGrouped['green']))
            <div class="learning--group--select--item" data-filter-adults="green">
                Žalia (5-6m.)
            </div>
        @endif
        @if(isset($groupsGrouped['blue']))
            <div class="learning--group--select--item" data-filter-adults="blue">
                Mėlyna (7-9m.)
            </div>
        @endif

        @if(isset($groupsGrouped['red']))
            <div class="learning--group--select--item" data-filter-adults="red">
                Raudona (10-13m.)
            </div>
        @endif
        @if(isset($groupsGrouped['no_type']))
            <div class="learning--group--select--item" data-filter-adults="no_type">
                Kursai suaugusiems
            </div>
        @endif

        @if(isset($groupsGrouped['individual']))
            <div class="learning--group--select--item" data-filter-adults="individual">
                Individualios pamokos
            </div>
        @endif



    </div>
    @foreach(\App\Models\Group::where("paid", 1)->where("hidden",0)
    ->where("type", '!=', 'bilingualism_consultation')
    ->where("age_category", '=', 'adults')
    ->orderBy("weight","ASC")
    ->get() as $group)
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
                    {{\Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d")}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}} ({{$descriptionData['eventsCount']}}
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

                @endif
            </div>
                @if ($group->price > 0)
                <div class="price">
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
    function filterByAdults(group) {
        $("[data-group-adults]").hide();
        $("[data-group-adults='"+group+"']").show();
        $("[data-filter-adults]").removeClass("active");
        $("[data-filter-adults='"+group+"']").addClass("active");
    }
    $("[data-filter-adults]").click(function () {
        filterByAdults($(this).attr("data-filter-adults"));
    });
    filterByAdults('{{$type}}');
</script>
