@extends("layouts.landing")

@section("title", "Patvirtinti užsakymą")

@section("content")
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Užsakymas</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-order-5">
            <table class="table" style="margin: auto;">
                <tbody>
                <tr>
                    <th scope="row" class="text-align-left">Vardas pavardė:</th>
                    <td>{{$paymentInfo['full_name']}}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-align-left">Grupė:</th>
                    <td>{{$paymentInfo['group_name']}}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-align-left">Grupės pradžia:</th>
                    <td>{{$paymentInfo['group_starts']}}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-align-left">Grupės pabaiga:</th>
                    <td>{{$paymentInfo['group_ends']}}</td>
                </tr>
                @if(isset($paymentInfo['bilingualism_consultation_note'])
                && !empty($paymentInfo['bilingualism_consultation_note']))
                <tr>
                    <th scope="row" class="text-align-left">Trumpas aprašas</th>
                    <td>@php echo $paymentInfo['bilingualism_consultation_note'] @endphp</td>
                </tr>
                @endif
                <tr>
                    @if($paymentInfo['age_category'] === 'adults')
                        <th scope="row" class="text-align-left">Vartotojas(-a):</th>
                    @else
                        <th scope="row" class="text-align-left">Vaikas(-ai):</th>
                    @endif
                    <td>{{$paymentInfo['students']}}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-align-left">Laikas: </th>
                    <td>{{App\TimeZoneUtils::updateTime($paymentInfo['time']->timezone(Cookie::get("user_timezone", "Europe/London")), $paymentInfo['group_updated_at'])->format("H:i")}} ({{Auth::user()->time_zone ? Auth::user()->time_zone : 'Europe/London'}})</td>
                </tr>
                <tr>
                    <th scope="row" class="text-align-left">Kaina:</th>
                    <td>£{{$paymentInfo['price']}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center  mt-order-5">
            <form action="{{$paymentInfo['url']}}">
                @if(!empty($paymentInfo['session_id']))
                    <input type="hidden" name="session_id" value="{{$paymentInfo['session_id']}}">
                @endif
                <button onclick="onConfirm('{{$paymentInfo['group_name']}}',
                        '{{$paymentInfo['group_id']}}',
                        '{{$paymentInfo['price']}}',
                        '{{$paymentInfo['group_type']}}',
                        '{{App\TimeZoneUtils::updateTime($paymentInfo['time']->timezone("Europe/London"), $paymentInfo['group_updated_at'])->format("H:i")}}',
                        '{{$paymentInfo['group_description']}}',
                        '{{$paymentInfo['group_starts']}} - {{$paymentInfo['group_ends']}}',
                        )" type="submit">Patvirtinti (£{{$paymentInfo['price']}})</button>
            </form>
        </div>
    </div>
    <script>
        function onConfirm(name, id, price, category, level, hour, description, dates) {
            dataLayer.push({
                event: 'eec.checkout',
                ecommerce: {
                    checkout: {
                        'actionField': {'step': 2},
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
        }
    </script>

@endsection