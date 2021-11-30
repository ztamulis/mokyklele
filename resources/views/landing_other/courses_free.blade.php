
<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite grupę</h2>
        <b>Svarbu:</b> Laikas nurodomas jūsų vietiniu laiku <small>({{ Cookie::get("user_timezone", "GMT") }})</small>
    </div>
    <div class="learning--group--select--selector">
        @php
            $groupsGrouped  = \App\Models\Group::where("paid", 0)->where("age_category", 'children')->where("hidden", 0)->get()->groupBy("type");
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
            <div class="learning--group--select--item active" data-filter-free="yellow">
                Geltona (2-4m.)
            </div>
        @endif

        @if(isset($groupsGrouped['green']))
            <div class="learning--group--select--item" data-filter-free="green">
                Žalia (5-6m.)
            </div>
        @endif
        @if(isset($groupsGrouped['blue']))
            <div class="learning--group--select--item" data-filter-free="blue">
                Mėlyna (7-9m.)
            </div>
        @endif

        @if(isset($groupsGrouped['red']))
            <div class="learning--group--select--item" data-filter-free="red">
                Raudona (10-13m.)
            </div>
        @endif

        @if(isset($groupsGrouped['individual']))
            <div class="learning--group--select--item" data-filter-free="individual">
                Individualios pamokos
            </div>
        @endif

    </div>
    @foreach(\App\Models\Group::where("paid", 0)->where("age_category", 'children')->where("hidden", 0)->orderBy("weight","ASC")->get() as $group)
        <div class="learning--group--select--row" data-group-free="{{ $group->type }}">
            <div class="color background--{{ $group->type }}"></div>
            <div class="text">
                <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else href="/select-group/order/free/{{ $group->slug }}" @endif >{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b></a><br>
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
                    <a href="/select-group/order/free/{{ $group->slug }}" class="button course--select--button">
                        Pasirinkti
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>
<script>
    $( document ).ready(function() {

        function filterByFree(group) {
        $("[data-group-free]").hide();
        $("[data-group-free='"+group+"']").show();
        $("[data-filter-free]").removeClass("active");
        $("[data-filter-free='"+group+"']").addClass("active");
    }
    $("[data-filter-free]").click(function () {
        filterByFree($(this).attr("data-filter-free"));
    });
        filterByFree('{{$type}}');
    });

</script>