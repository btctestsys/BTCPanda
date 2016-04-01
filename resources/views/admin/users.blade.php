@extends('layouts.admin')

@section('content')

			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN BANKS PORTLET-->
					<div class="portlet light tasks-widget">
						<div class="portlet-body">

 	                        <div class="row">
			                    <form action="#" class="searchUser_form" id="searchUser_form" name="searchUser_form" method="get" onsubmit="/users">
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="hidden" id="typ" name="typ" class="form-control" placeholder="Enter Type" value="limited">
    										<select class="form-control" name="country" id="country">
												<option value="">Select Country</option>						
												<option @if($request->country == 'AF') selected @endif value="AF">Afghanistan</option>						
												<option @if($request->country == 'AL') selected @endif value="AL">Albania</option>						
												<option @if($request->country == 'DZ') selected @endif value="DZ">Algeria</option>						
												<option @if($request->country == 'AS') selected @endif value="AS">American Samoa</option>						
												<option @if($request->country == 'AD') selected @endif value="AD">Andorra</option>						
												<option @if($request->country == 'AO') selected @endif value="AO">Angola</option>						
												<option @if($request->country == 'AI') selected @endif value="AI">Anguilla</option>						
												<option @if($request->country == 'AQ') selected @endif value="AQ">Antarctica</option>						
												<option @if($request->country == 'AG') selected @endif value="AG">Antigua and Barbuda</option>						
												<option @if($request->country == 'AR') selected @endif value="AR">Argentina</option>						
												<option @if($request->country == 'AM') selected @endif value="AM">Armenia</option>						
												<option @if($request->country == 'AW') selected @endif value="AW">Aruba</option>						
												<option @if($request->country == 'AU') selected @endif value="AU">Australia</option>						
												<option @if($request->country == 'AT') selected @endif value="AT">Austria</option>						
												<option @if($request->country == 'AZ') selected @endif value="AZ">Azerbaijan</option>						
												<option @if($request->country == 'BS') selected @endif value="BS">Bahamas</option>						
												<option @if($request->country == 'BH') selected @endif value="BH">Bahrain</option>						
												<option @if($request->country == 'BD') selected @endif value="BD">Bangladesh</option>						
												<option @if($request->country == 'BB') selected @endif value="BB">Barbados</option>						
												<option @if($request->country == 'BY') selected @endif value="BY">Belarus</option>						
												<option @if($request->country == 'BE') selected @endif value="BE">Belgium</option>						
												<option @if($request->country == 'BZ') selected @endif value="BZ">Belize</option>						
												<option @if($request->country == 'BJ') selected @endif value="BJ">Benin</option>						
												<option @if($request->country == 'BM') selected @endif value="BM">Bermuda</option>						
												<option @if($request->country == 'BT') selected @endif value="BT">Bhutan</option>						
												<option @if($request->country == 'BO') selected @endif value="BO">Bolivia</option>						
												<option @if($request->country == 'BA') selected @endif value="BA">Bosnia and Herzegovina</option>						
												<option @if($request->country == 'BW') selected @endif value="BW">Botswana</option>						
												<option @if($request->country == 'BR') selected @endif value="BR">Brazil</option>						
												<option @if($request->country == 'IO') selected @endif value="IO">British Indian Ocean Territory</option>						
												<option @if($request->country == 'VG') selected @endif value="VG">British Virgin Islands</option>						
												<option @if($request->country == 'BN') selected @endif value="BN">Brunei</option>						
												<option @if($request->country == 'BG') selected @endif value="BG">Bulgaria</option>						
												<option @if($request->country == 'BF') selected @endif value="BF">Burkina Faso</option>						
												<option @if($request->country == 'BI') selected @endif value="BI">Burundi</option>						
												<option @if($request->country == 'KH') selected @endif value="KH">Cambodia</option>						
												<option @if($request->country == 'CM') selected @endif value="CM">Cameroon</option>						
												<option @if($request->country == 'CA') selected @endif value="CA">Canada</option>						
												<option @if($request->country == 'CV') selected @endif value="CV">Cape Verde</option>						
												<option @if($request->country == 'KY') selected @endif value="KY">Cayman Islands</option>						
												<option @if($request->country == 'CF') selected @endif value="CF">Central African Republic</option>						
												<option @if($request->country == 'TD') selected @endif value="TD">Chad</option>						
												<option @if($request->country == 'CL') selected @endif value="CL">Chile</option>						
												<option @if($request->country == 'CN') selected @endif value="CN">China</option>						
												<option @if($request->country == 'CX') selected @endif value="CX">Christmas Island</option>						
												<option @if($request->country == 'CC') selected @endif value="CC">Cocos Islands</option>						
												<option @if($request->country == 'CO') selected @endif value="CO">Colombia</option>						
												<option @if($request->country == 'KM') selected @endif value="KM">Comoros</option>						
												<option @if($request->country == 'CK') selected @endif value="CK">Cook Islands</option>						
												<option @if($request->country == 'CR') selected @endif value="CR">Costa Rica</option>						
												<option @if($request->country == 'HR') selected @endif value="HR">Croatia</option>						
												<option @if($request->country == 'CU') selected @endif value="CU">Cuba</option>						
												<option @if($request->country == 'CY') selected @endif value="CY">Cyprus</option>	
												<option @if($request->country == 'CZ') selected @endif value="CZ">Czech Republic</option>						
												<option @if($request->country == 'CZ') selected @endif value="CD">Democratic Republic of the Congo</option>						
												<option @if($request->country == 'DK') selected @endif value="DK">Denmark</option>						
												<option @if($request->country == 'DJ') selected @endif value="DJ">Djibouti</option>						
												<option @if($request->country == 'DM') selected @endif value="DM">Dominica</option>						
												<option @if($request->country == 'DO') selected @endif value="DO">Dominican Republic</option>						
												<option @if($request->country == 'TL') selected @endif value="TL">East Timor</option>						
												<option @if($request->country == 'EC') selected @endif value="EC">Ecuador</option>						
												<option @if($request->country == 'EG') selected @endif value="EG">Egypt</option>						
												<option @if($request->country == 'SV') selected @endif value="SV">El Salvador</option>	
												<option @if($request->country == 'GQ') selected @endif value="GQ">Equatorial Guinea</option>						
												<option @if($request->country == 'ER') selected @endif value="ER">Eritrea</option>						
												<option @if($request->country == 'EE') selected @endif value="EE">Estonia</option>						
												<option @if($request->country == 'ET') selected @endif value="ET">Ethiopia</option>						
												<option @if($request->country == 'FK') selected @endif value="FK">Falkland Islands</option>						
												<option @if($request->country == 'FO') selected @endif value="FO">Faroe Islands</option>						
												<option @if($request->country == 'FJ') selected @endif value="FJ">Fiji</option>						
												<option @if($request->country == 'FI') selected @endif value="FI">Finland</option>						
												<option @if($request->country == 'FR') selected @endif value="FR">France</option>						
												<option @if($request->country == 'PF') selected @endif value="PF">French Polynesia</option>						
												<option @if($request->country == 'GA') selected @endif value="GA">Gabon</option>						
												<option @if($request->country == 'GM') selected @endif value="GM">Gambia</option>				
												<option @if($request->country == 'GE') selected @endif value="GE">Georgia</option>						
												<option @if($request->country == 'DE') selected @endif value="DE">Germany</option>						
												<option @if($request->country == 'GH') selected @endif value="GH">Ghana</option>						
												<option @if($request->country == 'GI') selected @endif value="GI">Gibraltar</option>						
												<option @if($request->country == 'GR') selected @endif value="GR">Greece</option>						
												<option @if($request->country == 'GL') selected @endif value="GL">Greenland</option>						
												<option @if($request->country == 'GD') selected @endif value="GD">Grenada</option>						
												<option @if($request->country == 'GU') selected @endif value="GU">Guam</option>						
												<option @if($request->country == 'GT') selected @endif value="GT">Guatemala</option>						
												<option @if($request->country == 'GN') selected @endif value="GN">Guinea</option>						
												<option @if($request->country == 'GW') selected @endif value="GW">Guinea-Bissau</option>						
												<option @if($request->country == 'GY') selected @endif value="GY">Guyana</option>						
												<option @if($request->country == 'HT') selected @endif value="HT">Haiti</option>						
												<option @if($request->country == 'HN') selected @endif value="HN">Honduras</option>	
												<option @if($request->country == 'HU') selected @endif value="HU">Hungary</option>						
												<option @if($request->country == 'IS') selected @endif value="IS">Iceland</option>						
												<option @if($request->country == 'IN') selected @endif value="IN">India</option>						
												<option @if($request->country == 'ID') selected @endif value="ID">Indonesia</option>						
												<option @if($request->country == 'IR') selected @endif value="IR">Iran</option>						
												<option @if($request->country == 'IQ') selected @endif value="IQ">Iraq</option>						
												<option @if($request->country == 'IE') selected @endif value="IE">Ireland</option>						
												<option @if($request->country == 'IM') selected @endif value="IM">Isle of Man</option>						
												<option @if($request->country == 'IT') selected @endif value="IT">Italy</option>						
												<option @if($request->country == 'CI') selected @endif value="CI">Ivory Coast</option>						
												<option @if($request->country == 'JM') selected @endif value="JM">Jamaica</option>						
												<option @if($request->country == 'JP') selected @endif value="JP">Japan</option>						
												<option @if($request->country == 'JE') selected @endif value="JE">Jersey</option>						
												<option @if($request->country == 'JO') selected @endif value="JO">Jordan</option>		
												<option @if($request->country == 'KZ') selected @endif value="KZ">Kazakhstan</option>						
												<option @if($request->country == 'KE') selected @endif value="KE">Kenya</option>						
												<option @if($request->country == 'KI') selected @endif value="KI">Kiribati</option>						
												<option @if($request->country == 'KW') selected @endif value="KW">Kuwait</option>						
												<option @if($request->country == 'KG') selected @endif value="KG">Kyrgyzstan</option>						
												<option @if($request->country == 'LA') selected @endif value="LA">Laos</option>						
												<option @if($request->country == 'LV') selected @endif value="LV">Latvia</option>						
												<option @if($request->country == 'LB') selected @endif value="LB">Lebanon</option>						
												<option @if($request->country == 'LS') selected @endif value="LS">Lesotho</option>						
												<option @if($request->country == 'LR') selected @endif value="LR">Liberia</option>						
												<option @if($request->country == 'LY') selected @endif value="LY">Libya</option>						
												<option @if($request->country == 'LI') selected @endif value="LI">Liechtenstein</option>						
												<option @if($request->country == 'LT') selected @endif value="LT">Lithuania</option>						
												<option @if($request->country == 'LU') selected @endif value="LU">Luxembourg</option>
												<option @if($request->country == 'MO') selected @endif value="MO">Macao</option>						
												<option @if($request->country == 'MK') selected @endif value="MK">Macedonia</option>						
												<option @if($request->country == 'MG') selected @endif value="MG">Madagascar</option>						
												<option @if($request->country == 'MW') selected @endif value="MW">Malawi</option>						
												<option @if($request->country == 'MY') selected @endif value="MY">Malaysia</option>						
												<option @if($request->country == 'MV') selected @endif value="MV">Maldives</option>						
												<option @if($request->country == 'ML') selected @endif value="ML">Mali</option>						
												<option @if($request->country == 'MT') selected @endif value="MT">Malta</option>						
												<option @if($request->country == 'MH') selected @endif value="MH">Marshall Islands</option>						
												<option @if($request->country == 'MR') selected @endif value="MR">Mauritania</option>						
												<option @if($request->country == 'MU') selected @endif value="MU">Mauritius</option>						
												<option @if($request->country == 'YT') selected @endif value="YT">Mayotte</option>						
												<option @if($request->country == 'MX') selected @endif value="MX">Mexico</option>						
												<option @if($request->country == 'FM') selected @endif value="FM">Micronesia</option>		
												<option @if($request->country == 'MD') selected @endif value="MD">Moldova</option>						
												<option @if($request->country == 'MC') selected @endif value="MC">Monaco</option>						
												<option @if($request->country == 'MN') selected @endif value="MN">Mongolia</option>						
												<option @if($request->country == 'ME') selected @endif value="ME">Montenegro</option>						
												<option @if($request->country == 'MS') selected @endif value="MS">Montserrat</option>						
												<option @if($request->country == 'MA') selected @endif value="MA">Morocco</option>						
												<option @if($request->country == 'MZ') selected @endif value="MZ">Mozambique</option>						
												<option @if($request->country == 'MM') selected @endif value="MM">Myanmar</option>						
												<option @if($request->country == 'NA') selected @endif value="NA">Namibia</option>						
												<option @if($request->country == 'NR') selected @endif value="NR">Nauru</option>						
												<option @if($request->country == 'NP') selected @endif value="NP">Nepal</option>						
												<option @if($request->country == 'NL') selected @endif value="NL">Netherlands</option>						
												<option @if($request->country == 'AN') selected @endif value="AN">Netherlands Antilles</option>						
												<option @if($request->country == 'NC') selected @endif value="NC">New Caledonia</option>
												<option @if($request->country == 'NZ') selected @endif value="NZ">New Zealand</option>						
												<option @if($request->country == 'NI') selected @endif value="NI">Nicaragua</option>						
												<option @if($request->country == 'NE') selected @endif value="NE">Niger</option>						
												<option @if($request->country == 'NG') selected @endif value="NG">Nigeria</option>						
												<option @if($request->country == 'NU') selected @endif value="NU">Niue</option>						
												<option @if($request->country == 'KP') selected @endif value="KP">North Korea</option>						
												<option @if($request->country == 'MP') selected @endif value="MP">Northern Mariana Islands</option>						
												<option @if($request->country == 'NO') selected @endif value="NO">Norway</option>						
												<option @if($request->country == 'OM') selected @endif value="OM">Oman</option>						
												<option @if($request->country == 'PK') selected @endif value="PK">Pakistan</option>						
												<option @if($request->country == 'PW') selected @endif value="PW">Palau</option>						
												<option @if($request->country == 'PA') selected @endif value="PA">Panama</option>						
												<option @if($request->country == 'PG') selected @endif value="PG">Papua New Guinea</option>						
												<option @if($request->country == 'PY') selected @endif value="PY">Paraguay</option>
												<option @if($request->country == 'PE') selected @endif value="PE">Peru</option>						
												<option @if($request->country == 'PH') selected @endif value="PH">Philippines</option>						
												<option @if($request->country == 'PN') selected @endif value="PN">Pitcairn</option>						
												<option @if($request->country == 'PL') selected @endif value="PL">Poland</option>						
												<option @if($request->country == 'PT') selected @endif value="PT">Portugal</option>						
												<option @if($request->country == 'PR') selected @endif value="PR">Puerto Rico</option>						
												<option @if($request->country == 'QA') selected @endif value="QA">Qatar</option>						
												<option @if($request->country == 'CG') selected @endif value="CG">Republic of the Congo</option>						
												<option @if($request->country == 'RO') selected @endif value="RO">Romania</option>						
												<option @if($request->country == 'RU') selected @endif value="RU">Russia</option>						
												<option @if($request->country == 'RW') selected @endif value="RW">Rwanda</option>						
												<option @if($request->country == 'BL') selected @endif value="BL">Saint Barthelemy</option>	
												<option @if($request->country == 'SH') selected @endif value="SH">Saint Helena</option>						
												<option @if($request->country == 'KN') selected @endif value="KN">Saint Kitts and Nevis</option>						
												<option @if($request->country == 'LC') selected @endif value="LC">Saint Lucia</option>						
												<option @if($request->country == 'MF') selected @endif value="MF">Saint Martin</option>						
												<option @if($request->country == 'PM') selected @endif value="PM">Saint Pierre and Miquelon</option>						
												<option @if($request->country == 'WS') selected @endif value="WS">Samoa</option>						
												<option @if($request->country == 'SM') selected @endif value="SM">San Marino</option>						
												<option @if($request->country == 'ST') selected @endif value="ST">Sao Tome and Principe</option>						
												<option @if($request->country == 'SA') selected @endif value="SA">Saudi Arabia</option>						
												<option @if($request->country == 'SN') selected @endif value="SN">Senegal</option>						
												<option @if($request->country == 'RS') selected @endif value="RS">Serbia</option>						
												<option @if($request->country == 'SC') selected @endif value="SC">Seychelles</option>						
												<option @if($request->country == 'SL') selected @endif value="SL">Sierra Leone</option>						
												<option @if($request->country == 'SG') selected @endif value="SG">Singapore</option>						
												<option @if($request->country == 'SK') selected @endif value="SK">Slovakia</option>						
												<option @if($request->country == 'SI') selected @endif value="SI">Slovenia</option>
												<option @if($request->country == 'SB') selected @endif value="SB">Solomon Islands</option>						
												<option @if($request->country == 'SO') selected @endif value="SO">Somalia</option>						
												<option @if($request->country == 'ZA') selected @endif value="ZA">South Africa</option>						
												<option @if($request->country == 'GS') selected @endif value="GS">South Georgia and the South Sandwich Islands</option>						
												<option @if($request->country == 'KR') selected @endif value="KR">South Korea</option>						
												<option @if($request->country == 'ES') selected @endif value="ES">Spain</option>						
												<option @if($request->country == 'LK') selected @endif value="LK">Sri Lanka</option>						
												<option @if($request->country == 'SD') selected @endif value="SD">Sudan</option>						
												<option @if($request->country == 'SR') selected @endif value="SR">Suriname</option>						
												<option @if($request->country == 'SJ') selected @endif value="SJ">Svalbard and Jan Mayen</option>						
												<option @if($request->country == 'SZ') selected @endif value="SZ">Swaziland</option>						
												<option @if($request->country == 'SE') selected @endif value="SE">Sweden</option>						
												<option @if($request->country == 'CH') selected @endif value="CH">Switzerland</option>						
												<option @if($request->country == 'SY') selected @endif value="SY">Syria</option>						
												<option @if($request->country == 'TW') selected @endif value="TW">Taiwan</option>						
												<option @if($request->country == 'TJ') selected @endif value="TJ">Tajikistan</option>						
												<option @if($request->country == 'TZ') selected @endif value="TZ">Tanzania</option>						
												<option @if($request->country == 'TH') selected @endif value="TH">Thailand</option>	
												<option @if($request->country == 'TG') selected @endif value="TG">Togo</option>						
												<option @if($request->country == 'TK') selected @endif value="TK">Tokelau</option>						
												<option @if($request->country == 'TO') selected @endif value="TO">Tonga</option>						
												<option @if($request->country == 'TT') selected @endif value="TT">Trinidad and Tobago</option>						
												<option @if($request->country == 'TN') selected @endif value="TN">Tunisia</option>						
												<option @if($request->country == 'TR') selected @endif value="TR">Turkey</option>						
												<option @if($request->country == 'TM') selected @endif value="TM">Turkmenistan</option>						
												<option @if($request->country == 'TC') selected @endif value="TC">Turks and Caicos Islands</option>						
												<option @if($request->country == 'TV') selected @endif value="TV">Tuvalu</option>						
												<option @if($request->country == 'VI') selected @endif value="VI">U.S. Virgin Islands</option>						
												<option @if($request->country == 'UG') selected @endif value="UG">Uganda</option>						
												<option @if($request->country == 'UA') selected @endif value="UA">Ukraine</option>						
												<option @if($request->country == 'AE') selected @endif value="AE">United Arab Emirates</option>						
												<option @if($request->country == 'GB') selected @endif value="GB">United Kingdom</option>						
												<option @if($request->country == 'UY') selected @endif value="UY">Uruguay</option>						
												<option @if($request->country == 'UZ') selected @endif value="UZ">Uzbekistan</option>	
												<option @if($request->country == 'VU') selected @endif value="VU">Vanuatu</option>						
												<option @if($request->country == 'VA') selected @endif value="VA">Vatican</option>						
												<option @if($request->country == 'VE') selected @endif value="VE">Venezuela</option>						
												<option @if($request->country == 'VN') selected @endif value="VN">Vietnam</option>						
												<option @if($request->country == 'WF') selected @endif value="WF">Wallis and Futuna</option>						
												<option @if($request->country == 'EH') selected @endif value="EH">Western Sahara</option>						
												<option @if($request->country == 'YE') selected @endif value="YE">Yemen</option>						
												<option @if($request->country == 'ZM') selected @endif value="ZM">Zambia</option>						
												<option @if($request->country == 'ZW') selected @endif value="ZW">Zimbabwe</option>						
											
    										</select>
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="text" id="tbname" name="tbname" class="form-control" placeholder="Enter Name" value="{{$request->tbname}}">
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="text" value="{{$request->tbuname}}" id="tbuname" name="tbuname" class="form-control" placeholder="Enter Username">
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="text" value="{{$request->tbwallet}}" id="tbwallet" name="tbwallet" class="form-control" placeholder="Enter Wallet">
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="text" value="{{$request->tbemail}}" id="tbemail" name="tbemail" class="form-control" placeholder="Enter Email">
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
									            <span class="input-group-btn">
												<table><tr><td>
									            <button class="btn blue" id="searchUser_btn" name="searchUser_btn" onclick="javascript:searchUser_form.typ.value='limited';">Search</button>
												</td><td width="10px;">&nbsp;
												</td><td>
									            <button class="btn blue" id="viewall_btn" name="viewall_btn" onclick="javascript:searchUser_form.typ.value='all';">View All</button>
												</td></tr></table>
									            </span>
				                            </div>
				                        </div>

                                </form>
		                    </div>
							<table class="table table-striped table-bordered table-hover" id="sample_1">
								<thead>
									<th>ID</th>
									<th>Ctry</th>
									<th>Name</th>
									<th>Member</td>
									<th>Email</th>
									<th>Pins</th>
									<th>Level</th>
									<th align=right>PH</th>
								</thead>
								<tbody>
									{{--*/ $user_cnt =  1 /*--}}
									{{--*/ $total_ph =  1 /*--}}
									@foreach($users	 as $output)
									<tr>
										<td><a href="/master/login/id/{{$output->id}}">{{$output->id}}</a></td>
										<td>{{$output->country}}&nbsp;</td>
										<td>{{$output->name}}</td>
										<td><a href="/master/login/id/{{$output->id}}">{{$output->username}}</a>({{round($output->uph,2)}})
										-> <a href="/master/login/id/{{$output->sid}}">{{$output->susername}}</a>({{round($output->sph,2)}})
										-> <a href="/master/login/id/{{$output->sid1}}">{{$output->susername1}}</a>({{round($output->sph1,2)}})</td>
										<td>{{$output->email}} 
										</td>
										<td>@if($output->bamboo_balance) {{$output->bamboo_balance}} @endif&nbsp;</td>
										<td>@if($output->level_id){{$output->level_id}} @endif&nbsp;</td>
										<td align=right>{{round($output->uph,2)}}&nbsp;</td>
									</tr>
									{{--*/ $user_cnt =  $user_cnt + 1 /*--}}
									{{--*/ $total_ph =  $total_ph + $output->uph /*--}}
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan=7>Total</td>
										<td align=right>{{round($total_ph,2)}} &nbsp;</td>
									</tr>
								</tfoot>
							</table>

						</div>
					</div>
					<!-- END BANKS PORTLET-->
				</div>
			</div>


@stop

@section('js')
@stop

@section('docready')
<script type="text/javascript">
$(document).ready(function($) {
	//
});

jQuery(document).ready(function () {
	TableAdvanced.init()


});
</script>
@stop