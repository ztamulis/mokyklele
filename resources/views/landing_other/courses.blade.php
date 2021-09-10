
<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite grupę</h2>
        <b>Svarbu:</b> Laikas nurodomas jūsų vietiniu laiku <small>({{ Cookie::get("user_timezone", "GMT") }})</small>
    </div>
    <div class="learning--group--select--selector">
        @php $groupsGrouped  = \App\Models\Group::where("paid", 1)->where("hidden", 0)->get()->groupBy("type"); @endphp

        @if($groupsGrouped['yellow'])
            <div class="learning--group--select--item active" data-filter="yellow">
                Geltona (2-4m.)
            </div>
        @endif

        @if($groupsGrouped['yellow'])
            <div class="learning--group--select--item" data-filter="green">
                Žalia (5-6m.)
            </div>
        @endif
        @if($groupsGrouped['yellow'])
            <div class="learning--group--select--item" data-filter="blue">
                Mėlyna (7-9m.)
            </div>
        @endif

        @if($groupsGrouped['yellow'])
            <div class="learning--group--select--item" data-filter="red">
                Raudona (10-13m.)
            </div>
        @endif

        @if($groupsGrouped['yellow'])
            <div class="learning--group--select--item" data-filter="individual">
                Individualios pamokos
            </div>
        @endif

    </div>
    @foreach(\App\Models\Group::where("paid", 1)->where("hidden",0)->orderBy("weight","ASC")->get() as $group)
        <div class="learning--group--select--row" data-group="{{ $group->type }}">
            <div class="color background--{{ $group->type }}"></div>
            <div class="text">
                <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else href="/select-group/order/{{ $group->id }}" @endif >{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b></a>
                @if($group->time_2)
                    / <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else href="/select-group/order/{{ $group->id }}" @endif ><b>{{ $group->time_2->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b></a>
                @endif
                <br>
                <span>{{ $group->display_name }}</span>
            </div>
            <div class="date">
                {{\Carbon\Carbon::parse($group->start_date)->format("m.d")}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}} ({{$group->course_length}}
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
                        <a href="/select-group/order/{{ $group->id }}" class="button course--select--button">
                            Pasirinkti
                        </a>
                    @else
                        <a href="/select-group/order/free/{{ $group->id }}" class="button course--select--button">
                            Pasirinkti
                        </a>
                    @endif
{{--                        <a href="/select-group/order/{{ $group->id }}" class="button course--select--button">--}}
{{--                            Pasirinkti--}}
{{--                        </a>--}}
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
    filterBy("yellow");
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
                    <a href="/select-group/{{ $group->id }}">{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }}</b></a><br>
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
