<x-app-layout>
    <div class="client--dashboard">
        <div class="client--dashboard--title">
            <h3>Paskyra</h3>
            <p>Čia galite pasikeisti ir pažiūrėti visą informaciją susijusią su Jūsų paskyra.</p>
        </div>
        @if(Auth::user()->role == "teacher")
            <div class="row mb-3">
                <div class="col">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col">
                                    <p class="m-0">Pravesta pamokų</p>
                                    <p class="m-0"><strong>{{ \App\Models\Event::where("teacher_id", Auth::user()->id)->where("date_at", "<", \Carbon\Carbon::now())->count() }}</strong></p>
                                </div>
                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col">
                                    <p class="m-0">Užsiregistruota</p>
                                    <p class="m-0"><strong>{{ Auth::user()->created_at }}</strong></p>
                                </div>
                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($message))
            <div class="row">
                <div class="col-xl-8 offset-xl-2">
                    <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
                </div>
            </div>
        @endif
        @if(Session::has('message'))
            <div class="row">
                <div class="col-xl-8 offset-xl-2">
                    <div class="alert alert-primary text-center" role="alert"><span>{{ Session::get('message') }}</span></div>
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

                    <div class="row">
                        <div class="col">
                            @if(Auth::user()->students->count() > 0)
                                <div class="dashboard--block">
                                    <h3>Jūsų vaikai</h3>
                                    <form method="POST" action="/dashboard/profile/photo-change" enctype="multipart/form-data">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table mt-2">
                                                <tbody>
                                                @php $students_arr_now = array(); @endphp
                                                @foreach(Auth::user()->students as $student)
                                                    @php                                               
                                                        if(!in_array($student->name, $students_arr_now)){
                                                            $students_arr_now[] = $student->name;
                                                    @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="student--image" @if($student->photo) style="background-image: url('/uploads/students/{{ $student->photo }}')" @endif ></div>
                                                                {{ $student->name }}
                                                            </td>
                                                            <td>
                                                                <small class="form-text text-muted">Nauja nuotrauka</small>
                                                                <input type="file" class="form-control-file" name="student_{{ $student->id }}" accept=".jpg,.jpeg,.png">
                                                            </td>
                                                        </tr>
                                                    @php } @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group text--right"><button class="dashboard--button dashboard--button--main btn-sm" type="submit">Išsaugoti įkeltą nuotrauką</button></div>
                                    </form>
                                </div>
                            @endif
                            <div class="dashboard--block">
                                <h3>Profilio informacija</h3>
                                <form method="POST" action="/dashboard/profile/info-change">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group"><label for="username"><strong>Jūsų vardas</strong><br></label><input class="form-control" type="text" name="name" value="{{ Auth::user()->name }}" placeholder="Vardas" maxlength="30" required></div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group"><label for="email"><strong>Jūsų pavardė</strong></label><input class="form-control" type="text" placeholder="Pavardė" name="surname" value="{{ Auth::user()->surname }}" maxlength="30" required></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group"><label for="last_name"><strong>Gyvenimoji šalis</strong></label><select name="country" class="form-control">
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Afganistan")) selected @endif value="Afganistan">Afghanistan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Albania")) selected @endif value="Albania">Albania</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Algeria")) selected @endif value="Algeria">Algeria</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "American")) selected @endif value="American Samoa">American Samoa</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Andorra")) selected @endif value="Andorra">Andorra</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Angola")) selected @endif value="Angola">Angola</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Anguilla")) selected @endif value="Anguilla">Anguilla</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Antigua")) selected @endif value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Argentina")) selected @endif value="Argentina">Argentina</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Armenia")) selected @endif value="Armenia">Armenia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Aruba")) selected @endif value="Aruba">Aruba</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Australia")) selected @endif value="Australia">Australia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Austria")) selected @endif value="Austria">Austria</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Azerbaijan")) selected @endif value="Azerbaijan">Azerbaijan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Bahamas")) selected @endif value="Bahamas">Bahamas</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Bahrain")) selected @endif value="Bahrain">Bahrain</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Bangladesh")) selected @endif value="Bangladesh">Bangladesh</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Barbados")) selected @endif value="Barbados">Barbados</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Belarus")) selected @endif value="Belarus">Belarus</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Belgium")) selected @endif value="Belgium">Belgium</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Belize")) selected @endif value="Belize">Belize</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Benin")) selected @endif value="Benin">Benin</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Bermuda")) selected @endif value="Bermuda">Bermuda</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Bhutan")) selected @endif value="Bhutan">Bhutan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Bolivia")) selected @endif value="Bolivia">Bolivia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Bonaire")) selected @endif value="Bonaire">Bonaire</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Bosnia")) selected @endif value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Botswana")) selected @endif value="Botswana">Botswana</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Brazil")) selected @endif value="Brazil">Brazil</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "British")) selected @endif value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Brunei")) selected @endif value="Brunei">Brunei</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Bulgaria")) selected @endif value="Bulgaria">Bulgaria</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Burkina")) selected @endif value="Burkina Faso">Burkina Faso</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Burundi")) selected @endif value="Burundi">Burundi</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Cambodia")) selected @endif value="Cambodia">Cambodia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Cameroon")) selected @endif value="Cameroon">Cameroon</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Canada")) selected @endif value="Canada">Canada</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Canary")) selected @endif value="Canary Islands">Canary Islands</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Cape")) selected @endif value="Cape Verde">Cape Verde</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Cayman")) selected @endif value="Cayman Islands">Cayman Islands</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Central")) selected @endif value="Central African Republic">Central African Republic</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Chad")) selected @endif value="Chad">Chad</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Channel")) selected @endif value="Channel Islands">Channel Islands</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Chile")) selected @endif value="Chile">Chile</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "China")) selected @endif value="China">China</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Christmas")) selected @endif value="Christmas Island">Christmas Island</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Cocos")) selected @endif value="Cocos Island">Cocos Island</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Colombia")) selected @endif value="Colombia">Colombia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Comoros")) selected @endif value="Comoros">Comoros</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Congo")) selected @endif value="Congo">Congo</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Cook")) selected @endif value="Cook Islands">Cook Islands</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Costa")) selected @endif value="Costa Rica">Costa Rica</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Cote")) selected @endif value="Cote DIvoire">Cote DIvoire</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Croatia")) selected @endif value="Croatia">Croatia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Cuba")) selected @endif value="Cuba">Cuba</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Curaco")) selected @endif value="Curaco">Curacao</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Cyprus")) selected @endif value="Cyprus">Cyprus</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Czech")) selected @endif value="Czech Republic">Czech Republic</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Denmark")) selected @endif value="Denmark">Denmark</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Djibouti")) selected @endif value="Djibouti">Djibouti</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Dominica")) selected @endif value="Dominica">Dominica</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Dominican")) selected @endif value="Dominican Republic">Dominican Republic</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "East")) selected @endif value="East Timor">East Timor</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Ecuador")) selected @endif value="Ecuador">Ecuador</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Egypt")) selected @endif value="Egypt">Egypt</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "El")) selected @endif value="El Salvador">El Salvador</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Equatorial")) selected @endif value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Eritrea")) selected @endif value="Eritrea">Eritrea</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Estonia")) selected @endif value="Estonia">Estonia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Ethiopia")) selected @endif value="Ethiopia">Ethiopia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Falkland")) selected @endif value="Falkland Islands">Falkland Islands</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Faroe")) selected @endif value="Faroe Islands">Faroe Islands</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Fiji")) selected @endif value="Fiji">Fiji</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Finland")) selected @endif value="Finland">Finland</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "France")) selected @endif value="France">France</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "French")) selected @endif value="French Guiana">French Guiana</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "French")) selected @endif value="French Polynesia">French Polynesia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "French")) selected @endif value="French Southern Ter">French Southern Ter</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Gabon")) selected @endif value="Gabon">Gabon</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Gambia")) selected @endif value="Gambia">Gambia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Georgia")) selected @endif value="Georgia">Georgia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Germany")) selected @endif value="Germany">Germany</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Ghana")) selected @endif value="Ghana">Ghana</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Gibraltar")) selected @endif value="Gibraltar">Gibraltar</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Great")) selected @endif value="Great Britain">Great Britain</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Greece")) selected @endif value="Greece">Greece</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Greenland")) selected @endif value="Greenland">Greenland</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Grenada")) selected @endif value="Grenada">Grenada</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Guadeloupe")) selected @endif value="Guadeloupe">Guadeloupe</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Guam")) selected @endif value="Guam">Guam</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Guatemala")) selected @endif value="Guatemala">Guatemala</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Guinea")) selected @endif value="Guinea">Guinea</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Guyana")) selected @endif value="Guyana">Guyana</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Haiti")) selected @endif value="Haiti">Haiti</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Hawaii")) selected @endif value="Hawaii">Hawaii</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Honduras")) selected @endif value="Honduras">Honduras</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Hong")) selected @endif value="Hong Kong">Hong Kong</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Hungary")) selected @endif value="Hungary">Hungary</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Iceland")) selected @endif value="Iceland">Iceland</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Indonesia")) selected @endif value="Indonesia">Indonesia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "India")) selected @endif value="India">India</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Iran")) selected @endif value="Iran">Iran</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Iraq")) selected @endif value="Iraq">Iraq</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Ireland")) selected @endif value="Ireland">Ireland</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Isle")) selected @endif value="Isle of Man">Isle of Man</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Israel")) selected @endif value="Israel">Israel</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Italy")) selected @endif value="Italy">Italy</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Jamaica")) selected @endif value="Jamaica">Jamaica</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Japan")) selected @endif value="Japan">Japan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Jordan")) selected @endif value="Jordan">Jordan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Kazakhstan")) selected @endif value="Kazakhstan">Kazakhstan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Kenya")) selected @endif value="Kenya">Kenya</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Kiribati")) selected @endif value="Kiribati">Kiribati</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Korea")) selected @endif value="Korea North">Korea North</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Korea")) selected @endif value="Korea Sout">Korea South</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Kuwait")) selected @endif value="Kuwait">Kuwait</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Kyrgyzstan")) selected @endif value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Laos")) selected @endif value="Laos">Laos</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Latvia")) selected @endif value="Latvia">Latvia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Lebanon")) selected @endif value="Lebanon">Lebanon</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Lesotho")) selected @endif value="Lesotho">Lesotho</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Liberia")) selected @endif value="Liberia">Liberia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Libya")) selected @endif value="Libya">Libya</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Liechtenstein")) selected @endif value="Liechtenstein">Liechtenstein</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Lithuania")) selected @endif value="Lithuania">Lithuania</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Luxembourg")) selected @endif value="Luxembourg">Luxembourg</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Macau")) selected @endif value="Macau">Macau</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Macedonia")) selected @endif value="Macedonia">Macedonia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Madagascar")) selected @endif value="Madagascar">Madagascar</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Malaysia")) selected @endif value="Malaysia">Malaysia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Malawi")) selected @endif value="Malawi">Malawi</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Maldives")) selected @endif value="Maldives">Maldives</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Mali")) selected @endif value="Mali">Mali</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Malta")) selected @endif value="Malta">Malta</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Marshall")) selected @endif value="Marshall Islands">Marshall Islands</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Martinique")) selected @endif value="Martinique">Martinique</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Mauritania")) selected @endif value="Mauritania">Mauritania</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Mauritius")) selected @endif value="Mauritius">Mauritius</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Mayotte")) selected @endif value="Mayotte">Mayotte</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Mexico")) selected @endif value="Mexico">Mexico</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Midway")) selected @endif value="Midway Islands">Midway Islands</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Moldova")) selected @endif value="Moldova">Moldova</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Monaco")) selected @endif value="Monaco">Monaco</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Mongolia")) selected @endif value="Mongolia">Mongolia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Montserrat")) selected @endif value="Montserrat">Montserrat</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Morocco")) selected @endif value="Morocco">Morocco</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Mozambique")) selected @endif value="Mozambique">Mozambique</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Myanmar")) selected @endif value="Myanmar">Myanmar</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Nambia")) selected @endif value="Nambia">Nambia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Nauru")) selected @endif value="Nauru">Nauru</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Nepal")) selected @endif value="Nepal">Nepal</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Netherland")) selected @endif value="Netherland Antilles">Netherland Antilles</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Netherlands")) selected @endif value="Netherlands">Netherlands (Holland, Europe)</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Nevis")) selected @endif value="Nevis">Nevis</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "New")) selected @endif value="New Caledonia">New Caledonia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "New")) selected @endif value="New Zealand">New Zealand</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Nicaragua")) selected @endif value="Nicaragua">Nicaragua</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Niger")) selected @endif value="Niger">Niger</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Nigeria")) selected @endif value="Nigeria">Nigeria</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Niue")) selected @endif value="Niue">Niue</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Norfolk")) selected @endif value="Norfolk Island">Norfolk Island</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Norway")) selected @endif value="Norway">Norway</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Oman")) selected @endif value="Oman">Oman</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Pakistan")) selected @endif value="Pakistan">Pakistan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Palau")) selected @endif value="Palau Island">Palau Island</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Palestine")) selected @endif value="Palestine">Palestine</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Panama")) selected @endif value="Panama">Panama</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Papua")) selected @endif value="Papua New Guinea">Papua New Guinea</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Paraguay")) selected @endif value="Paraguay">Paraguay</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Peru")) selected @endif value="Peru">Peru</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Phillipines")) selected @endif value="Phillipines">Philippines</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Pitcairn")) selected @endif value="Pitcairn Island">Pitcairn Island</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Poland")) selected @endif value="Poland">Poland</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Portugal")) selected @endif value="Portugal">Portugal</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Puerto")) selected @endif value="Puerto Rico">Puerto Rico</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Qatar")) selected @endif value="Qatar">Qatar</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Republic")) selected @endif value="Republic of Montenegro">Republic of Montenegro</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Republic")) selected @endif value="Republic of Serbia">Republic of Serbia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Reunion")) selected @endif value="Reunion">Reunion</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Romania")) selected @endif value="Romania">Romania</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Russia")) selected @endif value="Russia">Russia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Rwanda")) selected @endif value="Rwanda">Rwanda</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "St")) selected @endif value="St Barthelemy">St Barthelemy</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "St")) selected @endif value="St Eustatius">St Eustatius</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "St")) selected @endif value="St Helena">St Helena</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "St")) selected @endif value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "St")) selected @endif value="St Lucia">St Lucia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "St")) selected @endif value="St Maarten">St Maarten</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "St")) selected @endif value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "St")) selected @endif value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Saipan")) selected @endif value="Saipan">Saipan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Samoa")) selected @endif value="Samoa">Samoa</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Samoa")) selected @endif value="Samoa American">Samoa American</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "San")) selected @endif value="San Marino">San Marino</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Sao")) selected @endif value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Saudi")) selected @endif value="Saudi Arabia">Saudi Arabia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Senegal")) selected @endif value="Senegal">Senegal</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Seychelles")) selected @endif value="Seychelles">Seychelles</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Sierra")) selected @endif value="Sierra Leone">Sierra Leone</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Singapore")) selected @endif value="Singapore">Singapore</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Slovakia")) selected @endif value="Slovakia">Slovakia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Slovenia")) selected @endif value="Slovenia">Slovenia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Solomon")) selected @endif value="Solomon Islands">Solomon Islands</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Somalia")) selected @endif value="Somalia">Somalia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "South")) selected @endif value="South Africa">South Africa</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Spain")) selected @endif value="Spain">Spain</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Sri")) selected @endif value="Sri Lanka">Sri Lanka</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Sudan")) selected @endif value="Sudan">Sudan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Suriname")) selected @endif value="Suriname">Suriname</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Swaziland")) selected @endif value="Swaziland">Swaziland</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Sweden")) selected @endif value="Sweden">Sweden</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Switzerland")) selected @endif value="Switzerland">Switzerland</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Syria")) selected @endif value="Syria">Syria</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Tahiti")) selected @endif value="Tahiti">Tahiti</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Taiwan")) selected @endif value="Taiwan">Taiwan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Tajikistan")) selected @endif value="Tajikistan">Tajikistan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Tanzania")) selected @endif value="Tanzania">Tanzania</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Thailand")) selected @endif value="Thailand">Thailand</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Togo")) selected @endif value="Togo">Togo</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Tokelau")) selected @endif value="Tokelau">Tokelau</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Tonga")) selected @endif value="Tonga">Tonga</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Trinidad")) selected @endif value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Tunisia")) selected @endif value="Tunisia">Tunisia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Turkey")) selected @endif value="Turkey">Turkey</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Turkmenistan")) selected @endif value="Turkmenistan">Turkmenistan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Turks")) selected @endif value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Tuvalu")) selected @endif value="Tuvalu">Tuvalu</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Uganda")) selected @endif value="Uganda">Uganda</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "United Kingdom")) selected @endif value="United Kingdom">United Kingdom</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Ukraine")) selected @endif value="Ukraine">Ukraine</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "United Arab")) selected @endif value="United Arab Erimates">United Arab Emirates</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "United States")) selected @endif value="United States of America">United States of America</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Uraguay")) selected @endif value="Uraguay">Uruguay</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Uzbekistan")) selected @endif value="Uzbekistan">Uzbekistan</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Vanuatu")) selected @endif value="Vanuatu">Vanuatu</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Vatican")) selected @endif value="Vatican City State">Vatican City State</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Venezuela")) selected @endif value="Venezuela">Venezuela</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Vietnam")) selected @endif value="Vietnam">Vietnam</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Virgin")) selected @endif value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Virgin")) selected @endif value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Wake")) selected @endif value="Wake Island">Wake Island</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Wallis")) selected @endif value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Yemen")) selected @endif value="Yemen">Yemen</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Zaire")) selected @endif value="Zaire">Zaire</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Zambia")) selected @endif value="Zambia">Zambia</option>
                                                    <option @if(\Illuminate\Support\Str::startsWith(Auth::user()->country, "Zimbabwe")) selected @endif value="Zimbabwe">Zimbabwe</option>
                                                </select></div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col align-self-center">
                                            <div class="form-group text--right"><button class="dashboard--button dashboard--button--main btn-sm" type="submit">Išsaugoti pakeitimus</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if(Auth::user()->role != "user")
                            <div class="dashboard--block">
                                <h3>Profilio nuotraukos keitimas</h3>
                                <form method="POST" action="/dashboard/profile/profile-photo-change" enctype="multipart/form-data">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table mt-2">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="student--image" @if(Auth::user()->photo) style="background-image: url('/uploads/users/{{ Auth::user()->photo }}')" @endif ></div>
                                                        {{ Auth::user()->name }} {{ Auth::user()->surname }}
                                                    </td>
                                                    <td>
                                                        <small class="form-text text-muted">Nauja nuotrauka</small>
                                                        <input type="file" class="form-control-file" name="file" accept=".jpg,.jpeg,.png">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group text--right"><button class="dashboard--button dashboard--button--main btn-sm" type="submit">Išsaugoti įkeltą nuotrauką</button></div>
                                </form>
                            </div>
                            @endif
                            <div class="dashboard--block">
                                <h3>Slaptažodžio keitimas</h3>
                                <form method="POST" action="/dashboard/profile/password-change">
                                    @csrf
                                    <div class="form-group"><label for="address"><strong>Dabartinis&nbsp;slaptažodis</strong><br></label><input class="form-control" type="password" name="password" required></div>
                                    <div class="form-group"><label for="address"><strong>Naujas slaptažodis</strong><br></label><input class="form-control" type="password" name="new_password" required></div>
                                    <div class="form-group"><label for="address"><strong>Pakartokite naują slaptažodį</strong><br></label><input class="form-control" type="password" name="new_password_confirmation" required></div>
                                    <div class="form-group text--right"><button class="dashboard--button dashboard--button--main btn-sm" type="submit">Išsaugoti pakeitimus</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->role != "teacher")
                    <div class="dashboard--block">
                        <h3>Mokėjimai</h3>
                            <div class="row">
                                <div class="col">
                                    {{--                    <div class="alert alert-success text-center" role="alert"><span>Sėkmingai atšauktas tiesioginis debetas</span></div>--}}
                                </div>
                            </div>
                            <div class="row">
                                {{--                <div class="col-xl-6 offset-xl-3"><button class="btn btn-success btn-block" type="button">Atsiskaityti tiesioginiu debetu</button></div>--}}
                            </div>
                            <div class="row">
                                <div class="col-xl-6 offset-xl-3">
                                    {{--                    <h5 class="text-center">Išsaugoti kortelės duomenis atsiskaitymams</h5>--}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">


                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2">
                                    <form>
        {{--                                <div class="form-group"><input id="card-holder-name" class="form-control" type="text" placeholder="Mokėtojo vardas ir pavardė"></div>--}}
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2">
                                    <form>
                                        <div class="form-group">
                                            <div class="form-row">
                                            {{--                                <div class="col"><input class="form-control" type="text" name="card[number]" placeholder="Kortelės numeris"></div>--}}
                                            {{--                                <div class="col-xl-3"><input class="form-control" type="text" placeholder="mm / MM" name="card[expireDate]"></div>--}}
                                            {{--                                <div class="col-xl-3"><input class="form-control" type="text" placeholder="CVC" name="card[cvc]"></div>--}}
                                            <!-- Stripe Elements Placeholder -->
                                                {{--                                <div id="card-element"></div>--}}
                                                {{--                                <div class="col">--}}
                                                {{--                                    <div id="card-number"></div>--}}
                                                {{--                                </div>--}}
                                                {{--                                <div class="col-xl-3">--}}
                                                {{--                                    <div id="card-expiry"></div>--}}
                                                {{--                                </div>--}}
                                                {{--                                <div class="col-xl-3">--}}
                                                {{--                                    <div id="card-cvc"></div>--}}
                                                {{--                                </div>--}}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 offset-xl-4">
                                    {{--                    <form>--}}
                                    {{--                        <div class="form-group text-center"><button class="btn btn-success btn-block" type="button">Išsaugoti kortelę</button></div>--}}
                                    {{--                    </form>--}}

                                    <div class="form-group text-center">
                                        {{--                        <button class="dashboard--button dashboard--button--main btn-block" id="card-button" data-secret="{{ $intent->client_secret }}">--}}
                                        {{--                            Išsaugoti kortelę--}}
                                        {{--                        </button>--}}
                                        <a class="dashboard--button dashboard--button--main btn-block" id="card-button" href="/dashboard/billing-portal">
                                            Apmokėjimų valdymas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
{{--            </div>--}}
{{--            @if(Auth::user()->role != "user")--}}
{{--            <div class="card mb-5">--}}
{{--                <div class="card-header py-3">--}}
{{--                    <p class=" m-0 font-weight-bold">Zoom integracija</p>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-xl-4 offset-xl-4">--}}
{{--                            <div class="form-group text-center">--}}
{{--                                <a class="dashboard--button dashboard--button--main btn-block" id="card-button" href="https://zoom.us/oauth/authorize?response_type=code&client_id={{ env("ZOOM_CLIENT_ID") }}&redirect_uri={{ url("/dashboard/profile/zoom") }}">--}}
{{--                                    Prisijungti prie Zoom--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}


{{--    <script src="https://js.stripe.com/v3/"></script>--}}

{{--    <script>--}}
{{--        const stripe = Stripe("{{ env("STRIPE_KEY") }}");--}}

{{--        const elements = stripe.elements();--}}

{{--        var elementStyles = {--}}
{{--            base: {--}}
{{--                color: '#fff',--}}
{{--                fontFamily: 'Arial, sans-serif',--}}
{{--                fontSize: '13px',--}}
{{--                fontSmoothing: 'antialiased',--}}

{{--                ':focus': {--}}
{{--                    color: '#424770',--}}
{{--                },--}}

{{--                '::placeholder': {--}}
{{--                    color: '#9BACC8',--}}
{{--                },--}}

{{--                ':focus::placeholder': {--}}
{{--                    color: '#CFD7DF',--}}
{{--                },--}}
{{--            },--}}
{{--            invalid: {--}}
{{--                color: '#ccc',--}}
{{--                ':focus': {--}}
{{--                    color: '#FA755A',--}}
{{--                },--}}
{{--                '::placeholder': {--}}
{{--                    color: '#FFCCA5',--}}
{{--                },--}}
{{--            },--}}
{{--        };--}}

{{--        var elementClasses = {--}}
{{--            focus: 'focus',--}}
{{--            empty: 'empty',--}}
{{--            invalid: 'invalid',--}}
{{--        };--}}

{{--        var cardNumber = elements.create('cardNumber', {--}}
{{--            style: elementStyles,--}}
{{--            classes: elementClasses,--}}
{{--        });--}}
{{--        cardNumber.mount('#card-number');--}}

{{--        var cardExpiry = elements.create('cardExpiry', {--}}
{{--            style: elementStyles,--}}
{{--            classes: elementClasses,--}}
{{--        });--}}
{{--        cardExpiry.mount('#card-expiry');--}}

{{--        var cardCvc = elements.create('cardCvc', {--}}
{{--            style: elementStyles,--}}
{{--            classes: elementClasses,--}}
{{--        });--}}
{{--        cardCvc.mount('#card-cvc');--}}

{{--        const cardHolderName = document.getElementById('card-holder-name');--}}
{{--        const cardButton = document.getElementById('card-button');--}}
{{--        const clientSecret = cardButton.dataset.secret;--}}

{{--        cardButton.addEventListener('click', async (e) => {--}}
{{--            const { setupIntent, error } = await stripe.confirmCardSetup(--}}
{{--                clientSecret, {--}}
{{--                    payment_method: {--}}
{{--                        card: cardElement,--}}
{{--                        billing_details: { name: cardHolderName.value }--}}
{{--                    }--}}
{{--                }--}}
{{--            );--}}

{{--            if (error) {--}}
{{--                alert(error.message);--}}
{{--            } else {--}}
{{--                alert("OK! " + setupIntent.payment_method);--}}
{{--                $.post("/dashboard/profile/update-card", {_token: "{{ csrf_token() }}", payment_method: setupIntent.payment_method}, function (data){--}}
{{--                    alert(data);--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
</x-app-layout>