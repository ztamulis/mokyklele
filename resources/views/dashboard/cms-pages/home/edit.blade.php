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
        <h2 class="text-dark text-center mb-4">Redaguoti pagrindinį puslapį</h2>
        <div class="card"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                        <form action="{{route('pages.home-page.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="col-xl-12">
                                <h4>Pagrindinė puslapio informacija</h4>
                                <div class="form-group"><small class="form-text text-muted">Pagrindinis pavadinimas</small>
                                    <input class="form-control" type="text" name="main_title" value="{{ isset($homePageContent['main_title']) ?  $homePageContent['main_title'] : ''}}" >
                                </div>
                                <div class="form-group">
                                    <span class="form-text text-danger bold">Pagrindinis aprašymas</span>
                                    <textarea class="form-control summernote" name="main_description">{!! isset($homePageContent['main_description']) ?  $homePageContent['main_description'] : '' !!}</textarea>
                                </div>
                                <div class="form-group"><small class="form-text text-muted">Pagrindinė nuotrauka (.jpg, .png, .svg, .gif)</small>
                                    <input name="main_img" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.svg,.gif"/>
                                </div>
                                <div class="form-group"><small class="form-text text-muted">Pagrindinio mygtuko pavadinimas</small>
                                    <input class="form-control" type="text" name="main_button_text" value="{{ isset($homePageContent['main_button_text']) ?  $homePageContent['main_button_text'] : ''}}" >
                                </div>
                                <div class="form-group"><small class="form-text text-muted">Pagrindinis mygtuko adresas</small>
                                    <input class="form-control" type="text" name="main_button_url" value="{{ isset($homePageContent['main_button_url']) ?  $homePageContent['main_button_url'] : ''}}" >
                                </div>
                            </div>

                            <div class="col-xl-12 mt-5">
                                <h4>Pirmo bloko informacija</h4>

                                <div class="form-group"><small class="form-text text-muted">Pirmas blokas pavadinimas</small>
                                    <input class="form-control" type="text" name="first_block_title" value="{{ isset($homePageContent['first_block_title']) ?  $homePageContent['first_block_title'] : ''}}" >
                                </div>
                                <div class="form-group">
                                    <span class="form-text text-danger bold">Pirmas blokas aprašymas</span>
                                    <textarea class="form-control summernote" name="first_block_description">{!! isset($homePageContent['first_block_description']) ?  $homePageContent['first_block_description'] : '' !!}</textarea>
                                </div>
                                <div class="form-group"><small class="form-text text-muted">Pirmas blokas mygtuko pavadinimas</small>
                                    <input class="form-control" type="text" name="first_block_button_text" value="{{ isset($homePageContent['first_block_button_text']) ?  $homePageContent['first_block_button_text'] : ''}}" >
                                </div>
                                <div class="form-group"><small class="form-text text-muted">Pirmas blokas mygtuko adresas</small>
                                    <input class="form-control" type="text" name="first_block_button_url" value="{{ isset($homePageContent['first_block_button_url']) ?  $homePageContent['first_block_button_url'] : ''}}" >
                                </div>
                            </div>

                            <div class="col-xl-12 mt-5">
                                <h4>Antro bloko informacija</h4>
                                <div class="form-group"><small class="form-text text-muted">Antras blokas pavadinimas</small>
                                    <input class="form-control" type="text" name="second_block_title" value="{{ isset($homePageContent['second_block_title']) ?  $homePageContent['second_block_title'] : ''}}" >
                                </div>
                                <div class="form-group">
                                    <span class="form-text text-danger bold">Antras blokas aprašymas</span>
                                    <textarea class="form-control summernote" name="second_block_description">{!! isset($homePageContent['second_block_description']) ?  $homePageContent['second_block_description'] : '' !!}</textarea>
                                </div>
                                <div class="form-group"><small class="form-text text-muted">Antras blokas mygtuko pavadinimas</small>
                                    <input class="form-control" type="text" name="second_block_button_text" value="{{ isset($homePageContent['second_block_button_text']) ?  $homePageContent['second_block_button_text'] : ''}}" >
                                </div>
                                <div class="form-group"><small class="form-text text-muted">Antras blokas mygtuko adresas</small>
                                    <input class="form-control" type="text" name="second_block_button_url" value="{{ isset($homePageContent['second_block_button_url']) ?  $homePageContent['second_block_button_url'] : ''}}" >
                                </div>
                            </div>


                            <div class="col-xl-12 mt-5">
                                <h3>Trečio bloko informacija</h3>
                                <div class="form-group"><small class="form-text text-muted">Trečias blokas pavadinimas</small>
                                    <input class="form-control" type="text" name="third_block_title" value="{{ isset($homePageContent['third_block_title']) ?  $homePageContent['third_block_title'] : ''}}" >
                                </div>
                                <div class="form-group">
                                    <span class="form-text text-danger bold">Trečias blokas aprašymas</span>
                                    <textarea class="form-control summernote" name="third_block_description">{!! isset($homePageContent['third_block_description']) ?  $homePageContent['third_block_description'] : '' !!}</textarea>
                                </div>
                                <div class="form-group"><small class="form-text text-muted">Trečias blokas mygtuko pavadinimas</small>
                                    <input class="form-control" type="text" name="third_block_button_text" value="{{ isset($homePageContent['third_block_button_text']) ?  $homePageContent['third_block_button_text'] : ''}}" >
                                </div>
                                <div class="form-group"><small class="form-text text-muted">Trečias blokas mygtuko adresas</small>
                                    <input class="form-control" type="text" name="third_block_button_url" value="{{ isset($homePageContent['third_block_button_url']) ?  $homePageContent['third_block_button_url'] : ''}}" >
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-group mt-5"><button class="btn btn-primary" type="submit">Atnaujinti susitikimą</button></div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-user>