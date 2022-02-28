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
        <h3 class="text-dark mb-4">Sukurti patarimą</h3>
        <div class="card"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8">
                        <form action="{{route('pages.lithuanian-courses-children.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="site_name"  value="{{$lithuanianLanguagePageContent->site_name}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Aprašymas</small>
                                <textarea class="form-control summernote" name="description">{{$lithuanianLanguagePageContent->description}}</textarea>
                            </div>
                            <div class="form-group"><small class="form-text text-muted">Lietuvių kalbos nuotrauka (.jpg, .png, .svg, .gif)</small>
                                <input name="file" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.svg,.gif"/>
                            </div>

                            <h4 class="mt-5 mb-5">Pirmas blokas (Narystės privalumai)</h4>

                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="first_box_title"  value="{{$lithuanianLanguagePageContent->first_box_title}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas aprašymas</small>
                                <textarea class="form-control summernote" name="first_box_array[]">{{isset($lithuanianLanguagePageContent->first_box_array[0]) ? $lithuanianLanguagePageContent->first_box_array[0] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antras aprašymas</small>
                                <textarea class="form-control summernote" name="first_box_array[]">{{isset($lithuanianLanguagePageContent->first_box_array[1]) ? $lithuanianLanguagePageContent->first_box_array[1] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečias aprašymas</small>
                                <textarea class="form-control summernote" name="first_box_array[]">{{isset($lithuanianLanguagePageContent->first_box_array[2]) ? $lithuanianLanguagePageContent->first_box_array[2] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Ketvirtas aprašymas</small>
                                <textarea class="form-control summernote" name="first_box_array[]">{{isset($lithuanianLanguagePageContent->first_box_array[3]) ? $lithuanianLanguagePageContent->first_box_array[3] : ''}}</textarea>
                            </div>

                            <h4 class="mt-5 mb-5">Antras blokas (Kalbos mokėjimo lygiai)</h4>

                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="second_box_title"  value="{{$lithuanianLanguagePageContent->second_box_title}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Bendras tekstas</small>
                                <textarea class="form-control summernote" name="second_box_description">{{isset($lithuanianLanguagePageContent->second_box_description) ? $lithuanianLanguagePageContent->second_box_description : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas grupės pavadinimas</small>
                                <input class="form-control" type="text" name="second_box_name[]"  value="{{isset($lithuanianLanguagePageContent->second_box_name[0]) ? $lithuanianLanguagePageContent->second_box_name[0] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas aprašymas</small>
                                <textarea class="form-control summernote" name="second_box_content[]">{{isset($lithuanianLanguagePageContent->second_box_content[0]) ? $lithuanianLanguagePageContent->second_box_content[0] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antras grupės pavadinimas</small>
                                <input class="form-control" type="text" name="second_box_name[]"  value="{{isset($lithuanianLanguagePageContent->second_box_name[1]) ? $lithuanianLanguagePageContent->second_box_name[1] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antras aprašymas</small>
                                <textarea class="form-control summernote" name="second_box_content[]">{{isset($lithuanianLanguagePageContent->second_box_content[1]) ? $lithuanianLanguagePageContent->second_box_content[1] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečias grupės pavadinimas</small>
                                <input class="form-control" type="text" name="second_box_name[]"  value="{{isset($lithuanianLanguagePageContent->second_box_name[2]) ? $lithuanianLanguagePageContent->second_box_name[2] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečias aprašymas</small>
                                <textarea class="form-control summernote" name="second_box_content[]">{{isset($lithuanianLanguagePageContent->second_box_content[2]) ? $lithuanianLanguagePageContent->second_box_content[2] : ''}}</textarea>
                            </div>

                            <h4 class="mt-5 mb-5">Trečias blokas klausimai</h4>
                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_title"  value="{{$lithuanianLanguagePageContent->third_box_title}}">
                            </div>
                            <div class="form-group">
                                <legend>Klausimų forma</legend>
                                <select class="custom-select" name="main_component_questions">
                                    @foreach(\App\Http\Helpers\PageContentHelper::getComponentsNames() as $value  => $name)
                                        <option {{ $lithuanianLanguagePageContent->main_component_questions == $value ? 'selected' : ''}} value="{{$value}}" >{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($lithuanianLanguagePageContent->third_box_name[0]) ? $lithuanianLanguagePageContent->third_box_name[0] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($lithuanianLanguagePageContent->third_box_content[0]) ? $lithuanianLanguagePageContent->third_box_content[0] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antras pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($lithuanianLanguagePageContent->third_box_name[1]) ? $lithuanianLanguagePageContent->third_box_name[1] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antras aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($lithuanianLanguagePageContent->third_box_content[1]) ? $lithuanianLanguagePageContent->third_box_content[1] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečias pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($lithuanianLanguagePageContent->third_box_name[2]) ? $lithuanianLanguagePageContent->third_box_name[2] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečias aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($lithuanianLanguagePageContent->third_box_content[2]) ? $lithuanianLanguagePageContent->third_box_content[2] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Ketvirtas pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($lithuanianLanguagePageContent->third_box_name[3]) ? $lithuanianLanguagePageContent->third_box_name[3] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Ketvirtas aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($lithuanianLanguagePageContent->third_box_content[3]) ? $lithuanianLanguagePageContent->third_box_content[3] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Penktas pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($lithuanianLanguagePageContent->third_box_name[4]) ? $lithuanianLanguagePageContent->third_box_name[4] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Penktas aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($lithuanianLanguagePageContent->third_box_content[4]) ? $lithuanianLanguagePageContent->third_box_content[4] : ''}}</textarea>
                            </div>
                            <div class="form-group"><button class="btn btn-primary" type="submit">Pakeisti lietuvių kalbos puslapio duomenis</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/wp-includes/js/jquery/jquery.ui.touch-punch.js"></script>
</x-user>