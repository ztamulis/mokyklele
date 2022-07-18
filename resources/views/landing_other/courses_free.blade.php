
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
            $_COOKIE['groupTypeFree'] = $type;

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
    @php $groups = \App\Models\Group::where("paid", 0)->where("age_category", 'children')
    ->where("type", '!=', 'bilingualism_consultation')
    ->where("hidden", 0)
    ->orderBy("weight","ASC")
    ->get();
    @endphp

    @foreach( $groups as $key => $group)
        <div class="learning--group--select--row" data-group-free="{{ $group->type }}">
            <div class="color background--{{ $group->type }}"></div>
            <div class="text">
                <a @if($group->students()->count() >= $group->slots) href="javascript:;" @else onclick="chooseLessonDataLayer(
                    '{{$group->name}}',
                {{$group->id}},
                {{$group->adjustedPrice()}},
                        '{{$group->type}}',
                {{$key+1}},
                        '/select-group/order/free/{{$group->slug }}',
               '{{$group->type}}',
                '{{$group->time->timezone("Europe/London")->format("H:i")}}', '{{ $group->display_name }}',
                '{{isset($descriptionData['startDate']) ? \Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d") : '0'}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}}')
                        " @endif >{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "Europe/London"))->format("H:i") }}</b></a><br>
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
                    <a onclick="chooseLessonDataLayer(
                            '{{$group->name}}',
                    {{$group->id}},
                    {{$group->adjustedPrice()}},
                            '{{$group->type}}',
                    {{$key+1}},
                            '/select-group/order/free/{{$group->slug }}',
                    {{$group->type}},
                    '{{$group->time->timezone("Europe/London")->format("H:i")}}',
                            '{{ $group->display_name }}',
                            '{{isset($descriptionData['startDate']) ? \Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d") : '0'}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}}')" class="button course--select--button text-white">
                        Pasirinkti
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>
<script>
    $(document).ready(function() {
        document.cookie = "groupTypeFree={{$type}}";
        console.log(document.cookie);
        $("[data-filter-free]").click(function () {
            filterByFree($(this).attr("data-filter-free"));
            addOneCategory($(this).attr("data-filter-free"))

        });
        var hash = document.URL.substr(document.URL.indexOf('#') + 1);
        var indexOfUrl = hash.indexOf('-');
        if (parseInt(indexOfUrl) < 0) {
            filterByFree(hash);
            addOneCategory(hash)
        } else {
            filterByFree('{{$type}}');
            addAll();

        }
    });
    function filterByFree(group) {
        $("[data-group-free]").hide();
        $("[data-group-free='" + group + "']").show();
        $("[data-filter-free]").removeClass("active");
        $("[data-filter-free='" + group + "']").addClass("active");
    }

    function chooseLessonDataLayer(name, id, price, category, position, url, level, hour, description, dates) {
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
                            'quantity': 1,   // Please replace XXX with a quantity of hours of a selected class (only numbers are allowed. For example, if there is a text '2 pamokos', insert only number 2)
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
                    'actionField': {'list': 'Nemokama pamoka'},   // Replace XXX with a place where the class is visible (example: lietuvių kalbos pamokos, kursai suaugusiems, nemokama pamoka)
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

    function addAll() {
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            'event': 'eec.impressions',
            'ecommerce': {
                'currencyCode': 'XXX',   // Replace XXX with local currency code (EUR, USD, GBP, other 3-letter currency code)
                'impressions': [
                        @php foreach ($groups as $key => $group) {
                             $descriptionData = $group->getGroupStartDateAndCount();
                        @endphp

                    {
                        'name': '{{$group->name}}',   // Replace XXX with a name of a class (example: Antradieniais (1 lygis))
                        'id': '{{$group->id}} ',   // Replace XXX with ID of selected class
                        'category': '{{$group->paid ? 'Mokama' : 'Nemokama'}}',   // Please replace XXX with category of selected class (Should be either 'Mokama' or 'Nemokama')
                        'quantity': '{{isset($descriptionData['eventsCount']) ? $descriptionData['eventsCount'] : ''}}',   // Please replace XXX with a quantity of hours of a selected class (only numbers are allowed. For example, if there is a text '2 pamokos', insert only number 2)
                        'price': '{{$group->adjustedPrice()}}',   // Replace XXX with price of a selected class (example: 111.00 (it is mandatory to use a dot in the price and .00 if neccessary))
                        'list': 'Nemokama pamoka',   // Replace XXX with a place where the class is visible (example: lietuvių kalbos pamokos, kursai suaugusiems, nemokama pamoka,
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
    }

    function addOneCategory(category) {
        document.cookie = "groupType="+category;
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            'event': 'eec.impressions',
            'ecommerce': {
                'currencyCode': 'XXX',   // Replace XXX with local currency code (EUR, USD, GBP, other 3-letter currency code)
                'impressions': [
                        @php foreach ($groupsGrouped[$_COOKIE['groupTypeFree']] as $key => $group) {
                             $descriptionData = $group->getGroupStartDateAndCount();
                        @endphp
                    {
                        'name': '{{$group->name}}',   // Replace XXX with a name of a class (example: Antradieniais (1 lygis))
                        'id': '{{$group->id}} ',   // Replace XXX with ID of selected class
                        'category': '{{$group->paid ? 'Mokama' : 'Nemokama'}}',   // Please replace XXX with category of selected class (Should be either 'Mokama' or 'Nemokama')
                        'quantity': '{{isset($descriptionData['eventsCount']) ? $descriptionData['eventsCount'] : ''}}',   // Please replace XXX with a quantity of hours of a selected class (only numbers are allowed. For example, if there is a text '2 pamokos', insert only number 2)
                        'price': '{{$group->adjustedPrice()}}',   // Replace XXX with price of a selected class (example: 111.00 (it is mandatory to use a dot in the price and .00 if neccessary))
                        'list': 'Nemokama pamoka',   // Replace XXX with a place where the class is visible (example: lietuvių kalbos pamokos, kursai suaugusiems, nemokama pamoka,
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
    }

</script>