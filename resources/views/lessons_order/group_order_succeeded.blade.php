@extends("layouts.landing")

@section("title", "Užsakymo suvestinė")

@section("content")
    @if(!isset($error))
        <h1 class="content--title">Užsakymas</h1>
        <div class="text--center">
            <b>{{ $group->name }} {{ $group->time->timezone(Cookie::get("user_timezone", "Europe/London"))->format("H:i") }}</b>
            <br>
            {{ $group->display_name }}
            <br>
            @php $descriptionData = $group->getGroupStartDateAndCount() @endphp
            @if (!empty($descriptionData) && isset($descriptionData['eventsCount']))

            <span>Kursas vyks: {{\Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d")}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}} ({{$descriptionData['eventsCount']}}
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


                </span>
            @endif

            <br>
        </div>

    @endif

    <div class="text-center">
        <h3 style="color: #54efd1;">{{ $message }}</h3>
        @if(!isset($error))
            <a href="/dashboard" class="button">Prisijungti</a>
        @endif
    </div>
    <script>
        $(document).ready(function() {
            dataLayer.push({
                event: 'eec.purchase',
                'ecommerce': {
                    'purchase': {
                        'actionField': {
                            'id': '{{$payment->payment_id}}',   // Replace XXX with Transaction ID
                            'revenue': '{{$payment->amount}}',   // Replace XXX with total value of a cart (including tax & shipping)
                            'currencyCode': 'GBP',   // Replace XXX with local currency code (EUR, USD, GBP, other 3-letter currency code)
                            'coupon': '{{$payment->discount_code ? $payment->discount_code : 'NA'}}',   // Replace XXX into coupon field with a coupon name (if there were no coupon used, write NA)
                            'tax': '0',   // Replace XXX with an amount of taxes in a cart (if there are no taxes, insert 0)
                            'shipping': '0'   // Replace XXX with an amount of shipping costs (if there are no shipping costs, insert 0)
                        },
                        'products': [
                            {
                                'name': '{{$group->name}}',   // Replace XXX with a name of a class (example: Antradieniais (1 lygis))
                                'id': '{{$group->id}}',   // Replace XXX with ID of selected class
                                'category': '{{$group->paid ? 'Mokama' : 'Nemokama'}}',   // Please replace XXX with category of selected class (Should be either 'Mokama' or 'Nemokama')
                                'quantity': '{{isset($group->getGroupStartDateAndCount()['eventsCount']) ? $group->getGroupStartDateAndCount()['eventsCount'] : '0'}}',   // Please replace XXX with a quantity of hours of a selected class (only numbers are allowed. For example, if there is a text '2 pamokos', insert only number 2)
                                'price': '{{$group->price}}',   // Replace XXX with price of a selected class (example: 111.00 (it is mandatory to use a dot in the price and .00 if neccessary))
                                'level': '{{$group::getGroupTypeTranslated($group->type)}}',   // Replace XXX with a level of a group in which class is (examples: Mėlyna (7-9m.), Raudona (10-14m.))
                                'hour': '{{ App\TimeZoneUtils::updateTime($group->time->timezone("Europe/London"), $group->updated_at)->format('H:i')}}',   // Replace XXX with a hour of a class (examples: 09:00, 19:00)
                                'description': '{{ $group->description }}',   // Replace XXX with a description of a class (example: Pamokos 7-9 m. vaikams)
                                'dates': '{{isset($group->startDate) ? \Carbon\Carbon::parse($group->startDate)->format("m.d") : '0'}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}}'   // Replace XXX with a dates of a class (example: 07.12 - 07.12)
                            }
                        ]
                    }
                }
            });
        });
    </script>
@endsection