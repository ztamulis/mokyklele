<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <div class="learning--group--select--title">
        <h2>Registruokitės ir netrukus susisieksime!</h2>
        Jei turite daugiau nei vieną vaiką, užpildykite kiekvienam vaikui anketą atskirai
    </div>
    <form method="post" action="/register-free" class="free--lesson">
        @csrf
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <input type="text" name="name" placeholder="Jūsų vardas" required value="{{ old("name") }}">
                <br>
                <input style="margin-top: 20px;" type="text" name="student_name" placeholder="Vaiko vardas" required value="{{ old("student_name") }}">
                <br>
                Kiek vaikui metų?
                <br>
                <label><input type="radio" name="student_age" value="2-4" required> 2-4 metai</label><br>
                <label><input type="radio" name="student_age" value="5-6"> 5-6 metai</label><br>
                <label><input type="radio" name="student_age" value="7-9"> 7-9 metai</label><br>
                <label><input type="radio" name="student_age" value="10-13"> 10-14 metų</label><br>
                <label><input type="radio" name="student_age" value="14>"> 15 ir daugiau metų</label><br>
            </div>
            <div class="col-md-6 col-sm-12">
                <input type="email" name="email" placeholder="El. pašto adresas" required  value="{{ old("email") }}">
                <br>
                <?php
                    $country = 'Lithuania';
                ?>
                Gyvenamoji šalis<br>
                <select name="country" required>
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
                <br>
                <textarea placeholder="Papildomi komentarai" name="comments" maxlength="200">{{ old("comments") }}</textarea>
            </div>
        </div>

        <div class="clear"></div>
        <br><br>
        <label><input type="checkbox" name="terms" value="1" @if(old("terms")) checked @endif required> Sutinku su <a href="/privatumo-politika" target="_blank">Pasakos privatumo politika</a></label><br>
        <label><input type="checkbox" name="newsletter" value="1" @if(old("newsletter")) checked @endif > Sutinku gauti Pasakos naujienlaiškius</label>
        <button type="submit">Siųsti</button>
    </form>
</div>