
<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite grupę</h2>
        <b>Svarbu:</b> Laikas nurodomas jūsų vietiniu laiku <small>({{ Cookie::get("user_timezone", "GMT") }})</small>
    </div>
    <div class="learning--group--select--selector">
        <div class="learning--group--select--item active" data-filter-free="yellow">
            Geltona (2-4m.)
        </div>
        <div class="learning--group--select--item" data-filter-free="green">
            Žalia (5-6m.)
        </div>
        <div class="learning--group--select--item" data-filter-free="blue">
            Mėlyna (7-9m.)
        </div>
        <div class="learning--group--select--item" data-filter-free="red">
            Raudona (10-13m.)
        </div>
        <div class="learning--group--select--item" data-filter-free="individual">
            Individualios pamokos
        </div>
    </div>
    @foreach(\App\Models\Group::where("paid", 0)->where("hidden", 0)->orderBy("weight","ASC")->get() as $group)
        <div class="learning--group--select--row" data-group-free="{{ $group->type }}">
            <div class="color background--{{ $group->type }}"></div>
            <div class="text">
                <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else href="/select-group/{{ $group->id }}" @endif >{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b></a><br>
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
                    <a href="/select-group/order/free/{{ $group->id }}" class="button course--select--button">
                        Pasirinkti
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>
<script>
    function filterByFree(group) {
        $("[data-group-free]").hide();
        $("[data-group-free='"+group+"']").show();
        $("[data-filter-free]").removeClass("active");
        $("[data-filter-free='"+group+"']").addClass("active");
    }
    $("[data-filter-free]").click(function () {
        filterByFree($(this).attr("data-filter-free"));
    });
    filterByFree("yellow");
</script>
{{--
    <div class="learning--group--select--wrapper" data-vvveb-disabled>
        <div class="learning--group--select--title">
            <h2>Išsirinkite grupę</h2>
            <b>Svarbu:</b> Visų pamokų laikas nurodomas Didžiosios Britanijos laiku (GMT)
        </div>
        <div class="learning--group--select--selector">
            <div class="learning--group--select--item active" data-filter="yellow">
                Geltona (2-4m.)
            </div>
            <div class="learning--group--select--item" data-filter="green">
                Žalia (5-6m.)
            </div>
            <div class="learning--group--select--item" data-filter="blue">
                Mėlyna (7-9m.)
            </div>
            <div class="learning--group--select--item" data-filter="red">
                Raudona (10-13m.)
            </div>
            <div class="learning--group--select--item" data-filter="individual">
                Individualios pamokos
            </div>
        </div>
        @foreach(\App\Models\Group::where("type", "NOT LIKE", "free")->get() as $group)
            <div class="learning--group--select--row" data-group="{{ $group->type }}">
                <div class="color background--{{ $group->type }}"></div>
                <div class="text">
                    <a href="/select-group/{{ $group->id }}">{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b></a>
                    @if($group->time_2)
                        / <a href="/select-group/{{ $group->id }}"><b>{{ $group->time_2->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b></a>
                    @endif
                    <br>
                    <span>{{ $group->display_name }}</span>
                </div>
                <div class="price">
                    £{{ $group->price }}
                </div>
                <div class="actions">
                    @if($group->students()->count() >= $group->slots)
                        <a class="button-disabled">
                            Vietų nebėra
                        </a>
                    @else
                        <a href="/select-group/{{ $group->id }}" class="button">
                            Pasirinkti
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>--}}
