
<div class="learning--group--select--wrapper w-100" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Išsirinkite grupę</h2>
        <h6 style="color: red; "> Pamokų valandos rodomos Jūsų vietos laiku <small>({{ Cookie::get("user_timezone", "Europe/London") }})</small> 24 val. formatu</h6>
    </div>
    <div class="learning--group--select--selector">
        @php
            $groupsGrouped  = \App\Models\Group::where("paid", 1)->where("hidden", 0)
            ->where("type", '!=', 'bilingualism_consultation')
            ->where("age_category", 'children')
            ->get()
            ->groupBy("type");
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
            $_COOKIE['groupType'] = $type;

        @endphp

        @if(isset($groupsGrouped['yellow']))
            <a href="#yellow" id="yellow" class="learning--group--select--item active" data-filter="yellow">
                Geltona (2-4m.)
            </a>
        @endif

        @if(isset($groupsGrouped['green']))
            <a href="#green" id="green" class="learning--group--select--item" data-filter="green">
                Žalia (5-6m.)
            </a>
        @endif
        @if(isset($groupsGrouped['blue']))
            <a href="#blue" id="blue" class="learning--group--select--item" data-filter="blue">
                Mėlyna (7-9m.)
            </a>
        @endif

        @if(isset($groupsGrouped['red']))
            <a href="#red" id="red" class="learning--group--select--item" data-filter="red">
                Raudona (10-14m.)
            </a>
        @endif

        @if(isset($groupsGrouped['individual']))
            <a href="#individual" id="individual" class="learning--group--select--item" data-filter="individual">
                Individualios pamokos
            </a>
        @endif

    </div>
    @php $groups = \App\Models\Group::where("paid", 1)->where("hidden",0)
    ->where("type", '!=', 'bilingualism_consultation')
    ->where("age_category", 'children')
    ->orderBy("weight","ASC")
    ->get() @endphp
    @foreach($groups as $key => $group)
        <div class="learning--group--select--row" data-group="{{ $group->type }}">
            <div class="color background--{{ $group->type }}"></div>
            <div class="text">
                <a style="color: #000000;!important;"
                   @if($group->students()->count() >= $group->slots) href="javascript:;" @else
                    onclick="chooseLessonDataLayer(
                            '{{$group->name}}',
                            {{$group->id}},
                            {{$group->adjustedPrice()}},
                            '{{$group->paid ? 'Mokama' : 'Nemokama'}}',
                            {{$key+1}},
                            '/select-group/order/{{$group->slug }}',
                            '{{$group::getGroupTypeTranslated($group->type)}}',
                            '{{$group->time->timezone("Europe/London")->format("H:i")}}',
                            '{{ $group->display_name }}',
                            '{{isset($descriptionData['startDate']) ? \Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d") : '0'}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}}',
                            '{{isset($group->getGroupStartDateAndCount()['eventsCount']) ? $group->getGroupStartDateAndCount()['eventsCount'] : '0'}}'
                            )"
                        @endif

                >{{ $group->name }} <b>{{ $group->time->timezone(Cookie::get("user_timezone", "Europe/London"))->format("H:i") }}</b></a>
                @if($group->time_2)
                    / <a @if($group->students()->count() >= $group->slots)  @else
                         onclick="chooseLessonDataLayer(
                            '{{$group->name}}',
                            {{$group->id}},
                            {{$group->adjustedPrice()}},
                            '{{$group->paid ? 'Mokama' : 'Nemokama'}}',
                            {{$key+1}},
                            '/select-group/order/{{$group->slug }}',
                            '{{$group::getGroupTypeTranslated($group->type)}}',
                            '{{$group->time->timezone("Europe/London")->format("H:i")}}',
                            '{{ $group->display_name }}',
                            '{{isset($descriptionData['startDate']) ? \Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d") : '0'}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}}',
                            '{{isset($group->getGroupStartDateAndCount()['eventsCount']) ? $group->getGroupStartDateAndCount()['eventsCount'] : '0'}}'
                            )"
                            @endif ><b>{{ $group->time_2->timezone(Cookie::get("user_timezone", "Europe/London"))->format("H:i") }}
                        </b></a>
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
                    @php $url = '/select-group/order/'.$group->slug; @endphp
                    @if ($group->adjustedPrice() > 0)
                        <a
                                onclick="chooseLessonDataLayer(
                                        '{{$group->name}}',
                                        {{$group->id}},
                                        {{$group->adjustedPrice()}},
                                        '{{$group->paid ? 'Mokama' : 'Nemokama'}}',
                                        {{$key+1}},
                                        '/select-group/order/{{$group->slug }}',
                                        '{{$group::getGroupTypeTranslated($group->type)}}',
                                        '{{$group->time->timezone("Europe/London")->format("H:i")}}',
                                        '{{ $group->display_name }}',
                                        '{{isset($descriptionData['startDate']) ? \Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d") : '0'}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}}',
                                        '{{isset($group->getGroupStartDateAndCount()['eventsCount']) ? $group->getGroupStartDateAndCount()['eventsCount'] : '0'}}'
                                        )"
                            class="button course--select--button text-white">
                            Pasirinkti
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

    $(document).ready(function() {
        document.cookie = "groupType={{$type}}";
        $("[data-filter]").click(function () {
            filterBy($(this).attr("data-filter"));
            addOneCategory($(this).attr("data-filter"))
        });
        var hash = document.URL.substr(document.URL.indexOf('#') + 1);
        var indexOfUrl = hash.indexOf('-');
        if (parseInt(indexOfUrl) < 0) {
            filterBy(hash);
            addOneCategory(hash)
        } else {
            filterBy('{{$type}}');
            addOneCategory('{{$type}}')

        }
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
                    'actionField': {'list': 'lietuvių kalbos pamokos'},   // Replace XXX with a place where the class is visible (example: lietuvių kalbos pamokos, kursai suaugusiems, nemokama pamoka)
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
            document.cookie = "groupType="+category;
        $.ajax({
            type: "POST",
            url: "{{route('dataLayerDataByType')}}",
            data: { type: category, age_category : "children", paid : '1'},
            success: function (data) {
                dataLayer.push({ ecommerce: null });
                dataLayer.push({
                    'event': 'eec.impressions',
                    'ecommerce': {
                        'currencyCode': 'GBP',   // Replace XXX with local currency code (EUR, USD, GBP, other 3-letter currency code)
                        'impressions': [
                            data
                        ]
                    }
                });
            }
        });

    }
</script>
