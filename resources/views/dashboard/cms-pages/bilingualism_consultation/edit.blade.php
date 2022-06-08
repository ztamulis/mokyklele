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
        <h3 class="text-dark mb-4">Redaguoti Lietuvių kalbos puslapį</h3>
        <div class="card"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8">
                        <form action="{{route('pages.bilingualism-consultation.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="site_name"  value="{{$bilingualismConsultationPageContent->site_name}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Aprašymas</small>
                                <textarea class="form-control summernote" name="description">{{$bilingualismConsultationPageContent->description}}</textarea>
                            </div>
                            <div class="form-group"><small class="form-text text-muted">Lietuvių kalbos nuotrauka (.jpg, .png, .svg, .gif)</small>
                                <input name="file" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.svg,.gif"/>
                            </div>

                            <h4 class="mt-5 mb-5">Pirmas blokas (Narystės privalumai)</h4>

                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="first_box_title"  value="{{$bilingualismConsultationPageContent->first_box_title}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas aprašymas</small>
                                <textarea class="form-control summernote" name="first_box_array[]">{{isset($bilingualismConsultationPageContent->first_box_array[0]) ? $bilingualismConsultationPageContent->first_box_array[0] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antras aprašymas</small>
                                <textarea class="form-control summernote" name="first_box_array[]">{{isset($bilingualismConsultationPageContent->first_box_array[1]) ? $bilingualismConsultationPageContent->first_box_array[1] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečias aprašymas</small>
                                <textarea class="form-control summernote" name="first_box_array[]">{{isset($bilingualismConsultationPageContent->first_box_array[2]) ? $bilingualismConsultationPageContent->first_box_array[2] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Ketvirtas aprašymas</small>
                                <textarea class="form-control summernote" name="first_box_array[]">{{isset($bilingualismConsultationPageContent->first_box_array[3]) ? $bilingualismConsultationPageContent->first_box_array[3] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <legend><b>Kursų blokas</b></legend>
                                <select class="custom-select" name="main_component_courses">
                                    @foreach(\App\Http\Helpers\PageContentHelper::getComponentsNames() as $value  => $name)
                                        <option {{ $bilingualismConsultationPageContent->main_component_courses == $value ? 'selected' : ''}} value="{{$value}}" >{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <h4 class="mt-5 mb-5">Trečias blokas klausimai</h4>
                            <div class="form-group">
                                <small class="form-text text-muted">Pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_title"  value="{{$bilingualismConsultationPageContent->third_box_title}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($bilingualismConsultationPageContent->third_box_name[0]) ? $bilingualismConsultationPageContent->third_box_name[0] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Pirmas aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($bilingualismConsultationPageContent->third_box_content[0]) ? $bilingualismConsultationPageContent->third_box_content[0] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antras pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($bilingualismConsultationPageContent->third_box_name[1]) ? $bilingualismConsultationPageContent->third_box_name[1] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Antras aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($bilingualismConsultationPageContent->third_box_content[1]) ? $bilingualismConsultationPageContent->third_box_content[1] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečias pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($bilingualismConsultationPageContent->third_box_name[2]) ? $bilingualismConsultationPageContent->third_box_name[2] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Trečias aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($bilingualismConsultationPageContent->third_box_content[2]) ? $bilingualismConsultationPageContent->third_box_content[2] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Ketvirtas pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($bilingualismConsultationPageContent->third_box_name[3]) ? $bilingualismConsultationPageContent->third_box_name[3] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Ketvirtas aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($bilingualismConsultationPageContent->third_box_content[3]) ? $bilingualismConsultationPageContent->third_box_content[3] : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Penktas pavadinimas</small>
                                <input class="form-control" type="text" name="third_box_name[]"  value="{{isset($bilingualismConsultationPageContent->third_box_name[4]) ? $bilingualismConsultationPageContent->third_box_name[4] : ''}}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Penktas aprašymas</small>
                                <textarea class="form-control summernote" name="third_box_content[]">{{isset($bilingualismConsultationPageContent->third_box_content[4]) ? $bilingualismConsultationPageContent->third_box_content[4] : ''}}</textarea>
                            </div>
                            <div class="form-group"><button class="btn btn-primary" type="submit">Pakeisti dvikalbystės konsultacijų puslapio duomenis</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/wp-includes/js/jquery/jquery.ui.touch-punch.js"></script>
</x-user>