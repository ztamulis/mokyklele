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
    <h3 class="text-dark mb-4">Redaguoti apdovanojimą</h3>
    <div class="card"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">
                    <form action="/dashboard/rewards/{{ $reward->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <small class="form-text text-muted">Pavadinimas</small>
                            <input class="form-control" type="text" name="name" placeholder="Susitikimas su ...." value="{{ $reward->name }}">
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Aprašymas</small>
                            <textarea class="form-control summernote" name="description">{!! $reward->description !!}</textarea>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Lankytų pamokų dėl apdovanojimo skaičius (-1 Jeigu norite padaryti priskyrima patys)</small>
                            <input class="form-control" type="number" name="attendance_to_get_reward" value="{{ $reward->attendance_to_get_reward }}" >
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Apdovanojimo nuotrauka (.jpg, .png, .svg, .gif)</small>
                            <input name="file" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.svg,.gif"/>
                        </div>
                        <div class="form-group"><button class="btn btn-primary" type="submit">Atnaujinti apdovanojimą</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>