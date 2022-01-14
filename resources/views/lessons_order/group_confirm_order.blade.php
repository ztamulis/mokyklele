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
                    <td>{{$paymentInfo['time']->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i")}}</td>
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