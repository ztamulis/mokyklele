<x-app-layout>
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
                    <h3 class="text-dark mb-4">Pridėti vartotoja</h3>
                    <div class="card shadow"></div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-8">
                                    <form action="/dashboard/users" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <small class="form-text text-muted">El. paštas</small>
                                            <input class="form-control" type="email" name="email" placeholder="paštas@gmail.com" value="{{ old("email") }}">
                                        </div>
                                        <div class="form-group">
                                            <small class="form-text text-muted">Vardas</small>
                                            <input class="form-control" type="text" name="name" placeholder="Vardenis" value="{{ old("name") }}">
                                        </div>
                                        <div class="form-group">
                                            <small class="form-text text-muted">Pavardė</small>
                                            <input class="form-control" type="text" name="surname" placeholder="Pavardenis" value="{{ old("surname") }}">
                                        </div>
                                        <div class="form-group">
                                            <small class="form-text text-muted">Gyvenamoji šalis</small>
                                            <select class="form-control" name="country" required>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Afganistan")) selected @endif value="Afganistan">Afghanistan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Albania")) selected @endif value="Albania">Albania</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Algeria")) selected @endif value="Algeria">Algeria</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "American")) selected @endif value="American Samoa">American Samoa</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Andorra")) selected @endif value="Andorra">Andorra</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Angola")) selected @endif value="Angola">Angola</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Anguilla")) selected @endif value="Anguilla">Anguilla</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Antigua")) selected @endif value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Argentina")) selected @endif value="Argentina">Argentina</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Armenia")) selected @endif value="Armenia">Armenia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Aruba")) selected @endif value="Aruba">Aruba</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Australia")) selected @endif value="Australia">Australia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Austria")) selected @endif value="Austria">Austria</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Azerbaijan")) selected @endif value="Azerbaijan">Azerbaijan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Bahamas")) selected @endif value="Bahamas">Bahamas</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Bahrain")) selected @endif value="Bahrain">Bahrain</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Bangladesh")) selected @endif value="Bangladesh">Bangladesh</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Barbados")) selected @endif value="Barbados">Barbados</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Belarus")) selected @endif value="Belarus">Belarus</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Belgium")) selected @endif value="Belgium">Belgium</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Belize")) selected @endif value="Belize">Belize</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Benin")) selected @endif value="Benin">Benin</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Bermuda")) selected @endif value="Bermuda">Bermuda</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Bhutan")) selected @endif value="Bhutan">Bhutan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Bolivia")) selected @endif value="Bolivia">Bolivia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Bonaire")) selected @endif value="Bonaire">Bonaire</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Bosnia")) selected @endif value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Botswana")) selected @endif value="Botswana">Botswana</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Brazil")) selected @endif value="Brazil">Brazil</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "British")) selected @endif value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Brunei")) selected @endif value="Brunei">Brunei</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Bulgaria")) selected @endif value="Bulgaria">Bulgaria</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Burkina")) selected @endif value="Burkina Faso">Burkina Faso</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Burundi")) selected @endif value="Burundi">Burundi</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Cambodia")) selected @endif value="Cambodia">Cambodia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Cameroon")) selected @endif value="Cameroon">Cameroon</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Canada")) selected @endif value="Canada">Canada</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Canary")) selected @endif value="Canary Islands">Canary Islands</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Cape")) selected @endif value="Cape Verde">Cape Verde</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Cayman")) selected @endif value="Cayman Islands">Cayman Islands</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Central")) selected @endif value="Central African Republic">Central African Republic</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Chad")) selected @endif value="Chad">Chad</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Channel")) selected @endif value="Channel Islands">Channel Islands</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Chile")) selected @endif value="Chile">Chile</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "China")) selected @endif value="China">China</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Christmas")) selected @endif value="Christmas Island">Christmas Island</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Cocos")) selected @endif value="Cocos Island">Cocos Island</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Colombia")) selected @endif value="Colombia">Colombia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Comoros")) selected @endif value="Comoros">Comoros</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Congo")) selected @endif value="Congo">Congo</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Cook")) selected @endif value="Cook Islands">Cook Islands</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Costa")) selected @endif value="Costa Rica">Costa Rica</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Cote")) selected @endif value="Cote DIvoire">Cote DIvoire</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Croatia")) selected @endif value="Croatia">Croatia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Cuba")) selected @endif value="Cuba">Cuba</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Curaco")) selected @endif value="Curaco">Curacao</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Cyprus")) selected @endif value="Cyprus">Cyprus</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Czech")) selected @endif value="Czech Republic">Czech Republic</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Denmark")) selected @endif value="Denmark">Denmark</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Djibouti")) selected @endif value="Djibouti">Djibouti</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Dominica")) selected @endif value="Dominica">Dominica</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Dominican")) selected @endif value="Dominican Republic">Dominican Republic</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "East")) selected @endif value="East Timor">East Timor</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Ecuador")) selected @endif value="Ecuador">Ecuador</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Egypt")) selected @endif value="Egypt">Egypt</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "El")) selected @endif value="El Salvador">El Salvador</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Equatorial")) selected @endif value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Eritrea")) selected @endif value="Eritrea">Eritrea</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Estonia")) selected @endif value="Estonia">Estonia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Ethiopia")) selected @endif value="Ethiopia">Ethiopia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Falkland")) selected @endif value="Falkland Islands">Falkland Islands</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Faroe")) selected @endif value="Faroe Islands">Faroe Islands</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Fiji")) selected @endif value="Fiji">Fiji</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Finland")) selected @endif value="Finland">Finland</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "France")) selected @endif value="France">France</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "French")) selected @endif value="French Guiana">French Guiana</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "French")) selected @endif value="French Polynesia">French Polynesia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "French")) selected @endif value="French Southern Ter">French Southern Ter</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Gabon")) selected @endif value="Gabon">Gabon</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Gambia")) selected @endif value="Gambia">Gambia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Georgia")) selected @endif value="Georgia">Georgia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Germany")) selected @endif value="Germany">Germany</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Ghana")) selected @endif value="Ghana">Ghana</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Gibraltar")) selected @endif value="Gibraltar">Gibraltar</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Great")) selected @endif value="Great Britain">Great Britain</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Greece")) selected @endif value="Greece">Greece</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Greenland")) selected @endif value="Greenland">Greenland</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Grenada")) selected @endif value="Grenada">Grenada</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Guadeloupe")) selected @endif value="Guadeloupe">Guadeloupe</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Guam")) selected @endif value="Guam">Guam</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Guatemala")) selected @endif value="Guatemala">Guatemala</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Guinea")) selected @endif value="Guinea">Guinea</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Guyana")) selected @endif value="Guyana">Guyana</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Haiti")) selected @endif value="Haiti">Haiti</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Hawaii")) selected @endif value="Hawaii">Hawaii</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Honduras")) selected @endif value="Honduras">Honduras</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Hong")) selected @endif value="Hong Kong">Hong Kong</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Hungary")) selected @endif value="Hungary">Hungary</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Iceland")) selected @endif value="Iceland">Iceland</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Indonesia")) selected @endif value="Indonesia">Indonesia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "India")) selected @endif value="India">India</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Iran")) selected @endif value="Iran">Iran</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Iraq")) selected @endif value="Iraq">Iraq</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Ireland")) selected @endif value="Ireland">Ireland</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Isle")) selected @endif value="Isle of Man">Isle of Man</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Israel")) selected @endif value="Israel">Israel</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Italy")) selected @endif value="Italy">Italy</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Jamaica")) selected @endif value="Jamaica">Jamaica</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Japan")) selected @endif value="Japan">Japan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Jordan")) selected @endif value="Jordan">Jordan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Kazakhstan")) selected @endif value="Kazakhstan">Kazakhstan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Kenya")) selected @endif value="Kenya">Kenya</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Kiribati")) selected @endif value="Kiribati">Kiribati</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Korea")) selected @endif value="Korea North">Korea North</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Korea")) selected @endif value="Korea Sout">Korea South</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Kuwait")) selected @endif value="Kuwait">Kuwait</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Kyrgyzstan")) selected @endif value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Laos")) selected @endif value="Laos">Laos</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Latvia")) selected @endif value="Latvia">Latvia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Lebanon")) selected @endif value="Lebanon">Lebanon</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Lesotho")) selected @endif value="Lesotho">Lesotho</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Liberia")) selected @endif value="Liberia">Liberia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Libya")) selected @endif value="Libya">Libya</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Liechtenstein")) selected @endif value="Liechtenstein">Liechtenstein</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Lithuania")) selected @endif value="Lithuania">Lithuania</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Luxembourg")) selected @endif value="Luxembourg">Luxembourg</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Macau")) selected @endif value="Macau">Macau</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Macedonia")) selected @endif value="Macedonia">Macedonia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Madagascar")) selected @endif value="Madagascar">Madagascar</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Malaysia")) selected @endif value="Malaysia">Malaysia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Malawi")) selected @endif value="Malawi">Malawi</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Maldives")) selected @endif value="Maldives">Maldives</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Mali")) selected @endif value="Mali">Mali</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Malta")) selected @endif value="Malta">Malta</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Marshall")) selected @endif value="Marshall Islands">Marshall Islands</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Martinique")) selected @endif value="Martinique">Martinique</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Mauritania")) selected @endif value="Mauritania">Mauritania</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Mauritius")) selected @endif value="Mauritius">Mauritius</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Mayotte")) selected @endif value="Mayotte">Mayotte</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Mexico")) selected @endif value="Mexico">Mexico</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Midway")) selected @endif value="Midway Islands">Midway Islands</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Moldova")) selected @endif value="Moldova">Moldova</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Monaco")) selected @endif value="Monaco">Monaco</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Mongolia")) selected @endif value="Mongolia">Mongolia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Montserrat")) selected @endif value="Montserrat">Montserrat</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Morocco")) selected @endif value="Morocco">Morocco</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Mozambique")) selected @endif value="Mozambique">Mozambique</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Myanmar")) selected @endif value="Myanmar">Myanmar</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Nambia")) selected @endif value="Nambia">Nambia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Nauru")) selected @endif value="Nauru">Nauru</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Nepal")) selected @endif value="Nepal">Nepal</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Netherland")) selected @endif value="Netherland Antilles">Netherland Antilles</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Netherlands")) selected @endif value="Netherlands">Netherlands (Holland, Europe)</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Nevis")) selected @endif value="Nevis">Nevis</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "New")) selected @endif value="New Caledonia">New Caledonia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "New")) selected @endif value="New Zealand">New Zealand</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Nicaragua")) selected @endif value="Nicaragua">Nicaragua</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Niger")) selected @endif value="Niger">Niger</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Nigeria")) selected @endif value="Nigeria">Nigeria</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Niue")) selected @endif value="Niue">Niue</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Norfolk")) selected @endif value="Norfolk Island">Norfolk Island</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Norway")) selected @endif value="Norway">Norway</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Oman")) selected @endif value="Oman">Oman</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Pakistan")) selected @endif value="Pakistan">Pakistan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Palau")) selected @endif value="Palau Island">Palau Island</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Palestine")) selected @endif value="Palestine">Palestine</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Panama")) selected @endif value="Panama">Panama</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Papua")) selected @endif value="Papua New Guinea">Papua New Guinea</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Paraguay")) selected @endif value="Paraguay">Paraguay</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Peru")) selected @endif value="Peru">Peru</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Phillipines")) selected @endif value="Phillipines">Philippines</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Pitcairn")) selected @endif value="Pitcairn Island">Pitcairn Island</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Poland")) selected @endif value="Poland">Poland</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Portugal")) selected @endif value="Portugal">Portugal</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Puerto")) selected @endif value="Puerto Rico">Puerto Rico</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Qatar")) selected @endif value="Qatar">Qatar</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Republic")) selected @endif value="Republic of Montenegro">Republic of Montenegro</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Republic")) selected @endif value="Republic of Serbia">Republic of Serbia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Reunion")) selected @endif value="Reunion">Reunion</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Romania")) selected @endif value="Romania">Romania</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Russia")) selected @endif value="Russia">Russia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Rwanda")) selected @endif value="Rwanda">Rwanda</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "St")) selected @endif value="St Barthelemy">St Barthelemy</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "St")) selected @endif value="St Eustatius">St Eustatius</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "St")) selected @endif value="St Helena">St Helena</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "St")) selected @endif value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "St")) selected @endif value="St Lucia">St Lucia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "St")) selected @endif value="St Maarten">St Maarten</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "St")) selected @endif value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "St")) selected @endif value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Saipan")) selected @endif value="Saipan">Saipan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Samoa")) selected @endif value="Samoa">Samoa</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Samoa")) selected @endif value="Samoa American">Samoa American</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "San")) selected @endif value="San Marino">San Marino</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Sao")) selected @endif value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Saudi")) selected @endif value="Saudi Arabia">Saudi Arabia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Senegal")) selected @endif value="Senegal">Senegal</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Seychelles")) selected @endif value="Seychelles">Seychelles</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Sierra")) selected @endif value="Sierra Leone">Sierra Leone</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Singapore")) selected @endif value="Singapore">Singapore</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Slovakia")) selected @endif value="Slovakia">Slovakia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Slovenia")) selected @endif value="Slovenia">Slovenia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Solomon")) selected @endif value="Solomon Islands">Solomon Islands</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Somalia")) selected @endif value="Somalia">Somalia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "South")) selected @endif value="South Africa">South Africa</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Spain")) selected @endif value="Spain">Spain</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Sri")) selected @endif value="Sri Lanka">Sri Lanka</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Sudan")) selected @endif value="Sudan">Sudan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Suriname")) selected @endif value="Suriname">Suriname</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Swaziland")) selected @endif value="Swaziland">Swaziland</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Sweden")) selected @endif value="Sweden">Sweden</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Switzerland")) selected @endif value="Switzerland">Switzerland</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Syria")) selected @endif value="Syria">Syria</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Tahiti")) selected @endif value="Tahiti">Tahiti</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Taiwan")) selected @endif value="Taiwan">Taiwan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Tajikistan")) selected @endif value="Tajikistan">Tajikistan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Tanzania")) selected @endif value="Tanzania">Tanzania</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Thailand")) selected @endif value="Thailand">Thailand</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Togo")) selected @endif value="Togo">Togo</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Tokelau")) selected @endif value="Tokelau">Tokelau</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Tonga")) selected @endif value="Tonga">Tonga</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Trinidad")) selected @endif value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Tunisia")) selected @endif value="Tunisia">Tunisia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Turkey")) selected @endif value="Turkey">Turkey</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Turkmenistan")) selected @endif value="Turkmenistan">Turkmenistan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Turks")) selected @endif value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Tuvalu")) selected @endif value="Tuvalu">Tuvalu</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Uganda")) selected @endif value="Uganda">Uganda</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "United")) selected @endif value="United Kingdom">United Kingdom</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Ukraine")) selected @endif value="Ukraine">Ukraine</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "United")) selected @endif value="United Arab Erimates">United Arab Emirates</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "United")) selected @endif value="United States of America">United States of America</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Uraguay")) selected @endif value="Uraguay">Uruguay</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Uzbekistan")) selected @endif value="Uzbekistan">Uzbekistan</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Vanuatu")) selected @endif value="Vanuatu">Vanuatu</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Vatican")) selected @endif value="Vatican City State">Vatican City State</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Venezuela")) selected @endif value="Venezuela">Venezuela</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Vietnam")) selected @endif value="Vietnam">Vietnam</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Virgin")) selected @endif value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Virgin")) selected @endif value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Wake")) selected @endif value="Wake Island">Wake Island</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Wallis")) selected @endif value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Yemen")) selected @endif value="Yemen">Yemen</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Zaire")) selected @endif value="Zaire">Zaire</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Zambia")) selected @endif value="Zambia">Zambia</option>
                                                <option @if(\Illuminate\Support\Str::startsWith(old("country"), "Zimbabwe")) selected @endif value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <small class="form-text text-muted">Slaptažodis</small>
                                            <input class="form-control" type="password" name="password" placeholder="Slaptažodis" value="{{ old("password") }}">
{{--                                            <button class="btn btn-success btn-sm" type="button" style="margin: 4px 0px 0px ;">Generuoti atsitiktinį slaptažodį</button></div>--}}
                                        <div class="form-group">
                                            <small class="form-text text-muted">Rolė</small>
                                            <select class="form-control" name="role">
                                                <option value="admin" @if(old("role") == "admin") selected @endif>Administratorius</option>
                                                <option value="teacher" @if(old("role") == "teacher") selected @endif>Mokytojas</option>
                                                <option value="user" @if(old("role") == "user") selected @endif>Naudotojas</option>
                                            </select>
                                        </div>
{{--                                        <div class="form-group"><small class="form-text text-muted">Grupė</small>--}}
{{--                                            <select class="form-control" name="country" required>--}}
{{--                                                <option value="-1">Nepriskirta</option>--}}
{{--                                                @foreach($groups as $group)--}}
{{--                                                    <option value="{{ $group->id }}">{{ $group->name }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="formCheck-2" name="terms" value="{{ old("terms") }}" required checked>
                                            <label class="form-check-label" for="formCheck-2">Perskaičiau ir sutinku su privatumo politika</label>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Pridėti naują vartotoją</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
</x-app-layout>