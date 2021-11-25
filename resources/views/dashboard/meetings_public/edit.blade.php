<x-app-layout>
    @if(isset($message))
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="alert alert-primary text-center" role="alert">
                            <span>Klaida!<br>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </span>
                </div>
            </div>
        </div>
    @endif
    <h3 class="text-dark mb-4">Redaguoti susitikimą</h3>
    <div class="card"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">
                    <form action="/dashboard/introductions/{{ $meeting->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <small class="form-text text-muted">Pavadinimas</small>
                            <input class="form-control" type="text" name="name" placeholder="Susitikimas su ...." value="{{ $meeting->name }}">
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Data ({{ date("Y-m-d H:i") }} formatu,  {{ \App\TimeZoneUtils::currentGmtModifierText() }})</small>
                            @php 
                                $todayY = date("Y-m-d\TH:i", strtotime("+1 years"));
                            @endphp
                            <input class="form-control" type="datetime-local" name="date_at" max="{{ $todayY }}" placeholder="{{ date("Y-m-d\TH:i") }}" value="{{ Carbon\Carbon::parse($meeting->date_at)->timezone('Europe/London')->format('Y-m-d\TH:i')}}">
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Aprašymas</small>
                            <textarea class="form-control summernote" name="description">{!! $meeting->description !!}</textarea>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Zoom nuoroda</small>
                            <input class="form-control" type="text" name="join_link" placeholder="https://" value="{{ $meeting->join_link }}" >
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Susitikimo nuotrauka (.jpg, .png, .svg, .gif)</small>
                            <input name="file" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.svg,.gif"/>
                        </div>
                        <div class="form-group"><button class="btn btn-primary" type="submit">Atnaujinti susitikimą</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>