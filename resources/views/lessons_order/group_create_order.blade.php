@extends("layouts.landing")

@section("title", "Komanda")

@section("content")
    <h1 class="content--title">Užsakymas</h1>
    <div class="text--center">
        <b>{{ $group->name }}
            {{ App\TimeZoneUtils::updateTime($group->time->timezone(Cookie::get("user_timezone", "Europe/London")), $group->updated_at)->format('H:i') }}
            ({{Auth::user()->time_zone ? Auth::user()->time_zone : 'Europe/London'}})</b>
        <br>
        {{ $group->display_name }}
        <br>
        @php $descriptionData = $group->getGroupStartDateAndCount() @endphp
        @if (!empty($descriptionData) && isset($descriptionData['eventsCount']))

            <span>Kursas vyks: {{\Carbon\Carbon::parse($descriptionData['startDate'])->format("m.d")}} - {{\Carbon\Carbon::parse($group->end_date)->format("m.d")}} ({{$descriptionData['eventsCount']}}
                @if($descriptionData['eventsCount'] == 1)
                    pamoka)
                @elseif($descriptionData['eventsCount'] > 1 && $descriptionData['eventsCount'] < 10)
                    pamokos)
                @elseif($descriptionData['eventsCount'] > 9 && $descriptionData['eventsCount'] < 21)
                    pamokų)
                @elseif($descriptionData['eventsCount'] > 21)
                    pamokos)
                @elseif($descriptionData['eventsCount'])
                    pamoka)
                @endif
                </span>
        @endif
        <br>
    </div>

    @if ($errors->any())
        <div class="text--center">
            <h3 style="color: red;">Klaida! @foreach ($errors->all() as $error) {{ $error }} @endforeach</h3>
        </div>
    @endif

    @if (isset($error))
        <div class="text--center">
            <h3 style="color: red;">{{$error}}</h3>
        </div>
    @endif



        @if(Auth::check())

        <div class="order--dialog">
            <form method="POST" action="/select-group/create-order/{{$group->slug}}" novalidate payment-form>
                @csrf
                @if(!empty($coupon))
                    <input type="hidden" name="coupon-code" value="{{$coupon->code}}">
                    <input type="hidden" id="coupon-type" name="coupon_type" value="{{$coupon->type}}">
                    <input type="hidden" id="coupon-discount" name="coupon_discount" value="{{$coupon->discount}}">
                @endif
                <input type="hidden" name="action" value="order">
                @if ($group->age_category === 'adults')
                    Jūsų vardas
                @else
                    Vaikas:
                @endif
                <input type="hidden" name="students" value="">
                <div class="student--select"></div>
                @if($group->type !== 'individual' && $group->age_category != 'adults')
                    <div class="" data-add-student>
                        <span class="button" style="cursor: pointer;">Pridėti dar vieną vaiką </span><span> Broliui ar sesei toje pačioje grupėje taikome 50 % nuolaidą. </span>
                    </div>
                @endif
                <br><br>

                @if($group->type !=='free' && empty($coupon))
                        <div class="row" style="margin-bottom: 20px;">
                            Nuolaidos kodas:
                            <div class="col-md-12">
                                <input id="coupon" type="text" name="coupon" value="">
                            </div>
                            <div class="col-md-6">
                                <span id="coupon-btn" class="button" style="width: 220px!important; cursor: pointer;">Naudoti kodą</span>
                            </div>
                        </div>
                @endif
                <input type="hidden" name="payment_type" value="single">
                <input type="hidden" id="single-student-price" name="price" value="{{ $group->adjustedPrice($coupon) }}">
                <input type="hidden" name="payment_method" value="default">
                <div class="payment--loading-buy-notification" style="display: none; color: red">
                    <h4>Ačiū, kad patvirtinote mokėjimą. Norėdami pabaigti užsakymą, spauskite "Pirkti"</h4>
                </div>
                <button id="price-button" type="submit">Pirkti (£{{ !empty($coupon) && $coupon->type === 'fixed'
                ?  $group->adjustedPrice($coupon) - $coupon->discount : $group->adjustedPrice($coupon) }})</button>
            </form>
        </div>
        <script>
            $( document ).ready(function() {
                $('#coupon-btn').click(function() {
                    window.location.href="/select-group/order/{{$group->slug}}?coupon="+$('#coupon').val()
                });
            });




            // $("[name=student_id]").change(function () {
            //     if($(this).val() == "new"){
            //         $(".new_student").show();
            //     }else {
            //         $(".new_student").hide();
            //     }
            // });
            $("[name=payment_method]").change(function () {
                if($(this).val() == "new"){
                    $(".add_payment_method").show();
                }else {
                    $(".add_payment_method").hide();
                }
            });

            var available_students = [
                    @foreach(Auth()->user()->students()->where('birthday', '!=', '')->whereNotNull('birthday')->get() as $student)
                {
                    id: {{ $student->id }},
                    name: "{{ $student->name }}",
                    birthday: "{{$student->birthday}}",
                },
                @endforeach
            ];

            var studentsHtml = '<select data-select-student="0">';

            for(var i = 0; i < available_students.length; i++){
                var student = available_students[i];
                studentsHtml += '<option value="'+student.id+'">'+student.name+'</option>';
            }
            if ('{{$group->age_category}}' === 'children') {
                studentsHtml += '<option value="new">Pridėti vaiką</option></select>';
                studentsHtml += '<input type="text" name="new_student_name" data-new-student-input="0" placeholder="Vaiko vardas, pavardė">';
                studentsHtml += '<small data-birthday-label=0 style="display: none;">Vaiko gimtadienis:</small><input required type="date" name="new_student_birthday" data-new-student-input-age="0" placeholder="{{ date("Y-m-d") }}"></div>';

            } else {
                studentsHtml += '<option value="new">Pridėti vartotoja</option></select>';
                studentsHtml += '<input type="text" name="new_student_name" data-new-student-input="0" placeholder="Vartotojo(-os) vardas, pavardė">';
                studentsHtml += '<small data-birthday-label=0 style="display: none;">Vartotojo(-os) gimtadienis:</small><input required type="date" name="new_student_birthday" data-new-student-input-age="0" placeholder="{{ date("Y-m-d") }}"></div>';
            }


            $(".student--select").html(studentsHtml);
            if(available_students.length == 0){
                $(".student--select select").hide();
            }

            rebindSelect();

            function deleteStudent(id) {
                $('#children-'+id).remove();


                newPrice = recalculatePrice();
                var buttonText = 'Užsakyti (£ '+newPrice+')' ;
                $("#price-button").html(buttonText);
            }

            $("[data-add-student]").click(function() {
                var studentsCount = parseInt($(".student--select select").length);
                var availableSlots = {{$group->slots - $group->students()->count() }} ;
                if ((availableSlots - studentsCount) <=  0) {
                    alert('Grupė pilna!');
                    return;
                }
                var selectIndex = parseInt($("[data-select-student]").last().attr("data-select-student")) + 1;
                var studentsHtml = '<div id="children-'+selectIndex+'"><hr><span id="selectIndex" onclick="deleteStudent('+selectIndex+')" class="close-student-btn">x</span><select data-select-student="'+selectIndex+'">';
                for(var i = 0; i < available_students.length; i++){
                    var student = available_students[i];
                    studentsHtml += '<option value="'+student.id+'">'+student.name+'</option>';
                }

                studentsHtml += '<option value="new">Pridėti vaiką</option></select>';
                studentsHtml += '<input type="text" name="new_student_name" data-new-student-input="'+selectIndex+'" placeholder="Vaiko vardas, pavardė">';
                studentsHtml += '<small data-birthday-label='+selectIndex+' style="display: none;">Vaiko gimtadienis:</small><input required type="date" name="new_student_birthday" data-new-student-input-age="'+selectIndex+'" placeholder="{{ date("Y-m-d") }}"></div>';
                $(".student--select").append(studentsHtml);
                var newPrice = recalculatePrice();
                var buttonText = 'Užsakyti (£ '+newPrice+')' ;
                $("#price-button").html(buttonText);


                if(available_students.length == 0){
                    $(".student--select select").hide();
                }
                rebindSelect();
            });
            $("[name=payment_type]").change(function () {
                if($(this).val() == "subscription") {
                    $(".subscription--info").show();
                }else{
                    $(".subscription--info").hide();
                }
            });

            function recalculatePrice() {
                var studentsCount = $(".student--select select").length;
                var price = $('#single-student-price').val();
                var discountedPrice = parseInt(price) / 2;
                var newPrice = parseInt(price) + ((parseInt(studentsCount) - 1) * discountedPrice);
                if ($("#coupon-type").val() === 'fixed') {
                    newPrice = newPrice - parseInt(($("#coupon-discount").val()));
                }

                return newPrice
            }

            function rebindSelect() {
                $("[data-select-student]").unbind().change(function() {
                    if($(this).val() == "new") {
                        $("[data-new-student-input="+$(this).attr("data-select-student")+"],[data-birthday-label="+$(this).attr("data-select-student")+"],[data-new-student-input-age="+$(this).attr("data-select-student")+"]").show();
                    }else{
                        $("[data-new-student-input="+$(this).attr("data-select-student")+"],[data-birthday-label="+$(this).attr("data-select-student")+"],[data-new-student-input-age="+$(this).attr("data-select-student")+"]").hide();
                    }
                });
                $("[data-select-student]").change();
            }

            var pushingCardInformation = false;

            $("[payment-form]").submit(function(event) {
                var students = [];
                var dublicates = false;
                var form = $(this);

                $("[data-select-student]").each(function() {
                    var id = $(this).val();
                    if(students.indexOf(id) >= 0){
                        dublicates = true;
                        return;
                    }
                    if(id == "new"){
                        var name = $("[data-new-student-input="+$(this).attr("data-select-student")+"]").val();
                        var birthday = $("[data-new-student-input-age="+$(this).attr("data-select-student")+"]").val();
                        if(name == ""){
                            alert("Palikti tušti langeliai! Trūksta vardo!");
                            event.preventDefault();
                            return;
                        }
                        if(birthday == ""){
                            alert("Palikti tušti langeliai! Trūksta gimtadienio!");
                            event.preventDefault();
                            return;
                        }


                        if(/[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(name) || !isValidDate(birthday)){
                            alert("Rasta neleistinų simbolių! Vardai gali būti sudaryti tik iš raidžių, datos turi būti rašomos Y-m-d formatu!");
                            event.preventDefault();
                        }
                        if(name.length > 64) {
                            alert("Įrašytas vaiko vardas per ilgas, prašome patikrinti. (maks. 64 simboliai)");
                            event.preventDefault();
                        }
                        students.push("new_" + name + "_" + birthday);
                    } else {
                        students.push(id);
                    }
                });

                if(dublicates){
                    event.preventDefault();
                    alert("Mokiniai kartojasi! Prašome patikrinkti.");
                }

                // if($(".add_payment_method").css("opacity") != 0){
                //     event.preventDefault();
                //
                //     console.log("Card not found");
                //     if(pushingCardInformation){
                //         pushingCardInformation = false;
                //         console.log("Canceling due card not found");
                //
                //         $(".please--wait").remove();
                //         $("[type=submit]").show();
                //     } else {
                //         $("#card-button").click();
                //         pushingCardInformation = true;
                //         console.log("Adding card");
                //
                //         $("[type=submit]").parent().append("<div class='please--wait'>Prašome palaukti...</div>");
                //         $("[type=submit]").hide();
                //
                //         setTimeout(function() {
                //             form.submit();
                //         },6000);
                //     }
                //
                //     // alert("Prašome išsaugoti kortelės duomenis prieš tęsiant.");
                // }

                $("[name='students']").val(JSON.stringify(students));
            });

            function isValidDate(dateString)
            {
                // First check for the pattern
                var regex_date = /^\d{4}\-\d{1,2}\-\d{1,2}$/;

                if(!regex_date.test(dateString))
                {
                    return false;
                }

                // Parse the date parts to integers
                var parts   = dateString.split("-");
                var day     = parseInt(parts[2], 10);
                var month   = parseInt(parts[1], 10);
                var year    = parseInt(parts[0], 10);

                // Check the ranges of month and year
                if(year < 1970 || year > {{ date("Y") }} || month == 0 || month > 12)
                {
                    return false;
                }

                var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

                // Adjust for leap years
                if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
                {
                    monthLength[1] = 29;
                }

                // Check the range of the day
                return day > 0 && day <= monthLength[month - 1];
            }
        </script>
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe("{{ env("STRIPE_KEY") }}");

            const elements = stripe.elements();

            var elementStyles = {
                base: {
                    color: '#fff',
                    fontFamily: 'Arial, sans-serif',
                    fontSize: '16px',
                    fontSmoothing: 'antialiased',
                    padding: '10px',
                    color: "#000",

                    ':focus': {
                        color: '#000',
                    },

                    '::placeholder': {
                        color: '#aaaaaa',
                    },

                    ':focus::placeholder': {
                        color: '#aaaaaa',
                    },
                },
                invalid: {
                    color: '#ccc',
                    ':focus': {
                        color: '#FA755A',
                    },
                    '::placeholder': {
                        color: '#FFCCA5',
                    },
                },
            };

            var elementClasses = {
                focus: 'focus',
                empty: 'empty',
                invalid: 'invalid',
            };

            var cardNumber = elements.create('cardNumber', {
                style: elementStyles,
                classes: elementClasses,
            });
            cardNumber.mount('#card-number');

            var cardExpiry = elements.create('cardExpiry', {
                style: elementStyles,
                classes: elementClasses,
            });
            cardExpiry.mount('#card-expiry');

            var cardCvc = elements.create('cardCvc', {
                style: elementStyles,
                classes: elementClasses,
            });
            cardCvc.mount('#card-cvc');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardNumber,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );

                if (error) {
                    alert(error.message);
                } else {
                    $(".payment--loading").show();

                    $("[name=payment_method], .add_payment_method").css({
                        "opacity": "0",
                        "pointer-events": "none",
                        "height": 0,
                        "overflow": "hidden",
                    })
                    $.post("/dashboard/profile/update-card", {_token: "{{ csrf_token() }}", payment_method: setupIntent.payment_method}, function (data){
                        data = JSON.parse(data);
                        $(".payment--loading").html("Kortelė: <b>**** **** **** " + data.card_last + "</b>");
                        $(".payment--loading-buy-notification").show();

                    });
                }
            });
        </script>
    @else
        <div class="landing--col--even-1">
            <h2>Jau užsiregistravęs narys</h2>
            <form method="POST">
                @csrf
                <input type="hidden" name="action" value="login">
                <input type="email" name="email" placeholder="Jūsų el. pašto adresas">
                <input type="password" name="password" placeholder="Jūsų slaptažodis">
                <button type="submit">Prisijungti</button>
            </form>
        </div>
        <div class="landing--col--even-2">
            <h2>Naujas narys</h2>
            <form method="POST">
                @csrf
                <input type="hidden" name="action" value="register">
                <input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Jūsų vardas" name="name" value="{{ old('name') }}" required>
                <input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Jūsų pavardė" name="surname" value="{{ old('surname') }}" required>
                <input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Jūsų el. paštas" name="email" value="{{ old('email') }}" required>
                <input class="form-control form-control-user" type="password" id="examplePasswordInput" placeholder="Jūsų slaptažodis" name="password" required>
                <input class="form-control form-control-user" type="password" id="exampleRepeatPasswordInput" placeholder="Pakartokite slaptažodį" name="password_confirmation" required>
                <small class="form-text text-muted">Gyvenamoji šalis</small>
                <?php
                $ipinfo = json_decode(file_get_contents("http://ip-api.com/json/".Request::ip()));
//                $country = $ipinfo->country;
                $country = 'Lietuva';
                ?>
                <select class="form-control" name="country" required>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Afganistan")) selected @endif value="Afganistan">Afghanistan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Albania")) selected @endif value="Albania">Albania</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Algeria")) selected @endif value="Algeria">Algeria</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "American")) selected @endif value="American Samoa">American Samoa</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Andorra")) selected @endif value="Andorra">Andorra</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Angola")) selected @endif value="Angola">Angola</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Anguilla")) selected @endif value="Anguilla">Anguilla</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Antigua")) selected @endif value="Antigua & Barbuda">Antigua & Barbuda</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Argentina")) selected @endif value="Argentina">Argentina</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Armenia")) selected @endif value="Armenia">Armenia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Aruba")) selected @endif value="Aruba">Aruba</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Australia")) selected @endif value="Australia">Australia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Austria")) selected @endif value="Austria">Austria</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Azerbaijan")) selected @endif value="Azerbaijan">Azerbaijan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Bahamas")) selected @endif value="Bahamas">Bahamas</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Bahrain")) selected @endif value="Bahrain">Bahrain</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Bangladesh")) selected @endif value="Bangladesh">Bangladesh</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Barbados")) selected @endif value="Barbados">Barbados</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Belarus")) selected @endif value="Belarus">Belarus</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Belgium")) selected @endif value="Belgium">Belgium</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Belize")) selected @endif value="Belize">Belize</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Benin")) selected @endif value="Benin">Benin</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Bermuda")) selected @endif value="Bermuda">Bermuda</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Bhutan")) selected @endif value="Bhutan">Bhutan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Bolivia")) selected @endif value="Bolivia">Bolivia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Bonaire")) selected @endif value="Bonaire">Bonaire</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Bosnia")) selected @endif value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Botswana")) selected @endif value="Botswana">Botswana</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Brazil")) selected @endif value="Brazil">Brazil</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "British")) selected @endif value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Brunei")) selected @endif value="Brunei">Brunei</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Bulgaria")) selected @endif value="Bulgaria">Bulgaria</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Burkina")) selected @endif value="Burkina Faso">Burkina Faso</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Burundi")) selected @endif value="Burundi">Burundi</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Cambodia")) selected @endif value="Cambodia">Cambodia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Cameroon")) selected @endif value="Cameroon">Cameroon</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Canada")) selected @endif value="Canada">Canada</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Canary")) selected @endif value="Canary Islands">Canary Islands</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Cape")) selected @endif value="Cape Verde">Cape Verde</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Cayman")) selected @endif value="Cayman Islands">Cayman Islands</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Central")) selected @endif value="Central African Republic">Central African Republic</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Chad")) selected @endif value="Chad">Chad</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Channel")) selected @endif value="Channel Islands">Channel Islands</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Chile")) selected @endif value="Chile">Chile</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "China")) selected @endif value="China">China</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Christmas")) selected @endif value="Christmas Island">Christmas Island</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Cocos")) selected @endif value="Cocos Island">Cocos Island</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Colombia")) selected @endif value="Colombia">Colombia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Comoros")) selected @endif value="Comoros">Comoros</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Congo")) selected @endif value="Congo">Congo</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Cook")) selected @endif value="Cook Islands">Cook Islands</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Costa")) selected @endif value="Costa Rica">Costa Rica</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Cote")) selected @endif value="Cote DIvoire">Cote DIvoire</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Croatia")) selected @endif value="Croatia">Croatia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Cuba")) selected @endif value="Cuba">Cuba</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Curaco")) selected @endif value="Curaco">Curacao</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Cyprus")) selected @endif value="Cyprus">Cyprus</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Czech")) selected @endif value="Czech Republic">Czech Republic</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Denmark")) selected @endif value="Denmark">Denmark</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Djibouti")) selected @endif value="Djibouti">Djibouti</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Dominica")) selected @endif value="Dominica">Dominica</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Dominican")) selected @endif value="Dominican Republic">Dominican Republic</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "East")) selected @endif value="East Timor">East Timor</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Ecuador")) selected @endif value="Ecuador">Ecuador</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Egypt")) selected @endif value="Egypt">Egypt</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "El")) selected @endif value="El Salvador">El Salvador</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Equatorial")) selected @endif value="Equatorial Guinea">Equatorial Guinea</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Eritrea")) selected @endif value="Eritrea">Eritrea</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Estonia")) selected @endif value="Estonia">Estonia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Ethiopia")) selected @endif value="Ethiopia">Ethiopia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Falkland")) selected @endif value="Falkland Islands">Falkland Islands</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Faroe")) selected @endif value="Faroe Islands">Faroe Islands</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Fiji")) selected @endif value="Fiji">Fiji</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Finland")) selected @endif value="Finland">Finland</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "France")) selected @endif value="France">France</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "French")) selected @endif value="French Guiana">French Guiana</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "French")) selected @endif value="French Polynesia">French Polynesia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "French")) selected @endif value="French Southern Ter">French Southern Ter</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Gabon")) selected @endif value="Gabon">Gabon</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Gambia")) selected @endif value="Gambia">Gambia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Georgia")) selected @endif value="Georgia">Georgia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Germany")) selected @endif value="Germany">Germany</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Ghana")) selected @endif value="Ghana">Ghana</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Gibraltar")) selected @endif value="Gibraltar">Gibraltar</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Great")) selected @endif value="Great Britain">Great Britain</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Greece")) selected @endif value="Greece">Greece</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Greenland")) selected @endif value="Greenland">Greenland</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Grenada")) selected @endif value="Grenada">Grenada</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Guadeloupe")) selected @endif value="Guadeloupe">Guadeloupe</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Guam")) selected @endif value="Guam">Guam</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Guatemala")) selected @endif value="Guatemala">Guatemala</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Guinea")) selected @endif value="Guinea">Guinea</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Guyana")) selected @endif value="Guyana">Guyana</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Haiti")) selected @endif value="Haiti">Haiti</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Hawaii")) selected @endif value="Hawaii">Hawaii</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Honduras")) selected @endif value="Honduras">Honduras</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Hong")) selected @endif value="Hong Kong">Hong Kong</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Hungary")) selected @endif value="Hungary">Hungary</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Iceland")) selected @endif value="Iceland">Iceland</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Indonesia")) selected @endif value="Indonesia">Indonesia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "India")) selected @endif value="India">India</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Iran")) selected @endif value="Iran">Iran</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Iraq")) selected @endif value="Iraq">Iraq</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Ireland")) selected @endif value="Ireland">Ireland</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Isle")) selected @endif value="Isle of Man">Isle of Man</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Israel")) selected @endif value="Israel">Israel</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Italy")) selected @endif value="Italy">Italy</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Jamaica")) selected @endif value="Jamaica">Jamaica</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Japan")) selected @endif value="Japan">Japan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Jordan")) selected @endif value="Jordan">Jordan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Kazakhstan")) selected @endif value="Kazakhstan">Kazakhstan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Kenya")) selected @endif value="Kenya">Kenya</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Kiribati")) selected @endif value="Kiribati">Kiribati</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Korea")) selected @endif value="Korea North">Korea North</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Korea")) selected @endif value="Korea Sout">Korea South</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Kuwait")) selected @endif value="Kuwait">Kuwait</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Kyrgyzstan")) selected @endif value="Kyrgyzstan">Kyrgyzstan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Laos")) selected @endif value="Laos">Laos</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Latvia")) selected @endif value="Latvia">Latvia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Lebanon")) selected @endif value="Lebanon">Lebanon</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Lesotho")) selected @endif value="Lesotho">Lesotho</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Liberia")) selected @endif value="Liberia">Liberia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Libya")) selected @endif value="Libya">Libya</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Liechtenstein")) selected @endif value="Liechtenstein">Liechtenstein</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Lithuania")) selected @endif value="Lithuania">Lithuania</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Luxembourg")) selected @endif value="Luxembourg">Luxembourg</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Macau")) selected @endif value="Macau">Macau</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Macedonia")) selected @endif value="Macedonia">Macedonia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Madagascar")) selected @endif value="Madagascar">Madagascar</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Malaysia")) selected @endif value="Malaysia">Malaysia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Malawi")) selected @endif value="Malawi">Malawi</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Maldives")) selected @endif value="Maldives">Maldives</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Mali")) selected @endif value="Mali">Mali</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Malta")) selected @endif value="Malta">Malta</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Marshall")) selected @endif value="Marshall Islands">Marshall Islands</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Martinique")) selected @endif value="Martinique">Martinique</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Mauritania")) selected @endif value="Mauritania">Mauritania</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Mauritius")) selected @endif value="Mauritius">Mauritius</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Mayotte")) selected @endif value="Mayotte">Mayotte</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Mexico")) selected @endif value="Mexico">Mexico</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Midway")) selected @endif value="Midway Islands">Midway Islands</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Moldova")) selected @endif value="Moldova">Moldova</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Monaco")) selected @endif value="Monaco">Monaco</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Mongolia")) selected @endif value="Mongolia">Mongolia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Montserrat")) selected @endif value="Montserrat">Montserrat</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Morocco")) selected @endif value="Morocco">Morocco</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Mozambique")) selected @endif value="Mozambique">Mozambique</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Myanmar")) selected @endif value="Myanmar">Myanmar</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Nambia")) selected @endif value="Nambia">Nambia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Nauru")) selected @endif value="Nauru">Nauru</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Nepal")) selected @endif value="Nepal">Nepal</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Netherland")) selected @endif value="Netherland Antilles">Netherland Antilles</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Netherlands")) selected @endif value="Netherlands">Netherlands (Holland, Europe)</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Nevis")) selected @endif value="Nevis">Nevis</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "New")) selected @endif value="New Caledonia">New Caledonia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "New")) selected @endif value="New Zealand">New Zealand</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Nicaragua")) selected @endif value="Nicaragua">Nicaragua</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Niger")) selected @endif value="Niger">Niger</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Nigeria")) selected @endif value="Nigeria">Nigeria</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Niue")) selected @endif value="Niue">Niue</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Norfolk")) selected @endif value="Norfolk Island">Norfolk Island</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Norway")) selected @endif value="Norway">Norway</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Oman")) selected @endif value="Oman">Oman</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Pakistan")) selected @endif value="Pakistan">Pakistan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Palau")) selected @endif value="Palau Island">Palau Island</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Palestine")) selected @endif value="Palestine">Palestine</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Panama")) selected @endif value="Panama">Panama</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Papua")) selected @endif value="Papua New Guinea">Papua New Guinea</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Paraguay")) selected @endif value="Paraguay">Paraguay</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Peru")) selected @endif value="Peru">Peru</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Phillipines")) selected @endif value="Phillipines">Philippines</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Pitcairn")) selected @endif value="Pitcairn Island">Pitcairn Island</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Poland")) selected @endif value="Poland">Poland</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Portugal")) selected @endif value="Portugal">Portugal</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Puerto")) selected @endif value="Puerto Rico">Puerto Rico</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Qatar")) selected @endif value="Qatar">Qatar</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Republic")) selected @endif value="Republic of Montenegro">Republic of Montenegro</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Republic")) selected @endif value="Republic of Serbia">Republic of Serbia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Reunion")) selected @endif value="Reunion">Reunion</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Romania")) selected @endif value="Romania">Romania</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Russia")) selected @endif value="Russia">Russia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Rwanda")) selected @endif value="Rwanda">Rwanda</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "St Barthelemy")) selected @endif value="St Barthelemy">St Barthelemy</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "St Eustatius")) selected @endif value="St Eustatius">St Eustatius</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "St Helena")) selected @endif value="St Helena">St Helena</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "St Kitts-Nevis")) selected @endif value="St Kitts-Nevis">St Kitts-Nevis</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "St Lucia")) selected @endif value="St Lucia">St Lucia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "St Maarten")) selected @endif value="St Maarten">St Maarten</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "St Pierre")) selected @endif value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "St Vincent")) selected @endif value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Saipan")) selected @endif value="Saipan">Saipan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Samoa")) selected @endif value="Samoa">Samoa</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Samoa")) selected @endif value="Samoa American">Samoa American</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "San")) selected @endif value="San Marino">San Marino</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Sao")) selected @endif value="Sao Tome & Principe">Sao Tome & Principe</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Saudi")) selected @endif value="Saudi Arabia">Saudi Arabia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Senegal")) selected @endif value="Senegal">Senegal</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Seychelles")) selected @endif value="Seychelles">Seychelles</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Sierra")) selected @endif value="Sierra Leone">Sierra Leone</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Singapore")) selected @endif value="Singapore">Singapore</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Slovakia")) selected @endif value="Slovakia">Slovakia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Slovenia")) selected @endif value="Slovenia">Slovenia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Solomon")) selected @endif value="Solomon Islands">Solomon Islands</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Somalia")) selected @endif value="Somalia">Somalia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "South")) selected @endif value="South Africa">South Africa</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Spain")) selected @endif value="Spain">Spain</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Sri")) selected @endif value="Sri Lanka">Sri Lanka</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Sudan")) selected @endif value="Sudan">Sudan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Suriname")) selected @endif value="Suriname">Suriname</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Swaziland")) selected @endif value="Swaziland">Swaziland</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Sweden")) selected @endif value="Sweden">Sweden</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Switzerland")) selected @endif value="Switzerland">Switzerland</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Syria")) selected @endif value="Syria">Syria</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Tahiti")) selected @endif value="Tahiti">Tahiti</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Taiwan")) selected @endif value="Taiwan">Taiwan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Tajikistan")) selected @endif value="Tajikistan">Tajikistan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Tanzania")) selected @endif value="Tanzania">Tanzania</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Thailand")) selected @endif value="Thailand">Thailand</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Togo")) selected @endif value="Togo">Togo</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Tokelau")) selected @endif value="Tokelau">Tokelau</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Tonga")) selected @endif value="Tonga">Tonga</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Trinidad")) selected @endif value="Trinidad & Tobago">Trinidad & Tobago</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Tunisia")) selected @endif value="Tunisia">Tunisia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Turkey")) selected @endif value="Turkey">Turkey</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Turkmenistan")) selected @endif value="Turkmenistan">Turkmenistan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Turks")) selected @endif value="Turks & Caicos Is">Turks & Caicos Is</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Tuvalu")) selected @endif value="Tuvalu">Tuvalu</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Uganda")) selected @endif value="Uganda">Uganda</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "United Kingdom")) selected @endif value="United Kingdom">United Kingdom</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Ukraine")) selected @endif value="Ukraine">Ukraine</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "United Arab")) selected @endif value="United Arab Erimates">United Arab Emirates</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "United States")) selected @endif value="United States of America">United States of America</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Uraguay")) selected @endif value="Uraguay">Uruguay</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Uzbekistan")) selected @endif value="Uzbekistan">Uzbekistan</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Vanuatu")) selected @endif value="Vanuatu">Vanuatu</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Vatican")) selected @endif value="Vatican City State">Vatican City State</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Venezuela")) selected @endif value="Venezuela">Venezuela</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Vietnam")) selected @endif value="Vietnam">Vietnam</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Virgin")) selected @endif value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Virgin")) selected @endif value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Wake")) selected @endif value="Wake Island">Wake Island</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Wallis")) selected @endif value="Wallis & Futana Is">Wallis & Futana Is</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Yemen")) selected @endif value="Yemen">Yemen</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Zaire")) selected @endif value="Zaire">Zaire</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Zambia")) selected @endif value="Zambia">Zambia</option>
                    <option @if(\Illuminate\Support\Str::startsWith($country, "Zimbabwe")) selected @endif value="Zimbabwe">Zimbabwe</option>
                </select>
                <input class="form-check-input" type="checkbox" name="terms" value="1" required id="formCheck-1" @if(old('terms')) checked @endif ><label class="form-check-label" for="formCheck-1">Perskaičiau ir sutinku su privatumo politika</label>
                <br>
                <input type="checkbox" name="newsletter" value="1" id="formCheck-2" @if(old('newsletter')) checked @endif ><label class="form-check-label" for="formCheck-2">Sutinku gauti naujienlaiškius</label>

                <button type="submit">Registruotis</button>
            </form>
        </div>
        <div class="clear"></div>
    @endif
@endsection