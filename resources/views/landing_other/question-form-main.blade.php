
<div class="container m-3">
    <div class="" role="document">
        <div class=" row smart-wizard-box p-5">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span style="font-family: Playfair Display;font-style: normal;font-weight: bold;font-size: 29px;line-height: 30px;color: #F74395;">Kalbos mokėjimo lygio nustatymas</span>
                    </div>
                </div>
                <div class="row question-form-mobile-display-none">
                    <div class="col-lg-12">
                        <img class="img-fluid" width="380" height="380" style="height: 100%;-o-object-fit: cover;object-fit: cover;" src="{{asset('assets/img/other/castle 1.svg')}}">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @if(empty(Session::get('lithuania-language-form-results')))
                <form action="{{route('lithuanian-language-form-submit')}}" method="POST">
                    @csrf
                    @method("POST")
                <div id="smartwizard">
                    <ul>
                        <li><a href="#step-1">1</a></li>
                        <li><a href="#step-2">2</a></li>
                        <li><a href="#step-3">3</a></li>
                        <li><a href="#step-4">4</a></li>
                        <li><a href="#step-5">5</a></li>
                        @if(!Auth::check())
                            <li><a href="#step-6">6</a></li>
                        @endif
                    </ul>
                        <div class="mt-4 ml-4">
                            <div id="step-1">
                                <fieldset class="form-group row">
                                    <legend class="col-form-label col-sm-4 pt-0"><b>Vaiko amžius:</b></legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="age" id="gridRadios1" value="a" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                2-4 m.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="age" id="gridRadios2" value="b">
                                            <label class="form-check-label" for="gridRadios2">
                                                5-6 m.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="age" id="gridRadios3" value="c">
                                            <label class="form-check-label" for="gridRadios3">
                                                7-9 m.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="age" id="gridRadios4" value="d">
                                            <label class="form-check-label" for="gridRadios4">
                                                7-9 m.
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div id="step-2">
                                <fieldset class="form-group row">
                                    <legend class="col-form-label col-sm-12 pt-0"><b>Ar pažįsta lietuviškos abėcėlės raides, garsus?</b></legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="letters" id="gridRadios5" value="a" checked>
                                            <label class="form-check-label" for="gridRadios5">
                                                nepažįsta.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="letters" id="gridRadios6" value="b">
                                            <label class="form-check-label" for="gridRadios6">
                                                pažįsta kelias.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="letters" id="gridRadios8" value="c">
                                            <label class="form-check-label" for="gridRadios7">
                                                pažįsta visas.
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div id="step-3">
                                <fieldset class="form-group row">
                                    <legend class="col-form-label col-sm-12 pt-0"><b>Lietuvių kalbos supratimas</b></legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="language-level" id="gridRadios10" value="a" checked>
                                            <label class="form-check-label" for="gridRadios10">
                                                nesupranta arba supranta keletą bendriausių žodžių.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="language-level" id="gridRadios11" value="b">
                                            <label class="form-check-label" for="gridRadios11">
                                                pavienius, nesudėtingus žodžius.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="language-level" id="gridRadios12" value="c">
                                            <label class="form-check-label" for="gridRadios12">
                                                buitinius žodžius ir frazes.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="language-level" id="gridRadios13" value="d">
                                            <label class="form-check-label" for="gridRadios13">
                                                labai gerai supranta.
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div id="step-4">
                                <fieldset class="form-group row">
                                    <legend class="col-form-label col-sm-12 pt-0"><b>Kalbėjimas lietuviškai</b></legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="speaking-level" id="gridRadios14" value="a" checked>
                                            <label class="form-check-label" for="gridRadios14">
                                                nekalba arba žino keletą bendriausių žodžių.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="speaking-level" id="gridRadios15" value="b">
                                            <label class="form-check-label" for="gridRadios15">
                                                pavieniais, nesudėtingais žodžiais.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="speaking-level" id="gridRadios16" value="c">
                                            <label class="form-check-label" for="gridRadios16">
                                                buitinėmis frazėmis.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="speaking-level" id="gridRadios17" value="d">
                                            <label class="form-check-label" for="gridRadios17">
                                                rišliai kalba.
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div id="step-5">
                                <fieldset class="form-group row">
                                    <legend class="col-form-label col-sm-12 pt-0"><b>Skaitymas lietuviškai</b></legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="reading-level" id="gridRadios18" value="a" checked>
                                            <label class="form-check-label" for="gridRadios18">
                                                neskaito.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="reading-level" id="gridRadios19" value="b">
                                            <label class="form-check-label" for="gridRadios19">
                                                skiemenuodamas geba skaityti vienskiemenius ir dviskiemenius žodžius.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="reading-level" id="gridRadios20" value="c">
                                            <label class="form-check-label" for="gridRadios20">
                                                skiemenuodamas geba skaityti daugiaskiemenius žodžius.
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="reading-level" id="gridRadios21" value="d">
                                            <label class="form-check-label" for="gridRadios21">
                                                skaito sklandžiai.
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            @if(!Auth::check())
                                <div id="step-6">
                                    <fieldset class="form-group row">
                                        <div class="col-sm-10">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Elektroninis paštas</label>
                                                <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com" required>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            @else
                                <input type="hidden" class="form-control" name="email" value="{{Auth::user()->email}}">
                            @endif
                        </div>
                </div>
                </form>
                    @else
                        <form action="{{route('lithuanian-language-form-reset')}}" method="POST">
                            @csrf
                            @method("POST")
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="text-center">
                                        Jums rekomenduojama grupė: <b>{{Session::get('lithuania-language-form-results')}}</b>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="text-center btn-primary btn-sm">
                                        Bandyt iš naujo
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
            </div>
        </div>
    </div>
</div>