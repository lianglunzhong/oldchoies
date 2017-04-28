<div id="container">
        <div class="icontainer">
                <div class="bag">
                        <?php echo Message::get(); ?>
                        <h3 class="icon-shipping">Shipping Address</h3>
                        <p style="margin-bottom: 20px;">Please fill out the following form with detailed and correct shipping address, which is essential for the smoothness of shipping. Your personal information will be well protected by <?php echo Site::instance()->get('domain'); ?>. The information below marked with &quot;<span class="color01">*</span>&quot; is required.</p>
                        <form id="shippingAddress" method="POST" action="<?php echo LANGPATH; ?>/freebie/shipping" class="formArea">
                                <input type="hidden" name="payment_method" value="PP" />
                                <input type="hidden" name="shipping_method" value="39" />
                                <input type="hidden" name="shipping_address_id" value="new" />
                                <ul style="margin-top: -10px;" id="addressNew">     
                                        <li>
                                                <label for="firstname"><span>*</span> First Name:</label>
                                                <input type="text" name="shipping_firstname" id="firstname" class="allInput" value="" maxlength="16" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="lastname"><span>*</span> Last Name:</label>
                                                <input type="text" name="shipping_lastname" id="lastname" class="allInput" value="" maxlength="16" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="address"><span>*</span> Address:</label>
                                                <input type="text" name="shipping_address" id="address" class="allInput" value="" maxlength="320" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="city"><span>*</span> City / Town:</label>
                                                <input type="text" name="shipping_city" id="city" class="allInput" value="" maxlength="320" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="state"><span>*</span> State / County:</label>
                                                <input type="text" name="shipping_state" id="state" class="allInput" value="" maxlength="320" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="country"><span>*</span> Country:</label>
                                                <select name="shipping_country" id="country" class="allSelect" onchange="$('#billing_country').val($(this).val());return getCarrier($(this).val());">
                                                        <option value="US">UNITED STATES</option>
                                                        <option value="GB">UNITED KINGDOM</option>
                                                        <option value="CA">CANADA</option>
                                                        <option value="AU">AUSTRALIA</option>
                                                        <option value="AF">AFGHANISTAN</option>
                                                        <option value="AL">ALBANIA</option>
                                                        <option value="DZ">ALGERIA</option>
                                                        <option value="AS">AMERICAN SAMOA</option>
                                                        <option value="AD">ANDORRA</option>
                                                        <option value="AO">ANGOLA</option>
                                                        <option value="AI">ANGUILLA</option>
                                                        <option value="AQ">ANTARCTICA</option>
                                                        <option value="AG">ANTIGUA AND BARBUDA</option>
                                                        <option value="AR">ARGENTINA</option>
                                                        <option value="AM">ARMENIA</option>
                                                        <option value="AW">ARUBA</option>
                                                        <option value="AT">AUSTRIA</option>
                                                        <option value="AZ">AZERBAIJAN</option>
                                                        <option value="BS">BAHAMAS</option>
                                                        <option value="BH">BAHRAIN</option>
                                                        <option value="BD">BANGLADESH</option>
                                                        <option value="BB">BARBADOS</option>
                                                        <option value="BY">BELARUS</option>
                                                        <option value="BE">BELGIUM</option>
                                                        <option value="BZ">BELIZE</option>
                                                        <option value="BJ">BENIN</option>
                                                        <option value="BM">BERMUDA</option>
                                                        <option value="BT">BHUTAN</option>
                                                        <option value="BO">BOLIVIA</option>
                                                        <option value="BA">BOSNIA AND HERZEGOWINA</option>
                                                        <option value="BW">BOTSWANA</option>
                                                        <option value="BV">BOUVET ISLANDISLAND</option>
                                                        <option value="BR">BRAZIL</option>
                                                        <option value="IO">BRITISH INDIAN OCEAN TERRITORY</option>
                                                        <option value="BN">BRUNEI DARUSSALAM</option>
                                                        <option value="BUL">BULGARIA</option>
                                                        <option value="BF">BURKINA FASO</option>
                                                        <option value="BI">BURUNDI</option>
                                                        <option value="KH">CAMBODIA</option>
                                                        <option value="CM">CAMEROON</option>
                                                        <option value="CV">CAPE VERDE</option>
                                                        <option value="KY">CAYMAN ISLANDS</option>
                                                        <option value="CF">CENTRAL AFRICAN REPUBLIC</option>
                                                        <option value="TD">CHAD</option>
                                                        <option value="CL">CHILE</option>
                                                        <option value="CN">CHINA</option>
                                                        <option value="CX">CHRISTMAS ISLAND</option>
                                                        <option value="CC">COCOS (KEELING) ISLANDS</option>
                                                        <option value="CO">COLOMBIA</option>
                                                        <option value="KM">COMOROS</option>
                                                        <option value="CG">CONGO</option>
                                                        <option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option>
                                                        <option value="CK">COOK ISLANDS</option>
                                                        <option value="CR">COSTA RICA</option>
                                                        <option value="CI">COTE D'IVOIRE</option>
                                                        <option value="HR">CROATIA</option>
                                                        <option value="CU">CUBA</option>
                                                        <option value="CY">CYPRUS</option>
                                                        <option value="CZ">CZECH REPUBLIC</option>
                                                        <option value="CZ">CZECH REPUBLIC</option>
                                                        <option value="DK">DENMARK</option>
                                                        <option value="DJ">DJIBOUTI</option>
                                                        <option value="DM">DOMINICA</option>
                                                        <option value="DO">DOMINICAN REPUBLIC</option>
                                                        <option value="EC">ECUADOR</option>
                                                        <option value="EG">EGYPT</option>
                                                        <option value="SV">EL SALVADOR</option>
                                                        <option value="GQ">EQUATORIAL GUINEA</option>
                                                        <option value="ER">ERITREA</option>
                                                        <option value="EE">ESTONIA</option>
                                                        <option value="ET">ETHIOPIA</option>
                                                        <option value="FK">FALKLAND ISLANDS (MALVINAS)</option>
                                                        <option value="FO">FAROE ISLANDS</option>
                                                        <option value="FJ">FIJI</option>
                                                        <option value="FI">FINLAND</option>
                                                        <option value="FR">FRANCE</option>
                                                        <option value="GF">FRENCH GUIANA</option>
                                                        <option value="PF">FRENCH POLYNESIA</option>
                                                        <option value="TF">FRENCH SOUTHERN TERRITORIES</option>
                                                        <option value="GA">GABON</option>
                                                        <option value="GM">GAMBIA</option>
                                                        <option value="GE">GEORGIA</option>
                                                        <option value="DE">GERMANY</option>
                                                        <option value="GH">GHANA</option>
                                                        <option value="GI">GIBRALTAR</option>
                                                        <option value="GR">GREECE</option>
                                                        <option value="GL">GREENLAND</option>
                                                        <option value="GD">GRENADA</option>
                                                        <option value="GP">GUADELOUPE</option>
                                                        <option value="GU">GUAM</option>
                                                        <option value="GT">GUATEMALA</option>
                                                        <option value="GG">GUERNSEY</option>
                                                        <option value="GN">GUINEA</option>
                                                        <option value="GW">GUINEA-BISSAU</option>
                                                        <option value="GY">GUYANA</option>
                                                        <option value="HT">HAITI</option>
                                                        <option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option>
                                                        <option value="HN">HONDURAS</option>
                                                        <option value="HK">HONG KONG</option>
                                                        <option value="HU">HUNGARY</option>
                                                        <option value="IS">ICELAND</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="IN">INDIA</option>
                                                        <option value="ID">INDONESIA</option>
                                                        <option value="IR">IRAN, ISLAMIC REPUBLIC OF</option>
                                                        <option value="IQ">IRAQ</option>
                                                        <option value="IE">IRELAND</option>
                                                        <option value="IM">ISLE OF MAN</option>
                                                        <option value="IL">ISRAEL</option>
                                                        <option value="IT">ITALY</option>
                                                        <option value="JM">JAMAICA</option>
                                                        <option value="JP">JAPAN</option>
                                                        <option value="JE">JERSEY</option>
                                                        <option value="JO">JORDAN</option>
                                                        <option value="KZ">KAZAKHSTAN</option>
                                                        <option value="KE">KENYA</option>
                                                        <option value="KI">KIRIBATI</option>
                                                        <option value="KP">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option>
                                                        <option value="KW">KUWAIT</option>
                                                        <option value="KG">KYRGYZSTAN</option>
                                                        <option value="AX">LAND ISLANDS</option>
                                                        <option value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option>
                                                        <option value="LB">LEBANON</option>
                                                        <option value="LS">LESOTHO</option>
                                                        <option value="LR">LIBERIA</option>
                                                        <option value="LY">LIBYAN ARAB JAMAHIRIYA</option>
                                                        <option value="LI">LIECHTENSTEIN</option>
                                                        <option value="LT">LITHUANIA</option>
                                                        <option value="LU">LUXEMBOURG</option>
                                                        <option value="MO">MACAO</option>
                                                        <option value="MK">MACEDONIA</option>
                                                        <option value="MG">MADAGASCAR</option>
                                                        <option value="MW">MALAWI</option>
                                                        <option value="MY">MALAYSIA</option>
                                                        <option value="MV">MALDIVES</option>
                                                        <option value="ML">MALI</option>
                                                        <option value="MT">MALTA</option>
                                                        <option value="MH">MARSHALL ISLANDS</option>
                                                        <option value="MQ">MARTINIQUE</option>
                                                        <option value="MR">MAURITANIA</option>
                                                        <option value="MU">MAURITIUS</option>
                                                        <option value="YT">MAYOTTE</option>
                                                        <option value="MX">MEXICO</option>
                                                        <option value="FM">MICRONESIA, FEDERATED STATES OF</option>
                                                        <option value="MD">MOLDOVA</option>
                                                        <option value="MC">MONACO</option>
                                                        <option value="MN">MONGOLIA</option>
                                                        <option value="MS">MONTSERRAT</option>
                                                        <option value="MA">MOROCCO</option>
                                                        <option value="MZ">MOZAMBIQUE</option>
                                                        <option value="MM">MYANMAR</option>
                                                        <option value="NA">NAMIBIA</option>
                                                        <option value="NR">NAURU</option>
                                                        <option value="NL">NETHERLAND</option>
                                                        <option value="NP">NEPAL</option>
                                                        <option value="NC">NETHERLANDS ANTILLES AN NEW CALEDONIA</option>
                                                        <option value="NZ">NEW ZEALAND</option>
                                                        <option value="NI">NICARAGUA</option>
                                                        <option value="NE">NIGER</option>
                                                        <option value="NG">NIGERIA</option>
                                                        <option value="NU">NIUE</option>
                                                        <option value="NF">NORFOLK ISLAND</option>
                                                        <option value="MP">NORTHERN MARIANA ISLANDS</option>
                                                        <option value="NO">NORWAY</option>
                                                        <option value="OM">OMAN</option>
                                                        <option value="PK">PAKISTAN</option>
                                                        <option value="PW">PALAU</option>
                                                        <option value="PS">PALESTINIAN TERRITORY,OCCUPIED</option>
                                                        <option value="PA">PANAMA</option>
                                                        <option value="PG">PAPUA NEW GUINEA</option>
                                                        <option value="PY">PARAGUAY</option>
                                                        <option value="PE">PERU</option>
                                                        <option value="PH">PHILIPPINES</option>
                                                        <option value="PN">PITCAIRN</option>
                                                        <option value="PL">POLAND</option>
                                                        <option value="PT">PORTUGAL</option>
                                                        <option value="PR">PUERTO RICO</option>
                                                        <option value="QA">QATAR</option>
                                                        <option value="RE">REUNION</option>
                                                        <option value="RO">ROMANIA</option>
                                                        <option value="RU">RUSSIAN FEDERATION</option>
                                                        <option value="RW">RWANDA</option>
                                                        <option value="SH">SAINT HELENA</option>
                                                        <option value="KN">SAINT KITTS AND NEVIS</option>
                                                        <option value="LC">SAINT LUCIA</option>
                                                        <option value="PM">SAINT PIERRE AND MIQUELON</option>
                                                        <option value="VC">SAINT VINCENT AND THE GRENADINES</option>
                                                        <option value="WS">SAMOA</option>
                                                        <option value="SM">SAN MARINO</option>
                                                        <option value="ST">SAO TOME AND PRINCIPE</option>
                                                        <option value="SA">SAUDI ARABIA</option>
                                                        <option value="SN">SENEGAL</option>
                                                        <option value="CS">SERBIA AND MONTENEGRO</option>
                                                        <option value="SC">SEYCHELLES</option>
                                                        <option value="SG">SINGAPORE</option>
                                                        <option value="SK">SLOVAKIA</option>
                                                        <option value="SB">SOLOMON ISLANDS</option>
                                                        <option value="SO">SOMALIA</option>
                                                        <option value="ZA">SOUTH AFRICA</option>
                                                        <option value="AND">SOUTH GEORGIA</option>
                                                        <option value="KR">SOUTH KOREA</option>
                                                        <option value="ES">SPAIN</option>
                                                        <option value="LK">SRI LANKA</option>
                                                        <option value="SD">SUDAN</option>
                                                        <option value="SR">SURINAME</option>
                                                        <option value="SJ">SVALBARD AND JAN MAYEN</option>
                                                        <option value="SZ">SWAZILAND</option>
                                                        <option value="SE">SWEDEN</option>
                                                        <option value="CH">SWITZERLAND</option>
                                                        <option value="SY">SYRIAN ARAB REPUBLIC</option>
                                                        <option value="TW">TAIWAN</option>
                                                        <option value="TJ">TAJIKISTAN</option>
                                                        <option value="TZ">TANZANIA, UNITED REPUBLIC OF</option>
                                                        <option value="TH">THAILAND</option>
                                                        <option value="GS">THE SOUTH SANDWICH ISLANDS</option>
                                                        <option value="TL">TIMOR-LESTE</option>
                                                        <option value="TG">TOGO</option>
                                                        <option value="TK">TOKELAU</option>
                                                        <option value="TO">TONGA</option>
                                                        <option value="TT">TRINIDAD AND TOBAGO</option>
                                                        <option value="TN">TUNISIA</option>
                                                        <option value="TR">TURKEY</option>
                                                        <option value="TM">TURKMENISTAN</option>
                                                        <option value="TC">TURKS AND CAICOS ISLANDS</option>
                                                        <option value="TV">TUVALU</option>
                                                        <option value="UG">UGANDA</option>
                                                        <option value="UA">UKRAINE</option>
                                                        <option value="AE">UNITED ARAB EMIRATES</option>
                                                        <option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option>
                                                        <option value="UY">URUGUAY</option>
                                                        <option value="UZ">UZBEKISTAN</option>
                                                        <option value="VU">VANUATU</option>
                                                        <option value="VA">VATICAN CITY STATE(HOLY SEE)</option>
                                                        <option value="VE">VENEZUELA</option>
                                                        <option value="VG">VIRGIN ISLANDS, BRITISH</option>
                                                        <option value="VI">VIRGIN ISLANDS, U.S.</option>
                                                        <option value="VN">VIET NAM</option>
                                                        <option value="WF">WALLIS AND FUTUNA</option>
                                                        <option value="YE">YEMEN</option>
                                                        <option value="ZM">ZAMBIA</option>
                                                        <option value="ZW">ZIMBABWE</option>
                                                </select>
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="shipping_zip"><span>*</span> Zip / Postal Code:</label>
                                                <input type="text" name="shipping_zip" id="zip" class="allInput" value="" maxlength="16"   />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="phone"><span>*</span> Phone:</label>
                                                <input type="text" name="shipping_phone" id="phone" class="allInput" value="" maxlength="320"   />
                                                <div class="errorInfo"></div>
                                        </li>
                                </ul>

                                <ul>
                                        <li class="actions">
                                                <label>&nbsp;</label>
                                                <input type="submit" id="shippingAddressSubmit" class="allbtn btn-chk-out" value=" " />
                                        </li>
                                </ul>
                        </form>
                </div>
        </div>
</div>