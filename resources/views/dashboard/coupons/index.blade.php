
<x-app-layout>
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <h1 class="text-center mt-5 mb-5">Kuponai</h1>

    <div class="row mb-3">
        <div class="col-md-12 col-12">
            <a href="/dashboard/coupons/create" class="btn btn-primary" type="button">Sukurti naują</a>
        </div>
    </div>

    <div class="d-lg-block d-none">
        <div class="row mb-1" style="margin-right: -40px;">
            <div class="col-md-2 mr-3 font-weight-bold">
                <strong>Pavadinimas</strong>
            </div>
            <div class="col-md-1 font-weight-bold">
                <b>Tipas</b>
            </div>
            <div class="col-md-1 font-weight-bold">
                <b>Dydis</b>
            </div>
            <div class="col-md-1 mr-4 font-weight-bold">
                <b>Panaudota kartų</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Panaudojimo limitas</b>
            </div>
            <div class="col-md-1 font-weight-bold">
                <b>Galioja iki</b>
            </div>
            <div class="col-md-1 font-weight-bold">
                <b>Aktyvus</b>
            </div>
            <div class="col-md-1 font-weight-bold">
                <b>Veiksmai</b>
            </div>
        </div>
        @foreach ($coupons as $coupon)
            <div class="row" style="margin-right: -40px;">
                <div class="col-md-2 mr-3">
                    {{$coupon->code}}
                </div>
                <div class="col-md-1">
                    {{$coupon->type}}
                </div>
                <div class="col-md-1">
                    {{$coupon->discount}}
                </div>
                <div class="col-md-1 mr-4">
                    {{$coupon->used}}
                </div>
                <div class="col-md-2">
                    {{$coupon->use_limit}}
                </div>
                <div class="col-md-1">
                    {{$coupon->expires_at}}
                </div>
                <div class="col-md-1">
                    {{$coupon->active}}
                </div>
                <div class="col-md-1">
                    <a href="/dashboard/coupons/{{$coupon->id}}/edit" class="btn btn-info" type="button" style="margin: 0px 4px 0px;">Redaguoti</a>
                    <form action="/dashboard/coupons/{{$coupon->id}}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti kuponą?')" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" style="margin: 0px 4px 0px;" type="submit">Ištrinti</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>


    <div class="d-md-block d-lg-none mt-5 ">
        @foreach ($coupons as $coupon)
            <div class="row border-bottom mt-2">
                <div class="col-12 font-weight-bold">
                    <strong>Pavadinimas</strong>
                </div>
                <div class="col-12">
                    {{$coupon->code}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Tipas</b>
                </div>
                <div class="col-12">
                    {{$coupon->type}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Dydis</b>
                </div>
                <div class="col-12">
                    {{$coupon->discount}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Panaudota kartų</b>
                </div>
                <div class="col-12">
                    {{$coupon->used}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Panaudojimo limitas</b>
                </div>
                <div class="col-12">
                    {{$coupon->use_limit}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Galioja iki</b>
                </div>
                <div class="col-12">
                    {{$coupon->expires_at}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Veiksmai</b>
                </div>
                <div class="col-12">
                    <a href="/dashboard/coupons/{{$coupon->id}}/edit" class="btn btn-info" type="button" style="margin: 0px 4px 0px;">Redaguoti</a>
                    <form action="/dashboard/coupons/{{$coupon->id}}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti kuponą?')" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" style="margin: 0px 4px 0px;" type="submit">Ištrinti</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
