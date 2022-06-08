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
                <button type="submit">Patvirtinti (£{{$paymentInfo['price']}})</button>
            </form>
        </div>
    </div>

@endsection