@extends("layouts.landing")

@section("title", "Užsakymo suvestinė")

@section("content")
    @if(!isset($error))
        <h2 class="content--title">Registracijos patvirtinimas</h2>
        <div class="text--center">
            <b>{{\Carbon\Carbon::parse($group->start_date)->format("m.d")}}d., {{ $group->name }} {{ App\TimeZoneUtils::updateTime($group->time->timezone(Cookie::get("user_timezone", "Europe/London")), $group->updated_at)->format('H:i') }} (laikas nurodomas jūsų vietiniu  <small>({{ Cookie::get("user_timezone", "Europe/London") }}</small>)</b>
            <br>
            {{ $group->display_name }}
            <br>
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
                            'id': 'NA',   // Replace XXX with Transaction ID
                            'revenue': '0',   // Replace XXX with total value of a cart (including tax & shipping)
                            'currencyCode': 'GBP',   // Replace XXX with local currency code (EUR, USD, GBP, other 3-letter currency code)
                            'coupon': 'NA',   // Replace XXX into coupon field with a coupon name (if there were no coupon used, write NA)
                            'tax': '0',   // Replace XXX with an amount of taxes in a cart (if there are no taxes, insert 0)
                            'shipping': '0'   // Replace XXX with an amount of shipping costs (if there are no shipping costs, insert 0)
                        },
                        'products': [
                            {
                                'name': '{{$group->name}}',   // Replace XXX with a name of a class (example: Antradieniais (1 lygis))
                                'id': '{{$group->id}}',   // Replace XXX with ID of selected class
                                'category': '{{$group->type}}',   // Please replace XXX with category of selected class (Should be either 'Mokama' or 'Nemokama')
                                'quantity': '1',   // Please replace XXX with a quantity of hours of a selected class (only numbers are allowed. For example, if there is a text '2 pamokos', insert only number 2)
                                'price': '0',   // Replace XXX with price of a selected class (example: 111.00 (it is mandatory to use a dot in the price and .00 if neccessary))
                                'level': '{{ $group->display_name }}',   // Replace XXX with a level of a group in which class is (examples: Mėlyna (7-9m.), Raudona (10-14m.))
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