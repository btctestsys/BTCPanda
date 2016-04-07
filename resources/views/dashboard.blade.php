@extends('layouts.master')

@section('content')
@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif
<!-- Announcement -->
	<div class="modal fade" id="announce1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">New PH Ruling</h4>
				</div>
				<div class="modal-body">
					<h3 class="text-dark"> <small>26 January 2016</small></h3>
					<p >
					Dear Members,<br>
					<br>
					Please be informed that starting from 26th January 2016, the Referral Bonus and UniLevel Bonus for subsequent Provide Help (PH) will only be awarded to the respective recipients as long as there is no 'Get Help' (GH) request. If a GH happened, the new 'Providing Help' (PH) in the same calender month must be more than the GH amount of the said month before the Referral Bonus and UniLevel Bonus is awarded.
					<br><br>
					Sincerely,<br>
					BTCPanda.com Team <br>
	
						<br>
  					</p>
				</div>
				<div class="modal-footer">
					<button type="button" name="btnClose" id="btnClose" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="announce2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">New Marketing Plan 2016</h4>
				</div>
				<div class="modal-body">
					<h3 class="text-dark"> <small>4 February 2016</small></h3>
					<p >
					Dear Members/Helpers,<br>
					<br>
					Thank you for your support in our BTCPanda Global Crowdfunding System.<br>
					<br>
					As you are aware, BTCPanda is a Crowdfunding Structured Network. It is a global community project based on honesty and trust of the members and based on peer to peer crowdfunding platform.
					This allows you to raise finance from a 'crowd' of large and small investors who can pool money and digital currencies together, bringing a new source of money for you that never existed before.
					<br><br>
					BTCPanda is committed to ensure our platform is secure and our investors' interest are well protected. We will not hesitate to terminate any member who is dishonest and trying to manipulate our system.
					<br><br>
					As such, starting from 1st March 2016, we will introduce our new global marketing plan as below :  
					<br><br>
					Click the following link to download: <a href="/download/BTCPanda_plan_2016.pdf">pdf</a> or <a href="/download/BTCPanda_plan_2016.pps">powerpoint slide show</a>
					<br><br>
					We will also introduce new ruling to our system, effective immediately :
					<br>
					<ul>
						<li>New registered account with no Provide Help (PH) after SEVEN days will be terminated. <br>
						<li>Email address and mobile number is locked and cannot be changed permanently. No change request will be entertained.<br>
						<li>Each account will be locked with two withdrawal wallet addresses for enhanced security reason. You will have one opportunity to define this at any time before next withdrawal.<br>
						<li>It is members responsibility to ensure the amount of Provide Help (PH) in their wallet is intact before it reach 100% distribution. If at any time before 100% distribution completed, system detected unauthorised withdrawal by any member, the said account will be immediately suspended.<br>
					</ul>	
					<br><br>
					Sincerely,<br>
					BTCPanda.com Team <br>
  					</p>
				</div>
				<div class="modal-footer">
					<button type="button" name="btnClose" id="btnClose" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="announce3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Reset Wallet Address & Phone Number</h4>
				</div>
				<div class="modal-body">
					<h3 class="text-dark"> <small>18 February 2016</small></h3>
					<p >
					Dear Members/Helpers,<br>
					<br>
					We are currently experiencing high volume of requests to reset the wallet address and phone number.
					If you would like to request to reset the wallet address or phone number, please ensure the following steps already completed: 
					<ul>
						<li>Enter and verify mobile phone number in My Setting. <br>
						<li>Define country in My Setting. <br>
						<li>Enter Identification Number and upload document in My Setting. <br>
						<li>Submit video testimonial in My Setting. <br>
					</ul>	
					<br>
					Once you have fulfilled the above requirements, you may email your request to the <a href="mailto:support@btcpanda.com">support@btcpanda.com</a> 
					by attaching the proof of Identification Document and put the "RESET WALLET ADDRESS" or "RESET PHONE NUMBER" 
					or "RESET WALLET ADDRESS & PHONE NUMBER" in the email title. If any of the above is not completed we will 
					not entertain your request.
					<br><br>
					Please note that we only entertain this request ONCE. Therefore, please make sure you entered correct address once
					we reset it. Please allow 3 to 5 days for us to process your request.
 					<br><br>
					Sincerely,<br>
					BTCPanda.com Team <br>
 					</p>
				</div>
				<div class="modal-footer">
					<button type="button" name="btnClose" id="btnClose" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="announce4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">System Enhancement</h4>
				</div>
				<div class="modal-body">
					<h3 class="text-dark"> <small>19 February 2016</small></h3>
					<p >
					Dear Members/Helpers,<br>
					<br>
					We are upgrading our system to ensure all the provide help, get help and withdrawals can be processed without prejudice. This is especially taking into consideration that blockchain wallet transactions requires three confirmations before the transaction is recognized.
					<br>
					<br>
					Therefore, we are introducing transaction gap of 30 minutes. Any PH, GH or Withdrawal will trigger a 30 minutes waiting time before you will be allowed to make another transaction. The system will indicate the <strong>Next Transaction in:</strong> at the top page for you to easily track when you can make the transaction.
					<br>
					<br>
					Please contact <a href="mailto:support@btcpanda.com">support@btcpanda.com</a> should you have any concern or require help on this matter.
					<br>
					<br>
					Sincerely,<br>
					BTCPanda.com Team <br>
 					</p>
				</div>
				<div class="modal-footer">
					<button type="button" name="btnClose" id="btnClose" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="announce5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Receive OTP via Email</h4>
				</div>
				<div class="modal-body">
					<h3 class="text-dark"> <small>28 February 2016</small></h3>
					<p >
					Dear Members/Helpers,<br>
					<br>
					Good news! We have added a new way to receive your OTP. You can now receive OTP via email. To do this, go to My Setting and update your OTP Delivery. You may choose either Email or Mobile Phone.
					<br>
					<br>
					Thank you for your support.
					<br>
					<br>
					Sincerely,<br>
					BTCPanda.com Team <br>
 					</p>
				</div>
				<div class="modal-footer">
					<button type="button" name="btnClose" id="btnClose" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="announce6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Top DSV Competition</h4>
				</div>
				<div class="modal-body">
					<h3 class="text-dark"> <small>28 February 2016</small></h3>
					<p >
					Dear Members/Helpers,<br>
					<br>
					Good news! In conjunction with the launching of our new marketing plan, BTCPanda has come up with a new challenge for all members for the month of March. 
					<br><br>
					Top 3 highest Direct Sales Volume (DSV) will receive :- <br>
					1.) winner : 500 pins (Worth USD5,000.00)<br>
					2.) runner up: 300 pins (Worth USD3,000.00)<br>
					3.) 2nd runner up : 100 pins (Worth USD1,000.00)<br>
					 <br>
					This challange is exclusively for the month of March only. Challenge ends at 23:59 31st March. <br>
					<br>
					Reward will be credited to qualifiers account within the first week of April.<br>
					<br>
					Thank you for your continous support in BTCPanda.<br>
					<br>
					Sincerely,<br>
					BTCPanda.com Team <br>
 					</p>
				</div>
				<div class="modal-footer">
					<button type="button" name="btnClose" id="btnClose" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="announce7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Implementation of New Marketing Plan</h4>
				</div>
				<div class="modal-body">
					<h3 class="text-dark"> <small>3 March 2016</small></h3>
					<p >
					Dear Members/Helpers,<br>
					<br>
					Thank you for your support in our BTCPanda Global Crowdfunding System.
					<br>
					<br>
					In line with our announcement on the 4th Feb 2016 to introduced our new marketing plan and system, we are glad to inform that the new marketing 
					plan is already enforced starting 1st March 2016.
					<br>
					<br>
					Please click the following link to download: pdf or PowerPoint slide of new marketing plan : 
					<a href="/download/BTCPanda_plan_2016.pdf">pdf</a> or <a href="/download/BTCPanda_plan_2016.pps">powerpoint slide show</a>
					<br>
					<br>
					We also introduce new ruling to our system, effective immediately: 
					<br>
					<br>
					Email address and mobile number is locked and cannot be changed permanently. No change request will be entertained unless with some concrete 
					reasons and it is 100% admin's prerogative to allow such changes. Each account will be locked with two withdrawal wallet addresses for enhanced 
					security reason. You will only have one opportunity to define this at any time before next withdrawal.
					<br>
					<br>
					It is members responsibility to ensure the amount of Provide Help (PH) in their wallet is intact and in sync with PH amount before it reach 
					100% distribution. If at any time before 100% distribution completed, system detected unauthorised withdrawal by any member, the said account 
					will not be eligible for Getting Help (GH).
					<br>
					<br>
					The system will change from current FIFO (First In First Out) to Intelligence  Randomise System (IRS) for more efficient way of PH and GH. Hence, 
					in order for you to become eligible of Getting Help (GH), you MUST meet two requirements, which are :
					<br>
						1.  The PH bitcoin is 100% distributed. 
					<br>
						2.  Achieved a PH Maturity of 15 days.
					<br>
					<br>
					The objective of the new marketing plan is to promote a better and healthier  eco-system for everyone to enjoy the benefits together equally. 
					<br>
					<br>
					Sincerely,<br>
					BTCPanda.com Team <br>
 					</p>
				</div>
				<div class="modal-footer">
					<button type="button" name="btnClose" id="btnClose" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="announce8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Announcing DSV March 2016 Competition Winner</h4>
				</div>
				<div class="modal-body">
					<h3 class="text-dark"> <small>1 April 2016</small></h3>
					<p >
					Dear Members/Helpers,<br>
					<br>
					<img src="/download/aaron.jpg" width=300>
					<br>
					<br>
					We are pleased to announce to you the DSV March 2016 Competition is won by aarondegosu from Malaysia with total DSV of 430.71 BTC.
					<br><br>
					Top 3 Winners are as follow: 
					<br><br>
					1) aarondegosu (Malaysia)	430.71 BTC - 500 pins prize<br>
					2) divendraa (Malaysia) 421.92 BTC - 300 pins prize<br>
					3) LIM5927MY (Malaysia) 409.09 BTC - 100 pins prize<br>
					<br>
					Congratulation to all winners and the prizes has been credited to the winners accordingly.
					<br><br>
					Sincerely,
					<br><br>
					BTCPanda.com Team <br>
 					</p>
				</div>
				<div class="modal-footer">
					<button type="button" name="btnClose" id="btnClose" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="announce9" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">April 2016 Promotion</h4>
				</div>
				<div class="modal-body">
					<h3 class="text-dark"> <small>1 April 2016</small></h3>
					<p >
					Dear Members/Helpers,<br>
					<br>
					Due to huge success of previous promotion, we are pleased to announce new promotion for April.<br>
					<br>
					First of all, we would invite everyone for the Be a Leader Promotion. In this challenge, everyone who achieve and maintain the Manager position shall be awarded as follow:- <br>
					1) Be a Charity Helper (CH) - 100 pins (Worth USD1,000.00)<br>
					2) Be a Angel Helper (AH) - 200 pins (Worth USD2,000.00)<br>
					3) Be a Venture Helper (VH) - 300 pins (Worth USD3,000.00)<br>
					4) Be a Philanthropist (P) - 700 pins (Worth USD7,000.00)<br>
					<br>
					To be eligible for the Be a Leader Promotion, you must earn higher manager title than the last title in March. For example, if your title in March was Charity Helper, then you must be at least Angel Helper in April to be eligible. You must also retain the title until end of April to be eligible.<br>
					<br>
					Secondly, we shall continue the Top DSV Promotion for month of April too. Top 3 highest Direct Sales Volume (DSV) will receive :- <br>
					1) winner : 500 pins (Worth USD5,000.00)<br>
					2) runner up: 300 pins (Worth USD3,000.00)<br>
					3) 2nd runner up : 100 pins (Worth USD1,000.00)<br>
					<br>
					This challange is exclusively for the month of April 2016 only. Challenge ends at 23:59 30th April 2016. <br>
					<br>
					Reward will be credited to qualifiers account within the first week of May 2016.<br>
					<br>
					Thank you for your continous support in BTCPanda.<br>
					<br>
					Sincerely,<br>
					BTCPanda.com Team <br>
 					</p>
				</div>
				<div class="modal-footer">
					<button type="button" name="btnClose" id="btnClose" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

<!-- Page-Title -->
<div class="row">
	<div class="col-sm-12">
		<h4 class="page-title">Dashboard</h4>
		<p class="text-muted page-title-alt">Welcome to BTCPanda.com</p>
	</div>
</div>

<div class="row">
<!-- Statistics -->
	<div class="col-md-12 col-lg-12">
		<div class="row">
			<div class="col-md-3 col-lg-3">
				<a href="/provide_help">
				<div class="widget-bg-color-icon card-box fadeInDown animated">
					<div class="bg-icon bg-icon-info pull-left">
						<i class="fa fa-bitcoin text-info"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><b class="counter">{{$referrals_active}}</b> {{trans('main.active')}}</h3>
						<p class="text-muted">{{trans('main.direct_sponsor')}}</p>
					</div>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>

			<div class="col-md-3 col-lg-3">
				<a href="/referral">
				<div class="widget-bg-color-icon card-box">
					<div class="bg-icon bg-icon-inverse pull-left">
						<i class="fa fa-heartbeat text-inverse"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><b class="counter"> {{$referrals_active }}</b></h3>
						<p class="text-muted">{{trans('main.direct_sponsor')}}</p>
					</div>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>

			<div class="col-md-3 col-lg-3">
				<a href="/unitree">
				<div class="widget-bg-color-icon card-box fadeInDown animated">
					<div class="bg-icon bg-icon-info pull-left">
						<i class="fa fa-bitcoin text-info"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round($DSV_amount,4)}}</b> </h3>
						<p class="text-muted">Direct Sales Volume</p>
					</div>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>

			<div class="col-md-3 col-lg-3">
				<a href="/unitree">
				<div class="widget-bg-color-icon card-box fadeInDown animated">
					<div class="bg-icon bg-icon-info pull-left">
						<i class="fa fa-bitcoin text-info"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round($DSV_march,4)}}</b> </h3>
						<p class="text-muted">DSV April</p>
					</div>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>

			<div class="col-md-3 col-lg-3">
				<a href="/referral_bonus">
				<div class="widget-bg-color-icon card-box">
					<div class="bg-icon bg-icon-pink pull-left">
						<i class="fa fa-group text-pink"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round(app('App\Http\Controllers\ReferralController')->sumReferralBonus($user->id),4)}}</b></h3>
						<p class="text-muted">{{trans('main.ref_bonus')}} {{$user->levelReferral->referral_rate}}%</p>
					</div>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>

			<div class="col-md-3 col-lg-3">
				<a href="/unilevel_bonus">
				<div class="widget-bg-color-icon card-box">
					<div class="bg-icon bg-icon-warning pull-left">
						<i class="fa fa-sort-amount-asc text-warning"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round(app('App\Http\Controllers\ReferralController')->sumUnilevelBonus($user->id),4)}}</b></h3>
						<p class="text-muted">{{trans('main.unilevel_bonus')}}</p>
					</div>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>

			<div class="col-md-3 col-lg-3">
				<a href="/wallet">
				<div class="widget-bg-color-icon card-box">
					<div class="bg-icon bg-icon-purple pull-left">
						<i class="ti-wallet text-purple"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round($user->wallet->current_balance,4)}}</b></h3>
						<p class="text-muted">{{trans('main.my_wallet')}}</p>
					</div>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>

			<div class="col-md-3 col-lg-3">
				<a href="/bamboo">
				<div class="widget-bg-color-icon card-box">
					<div class="bg-icon bg-icon-success pull-left">
						<i class="fa fa-thumb-tack text-success"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><b class="counter">{{$user->bamboo_balance}}</b></h3>
						<p class="text-muted">{{trans('main.pins')}}</p>
					</div>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>
		</div>
	</div>
<!-- End Statistics -->

<!-- BTCPanda 4 Steps -->
<div class="col-md-12 col-lg-12">
	<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="widget-bg-color-icon card-box">
		<h3 class="page-title">Quick Overview: BTCPanda in 4 Steps</h3>
		<hr>
		<center><img src="/download/BTCPanda_4steps.jpg"></center>
		</div>
	</div>
	</div>
</div>
<!-- BTCPanda 4 Steps -->

<!-- DSV -->
<div class="col-md-6 col-lg-6">
	<div class="row">
	<div class="col-md-6 col-lg-12">
		<div class="widget-bg-color-icon card-box">
		<h3 class="page-title">Top 20: April 2016 DSV Standing</h3>
		<hr>
Top 3 highest Direct Sales Volume (DSV) for April 2016 will receive :-<br>
1.) winner : 500 pins (Worth USD5,000.00)<br>
2.) runner up: 300 pins (Worth USD3,000.00)<br>
3.) 2nd runner up : 100 pins (Worth USD1,000.00)<br><br>
		<table class="table table-striped table-bordered table-hover" id="sample_1">
			<thead>
				<th>No</th>
				<th>Country</th>
				<th>Username</th>
				<th>Total DSV</td>
			</thead>
			<tbody>
				{{--*/ $dt =  '' /*--}}
				{{--*/ $cnt =  1 /*--}}
				@foreach($TopDSV as $output)
				<tr>
					<td>{{$cnt}}&nbsp;</td>
					<td>{{$output->country}}&nbsp;</td>
					<td>{{$output->username}}&nbsp;</td>
					<td>{{round($output->activedownlinePH,2)}}&nbsp;</td>
				</tr>
				{{--*/ $cnt =  $cnt + 1 /*--}}
				{{--*/ $dt = $output->dt /*--}}
				@endforeach
			</tbody>
		</table>
		<small>* Standing as at {{$dt}}</small>
		</div>
	</div>
	</div>
</div>
<!-- End DSV -->

<!-- Announcement -->
<div class="col-md-6 col-lg-6">
	<div class="row">
	<div class="col-md-6 col-lg-12">
		<div class="widget-bg-color-icon card-box">
		<h3 class="page-title">Announcement</h3>
		<hr>
			<div class="text-left">
				<h3 class="text-dark">April 2016 Promotion<br><small>1 April 2016</small></h3>
				<p class="text-muted">
				We are pleased to announce the promotion for April 2016.. <a id="announcelink9" href="#">read more</a>
				</p>
				<hr>

				<h3 class="text-dark">Announcing DSV March 2016 Competition Winner<br><small>1 April 2016</small></h3>
				<p class="text-muted">
				We are pleased to announce the DSV March Winners.. <a id="announcelink8" href="#">read more</a>
				</p>
				<hr>

				<h3 class="text-dark">Implementation of New Marketing Plan<br><small>3 March 2016</small></h3>
				<p class="text-muted">
				We are glad to inform that the new marketing plan is already enforced.. <a id="announcelink7" href="#">read more</a>
				</p>
				<hr>

				<h3 class="text-dark">Top DSV Competition<br><small>1 March 2016</small></h3>
				<p class="text-muted">
				Join our challenge to become Top 3 highest Direct Sales Volume qualifier.. <a id="announcelink6" href="#">read more</a>
				</p>
				<hr>

				<h3 class="text-dark">Receive OTP via Email<br><small>28 February 2016</small></h3>
				<p class="text-muted">
				You can now receive OTP via email.. <a id="announcelink5" href="#">read more</a>
				</p>
				<hr>

				<h3 class="text-dark">System Enhancement<br><small>19 February 2016</small></h3>
				<p class="text-muted">
				We are upgrading our system to ensure all the provide help, get help and withdrawals can be processed without prejudice.. <a id="announcelink4" href="#">read more</a>
				</p>
				<hr>

				<h3 class="text-dark">Reset Wallet Address & Phone Number<br><small>18 February 2016</small></h3>
				<p class="text-muted">
				If you would like to request to reset the wallet address, please follow the following steps.. <a id="announcelink3" href="#">read more</a>
				</p>
				<hr>

				<h3 class="text-dark">New Marketing Plan 2016 <br><small>4 February 2016</small></h3>
				<p class="text-muted">
				Thank you for your support in our BTCPanda Global Crowdfunding System.. <a id="announcelink2" href="#">read more</a>
				</p>
				<hr>

				<h3 class="text-dark">New PH Ruling <br><small>26 January 2016</small></h3>
				<p class="text-muted">
				Please be informed that starting from 26th January 2016, the Referral Bonus and UniLevel Bonus .. <a id="announcelink1" href="#">read more</a>
				</p>

			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	</div>
</div>
<!-- End Announcement -->


</div>


<div class="row hide">

<div class="col-lg-4">
	<div class="card-box">
		<h4 class="text-dark header-title m-t-0 m-b-30">PH Targets</h4>

		<div class="widget-chart text-center">
			<input class="knob" data-width="150" data-height="150" data-linecap=round data-fgColor="#fb6d9d" value="80" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15"/>
			<h5 class="text-muted m-t-20">Total PH Today</h5>
			<h2 class="font-600"><i class="fa fa-bitcoin"></i> 75</h2>
			<ul class="list-inline m-t-15">
				<li>
					<h5 class="text-muted m-t-20">Target</h5>
					<h4 class="m-b-0"><i class="fa fa-bitcoin"></i> 1000</h4>
				</li>
				<li>
					<h5 class="text-muted m-t-20">Last week</h5>
					<h4 class="m-b-0"><i class="fa fa-bitcoin"></i> 523</h4>
				</li>
				<li>
					<h5 class="text-muted m-t-20">Last Month</h5>
					<h4 class="m-b-0"><i class="fa fa-bitcoin"></i> 965</h4>
				</li>
			</ul>
		</div>
	</div>

</div>

<div class="col-lg-8">
	<div class="card-box">
		<h4 class="text-dark header-title m-t-0">PH/GH Stats Daily</h4>
		<div class="text-center">
			<ul class="list-inline chart-detail-list">
				<li>
					<h5><i class="fa fa-circle m-r-5" style="color: #5fbeaa;"></i>PH</h5>
				</li>
				<li>
					<h5><i class="fa fa-circle m-r-5" style="color: #5d9cec;"></i>GH</h5>
				</li>
			</ul>
		</div>
		<div id="morris-bar-stacked" style="height: 303px;"></div>
	</div>
</div>

</div>
<!-- end row -->

<div class="row hide">

<div class="col-lg-6">
	<div class="card-box">
		<h4 class="text-dark header-title m-t-0">Total Stats</h4>

		<div class="text-center">
			<ul class="list-inline chart-detail-list">
				<li>
					<h5><i class="fa fa-circle m-r-5" style="color: #5fbeaa;"></i>PH</h5>
				</li>
				<li>
					<h5><i class="fa fa-circle m-r-5" style="color: #5d9cec;"></i>GH</h5>
				</li>
				<li>
					<h5><i class="fa fa-circle m-r-5" style="color: #ebeff2;"></i>Both</h5>
				</li>
			</ul>
		</div>

		<div id="morris-area-with-dotted" style="height: 300px;"></div>

	</div>

</div>

<!-- col -->

<div class="col-lg-6">
	<div class="card-box">
		<a href="#" class="pull-right btn btn-default btn-sm waves-effect waves-light">View All</a>
		<h4 class="text-dark header-title m-t-0">Recent Orders</h4>
		<p class="text-muted m-b-30 font-13">
			Use the button classes on an element.
		</p>

		<div class="table-responsive">
			<table class="table table-actions-bar m-b-0">
				<thead>
					<tr>
						<th></th>
						<th>Item Name</th>
						<th>Up-Down</th>
						<th style="min-width: 80px;">Manage</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span data-plugin="peity-bar" data-colors="#5fbeaa,#5fbeaa" data-width="80" data-height="30">5,3,9,6,5,9,7,3,5,2</span></td>
						<td><img src="assets/images/products/iphone.jpg" class="thumb-sm pull-left m-r-10" alt=""> Apple iPhone </td>
						<td><span class="text-custom">+$230</span></td>
						<td>
							<a href="#" class="table-action-btn"><i class="md md-edit"></i></a>
							<a href="#" class="table-action-btn"><i class="md md-close"></i></a>
						</td>
					</tr>

					<tr>
						<td><span data-plugin="peity-line" data-fill="#5fbeaa" data-stroke="#5fbeaa" data-width="80" data-height="30">0,-3,-6,-4,-5,-4,-7,-3,-5,-2</span></td>
						<td><img src="assets/images/products/samsung.jpg" class="thumb-sm pull-left m-r-10" alt=""> Samsung Phone </td>
						<td><span class="text-danger">-$154</span></td>
						<td>
							<a href="#" class="table-action-btn"><i class="md md-edit"></i></a>
							<a href="#" class="table-action-btn"><i class="md md-close"></i></a>
						</td>
					</tr>

					<tr>
						<td><span data-plugin="peity-line" data-fill="#fff" data-stroke="#5fbeaa" data-width="80" data-height="30">5,3,9,6,5,9,7,3,5,2</span>
							<td><img src="assets/images/products/imac.jpg" class="thumb-sm pull-left m-r-10" alt=""> Apple iPhone </td>
							<td><span class="text-custom">+$1850</span></td>
							<td>
								<a href="#" class="table-action-btn"><i class="md md-edit"></i></a>
								<a href="#" class="table-action-btn"><i class="md md-close"></i></a>
							</td>
						</tr>

						<tr>
							<td><span data-plugin="peity-pie" data-colors="#5fbeaa,#ebeff2" data-width="30" data-height="30">1/5</span></td>
							<td><img src="assets/images/products/macbook.jpg" class="thumb-sm pull-left m-r-10" alt=""> Apple iPhone </td>
							<td><span class="text-danger">-$560</span></td>
							<td>
								<a href="#" class="table-action-btn"><i class="md md-edit"></i></a>
								<a href="#" class="table-action-btn"><i class="md md-close"></i></a>
							</td>
						</tr>

						<tr>
							<td><span data-plugin="peity-bar" data-colors="#5fbeaa,#ebeff2" data-width="80" data-height="30">5,3,9,6,5,9,7,3,5,2</span></td>
							<td><img src="assets/images/products/lumia.jpg" class="thumb-sm pull-left m-r-10" alt=""> Lumia iPhone </td>
							<td><span class="text-custom">+$230</span></td>
							<td>
								<a href="#" class="table-action-btn"><i class="md md-edit"></i></a>
								<a href="#" class="table-action-btn"><i class="md md-close"></i></a>
							</td>
						</tr>

					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- end col -->

</div>
<!-- end row -->
@stop
@section('docready')
<script type="text/javascript">
$(document).ready(function($) {
	//$(".announce").dialog("open");
	$("#announcelink1").on("click", function() {
		$("#announce1").modal('show');
	});
	$("#announcelink2").on("click", function() {
		$("#announce2").modal('show');
	});
	$("#announcelink3").on("click", function() {
		$("#announce3").modal('show');
	});
	$("#announcelink4").on("click", function() {
		$("#announce4").modal('show');
	});
	$("#announcelink5").on("click", function() {
		$("#announce5").modal('show');
	});
	$("#announcelink6").on("click", function() {
		$("#announce6").modal('show');
	});
	$("#announcelink7").on("click", function() {
		$("#announce7").modal('show');
	});
	$("#announcelink8").on("click", function() {
		$("#announce8").modal('show');
	});
	$("#announcelink9").on("click", function() {
		$("#announce9").modal('show');
	});
});
</script>
@stop