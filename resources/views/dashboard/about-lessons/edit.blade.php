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
        <h3 class="text-dark mb-4">Redaguoti Zoom puslapį</h3>
        <div class="card"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8">
                        <form action="{{route('pages.about-us.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="main_title"  value="{{$aboutUsPageContent['main_title']}}">
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Aprašymas</small>
                                <textarea class="form-control summernote" name="main_description">{{$aboutUsPageContent['main_description']}}</textarea>
                            </div>
                            <h4 class="mt-5 mb-5">Pirmas blokas</h4>

                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="first_block_title"  value="{{$aboutUsPageContent['first_block_title']}}">
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Pirmos grupės aprašymas</small>
                                <textarea class="form-control summernote" name="first_block_first_description">{{$aboutUsPageContent['first_block_first_description']}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmos grupės nuoroda į registracija</small>
                                <input class="form-control" type="text" name="first_block_first_url"  value="{{$aboutUsPageContent['first_block_first_url']}}">
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Antros grupės aprašymas</small>
                                <textarea class="form-control summernote" name="first_block_second_description">{{$aboutUsPageContent['first_block_second_description']}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antros grupės nuoroda į registracija</small>
                                <input class="form-control" type="text" name="first_block_second_url"  value="{{$aboutUsPageContent['first_block_second_url']}}">
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Trečios grupės aprašymas</small>
                                <textarea class="form-control summernote" name="first_block_third_description">{{$aboutUsPageContent['first_block_third_description']}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečios grupės nuoroda į registracija</small>
                                <input class="form-control" type="text" name="first_block_third_url"  value="{{$aboutUsPageContent['first_block_third_url']}}">
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Ketvirtos grupės aprašymas</small>
                                <textarea class="form-control summernote" name="first_block_fourth_description">{{$aboutUsPageContent['first_block_fourth_description']}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Ketvirtos grupės nuoroda į registracija</small>
                                <input class="form-control" type="text" name="first_block_fourth_url"  value="{{$aboutUsPageContent['first_block_fourth_url']}}">
                            </div>


                            <h4 class="mt-5 mb-5">Video</h4>
                            <div class="form-group">
                                <small class="form-text text-muted">Video nuoroda</small>
                                <input class="form-control" type="text" name="video_url"  value="{{$aboutUsPageContent['video_url']}}">
                            </div>



                            <h4 class="mt-5 mb-5">Antras blokas</h4>

                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="second_block_title"  value="{{$aboutUsPageContent['second_block_title']}}">
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas aprašymas kairė</small>
                                <textarea class="form-control summernote" name="second_block_first_left">{{$aboutUsPageContent['second_block_first_left']}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas aprašymas dešinė</small>
                                <textarea class="form-control summernote" type="text" name="second_block_first_right">{{$aboutUsPageContent['second_block_first_right']}}</textarea>
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Antras aprašymas kairė</small>
                                <textarea class="form-control summernote" name="second_block_second_left">{{$aboutUsPageContent['second_block_second_left']}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antras aprašymas dešinė</small>
                                <textarea class="form-control summernote" type="text" name="second_block_second_right"  >{{$aboutUsPageContent['second_block_second_right']}}</textarea>
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Trečias aprašymas kairė</small>
                                <textarea class="form-control summernote" name="second_block_third_left">{{$aboutUsPageContent['second_block_third_left']}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečias aprašymas dešinė</small>
                                <textarea class="form-control summernote" type="text" name="second_block_third_right">{{$aboutUsPageContent['second_block_third_right']}}</textarea>
                            </div>

                            <div class="form-group"><button class="btn btn-primary" type="submit">Pakeisti apie mus puslapio duomenis</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/wp-includes/js/jquery/jquery.ui.touch-punch.js"></script>
</x-user>