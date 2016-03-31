@extends('layouts.static')

@section('content')
        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class=" card-box">
                <div class="panel-heading">
                    <h3 class="text-center"> {{trans('main.register_for')}} <strong class="text-custom"><span>BTC <img src="/assets/images/avatar.jpg" height="50"> Panda</span></strong></h3>
                </div>

                <div class="panel-body">


<table>
<?php 


    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
?>
<?php 


    foreach ($_GET as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
?>
</table>

                    @if (count($errors) > 0)
                    <div class="alert alert-danger"><ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul></div>
                    @endif                
                    <form id="form-reg" name="form-reg" class="form-reg" method="POST" action="/auth/register">{!! csrf_field() !!}
                    
                        <div class="form-group ">
                            
                            <div class="col-xs-12">
                                <label class="m-b-15">{{trans('main.referral_required')}}</label>
                                <input class="form-control" type="text" required="" id="referral" name="referral" placeholder="{{trans('main.referral_username')}}" value="<?php @$username = explode('/',$_SERVER['REQUEST_URI']);echo @$username[2] ?>">
                            </div>
                        </div>

                        <hr/>

                        <div class="form-group ">
                            <div class="col-xs-12">
								{{trans('main.register_name')}}
                                <input class="form-control" type="text" required="" id="name" name="name" placeholder="{{trans('main.full_name')}}" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" id="username" name="username" placeholder="{{trans('main.username')}}" value="{{ old('username') }}">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" required="" id="email" name="email" placeholder="{{trans('main.email')}}">
                            </div>
                        </div>
						
						<div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="number" required="" id="mobile" name="mobile" placeholder="{{trans('main.mobile')}}">
                            </div>
                        </div>

						<div class="form-group">
                            <div class="col-xs-12">
    							<select class="form-control" name="country" id="country">
									<option value="">Please Choose Country</option>						
									<option value="AF">Afghanistan</option>						
									<option value="AL">Albania</option>						
									<option value="DZ">Algeria</option>						
									<option value="AS">American Samoa</option>						
									<option value="AD">Andorra</option>						
									<option value="AO">Angola</option>						
									<option value="AI">Anguilla</option>						
									<option value="AQ">Antarctica</option>						
									<option value="AG">Antigua and Barbuda</option>						
									<option value="AR">Argentina</option>						
									<option value="AM">Armenia</option>						
									<option value="AW">Aruba</option>						
									<option value="AU">Australia</option>						
									<option value="AT">Austria</option>						
									<option value="AZ">Azerbaijan</option>						
									<option value="BS">Bahamas</option>						
									<option value="BH">Bahrain</option>						
									<option value="BD">Bangladesh</option>						
									<option value="BB">Barbados</option>						
									<option value="BY">Belarus</option>						
									<option value="BE">Belgium</option>						
									<option value="BZ">Belize</option>						
									<option value="BJ">Benin</option>						
									<option value="BM">Bermuda</option>						
									<option value="BT">Bhutan</option>						
									<option value="BO">Bolivia</option>						
									<option value="BA">Bosnia and Herzegovina</option>						
									<option value="BW">Botswana</option>						
									<option value="BR">Brazil</option>						
									<option value="IO">British Indian Ocean Territory</option>						
									<option value="VG">British Virgin Islands</option>						
									<option value="BN">Brunei</option>						
									<option value="BG">Bulgaria</option>						
									<option value="BF">Burkina Faso</option>						
									<option value="BI">Burundi</option>						
									<option value="KH">Cambodia</option>						
									<option value="CM">Cameroon</option>						
									<option value="CA">Canada</option>						
									<option value="CV">Cape Verde</option>						
									<option value="KY">Cayman Islands</option>						
									<option value="CF">Central African Republic</option>						
									<option value="TD">Chad</option>						
									<option value="CL">Chile</option>						
									<option value="CN">China</option>						
									<option value="CX">Christmas Island</option>						
									<option value="CC">Cocos Islands</option>						
									<option value="CO">Colombia</option>						
									<option value="KM">Comoros</option>						
									<option value="CK">Cook Islands</option>						
									<option value="CR">Costa Rica</option>						
									<option value="HR">Croatia</option>						
									<option value="CU">Cuba</option>						
									<option value="CY">Cyprus</option>	
									<option value="CZ">Czech Republic</option>						
									<option value="CD">Democratic Republic of the Congo</option>						
									<option value="DK">Denmark</option>						
									<option value="DJ">Djibouti</option>						
									<option value="DM">Dominica</option>						
									<option value="DO">Dominican Republic</option>						
									<option value="TL">East Timor</option>						
									<option value="EC">Ecuador</option>						
									<option value="EG">Egypt</option>						
									<option value="SV">El Salvador</option>	
									<option value="GQ">Equatorial Guinea</option>						
									<option value="ER">Eritrea</option>						
									<option value="EE">Estonia</option>						
									<option value="ET">Ethiopia</option>						
									<option value="FK">Falkland Islands</option>						
									<option value="FO">Faroe Islands</option>						
									<option value="FJ">Fiji</option>						
									<option value="FI">Finland</option>						
									<option value="FR">France</option>						
									<option value="PF">French Polynesia</option>						
									<option value="GA">Gabon</option>						
									<option value="GM">Gambia</option>				
									<option value="GE">Georgia</option>						
									<option value="DE">Germany</option>						
									<option value="GH">Ghana</option>						
									<option value="GI">Gibraltar</option>						
									<option value="GR">Greece</option>						
									<option value="GL">Greenland</option>						
									<option value="GD">Grenada</option>						
									<option value="GU">Guam</option>						
									<option value="GT">Guatemala</option>						
									<option value="GN">Guinea</option>						
									<option value="GW">Guinea-Bissau</option>						
									<option value="GY">Guyana</option>						
									<option value="HT">Haiti</option>						
									<option value="HN">Honduras</option>	
									<option value="HU">Hungary</option>						
									<option value="IS">Iceland</option>						
									<option value="IN">India</option>						
									<option value="ID">Indonesia</option>						
									<option value="IR">Iran</option>						
									<option value="IQ">Iraq</option>						
									<option value="IE">Ireland</option>						
									<option value="IM">Isle of Man</option>						
									<option value="IT">Italy</option>						
									<option value="CI">Ivory Coast</option>						
									<option value="JM">Jamaica</option>						
									<option value="JP">Japan</option>						
									<option value="JE">Jersey</option>						
									<option value="JO">Jordan</option>		
									<option value="KZ">Kazakhstan</option>						
									<option value="KE">Kenya</option>						
									<option value="KI">Kiribati</option>						
									<option value="KW">Kuwait</option>						
									<option value="KG">Kyrgyzstan</option>						
									<option value="LA">Laos</option>						
									<option value="LV">Latvia</option>						
									<option value="LB">Lebanon</option>						
									<option value="LS">Lesotho</option>						
									<option value="LR">Liberia</option>						
									<option value="LY">Libya</option>						
									<option value="LI">Liechtenstein</option>						
									<option value="LT">Lithuania</option>						
									<option value="LU">Luxembourg</option>
									<option value="MO">Macao</option>						
									<option value="MK">Macedonia</option>						
									<option value="MG">Madagascar</option>						
									<option value="MW">Malawi</option>						
									<option value="MY">Malaysia</option>						
									<option value="MV">Maldives</option>						
									<option value="ML">Mali</option>						
									<option value="MT">Malta</option>						
									<option value="MH">Marshall Islands</option>						
									<option value="MR">Mauritania</option>						
									<option value="MU">Mauritius</option>						
									<option value="YT">Mayotte</option>						
									<option value="MX">Mexico</option>						
									<option value="FM">Micronesia</option>		
									<option value="MD">Moldova</option>						
									<option value="MC">Monaco</option>						
									<option value="MN">Mongolia</option>						
									<option value="ME">Montenegro</option>						
									<option value="MS">Montserrat</option>						
									<option value="MA">Morocco</option>						
									<option value="MZ">Mozambique</option>						
									<option value="MM">Myanmar</option>						
									<option value="NA">Namibia</option>						
									<option value="NR">Nauru</option>						
									<option value="NP">Nepal</option>						
									<option value="NL">Netherlands</option>						
									<option value="AN">Netherlands Antilles</option>						
									<option value="NC">New Caledonia</option>
									<option value="NZ">New Zealand</option>						
									<option value="NI">Nicaragua</option>						
									<option value="NE">Niger</option>						
									<option value="NG">Nigeria</option>						
									<option value="NU">Niue</option>						
									<option value="KP">North Korea</option>						
									<option value="MP">Northern Mariana Islands</option>						
									<option value="NO">Norway</option>						
									<option value="OM">Oman</option>						
									<option value="PK">Pakistan</option>						
									<option value="PW">Palau</option>						
									<option value="PA">Panama</option>						
									<option value="PG">Papua New Guinea</option>						
									<option value="PY">Paraguay</option>
									<option value="PE">Peru</option>						
									<option value="PH">Philippines</option>						
									<option value="PN">Pitcairn</option>						
									<option value="PL">Poland</option>						
									<option value="PT">Portugal</option>						
									<option value="PR">Puerto Rico</option>						
									<option value="QA">Qatar</option>						
									<option value="CG">Republic of the Congo</option>						
									<option value="RO">Romania</option>						
									<option value="RU">Russia</option>						
									<option value="RW">Rwanda</option>						
									<option value="BL">Saint Barthelemy</option>	
									<option value="SH">Saint Helena</option>						
									<option value="KN">Saint Kitts and Nevis</option>						
									<option value="LC">Saint Lucia</option>						
									<option value="MF">Saint Martin</option>						
									<option value="PM">Saint Pierre and Miquelon</option>						
									<option value="WS">Samoa</option>						
									<option value="SM">San Marino</option>						
									<option value="ST">Sao Tome and Principe</option>						
									<option value="SA">Saudi Arabia</option>						
									<option value="SN">Senegal</option>						
									<option value="RS">Serbia</option>						
									<option value="SC">Seychelles</option>						
									<option value="SL">Sierra Leone</option>						
									<option value="SG">Singapore</option>						
									<option value="SK">Slovakia</option>						
									<option value="SI">Slovenia</option>
									<option value="SB">Solomon Islands</option>						
									<option value="SO">Somalia</option>						
									<option value="ZA">South Africa</option>						
									<option value="GS">South Georgia and the South Sandwich Islands</option>						
									<option value="KR">South Korea</option>						
									<option value="ES">Spain</option>						
									<option value="LK">Sri Lanka</option>						
									<option value="SD">Sudan</option>						
									<option value="SR">Suriname</option>						
									<option value="SJ">Svalbard and Jan Mayen</option>						
									<option value="SZ">Swaziland</option>						
									<option value="SE">Sweden</option>						
									<option value="CH">Switzerland</option>						
									<option value="SY">Syria</option>						
									<option value="TW">Taiwan</option>						
									<option value="TJ">Tajikistan</option>						
									<option value="TZ">Tanzania</option>						
									<option value="TH">Thailand</option>	
									<option value="TG">Togo</option>						
									<option value="TK">Tokelau</option>						
									<option value="TO">Tonga</option>						
									<option value="TT">Trinidad and Tobago</option>						
									<option value="TN">Tunisia</option>						
									<option value="TR">Turkey</option>						
									<option value="TM">Turkmenistan</option>						
									<option value="TC">Turks and Caicos Islands</option>						
									<option value="TV">Tuvalu</option>						
									<option value="VI">U.S. Virgin Islands</option>						
									<option value="UG">Uganda</option>						
									<option value="UA">Ukraine</option>						
									<option value="AE">United Arab Emirates</option>						
									<option value="GB">United Kingdom</option>						
									<option value="UY">Uruguay</option>						
									<option value="UZ">Uzbekistan</option>	
									<option value="VU">Vanuatu</option>						
									<option value="VA">Vatican</option>						
									<option value="VE">Venezuela</option>						
									<option value="VN">Vietnam</option>						
									<option value="WF">Wallis and Futuna</option>						
									<option value="EH">Western Sahara</option>						
									<option value="YE">Yemen</option>						
									<option value="ZM">Zambia</option>						
									<option value="ZW">Zimbabwe</option>						
    							</select>
							</div>
						</div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" id="password" name="password" placeholder="{{trans('main.password')}}" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" id="password_confirmation" name="password_confirmation" placeholder="{{trans('main.confirm_password')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox" checked="checked">
                                    <label for="checkbox-signup">{{trans('main.i_accept')}} <a href="#">{{trans('main.tnc')}}</a></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
                                    {{trans('main.register')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    <p>
                        {{trans('main.already_have')}}<a href="/login" class="text-primary m-l-5"><b>{{trans('main.login')}}</b></a>
                    </p>
                </div>

                <div class="text-center"><a href="/lang/en">English</a> | <a href="/lang/cn">华语</a> | <a href="/lang/id">Indonesia</a></div>
            </div>

        </div>
@stop

@section('js')
@stop

@section('docready')
jQuery(document).ready(function () {
	$('#form-reg').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			referral: {
				required: true
			},
			name: {
				required: true
			},
			username: {
				required: true
			},
			email: {
				required: true
			},
			country: {
				required: true
			},
			password: {
				required: true
			},
			password_confirmation: {
				required: true,
				equalTo: password
			}
		},

		messages: { // custom messages for input
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
		},

		highlight: function (element) { // hightlight error inputs
			$(element)
					.closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},

		errorPlacement: function (error, element) {
			if (element.closest('.input-icon').size() === 1) {
				error.insertAfter(element.closest('.input-icon'));
			} else {
				error.insertAfter(element);
			}
		},

		submitHandler: function (form) {
		}

	});
});

@stop