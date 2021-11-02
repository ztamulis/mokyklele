
<x-app-layout>
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <h1 class="text-center mt-5 mb-5">Atsakymai į klausimus</h1>

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
            <div class="col-md-2 font-weight-bold">
                <b>Studento amžius</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Šalis</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Papildomi komentarai/klausimai</b>
            </div>
        </div>
        @foreach ($registrations as $registration)
            <div class="row">
                <div class="col-md-2">
                    {{$registration->email}}
                </div>
                <div class="col-md-2">
                    {{$registration->name}}
                </div>
                <div class="col-md-2">
                    {{$registration->student_name}}
                </div>
                <div class="col-md-2">
                    {{$registration->student_age}}
                </div>
                <div class="col-md-2">
                    {{$registration->country}}
                </div>
                <div class="col-md-2">
                    {{$registration->comment}}
                </div>
            </div>
            <div class="dashboard--block--hr"></div>

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
            </div>
        @endforeach
    </div>
</x-app-layout>
