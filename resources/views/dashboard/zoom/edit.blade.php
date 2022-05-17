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
                        <form action="{{route('pages.zoom-page.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="main_title"  value="{{$zoomPageContent['main_title']}}">
                            </div>

                            <h4 class="mt-5 mb-5">Pirmas</h4>

                            <div class="form-group">
                                <small class="form-text text-muted">Kairė pusė</small>
                                <textarea class="form-control summernote" name="first_block_left">{{isset($zoomPageContent['first_block_left']) ? $zoomPageContent['first_block_left'] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Dešinė pusė</small>
                                <textarea class="form-control summernote" name="first_block_right">{{isset($zoomPageContent['first_block_right']) ? $zoomPageContent['first_block_right'] : ''}}</textarea>
                            </div>

                            <h4 class="mt-5 mb-5">Antras blokas</h4>

                            <div class="form-group">
                                <small class="form-text text-muted">Kairė pusė</small>
                                <textarea class="form-control summernote" name="second_block_left">{{isset($zoomPageContent['second_block_left']) ? $zoomPageContent['second_block_left'] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Dešinė pusė</small>
                                <textarea class="form-control summernote" name="second_block_right">{{isset($zoomPageContent['second_block_right']) ? $zoomPageContent['second_block_right'] : ''}}</textarea>
                            </div>

                            <h4 class="mt-5 mb-5">Video</h4>
                            <div class="form-group">
                                <small class="form-text text-muted">Video url</small>
                                <input class="form-control" type="text" name="video_url"  value="{{$zoomPageContent['video_url']}}">
                            </div>
                            <div class="form-group"><button class="btn btn-primary" type="submit">Pakeisti zoom puslapio duomenis</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/wp-includes/js/jquery/jquery.ui.touch-punch.js"></script>
</x-user>