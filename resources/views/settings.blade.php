@extends('layouts.master')

@section('content')
@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif
<?php
//case untuk leader
if(in_array(session('AdminLvl'),array(1,2))){
	if($user->id == session('has_admin_access')){
		$btn_LeaderCase = '';
	}else{
		$btn_LeaderCase = 'disabled';
	}
}else{
	$btn_LeaderCase = '';
}
?>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<div class="row">

	<div class="col-lg-12 hide">
		<div class="progress progress-lg m-b-5" style="border:1px solid #ddd">
			<div class="progress-bar progress-bar-striped progress-bar-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
				Account Verified 25%
			</div>
		</div>
	</div>

	@if (in_array(session('AdminLvl'),array(3,4)))
	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default min-height-panel-settings">
			<div class="panel-heading">
				<h3 class="panel-title">Admin Update</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/admin/update">{!! csrf_field() !!}
					<div class="form-group">
						<label for="youtube">{{trans('main.your_wallet')}} #1</label>
						<input type="text" readonly class="form-control" id="wallet1" name="wallet1" value="{{$user->wallet1}}" placeholder="{{trans('main.your_wallet')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.your_wallet')}} #2</label>
						<input type="text" readonly class="form-control" id="wallet2" name="wallet2" value="{{$user->wallet2}}" placeholder="{{trans('main.your_wallet')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.email')}} </label>
						<input type="text" class="form-control" id="email" name="email" value="{{$user->email}}" placeholder="{{trans('main.email')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.mobile_verification')}}</label>
						<input type="text" class="form-control" id="mobile" name="mobile" value="{{$user->mobile}}" placeholder="{{trans('main.mobile_verification')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.password')}}</label>
						<input type="password" class="form-control" id="pwd" name="pwd" value="" placeholder="Enter new password to reset">
 					</div>

					<div class="form-group">
						<label for="youtube">OTP</label>
						<input type="text" class="form-control" id="votp" name="votp" value="{{$user->otp}}" placeholder="Current OTP">
 					</div>


					<div class="form-group">
						<label for="youtube">Suspension</label>
    					<select class="form-control" name="suspension" id="suspension">
							<option @if($user->suspend == '0') selected @endif value="0">0 Active</option>
							<option @if($user->suspend == '1') selected @endif value="1">1 Suspend Bonus</option>
							<option @if($user->suspend == '2') selected @endif value="2">2 Suspend Bonus & Login</option>
    					</select>
 					</div>
					<div class="form-group">
						<label for="youtube">KYC</label>
    					<select class="form-control" name="kyc" id="kyc">
							<option @if($user->kyc == '0') selected @endif value="0">0 No KYC</option>
							<option @if($user->kyc == '1') selected @endif value="1">1 Verification</option>
							<option @if($user->kyc == '2') selected @endif value="2">2 Endorsed</option>
							<option @if($user->kyc == '3') selected @endif value="3">3 Rejected</option>
							<option @if($user->kyc == '4') selected @endif value="4">4 Verified</option>
    					</select>
 					</div>
					<?php if($user->kyc == '1'){ ?>
					<button type="reset" id="btn_resend_email_kyc" class="btn btn-block btn-primary waves-effect waves-light" style="margin-bottom:10px;">Resend KYC Email</button>
					<?php } ?>
					<div class="form-group">
						<label for="youtube">KYC Note</label>
						<textarea class="form-control" placeholer="KYC Note" name="kyc_note" id="kyc_note">{{$user->kyc_note}}</textarea>
 					</div>
					@if (in_array(session('AdminLvl'),array(4)))
					<div class="form-group">
						<label for="youtube">Admin Level</label>
    					<select class="form-control" name="adminlvl" id="adminlvl">
							<option @if($user->adm == '0') selected @endif value="0">0 Member</option>
							<option @if($user->adm == '1') selected @endif value="1">1 Leader</option>
							<option @if($user->adm == '2') selected @endif value="2">2 Customer Service</option>
							<option @if($user->adm == '3') selected @endif value="3">3 Admin</option>
							<option @if($user->adm == '4') selected @endif value="4">4 Super Admin</option>
    					</select>
 					</div>
					@endif
					<?php
					if($user->kyc == '0' || $user->kyc == ''){
						$button_name = "KYC";
						$status_to_update = '1';
					}elseif($user->kyc == '1'){
						$button_name = "Endorse KYC";
						$status_to_update = '2';
					}
					?>
					<?php
					if($user->kyc == '0' || $user->kyc == '' || $user->kyc == '1'){

						echo '<button type="reset" class="btn btn-block btn-primary btn_kyc"
								userid="'.$user->id.'" statustoupdate="'.$status_to_update.'">
								'.$button_name.'
								</button>';
					}elseif($user->kyc == '2'){
						echo '<a type="reset" class="btn btn-block btn-danger btn_kyc"
								userid="'.$user->id.'" statustoupdate="3">Reject KYC</a>';
						echo '<a type="reset" class="btn btn-block btn-success btn_kyc"
								userid="'.$user->id.'" statustoupdate="4">Approve KYC</a>';
					}
					?>
 					<button type="submit" class="btn btn-block btn-warning waves-effect waves-light">Admin Update</button>
				</form>
			</div>
		</div>
	</div>
	@endif

	@if (in_array(session('AdminLvl'),array(2)))
	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default min-height-panel-settings">
			<div class="panel-heading">
				<h3 class="panel-title">Admin Update</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/admin/csupdate">{!! csrf_field() !!}

					<div class="form-group">
						<label for="youtube">{{trans('main.password')}}</label>
						<input type="password" class="form-control" id="pwd" name="pwd" value="" placeholder="Enter new password to reset">
 					</div>
				<button type="submit" class="btn btn-block btn-warning waves-effect waves-light">Admin Update</button>
				</form>

				<hr>
					<div class="form-group">
						<label for="youtube">Suspension</label>
    					<select class="form-control" name="suspension" id="suspension" disabled>
							<option @if($user->suspend == '0') selected @endif value="0">0 Active</option>
							<option @if($user->suspend == '1') selected @endif value="1">1 Suspend Bonus</option>
							<option @if($user->suspend == '2') selected @endif value="2">2 Suspend Bonus & Login</option>
    					</select>
 					</div>
					<div class="form-group">
						<label for="youtube">KYC</label>
    					<select class="form-control" name="kyc" id="kyc" disabled>
							<option @if($user->kyc == '0') selected @endif value="0">0 No KYC</option>
							<option @if($user->kyc == '1') selected @endif value="1">1 Verification</option>
							<option @if($user->kyc == '2') selected @endif value="2">2 Endorsed</option>
							<option @if($user->kyc == '3') selected @endif value="3">3 Rejected</option>
							<option @if($user->kyc == '4') selected @endif value="4">4 Verified</option>
    					</select>
 					</div>
					<?php if($user->kyc == '1'){ ?>
					<button type="reset" id="btn_resend_email_kyc" class="btn btn-block btn-primary waves-effect waves-light" style="margin-bottom:10px;">Resend KYC Email</button>
					<?php } ?>
					<div class="form-group">
						<label for="youtube">KYC Note</label>
						<textarea class="form-control" placeholer="KYC Note" name="kyc_note" id="kyc_note">{{$user->kyc_note}}</textarea>
 					</div>
					<?php
					if($user->kyc == '0' || $user->kyc == ''){
						$button_name = "KYC";
						$status_to_update = '1';
					}elseif($user->kyc == '1'){
						$button_name = "Endorse KYC";
						$status_to_update = '2';
					}
					?>
					<?php if($user->kyc == '0' || $user->kyc == '' || $user->kyc == '1'){ ?>
					<button type="submit" class="btn btn-block btn-primary btn_kyc"
					userid="<?php echo $user->id;?>" statustoupdate="<?php echo $status_to_update;?>">
					<?php echo $button_name;?>
					</button>
					<?php } ?>


			</div>
		</div>
	</div>
	@endif

	@if (in_array(session('AdminLvl'),array(3,4)))
	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default min-height-panel-settings">
			<div class="panel-heading">
				<h3 class="panel-title">Admin Wallet Update</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/admin/updateWallet">{!! csrf_field() !!}
				<div class="form-group">
					<label for="youtube">{{trans('main.your_wallet')}} #1</label>
					<input type="text" class="form-control" id="wallet1" name="wallet1" value="{{$user->wallet1}}" placeholder="{{trans('main.your_wallet')}}">
				</div>

				<div class="form-group">
					<label for="youtube">{{trans('main.your_wallet')}} #2</label>
					<input type="text" class="form-control" id="wallet2" name="wallet2" value="{{$user->wallet2}}" placeholder="{{trans('main.your_wallet')}}">
				</div>

				<button type="submit" class="btn btn-block btn-warning waves-effect waves-light">Admin Update</button>
				</form>
			</div>
		</div>
	</div>
	@endif
	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{trans('main.profile_details')}}</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/profile/update">{!! csrf_field() !!}
					<div class="form-group">
					<label for="name">{{trans('main.username')}}</label>
						<input type="text" class="form-control" id="username" value="{{$user->username}}" disabled>
					</div>

					<div class="form-group">
					<label for="name">{{trans('main.name')}}</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="{{$user->name}}" disabled>
					</div>

					<div class="form-group">
					<label for="email">{{trans('main.email')}}</label>
						<input type="email" class="form-control" id="email" name="email" laceholder="Enter email" value="{{$user->email}}" disabled>
					</div>
					<?php
					if($user->active == 0){
						$btn_active_disabled = '';
					}else{
						$btn_active_disabled = 'disabled';
					}
					?>
					<?php if(in_array(session('AdminLvl'),array(3,4))){ ?>
					<button type="reset" id="btn_resend_email" class="btn btn-block btn-primary waves-effect waves-light" <?php echo $btn_active_disabled;?> style="margin-bottom:10px;">Resend Confirmation Email</button>
					<?php } ?>

					<div class="form-group">
					<label for="country">{{trans('main.country')}}</label>
    				<select class="form-control" name="country" id="country">
						@foreach ($country as $output)
							<option @if($user->country == $output->code) selected @endif value="{{$output->code}}">{{$output->country}} ({{$output->phone}})</option>
						@endforeach
    				</select>
					</div>

					<button <?php echo $btn_LeaderCase;?> type="submit" class="btn btn-block btn-primary waves-effect waves-light">{{trans('main.update')}}</button>
					<!--<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif type="submit" class="btn btn-block btn-primary waves-effect waves-light">{{trans('main.update')}}</button>-->
				</form>
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">OTP Delivery</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/messaging/update">{!! csrf_field() !!}
					<div class="form-group">
					<label for="name">Delivery Method</label>
    				<select class="form-control" name="messaging" id="messaging">
						<option @if($user->messaging == 'email') selected @endif value="email">Email</option>
						<option @if($user->messaging == 'mobile'||$user->messaging == '') selected @endif value="mobile">Mobile Phone</option>
    				</select>
					</div>

					<button  <?php echo $btn_LeaderCase;?> type="submit" class="btn btn-block btn-primary waves-effect waves-light">{{trans('main.update')}}</button>
				</form>
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default min-height-panel-settings">
			<div class="panel-heading">
				<h3 class="panel-title">{{trans('main.mobile_verification')}}</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/mobile/update">{!! csrf_field() !!}
					<div class="form-group">
					<label for="mobile">{{trans('main.full_format_number')}}</label>
						<input @if($user->otp) disabled @endif type="text" class="form-control" id="mobile" name="mobile" placeholder="{{trans('main.include_country_code')}} (+)" value="{{$user->mobile}}">
					</div>
					@if($user->mobile_verified)
					<span class="green"><i class="fa fa-check"></i> {{trans('main.verified')}}</span>
					@else
					<button  <?php echo $btn_LeaderCase;?> type="submit" class="btn btn-block btn-primary waves-effect waves-light m-b-20">{{trans('main.update')}}</button>
					@endif
				</form>

				@if(!$user->mobile_verified)
					@if($user->mobile)
					<form role="form" method="post" action="/settings/mobile/verify">{!! csrf_field() !!}
						<div class="form-group">
						<label for="otp">{{trans('main.verify_with_otp')}}</label>
							<input type="text" class="form-control" id="otp" name="otp" placeholder="{{trans('main.otp')}}" required>
						</div>

						<button  <?php echo $btn_LeaderCase;?> type="submit" class="btn btn-block btn-success waves-effect waves-light">{{trans('main.verify')}}</button>
					</form>
					<form role="form" method="post" action="/sms/otp">{!! csrf_field() !!}
						<button <?php echo $btn_LeaderCase;?>
						@if($user->otp) disabled @endif
						onclick="sendotpnow(); return false;" id="otp_btn" type="submit" class="btn btn-block btn-warning waves-effect waves-light m-t-10">
						@if($user->otp) {{trans('main.otp_sent')}} @else {{trans('main.request_otp')}} @endif
						</button>
					</form>
					@endif
				@endif
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default min-height-panel-settings">
			<div class="panel-heading">
				<h3 class="panel-title">{{trans('main.your_withdraw_wallet')}}</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/wallet/update">{!! csrf_field() !!}
					<div class="form-group">
						<label for="youtube">{{trans('main.your_wallet')}} #1</label>
						<input @if ($user->wallet2 or $user->wallet1) disabled @endif type="text" class="form-control" id="wallet1" name="wallet1" value="{{$user->wallet1}}" placeholder="{{trans('main.your_wallet')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.your_wallet')}} #2</label>
						<input @if ($user->wallet2 or $user->wallet1) disabled @endif type="text" class="form-control" id="wallet2" name="wallet2" value="{{$user->wallet2}}" placeholder="{{trans('main.your_wallet')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.otp')}}</label>
						<input @if ($user->wallet2 or $user->wallet1) disabled @endif type="text" class="form-control" id="otp" name="otp" placeholder="{{trans('main.otp')}}">
 					</div>
					@if ($user->wallet2 or $user->wallet1)
					* Wallet is locked and cannot be changed.
					@else
					* Wallet address will be locked after update.
					@endif
 					<button @if ($user->wallet2 or $user->wallet1) disabled @endif type="submit" class="btn btn-primary btn-block"  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif>Update</button>
					<form role="form" method="post" action="/sms/otp">{!! csrf_field() !!}
						<button  <?php echo $btn_LeaderCase;?>
						@if($user->otp) disabled @endif
						onclick="sendotpnow(); return false;" id="otp_btn" type="submit" class="btn btn-block btn-warning waves-effect waves-light m-t-10">
						@if($user->otp) {{trans('main.otp_sent')}} @else {{trans('main.request_otp')}} @endif
						</button>
					</form>
				</form>
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default min-height-panel-settings">
			<div class="panel-heading">
				<h3 class="panel-title">{{trans('main.id_documents')}}</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/identification/update">{!! csrf_field() !!}
					<div class="form-group">
					<label for="identification">{{trans('main.id_no')}}</label>
						<input type="text" class="form-control" id="identification" name="identification" placeholder="{{trans('main.example_id_no')}}" value="{{$user->identification}}" @if($user->identification_verified == 1) disabled @endif>
					</div>

					@if($user->identification_verified != 1)
					<button  <?php echo $btn_LeaderCase;?>  type="submit" class="btn btn-block btn-primary waves-effect waves-light m-b-20">{{trans('main.update')}}</button>
					@endif
				</form>

				@if($user->identification_verified != 1)
				@if($user->identification)
				<form role="form" method="post" action="/settings/identification/upload" enctype="multipart/form-data">{!! csrf_field() !!}
					<div class="form-group">
					<label for="identification_file">{{trans('main.upload_file')}}</label>
						<input type="file" name="identification_file">
					</div>
					<button  <?php echo $btn_LeaderCase;?> type="submit" class="btn btn-block btn-warning waves-effect waves-light">{{trans('main.upload')}}</button>
				</form>
				@endif
				@endif

				@if($user->identification_verified == -1)
				<i class="fa fa-spinner fa-spin crimson m-t-20"></i> <span class="crimson">{{trans('main.pending_verification')}}</span>
				@endif

				@if($user->identification_verified == 1)
				<span class="green"><i class="fa fa-check"></i> {{trans('main.verified')}}</span>
				@endif
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default min-height-panel-settings">
			<div class="panel-heading">
				<h3 class="panel-title">{{trans('main.video_testimonial')}}</h3>
			</div>
			<div class="panel-body">
				@if($user->youtube_verified != 1)
				<form role="form" method="post" action="/settings/youtube/update">{!! csrf_field() !!}
					<div class="form-group">
					<label for="youtube">{{trans('main.enter_youtube_link')}}</label>
						<input type="text" class="form-control" id="youtube" name="youtube" placeholder="i.e https://www.youtube.com/watch?v=L1-k9SLOavY" value="{{$user->youtube}}">
					</div>

					<button  <?php echo $btn_LeaderCase;?> type="submit" class="btn btn-block btn-primary waves-effect waves-light">{{trans('main.update')}}</button>
				</form>
				@endif

				@if($user->youtube_verified == -1)
				<i class="fa fa-spinner fa-spin crimson m-t-20"></i> <span class="crimson">{{trans('main.pending_verification')}}</span>
				@endif

				@if($user->youtube_verified == 1)
				<iframe style="border:1px solid #ddd" width="100%" src="{{ app('App\Http\Controllers\UserController')->embedYouTube($user->youtube) }}"></iframe>
				<span class="green"><i class="fa fa-check"></i> {{trans('main.verified')}}</span>
				@endif

			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default min-height-panel-settings">
			<div class="panel-heading">
				<h3 class="panel-title">{{trans('main.change_password')}}</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/password/update">{!! csrf_field() !!}
					<div class="form-group">
						<label for="youtube">{{trans('main.password')}}</label>
						<input type="password" class="form-control" id="cpass" name="cpass" placeholder="{{trans('main.password')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.new_password')}}</label>
						<input type="password" class="form-control" id="newpass" name="newpass" placeholder="{{trans('main.new_password')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.confirm_password')}}</label>
						<input type="password" class="form-control" id="cnewpass" name="cnewpass" placeholder="{{trans('main.confirm_password')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.otp')}}</label>
						<input type="text" class="form-control" id="otp" name="otp" placeholder="{{trans('main.otp')}}">
 					</div>

 					<button  <?php echo $btn_LeaderCase;?> type="submit" class="btn btn-primary btn-block">Update</button>
					<form role="form" method="post" action="/sms/otp">{!! csrf_field() !!}
						<button   <?php echo $btn_LeaderCase;?>
						@if($user->otp) disabled @endif
						onclick="sendotpnow(); return false;" id="otp_btn" type="submit" class="btn btn-block btn-warning waves-effect waves-light m-t-10">
						@if($user->otp) {{trans('main.otp_sent')}} @else {{trans('main.request_otp')}} @endif
						</button>
					</form>
				</form>
			</div>
		</div>
	</div>

</div>

<input type="hidden" id="act" value="<?php echo $act;?>">
@stop

@section('js')
<script>

function sendotpnow()
{
    var jqxhr = $.ajax( "/sms/otp" )
    .done(function(data) {
		$.each(data, function(i, obj) {
		  if(obj.status=="Error")
		  {
			$('#otp_btn').html("{{trans('main.otp_sent')}}");
		  }
		  else
		  {
		    swal("OTP Sent!", "Please wait till this popup closes.", "success")
			$('#otp_btn').html("{{trans('main.request_otp')}}");
			window.location.href="/settings"
			//location.reload();
		  }
		});
    })
    .fail(function(data) {
        alert("There was some error. Try again.");
    })
    .always(function(data) {
        return null;
    });
}
</script>

@stop

@section('docready')
<script type="text/javascript">
$(document).ready(function($) {

	var act = $('#act').val();
	if(act == 1){
		swal("Please Update", "Mobile Number and Country is required before you can PH.", "error")
	}

	$('#btn_resend_email').on('click', function () {
		$.get("/settings/admin/resendEmail", function (data, status) {
			if(data == '1'){
				swal("Sent!", "Confirmation email has been sent.", "success")
			}else{
				swal("Error!", "Email confirmation can not be sent.", "error")
			}
		});
	});

	$('#btn_resend_email_kyc').on('click', function () {
		$.get("/settings/admin/resendEmailKYCVerification", function (data, status) {
			if(data == '1'){
				swal("Sent!", "KYC Verification email has been sent.", "success")
			}else{
				swal("Error!", "KYC Verification email can not be sent.", "error")
			}
		});
	});

	$('.btn_kyc').on('click', function () {

		var uid = $(this).attr('userid');
		var statustoupdate = $(this).attr('statustoupdate');
		var kyc_note = $("#kyc_note").val();

		$.ajax({
			type: "POST",
			url: "/master/kyc/status/"+ uid +"/"+statustoupdate+"/"+ kyc_note,
			beforeSend: function (xhr) {
				var token = $('meta[name="csrf_token"]').attr('content');
				if (token) {
					return xhr.setRequestHeader('X-CSRF-TOKEN', token);
				}
			},
			success: function(msg){
				if(msg == 1){
					swal({
						  title: "Updated!",
						  text: "KYC Status updated.",
						  type: "success",
						  showCancelButton: false,
						  confirmButtonText: "Reload Page",
						  closeOnConfirm: false
						},
						function(){
						  $(location).attr('href', 'settings')
						});
				}
			}
		});
	});

});
</script>
@stop
