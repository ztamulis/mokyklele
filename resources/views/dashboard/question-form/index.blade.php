
<x-app-layout>
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <h1 class="text-center mt-5 mb-5">Atsakymai į klausimus</h1>

    <div class="d-lg-block d-none">
        <div class="row mb-1" style="margin-right: 100px;">
            <div class="col-md-3 mr-1 font-weight-bold">
                <strong>Elektroninis paštas</strong>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Kokios jūsų lietuvių kalbos žinios?</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Kokiomis dienomis norėtumėte, kad vyktų pamokos?</b>
            </div>
            <div class="col-md-1 mr-2 font-weight-bold">
                <b>Kiek kartų per savaitę norėtumėte mokytis?</b>
            </div>
            <div class="col-md-2 font-weight-bold">
                <b>Papildomi komentarai/klausimai</b>
            </div>
            <div class="col-md-1 font-weight-bold">
                <b>Data</b>
            </div>
        </div>
        @foreach ($questions as $question)
            <div class="row" style="margin-right: 100px;">
                <div class="col-md-3 mr-1" style="  word-wrap: break-word;">
                    {{$question->email}}
                </div>
                <div class="col-md-2">
                    {{$question->language_level}}
                </div>
                <div class="col-md-2">
                    {{isset($question->week_days) ? implode(', ', $question->week_days) : ''}}
                </div>
                <div class="col-md-1 mr-2">
                    {{$question->times_per_week}}
                </div>
                <div class="col-md-2">
                    {{$question->comment}}
                </div>
                <div class="col-md-1">
                    {{\Carbon\Carbon::parse($question->created_at)->timezone('Europe/London')->format('Y-m-d H:i:s')}}
                </div>
            </div>
            <div class="dashboard--block--hr"></div>

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
                    {{isset($question->week_days) ? implode(', ', $question->week_days) : ''}}
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
