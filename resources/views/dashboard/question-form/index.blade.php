
<x-app-layout>
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <h1 class="text-center mt-5 mb-5">Atsakymai į klausimus</h1>

    <div class="d-lg-block d-none">
        <div class="row mb-1" style="margin-right: -40px;">
            <div class="col-md-3 mr-3 font-weight-bold">
                <strong>Elektroninis paštas</strong>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Kokios jūsų lietuvių kalbos žinios?</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Kokiomis dienomis norėtumėte, kad vyktų pamokos?</b>
            </div>
            <div class="col-md-2 mr-4 font-weight-bold">
                <b>Kiek kartų per savaitę norėtumėte mokytis?</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Papildomi komentarai/klausimai</b>
            </div>
        </div>
        @foreach ($questions as $question)
            <div class="row" style="margin-right: -40px;">
                <div class="col-md-3 mr-3">
                    {{$question->email}}
                </div>
                <div class="col-md-2">
                    {{$question->language_level}}
                </div>
                <div class="col-md-2">
                    {{implode(', ', $question->week_days)}}
                </div>
                <div class="col-md-2 mr-4">
                    {{$question->times_per_week}}
                </div>
                <div class="col-md-2">
                    {{$question->comment}}
                </div>
            </div>
        @endforeach
    </div>


    <div class="d-md-block d-lg-none mt-5">
        @foreach ($questions as $question)
            <div class="row border-bottom mt-2">
                <div class="col-12 font-weight-bold">
                    <strong>Elektroninis paštas</strong>
                </div>
                <div class="col-12">
                    {{$question->email}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Kokios jūsų lietuvių kalbos žinios?</b>
                </div>
                <div class="col-12">
                    {{$question->language_level}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Kokiomis dienomis norėtumėte, kad vyktų pamokos?</b>
                </div>
                <div class="col-12">
                    {{implode(', ', $question->week_days)}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Kiek kartų per savaitę norėtumėte mokytis?</b>
                </div>
                <div class="col-12">
                    {{$question->times_per_week}}
                </div>
                <div class="col-12 font-weight-bold">
                    <b>Papildomi komentarai/klausimai</b>
                </div>
                <div class="col-12">
                    {{$question->comment}}
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
