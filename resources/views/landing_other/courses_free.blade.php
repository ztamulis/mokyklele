
<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite grupę</h2>
        <h6 style="color: red; "> Pamokų valandos rodomos Jūsų vietos laiku <small>({{ Cookie::get("user_timezone", "Europe/London") }})</small> 24 val. formatu</h6>
    </div>
    <div class="learning--group--select--selector">
        @php
            $groupsGrouped  = \App\Models\Group::where("paid", 0)->where("age_category", 'children')
            ->where("hidden", 0)
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
            }

        @endphp

        @if(isset($groupsGrouped['yellow']))
            <a href="#yellow" class="learning--group--select--item active" id="yellow" data-filter-free="yellow">
                Geltona (2-4m.)
            </a>
        @endif

        @if(isset($groupsGrouped['green']))
            <a href="#green" class="learning--group--select--item" id="green" data-filter-free="green">
                Žalia (5-6m.)
            </a>
        @endif
        @if(isset($groupsGrouped['blue']))
            <a href="#blue" class="learning--group--select--item" id="blue" data-filter-free="blue">
                Mėlyna (7-9m.)
            </a>
        @endif

        @if(isset($groupsGrouped['red']))
            <a href="#red" class="learning--group--select--item" id="red" data-filter-free="red">
                Raudona (10-14m.)
            </a>
        @endif

        @if(isset($groupsGrouped['individual']))
            <a href="#individual" class="learning--group--select--item" id="individual" data-filter-free="individual">
                Individualios pamokos
            </a>
        @endif

    </div>
    @foreach(\App\Models\Group::where("paid", 0)->where("age_category", 'children')
    ->where("type", '!=', 'bilingualism_consultation')
    ->where("hidden", 0)
    ->orderBy("weight","ASC")
    ->get() as $group)
        <div class="learning--group--select--row" data-group-free="{{ $group->type }}">
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
                    <a class="button button-disabled course--select--button">
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
    $(document).ready(function() {
        $("[data-filter-free]").click(function () {
            filterByFree($(this).attr("data-filter-free"));
        });
        var hash = document.URL.substr(document.URL.indexOf('#') + 1);
        var indexOfUrl = hash.indexOf('-');
        if (parseInt(indexOfUrl) < 0) {
            filterByFree(hash);
        } else {
            filterByFree('{{$type}}');
        }
    });
    function filterByFree(group) {
        $("[data-group-free]").hide();
        $("[data-group-free='" + group + "']").show();
        $("[data-filter-free]").removeClass("active");
        $("[data-filter-free='" + group + "']").addClass("active");
    }

</script>