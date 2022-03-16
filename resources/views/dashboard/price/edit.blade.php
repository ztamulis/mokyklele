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
        <h3 class="text-dark mb-4">Kainų puslapis</h3>
        <div class="card"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8">
                        <form action="{{route('pages.prices.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group"><small class="form-text text-muted">Pirmo bloko pirmas nuotrauka (.jpg, .png, .svg, .gif)</small>
                                <input name="first_block_first_img" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.svg,.gif"/>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmo bloko pirmas tekstas</small>
                                <textarea class="form-control summernote" name="first_block_first_content">{!! $pricePageContent['first_block_first_content'] !!}</textarea>
                            </div>
                            
                            <div class="form-group"><small class="form-text text-muted">Pirmo bloko antra nuotrauka (.jpg, .png, .svg, .gif)</small>
                                <input name="first_block_second_img" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.svg,.gif"/>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmo bloko antras tekstas</small>
                                <textarea class="form-control summernote" name="first_block_second_content">{!! $pricePageContent['first_block_second_content'] !!}</textarea>
                            </div>

                            <div class="form-group"><small class="form-text text-muted">Pirmo bloko trečia nuotrauka (.jpg, .png, .svg, .gif)</small>
                                <input name="first_block_third_img" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.svg,.gif"/>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmo bloko trečias tekstas</small>
                                <textarea class="form-control summernote" name="first_block_third_content">{!! $pricePageContent['first_block_third_content'] !!}</textarea>
                            </div>


                            <div class="form-group">
                                <small class="form-text text-muted">Antro bloko pirmas tekstas</small>
                                <textarea class="form-control summernote" name="second_block_first_content">{!! $pricePageContent['second_block_first_content'] !!}</textarea>
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Antro bloko antras tekstas</small>
                                <textarea class="form-control summernote" name="second_block_second_content">{!! $pricePageContent['second_block_second_content'] !!}</textarea>
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Antro bloko trečias tekstas</small>
                                <textarea class="form-control summernote" name="second_block_third_content">{!! $pricePageContent['second_block_third_content'] !!}</textarea>
                            </div>

                            <div class="form-group">
                                <small class="form-text text-muted">Apatinis textas</small>
                                <textarea class="form-control summernote" name="end_text">{!! $pricePageContent['end_text'] !!}</textarea>
                            </div>

                            <div class="form-group"><button class="btn btn-primary" type="submit">Atnaujinti kainų puslapį</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user>