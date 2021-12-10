
<div class="learning--group--select--wrapper w-100" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite grupę</h2>
        <b>Svarbu:</b> Laikas nurodomas jūsų vietiniu laiku <small>({{ Cookie::get("user_timezone", "GMT") }})</small> 24 val. formatas
    </div>
    <div class="learning--group--select--selector">
        @php
            $groupsGrouped  = \App\Models\Group::where("paid", 1)->where("hidden", 0)->where("age_category", 'children')->get()->groupBy("type");
            $type = '  ';
            if (isset($groupsGrouped['yellow'])) {
            $type = 'yellow';
            } elseif(isset($groupsGrouped['green'])) {
                $type = 'green';

            } elseif(isset($groupsGrouped['blue'])) {
                $type = 'blue';

            } elseif(isset($groupsGrouped['red'])) {
                $type = 'red';
            } elseif(isset($groupsGrouped['individual'])) {
                $type = 'individual';
            }
        @endphp

        @if(isset($groupsGrouped['yellow']))
            <div class="learning--group--select--item active" data-filter="yellow">
                Geltona (2-4m.)
            </div>
        @endif

        @if(isset($groupsGrouped['green']))
            <div class="learning--group--select--item" data-filter="green">
                Žalia (5-6m.)
            </div>
        @endif
        @if(isset($groupsGrouped['blue']))
            <div class="learning--group--select--item" data-filter="blue">
                Mėlyna (7-9m.)
            </div>
        @endif

        @if(isset($groupsGrouped['red']))
            <div class="learning--group--select--item" data-filter="red">
                Raudona (10-13m.)
            </div>
        @endif

        @if(isset($groupsGrouped['individual']))
            <div class="learning--group--select--item" data-filter="individual">
                Individualios pamokos
            </div>
        @endif

    </div>
    @foreach(\App\Models\Group::where("paid", 1)->where("hidden",0)->where("age_category", 'children')->orderBy("weight","ASC")->get() as $group)
        <div class="learning--group--select--row" data-group="{{ $group->type }}">
            <div class="color background--{{ $group->type }}"></div>
            <div class="text">
                <a style="color: #000000;!important;" @if($group->students()->count() >= $group->slots) href="javascript:;" @else href="/select-group/order/{{ $group->slug }}" @endif >{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b></a>
                @if($group->time_2)
                    / <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else href="/select-group/order/{{ $group->slug }}" @endif ><b>{{ $group->time_2->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b></a>
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
                    <a class="button button-disabled course--select--button">
                        Vietų nebėra
                    </a>
                @else
                    @if ($group->adjustedPrice() > 0)
                        <a href="/select-group/order/{{ $group->slug }}" class="button course--select--button">
                            Pasirinkti
                        </a>
                    @else
                        <a href="/select-group/order/free/{{ $group->slug }}" class="button course--select--button">
                            Pasirinkti
                        </a>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
</div>
<script>
    function filterBy(group) {
        $("[data-group]").hide();
        $("[data-group='"+group+"']").show();
        $("[data-filter]").removeClass("active");
        $("[data-filter='"+group+"']").addClass("active");
    }
    $("[data-filter]").click(function () {
        filterBy($(this).attr("data-filter"));
    });
    filterBy('{{$type}}');
</script>
