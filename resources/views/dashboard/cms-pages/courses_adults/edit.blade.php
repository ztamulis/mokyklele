<x-user>
    <div class="container--other">
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
        <h3 class="text-dark mb-4">Redaguoti suagusiųjų kursų puslapį</h3>
        <div class="card"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8">
                        <form action="{{route('pages.courses-adults.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimo tekstas</small>
                                <input class="form-control" type="text" name="main_title" placeholder="Susitikimai" value="{{ $coursesPageContent['main_title'] }}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Puslapio tekstas</small>
                                <textarea class="form-control summernote" name="main_description">{!! $coursesPageContent['main_description'] !!}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Apatinis puslapio tekstas</small>
                                <textarea class="form-control summernote" name="bottom_description">{!! $coursesPageContent['bottom_description'] !!}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirma forma</small>
                                <select class="custom-select" name="main_component">
                                    @foreach(\App\Http\Helpers\PageContentHelper::getComponentsNames() as $value  => $name)
                                    <option {{ $coursesPageContent['main_component'] == $value ? 'selected' : ''}} value="{{$value}}" >{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Antra forma</small>
                                <select class="custom-select" name="second_component">
                                    @foreach(\App\Http\Helpers\PageContentHelper::getComponentsNames() as $value  => $name)
{{--                                        <option value="{{$value}}" >{{$name}}</option>--}}

                                        <option {{ $coursesPageContent['second_component'] == $value ? 'selected' : ''}} value="{{$value}}" >{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group"><small class="form-text text-muted">Puslapio nuotrauka (.jpg, .png, .svg, .gif)</small>
                                <input name="file" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.svg,.gif"/>
                            </div>
                            <div class="form-group"><button class="btn btn-primary" type="submit">Atnaujinti suaugusiųjų kursų puslapį</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user>