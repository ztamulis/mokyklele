
<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite grupę</h2>
        <h6 style="color: red; "> Pamokų valandos rodomos Jūsų vietos laiku <small>({{ Cookie::get("user_timezone", "Europe/London") }})</small> 24 val. formatu</h6>
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
        $_COOKIE['groupAdultsFreeType'] = $type;

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
    @php $groups = \App\Models\Group::where("paid", 0)->where("age_category", 'adults')
    ->where("hidden", 0)
    ->where("type", '!=', 'bilingualism_consultation')
    ->orderBy("weight","ASC")
    ->get() @endphp
    @foreach($groups as $key => $group)
        <div class="learning--group--select--row" data-group-adults-free="{{ $group->type }}">
            <div class="color background--{{ $group->type }}"></div>
            <div class="text">
                <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else
                onclick="chooseLessonDataLayer(
                        '{{$group->name}}',
                        {{$group->id}},
                        {{$group->adjustedPrice()}},
                        '{{$group->paid ? 'Mokama' : 'Nemokama'}}',
                        {{$key+1}},
                        '/select-group/order/free/{{$group->slug }}',
                        '{{$group::getGroupTypeTranslated($group->type)}}',
                        '{{$group->time->timezone("Europe/London")->format("H:i")}}',
                        '{{ $group->display_name }}',
                        '{{isset($descriptionData['startDate']) ? \Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d") : '0'}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}}',
                        '{{isset($group->getGroupStartDateAndCount()['eventsCount']) ? $group->getGroupStartDateAndCount()['eventsCount'] : '0'}}'
                        )"
                        @endif
                >{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "Europe/London"))->format("H:i") }}</b></a><br>
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
                    <a
                        onclick="chooseLessonDataLayer(
                                '{{$group->name}}',
                                {{$group->id}},
                                {{$group->adjustedPrice()}},
                                '{{$group->paid ? 'Mokama' : 'Nemokama'}}',
                                {{$key+1}},
                                '/select-group/order/free/{{$group->slug }}',
                                '{{$group::getGroupTypeTranslated($group->type)}}',
                                '{{$group->time->timezone("Europe/London")->format("H:i")}}',
                                '{{ $group->display_name }}',
                                '{{isset($descriptionData['startDate']) ? \Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d") : '0'}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}}',
                                '{{isset($group->getGroupStartDateAndCount()['eventsCount']) ? $group->getGroupStartDateAndCount()['eventsCount'] : '0'}}'
                                )"
                       class="button course--select--button text-white">
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

        addOneCategory($(this).attr("data-filter-adults-free"))

    });
        filterByAdultsFree('{{$type}}');
        addOneCategory('{{$type}}');
    });

    function chooseLessonDataLayer(name, id, price, category, position, url, level, hour, description, dates, quantity) {
        dataLayer.push({
            'event': 'eec.addtocart',
            'ecommerce': {
                'currencyCode': 'GBP',     // Replace XXX with local currency code (EUR, USD, GBP, other 3-letter currency code)
                'add': {
                    'products': [
                        {
                            'name': name,   // Replace XXX with a name of a class (example: Antradieniais (1 lygis))
                            'id': id,   // Replace XXX with ID of selected class
                            'category': category,   // Please replace XXX with category of selected class (Should be either 'Mokama' or 'Nemokama')
                            'quantity': quantity,   // Please replace XXX with a quantity of hours of a selected class (only numbers are allowed. For example, if there is a text '2 pamokos', insert only number 2)
                            'price': price,   // Replace XXX with price of a selected class (example: 111.00 (it is mandatory to use a dot in the price and .00 if neccessary))
                            'level': level,   // Replace XXX with a level of a group in which class is (examples: Mėlyna (7-9m.), Raudona (10-14m.))
                            'hour': hour,   // Replace XXX with a hour of a class (examples: 09:00, 19:00)
                            'description': description,   // Replace XXX with a description of a class (example: Pamokos 7-9 m. vaikams)
                            'dates': dates   // Replace XXX with a dates of a class (example: 07.12 - 07.12)
                        }
                    ]
                }
            }
        });
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            'event': 'productClick',
            'ecommerce': {
                'click': {
                    'actionField': {'list': 'Nemokami kursai suaugusiems'},   // Replace XXX with a place where the class is visible (example: lietuvių kalbos pamokos, kursai suaugusiems, nemokama pamoka)
                    'products': [{
                        'name': name,   // Replace productObj.name with a selected class name
                        'id': id,   // Replace productObj.id with a selected class ID
                        'price': price,   // Replace productObj.price with a selected class price
                        'category': category,   // Replace productObj.cat with a selected class category
                        'position': position,   // Replace productObj.position with a position on which selected class was clicked
                    }]
                }
            },
            'eventCallback': function() {
                document.location = url
            }
        });
    }

    function addOneCategory(category) {
        document.cookie = "groupAdultsFreeType="+category;
        @if (!isset($_COOKIE['groupAdultsFreeType']))
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            'event': 'eec.impressions',
            'ecommerce': {
                'currencyCode': 'XXX',   // Replace XXX with local currency code (EUR, USD, GBP, other 3-letter currency code)
                'impressions': [
                        @php foreach ($groupsGrouped[$_COOKIE['groupAdultsFreeType']] as $key => $group) {
                             $descriptionData = $group->getGroupStartDateAndCount();
                        @endphp

                    {
                        'name': '{{$group->name}}',   // Replace XXX with a name of a class (example: Antradieniais (1 lygis))
                        'id': '{{$group->id}} ',   // Replace XXX with ID of selected class
                        'category': '{{$group->paid ? 'Mokama' : 'Nemokama'}}',   // Please replace XXX with category of selected class (Should be either 'Mokama' or 'Nemokama')
                        'quantity': '{{isset($descriptionData['eventsCount']) ? $descriptionData['eventsCount'] : ''}}',   // Please replace XXX with a quantity of hours of a selected class (only numbers are allowed. For example, if there is a text '2 pamokos', insert only number 2)
                        'price': '{{$group->adjustedPrice()}}',   // Replace XXX with price of a selected class (example: 111.00 (it is mandatory to use a dot in the price and .00 if neccessary))
                        'list': 'Kursai suagusiems',   // Replace XXX with a place where the class is visible (example: lietuvių kalbos pamokos, kursai suaugusiems, nemokama pamoka,
                        'position':'{{$key +1}}' ,   // Example of position=1 if this class is in first place
                        'level': '{{$group->type}}',   // Replace XXX with a level of a group in which class is (examples: Mėlyna (7-9m.), Raudona (10-14m.))
                        'hour': '{{$group->time->timezone("Europe/London")->format("H:i")}}',   // Replace XXX with a hour of a class (examples: 09:00, 19:00)
                        'description': '{{ $group->display_name }}',   // Replace XXX with a description of a class (example: Pamokos 7-9 m. vaikams)
                        'dates': '{{isset($descriptionData['startDate']) ? \Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d") : '0'}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}}'   // Replace XXX with a dates of a class (example: 07.12 - 07.12)
                    },
                    @php } @endphp
                ]
            }
        });
        @endif
    }

</script>