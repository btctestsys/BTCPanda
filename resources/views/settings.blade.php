@extends('layouts.master')

@section('content')
@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif
<div class="row">
	
	<div class="col-lg-12 hide">
		<div class="progress progress-lg m-b-5" style="border:1px solid #ddd">
			<div class="progress-bar progress-bar-striped progress-bar-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
				Account Verified 25%
			</div>
		</div>
	</div>

	@if(session('isAdmin')=='true') 
	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default min-height-panel-settings">
			<div class="panel-heading">
				<h3 class="panel-title">Admin Update</h3>
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="/settings/admin/update">{!! csrf_field() !!}
					<div class="form-group">
						<label for="youtube">{{trans('main.your_wallet')}} #1</label>
						<input type="text" class="form-control" id="wallet1" name="wallet1" value="{{$user->wallet1}}" placeholder="{{trans('main.your_wallet')}}">
 					</div>

					<div class="form-group">
						<label for="youtube">{{trans('main.your_wallet')}} #2</label>
						<input type="text" class="form-control" id="wallet2" name="wallet2" value="{{$user->wallet2}}" placeholder="{{trans('main.your_wallet')}}">
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
					 @if (in_array(session('AdminLvl'),array(3,4)))
					<div class="form-group">
						<label for="youtube">OTP</label>
						<input type="text" class="form-control" id="votp" name="votp" value="{{$user->otp}}" placeholder="Current OTP">
 					</div>
					@endif
					 @if (in_array(session('AdminLvl'),array(4)))
					<div class="form-group">
						<label for="youtube">Admin Level</label>
    					<select class="form-control" name="adminlvl" id="adminlvl">
							<option @if($user->adm == '0') selected @endif value="0">0 Member</option>
							<option @if($user->adm == '1') selected @endif value="1">1 Marketing</option>
							<option @if($user->adm == '2') selected @endif value="2">2 Customer Service</option>
							<option @if($user->adm == '3') selected @endif value="3">3 Admin</option>
							<option @if($user->adm == '4') selected @endif value="4">4 Super Admin</option>
    					</select>
 					</div>
					@endif
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
						<input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="{{$user->name}}">
					</div>

					<div class="form-group">
					<label for="email">{{trans('main.email')}}</label>
						<input type="email" class="form-control" id="email" name="email" laceholder="Enter email" value="{{$user->email}}" disabled>
					</div>

					<div class="form-group">
					<label for="country">{{trans('main.country')}}</label>
    				<select class="form-control" name="country" id="country">
						@foreach ($country as $output)
							<option @if($user->country == $output->code) selected @endif value="{{$output->code}}">{{$output->country}} ({{$output->phone}})</option>						
						@endforeach
    				</select>
					</div>

					<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif type="submit" class="btn btn-block btn-primary waves-effect waves-light">{{trans('main.update')}}</button>
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

					<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif type="submit" class="btn btn-block btn-primary waves-effect waves-light">{{trans('main.update')}}</button>
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
					<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif type="submit" class="btn btn-block btn-primary waves-effect waves-light m-b-20">{{trans('main.update')}}</button>
					@endif
				</form>
				
				@if(!$user->mobile_verified)
					@if($user->mobile)
					<form role="form" method="post" action="/settings/mobile/verify">{!! csrf_field() !!} 
						<div class="form-group">
						<label for="otp">{{trans('main.verify_with_otp')}}</label>
							<input type="text" class="form-control" id="otp" name="otp" placeholder="{{trans('main.otp')}}" required>
						</div>

						<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif type="submit" class="btn btn-block btn-success waves-effect waves-light">{{trans('main.verify')}}</button>
					</form>
					<form role="form" method="post" action="/sms/otp">{!! csrf_field() !!} 
						<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif
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
				<h3 class="panel-title">{{trans('main.your_wallet')}}</h3>
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
						<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif
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
					<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif  type="submit" class="btn btn-block btn-primary waves-effect waves-light m-b-20">{{trans('main.update')}}</button>
					@endif
				</form>
				
				@if($user->identification_verified != 1)
				@if($user->identification)
				<form role="form" method="post" action="/settings/identification/upload" enctype="multipart/form-data">{!! csrf_field() !!}
					<div class="form-group">
					<label for="identification_file">{{trans('main.upload_file')}}</label>
						<input type="file" name="identification_file">
					</div>
					<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif type="submit" class="btn btn-block btn-warning waves-effect waves-light">{{trans('main.upload')}}</button>
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

					<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif type="submit" class="btn btn-block btn-primary waves-effect waves-light">{{trans('main.update')}}</button>
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

 					<button  @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif type="submit" class="btn btn-primary btn-block">Update</button>
					<form role="form" method="post" action="/sms/otp">{!! csrf_field() !!} 
						<button   @if (in_array(session('AdminLvl'),array(1,2))) disabled @endif
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
	//
});
</script>
@stop