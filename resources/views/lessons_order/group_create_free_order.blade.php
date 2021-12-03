@extends("layouts.landing")

@section("title", "Komanda")

@section("content")
    <h2 class="content--title">Registracija į nemokamą pamoką</h2>
    <div class="text--center">
        <b>{{\Carbon\Carbon::parse($group->start_date)->format("m.d")}}d., {{ $group->name }} {{ $group->time->timezone(Cookie::get("user_timezone", "GMT"))->format("H:i") }} (laikas nurodomas jūsų vietiniu laiku <small>({{ Cookie::get("user_timezone", "GMT") }})</small>)</b>
        <br>
        {{ $group->display_name }}
        <br>
        <br>
        <br>
    </div>
    @if (isset($error))
        <div class="text--center">
            <h3 style="color: red;">{{$error}}</h3>
        </div>
    @endif


    @if ($errors->any())
        <div class="text--center">
            <h3 style="color: red;">Klaida! @foreach ($errors->all() as $error) {{ $error }} @endforeach</h3>
        </div>
    @endif

    <br><br>
        <div class="order--dialog">
            <form method="POST" action="/select-group/order/free/create/{{$group->slug}}">
                @csrf
                <input type="hidden" name="action" value="order">
                @if ($group->age_category === 'adults')
                    Jūsų vardas
                @else
                    Vaikas:
                @endif                <input type="hidden" name="students" value="">
                <div class="student--select"></div>
                @if($group->type !== 'individual' && $group->age_category != 'adults')
                    <div class="" data-add-student>
                        <span class="button" style="cursor: pointer;">Pridėti dar vieną vaiką </span>
                    </div>
                @endif
                <br><br>
                <input type="hidden" name="payment_type" value="single">
                <input type="hidden" name="payment_method" value="default">
                <button id="price-button" type="submit">Registruotis</button>
            </form>
        </div>
        <script>
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
                    @foreach(Auth()->user()->students()->get() as $student)
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

            studentsHtml += '<option value="new">Pridėti vaiką</option></select>';
            studentsHtml += '<input type="text" name="new_student_name" data-new-student-input="0" placeholder="Vaiko vardas, pavardė">';
            studentsHtml += '<small data-birthday-label=0 style="display: none;">Vaiko gimtadienis:</small><input type="date" name="new_student_birthday" data-new-student-input-age="0" placeholder="{{ date("Y-m-d") }}"></div>';

            $(".student--select").html(studentsHtml);
            if(available_students.length == 0){
                $(".student--select select").hide();
            }

            rebindSelect();

            function deleteStudent(id) {
                $('#children-'+id).remove();
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
                studentsHtml += '<small data-birthday-label='+selectIndex+' style="display: none;">Vaiko gimtadienis:</small><input type="date" name="new_student_birthday" data-new-student-input-age="'+selectIndex+'" placeholder="{{ date("Y-m-d") }}"></div>';
                $(".student--select").append(studentsHtml);
                // var studentsCount = $(".student--select select").length;
                // var price = $('#single-student-price').val();
                // var discountedPrice = parseInt(price) / 2;
                // var newPrice = parseInt(price) + ((parseInt(studentsCount) - 1) * discountedPrice);
                //
                // var buttonText = 'Užsakyti (£ '+newPrice+')' ;
                // $("#price-button").html(buttonText);


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

            $("form").submit(function(event) {
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
                        if(name == "" || birthday == ""){
                            if(confirm("Palikti tušti langeliai! Informacija susijusi su tuščiais langeliais nebus įvesta. Ar norite tęsti?")){
                            } else {
                                event.preventDefault();
                            }
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
                    alert("Vaikai kartojasi! Prašome patikrinkti.");
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
@endsection