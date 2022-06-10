
<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite grupę</h2>
        <h5 style="color: red; "> Pamokų valandos rodomos Jūsų vietos laiku <small>({{ Cookie::get("user_timezone", "Europe/London") }})</small> 24 val. formatas</h5>
    </div>
    <div class="learning--group--select--selector">
        @php
            $groupsGrouped  = \App\Models\Group::where("paid", 0)->where("hidden", 0)
            ->where("age_category", 'adults')
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
            } elseif(isset($groupsGrouped['individual'])) {
                $type = 'individual';
            } elseif(isset($groupsGrouped['no_type'])) {
                $type = 'no_type';
            }

        @endphp

        @if(isset($groupsGrouped['yellow']))
            <div class="learning--group--select--item active" data-filter-adults-free="yellow">
                Geltona (2-4m.)
            </div>
        @endif

        @if(isset($groupsGrouped['green']))
            <div class="learning--group--select--item" data-filter-adults-free="green">
                Žalia (5-6m.)
            </div>
        @endif
        @if(isset($groupsGrouped['blue']))
            <div class="learning--group--select--item" data-filter-adults-free="blue">
                Mėlyna (7-9m.)
            </div>
        @endif

        @if(isset($groupsGrouped['red']))
            <div class="learning--group--select--item" data-filter-adults-free="red">
                Raudona (10-13m.)
            </div>
        @endif

        @if(isset($groupsGrouped['individual']))
            <div class="learning--group--select--item" data-filter-adults-free="individual">
                Individualios pamokos
            </div>
        @endif
        @if(isset($groupsGrouped['no_type']))
            <div class="learning--group--select--item" data-filter-adults-free="no_type">
                Kursai suaugusiems
            </div>
        @endif

    </div>
    @foreach(\App\Models\Group::where("paid", 0)->where("age_category", 'adults')
    ->where("hidden", 0)
    ->where("type", '!=', 'bilingualism_consultation')
    ->orderBy("weight","ASC")
    ->get() as $group)
        <div class="learning--group--select--row" data-group-adults-free="{{ $group->type }}">
            <div class="color background--{{ $group->type }}"></div>
            <div class="text">
                <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else href="/select-group/order/free/{{ $group->slug }}" @endif >{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "Europe/London"))->format("H:i") }}</b></a><br>
                <span>{{ $group->display_name }}</span>
            </div>
            <div class="date">
            </div>
            <div class="price">
                {{\Carbon\Carbon::parse($group->start_date)->format("m.d")}}d.
            </div>
            <div class="actions">
                @if($group->students()->count() >= $group->slots)
                    <a class="button button-disabled course--select--button text-white">
                        Vietų nebėra
                    </a>
                @else
                    <a href="/select-group/order/free/{{ $group->slug }}" class="button course--select--button text-white">
                        Pasirinkti
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>
<script>
    $( document ).ready(function() {

        function filterByAdultsFree(group) {
        $("[data-group-adults-free]").hide();
        $("[data-group-adults-free='"+group+"']").show();
        $("[data-filter-adults-free]").removeClass("active");
        $("[data-filter-adults-free='"+group+"']").addClass("active");
    }
    $("[data-filter-adults-free]").click(function () {
        filterByAdultsFree($(this).attr("data-filter-adults-free"));
    });
        filterByAdultsFree('{{$type}}');
    });

</script>