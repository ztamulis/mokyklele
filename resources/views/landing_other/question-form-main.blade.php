<style>
    .link-button {
        background: none;
        border: none;
        text-decoration: underline;
        cursor: pointer;
    }
</style>
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
                        <img class="img-fluid" width="380" height="380" style="height: 100%;-o-object-fit: cover;object-fit: cover;" src="{{asset('assets/img/other/274658017_689640008884995_751547573728791025_n.png')}}">
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
                        <li><a id="question-5" href="#step-5">5</a></li>
                        @if(!Auth::check())
                            <li><a href="#step-6">6</a></li>
                        @endif
                    </ul>
                        <div class="mt-4 ml-4">
                            <div id="step-1">
                                <fieldset class="form-group row">
                                    <legend class="col-form-label col-sm-4 pt-0"><b>Vaiko amžius:</b></legend>
                                    <div class="col-sm-10">
                                        <div class="form-check" id="answer-1">
                                            <input class="form-check-input" type="radio" name="age" id="gridRadios1" value="a" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                               2-4 m.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-2">
                                            <input class="form-check-input" type="radio" name="age" id="gridRadios2" value="b">
                                            <label class="form-check-label" for="gridRadios2">
                                               5-6 m.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-3">
                                            <input class="form-check-input" type="radio" name="age" id="gridRadios3" value="c">
                                            <label class="form-check-label" for="gridRadios3">
                                               7-9 m.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-4">
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
                                        <div class="form-check" id="answer-5">
                                            <input class="form-check-input" type="radio" name="letters" id="gridRadios5" value="a" checked>
                                            <label class="form-check-label" for="gridRadios5">
                                              nepažįsta.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-6">
                                            <input class="form-check-input" type="radio" name="letters" id="gridRadios6" value="b">
                                            <label class="form-check-label" for="gridRadios6">
                                              pažįsta kelias.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-7">
                                            <input class="form-check-input" type="radio" name="letters" id="gridRadios7" value="c">
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
                                        <div class="form-check" id="answer-8">
                                            <input class="form-check-input" type="radio" name="language-level" id="gridRadios8" value="a" checked>
                                            <label class="form-check-label" for="gridRadios8">
                                               nesupranta arba supranta keletą bendriausių žodžių.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-9">
                                            <input class="form-check-input" type="radio" name="language-level" id="gridRadios9" value="b">
                                            <label class="form-check-label" for="gridRadios9">
                                              pavienius, nesudėtingus žodžius.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-10">
                                            <input class="form-check-input" type="radio" name="language-level" id="gridRadios10" value="c">
                                            <label class="form-check-label" for="gridRadios10">
                                             buitinius žodžius ir frazes.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-11">
                                            <input class="form-check-input" type="radio" name="language-level" id="gridRadios11" value="d">
                                            <label class="form-check-label" for="gridRadios11">
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
                                        <div class="form-check" id="answer-12">
                                            <input class="form-check-input" type="radio" name="speaking-level" id="gridRadios12" value="a" checked>
                                            <label class="form-check-label" for="gridRadios12">
                                              nekalba arba žino keletą bendriausių žodžių.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-13">
                                            <input class="form-check-input" type="radio" name="speaking-level" id="gridRadios13" value="b">
                                            <label class="form-check-label" for="gridRadios13">
                                              pavieniais, nesudėtingais žodžiais.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-14">
                                            <input class="form-check-input" type="radio" name="speaking-level" id="gridRadios14" value="c">
                                            <label class="form-check-label" for="gridRadios14">
                                              buitinėmis frazėmis.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-15">
                                            <input class="form-check-input" type="radio" name="speaking-level" id="gridRadios15" value="d">
                                            <label class="form-check-label" for="gridRadios15">
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
                                        <div class="form-check" id="answer-16">
                                            <input class="form-check-input" type="radio" name="reading-level" id="gridRadios16" value="a" checked>
                                            <label class="form-check-label" for="gridRadios16">
                                             neskaito.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-17">
                                            <input class="form-check-input" type="radio" name="reading-level" id="gridRadios17" value="b">
                                            <label class="form-check-label" for="gridRadios17">
                                              skiemenuodamas geba skaityti vienskiemenius ir dviskiemenius žodžius.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-18">
                                            <input class="form-check-input" type="radio" name="reading-level" id="gridRadios18" value="c">
                                            <label class="form-check-label" for="gridRadios18">
                                              skiemenuodamas geba skaityti daugiaskiemenius žodžius.
                                            </label>
                                        </div>
                                        <div class="form-check" id="answer-19">
                                            <input class="form-check-input" type="radio" name="reading-level" id="gridRadios19" value="d">
                                            <label class="form-check-label" for="gridRadios19">
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
                            @csrf
                            @method("POST")
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="text-center">
                                        Jums rekomenduojama grupė: <b>{{Session::get('lithuania-language-form-results')}}</b>
                                    </span>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <a href="#courses-buy" style="color:#0f65ef!important;">Registracija į kursą</a>
                                </div>
                                <form action="{{route('lithuanian-language-form-reset')}}" method="POST">
                                    <div class="col-md-12 mt-2">
                                        <input type="submit" id="reset-button" style="display: none;" />
                                        <label class="link-button " for="reset-button"><b>Bandyt iš naujo</b></label>
                                    </div>
                                </form>

                            </div>
                    @endif
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var btnFinish = $('<button type="submit"></button>').text('Pateikti').attr('id', 'finish-button')
            .addClass('btn btn-primary btn-sm ml-sm-1 mt-xs-3 mt-1 d-none');
        var wizard = $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'dots',
            autoAdjustHeight: true,
            transitionEffect: 'fade',
            showStepURLhash: false,
            labelFinish: 'Finish',  // label for Finish button
            labelCancel: 'Cancel',
            toolbarSettings: {
                toolbarPosition: 'bottom', // none, top, bottom, both
                toolbarButtonPosition: 'center', // left, right, center
                toolbarExtraButtons: [btnFinish],
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                enableFinishButton: true,
            },
            lang: { // Language variables for button
                next: 'Pirmyn >',
                previous: '< Atgal',
                finish: 'Pateikti'
            }
        });
                // $('.btn.btn-primary.btn-sm.mt-1.sw-btn-next').hide();
        $( "#answer-13,#answer-14,#answer-15").unbind().click(function() {
            $('#smartwizard').smartWizard("stepState", [4], "enable");
            $('#smartwizard').smartWizard("stepState", [4], "show");
            if ($('.nav.nav-tabs.step-anchor.question-form-tablet-display-none').children().length === 5) {
                $('#finish-button').addClass('d-none');
            }

        });
        $( "#answer-12").unbind().click(function() {
            $('#smartwizard').smartWizard("stepState", [4], "disable");
            $('#smartwizard').smartWizard("stepState", [4], "hide");
            if ($('.nav.nav-tabs.step-anchor.question-form-tablet-display-none').children().length === 5) {
                $('#finish-button').removeClass('d-none');
            }

        });
        $(wizard).on("leaveStep", function (e, anchorObject, stepIndex, nextStepIndex, stepDirection) {
            if (nextStepIndex == 'forward') {
                setQuestions(stepIndex);
                if ($('#gridRadios12').is(':checked')) {
                    $('#smartwizard').smartWizard("stepState", [4], "disable");
                    $('#smartwizard').smartWizard("stepState", [4], "hide");
                }
            }
            var minuStep = 2;
            if ($('.nav-item.done.disabled.hidden').length === 1 || $('.nav-item.disabled.hidden').length === 1) {
                minuStep = 3;
            }

            if (nextStepIndex == 'forward' && (anchorObject.prevObject.length - minuStep) === stepIndex) {
                $('#finish-button').removeClass('d-none');
            } else {
                $('#finish-button').addClass('d-none');
            }
        });
    });

    function setQuestions(stepIndex) {
        stepIndex = stepIndex + 1;
        if (stepIndex === 5) {
            return;
        }
        var i = 1;
        var stepTo = getStepTo(stepIndex);
        var selectedAnswers = [];
        while (i <= stepTo) {
            // console.log(i);
            if($('#gridRadios'+i).is(':checked')) {
                if (i >= 1 && i<=4) {
                    selectedAnswers[1] = $('#gridRadios'+i).val();
                }
                if (i >= 5 && i<=7) {
                    selectedAnswers[2] = $('#gridRadios'+i).val();
                }
                if (i >= 8 && i<=11) {
                    selectedAnswers[3] = $('#gridRadios'+i).val();
                }
                if (i >= 12 && i<=15) {
                    selectedAnswers[4] = $('#gridRadios'+i).val();
                }
            }
            i++;
        }
        var availableAnswers = getAvailableAnswers(selectedAnswers);
        setNewAnswers(availableAnswers, stepIndex);
        setFourthAnswer(stepIndex);
    }
    function setFourthAnswer(stepIndex) {
        var i = 12;
        var rangeTo = 15;
        if (stepIndex !== 3) {
            return;
        }
        while (i <= rangeTo) {
            if ($('#answer-'+i).css('display') !== 'none') {
                $('#gridRadios'+i).prop('checked', true);
                if ($('#answer-12').css('display') === 'none') {
                    $('#smartwizard').smartWizard("stepState", [4], "enable");
                    $('#smartwizard').smartWizard("stepState", [4], "show");
                    $('#finish-button').addClass('d-none');
                }
                break;
            }
            i++;
        }
        // if (availableAnswers[30] !== undefined) {
        //     $('#step-5').hide();
        //     $('#question-5').hide();
        // }
    }

    function getAvailableAnswers(selectedAnswers) {
        var availableAnswers = [];

        if (selectedAnswers.length === 2 || $('#gridRadios1').is(':checked') === true) {
            availableAnswers[32] = '';
            return availableAnswers;
        }
        if (selectedAnswers.length === 3) {
            if (selectedAnswers[1] === 'b') {
                if (selectedAnswers[2] === 'a' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                } else {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                    availableAnswers[11] = '';
                }
            }

            if (selectedAnswers[1] === 'c' || selectedAnswers[1] === 'd') {
                if (selectedAnswers[2] === 'a' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                }

                if (selectedAnswers[2] === 'b' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                }
                if (selectedAnswers[2] === 'c' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                    availableAnswers[11] = '';
                }
            }
        }

        if (selectedAnswers.length === 4) {
            if (selectedAnswers[1] === 'b') {
                //second question
                if (selectedAnswers[2] === 'a' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                } else {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                    availableAnswers[11] = '';
                }

                // third question
                // third question
                if (selectedAnswers[3] === 'a' ) {
                    availableAnswers[13] = '';
                    availableAnswers[30] = '';
                }

                if (selectedAnswers[3] === 'b' ) {
                    availableAnswers[12] = '';
                    availableAnswers[13] = '';
                    availableAnswers[30] = '';
                }


                if (selectedAnswers[3] === 'c' ) {
                    availableAnswers[14] = '';
                }

                if (selectedAnswers[3] === 'd' ) {
                    availableAnswers[15] = '';
                }
            }

            if (selectedAnswers[1] === 'c' || selectedAnswers[1] === 'd') {
                //second question
                if (selectedAnswers[2] === 'a' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                }

                if (selectedAnswers[2] === 'b' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                }
                if (selectedAnswers[2] === 'c' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                    availableAnswers[11] = '';
                }

                // third question
                if (selectedAnswers[3] === 'a' ) {
                    availableAnswers[13] = '';
                    availableAnswers[30] = '';
                }

                if (selectedAnswers[3] === 'b' ) {
                    availableAnswers[12] = '';
                    availableAnswers[13] = '';
                    availableAnswers[30] = '';
                }


                if (selectedAnswers[3] === 'c' ) {
                    availableAnswers[14] = '';
                }

                if (selectedAnswers[3] === 'd' ) {
                    availableAnswers[15] = '';
                }
            }
        }
        // if (selectedAnswers.length === 5) {
            if (selectedAnswers[1] === 'b') {
                //second question
                if (selectedAnswers[2] === 'a' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                } else {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                    availableAnswers[11] = '';
                }

                // third question
                if (selectedAnswers[3] === 'a') {
                    availableAnswers[13] = '';
                    availableAnswers[30] = '';
                }

                if (selectedAnswers[3] === 'b') {
                    availableAnswers[12] = '';
                    availableAnswers[13] = '';
                    availableAnswers[30] = '';
                }


                if (selectedAnswers[3] === 'c') {
                    availableAnswers[14] = '';
                }

                if (selectedAnswers[3] === 'd') {
                    availableAnswers[15] = '';
                }
            }

            if (selectedAnswers[1] === 'c' || selectedAnswers[1] === 'd') {
                //second question
                if (selectedAnswers[2] === 'a' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                }

                if (selectedAnswers[2] === 'b' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                }
                if (selectedAnswers[2] === 'c' ) {
                    availableAnswers[8] = '';
                    availableAnswers[9] = '';
                    availableAnswers[10] = '';
                    availableAnswers[11] = '';
                }

                // third question
                if (selectedAnswers[3] === 'a' ) {
                    availableAnswers[13] = '';
                    availableAnswers[30] = '';
                }

                if (selectedAnswers[3] === 'b' ) {
                    availableAnswers[12] = '';
                    availableAnswers[13] = '';
                    availableAnswers[30] = '';
                }


                if (selectedAnswers[3] === 'c' ) {
                    availableAnswers[14] = '';
                }

                if (selectedAnswers[3] === 'd' ) {
                    availableAnswers[15] = '';
                }
            }

            if (selectedAnswers[1] === 'b') {
                if (selectedAnswers[4] === 'b') {
                    availableAnswers[16] = '';
                    availableAnswers[17] = '';
                }

                if (selectedAnswers[4] === 'c' || selectedAnswers[4] === 'd') {
                    availableAnswers[17] = '';
                    availableAnswers[18] = '';
                    availableAnswers[19] = '';

                }
            }

            if (selectedAnswers[1] === 'c' || selectedAnswers[1] === 'd') {
                if (selectedAnswers[4] === 'b') {

                    availableAnswers[16] = '';
                    availableAnswers[17] = '';
                }
                if (selectedAnswers[4] === 'c') {
                    availableAnswers[17] = '';
                    availableAnswers[18] = '';
                }
                if (selectedAnswers[4] === 'd') {

                    availableAnswers[18] = '';
                    availableAnswers[19] = '';
                }
            }
        // }
        return availableAnswers;

    }

    function setNewAnswers(availableAnswers, stepIndex) {
        var i = 8;
        var rangeTo = getRangeTo(stepIndex);
        while (i <= rangeTo) {
            var answer = $('#answer-'+i);
            answer.hide();
            if (availableAnswers[i] !== undefined || availableAnswers[32] !== undefined) {
                answer.show();
            }
            i++;
        }
        // if (availableAnswers[30] !== undefined) {
        //     $('#step-5').hide();
        //     $('#question-5').hide();
        // }
    }
    function getRangeTo(stepIndex) {
        if (stepIndex === 1) {
            return 7;
        } else if (stepIndex === 2) {
            return 11;
        }else if (stepIndex === 3) {
            return 15;
        }else if (stepIndex === 4) {
            return 19;
        }
    }

    function getStepTo(stepIndex) {
        if (stepIndex === 1) {
            return 4;
        } else if (stepIndex === 2) {
            return 7;
        }else if (stepIndex === 3) {
            return 11;
        }else if (stepIndex === 4) {
            return 15;
        }
    }
</script>