
<x-app-layout>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <h1 class="text-center mt-5 mb-5">Atsakymai į klausimus</h1>
    <a style="color: #0a00f9!important;" href="{{asset('nemokama-pamoka.xlsx')}}">Excel download</a>
    <form method="GET" action="/register-free/admin">
        <div class="form-row mb-3 mt-3">
            <div class="col-md-6 col-xl-4 mt-1 text-nowrap"><input class="form-control" type="text" name="email" placeholder="el. paštas" value="{{ request()->input("email") }}"></div>
            <div class="col-md-6 col-xl-4 mt-1 text-nowrap"><input class="form-control" type="text" name="name" placeholder="Vardas" value="{{ request()->input("name") }}"></div>
            <div class="col-xl-3">
                <button class="btn btn-success mt-1" type="submit">Paieška</button>
            </div>
        </div>
    </form>
    <div class="d-lg-block d-none">
        <div class="row mb-1" >
            <div class="col-md-2 font-weight-bold">
                <strong>Elektroninis paštas</strong>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Vardas</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Studento vardas</b>
            </div>
            <div class="col-md-1 font-weight-bold">
                <b>Studento amžius</b>
            </div>
            <div class="col-md-1 font-weight-bold">
                <b>Šalis</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Papildomi komentarai/klausimai</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Laikas</b>
            </div>
        </div>
        @foreach ($registrations as $registration)
            <div class="row">
                <div class="col-md-2" style="    word-break: break-word;">
                    {{$registration->email}}
                </div>
                <div class="col-md-2">
                    {{$registration->name}}
                </div>
                <div class="col-md-2">
                    {{$registration->student_name}}
                </div>
                <div class="col-md-1">
                    {{$registration->student_age}}
                </div>
                <div class="col-md-1">
                    {{$registration->country}}
                </div>
                <div class="col-md-2">
                    {{$registration->comment}}
                </div>
                <div class="col-md-2">
                    {{$registration->created_at->timezone('Europe/London')->format('Y-m-d h:i:s')}}
                </div>
            </div>
            <hr>
        @endforeach
    </div>


    <div class="d-md-block d-lg-none mt-5">
        @foreach ($registrations as $registration)
            <div class="row border-bottom mt-2">
                <div class="col-12 font-weight-bold">
                    <strong>Elektroninis paštas</strong>
                </div>
                <div class="col-12">
                    {{$registration->email}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Studento vardas</b>
                </div>
                <div class="col-12">
                    {{$registration->name}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Studento amžius</b>
                </div>
                <div class="col-12">
                    {{$registration->student_age}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Šalis</b>
                </div>
                <div class="col-12">
                    {{$registration->country}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Papildomi komentarai/klausimai</b>
                </div>
                <div class="col-12">
                    {{$registration->comment}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Laikas</b>
                </div>
                <div class="col-12">
                    {{$registration->created_at->timezone('Europe/London')->format('Y-m-d h:i:s')}}
                </div>
                <hr>
            </div>
        @endforeach
    </div>
</x-app-layout>
