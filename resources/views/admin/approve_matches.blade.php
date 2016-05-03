
<?php //print_r($matches);?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="b">
						<td>Date</td>
						<td>Member</td>
						<td>To Match</td>
						<td>Type</td>
						<td>Days</td>
						<td>Action</td>
					</thead>
					<tbody>
						{{--*/ $total_match =  0 /*--}}
						@foreach($matches as $output)
						<tr>
							<td title="{{$output->created_at}}">{{Carbon\Carbon::parse($output->created_at)->diffForHumans()}}</td>
							<td>
							@if($output->u1s>=1)
							<a href="/master/login/id/{{$output->user_id}}"><mark><strike>{{$output->username}}</strike></mark></a>({{round($output->uph,2)}})
							@else
							<a href="/master/login/id/{{$output->user_id}}">{{$output->username}}</a>({{round($output->uph,2)}})
							@endif
							@if($output->u2s>=1)
							-> <a href="/master/login/id/{{$output->sid}}"><mark><strike>{{$output->susername}}</strike></mark></a>({{round($output->sph,2)}})
							@else
							-> <a href="/master/login/id/{{$output->sid}}">{{$output->susername}}</a>({{round($output->sph,2)}})
							@endif
							@if($output->u3s>=1)
							-> <a href="/master/login/id/{{$output->sid1}}"><mark><strike>{{$output->susername1}}</strike></mark></a>({{round($output->sph1,2)}})</td>
							@else
							-> <a href="/master/login/id/{{$output->sid1}}">{{$output->susername1}}</a>({{round($output->sph1,2)}})</td>
							@endif

							<td>{{round($output->amt,8)}}</td>
							<td>@if($output->type == 1) Referral @endif @if($output->type == 2) Unilevel @endif @if($output->type == 3) Earning @endif</td>
							<td>{{Carbon\Carbon::parse($output->created_at)->diffindays()}}</td>
							<td nowrap=nowrap>
							<!-- <form method="post" action="/master/approval/match/{{$output->id}}"> -->
								{!! csrf_field() !!}
								<span id="btnApproved{{$output->id}}"></span>
								<button class="btn btn-xs btn-success btnApprove btnApprove{{$output->user_id}}" id="btnApprove{{$output->id}}"
									outputID="{{$output->id}}"
									outputDate="{{Carbon\Carbon::parse($output->created_at)->diffForHumans()}}"
									outputUsername="{{$output->username}}"
									outputToMatch="{{round($output->amt,8)}}">
									Approve
								</button>
								@if($output->kyc == 0)
								<span class="btnKYCed{{$output->user_id}}"></span>
								<button data-toggle="modal" data-target="#modalKYC" class="btn btn-xs btn-warning btnKYC btnKYC{{$output->user_id}}"
									outputUserId="{{$output->user_id}}"
									outputUsername="{{$output->username}}">
									KYC
								</button>
								@endif
								@if($output->kyc == 1)
								<button class="btn btn-xs btn-success" title="KYC Verification" disabled>
									<i class='fa fa-pause'></i> KYCed
								</button>
								@endif
								@if($output->kyc == 2)
								<button class="btn btn-xs btn-info" title="KYC Endorse" disabled>
									<i class='fa fa-eye'></i> KYCing
								</button>
								@endif
								@if($output->kyc == 3)
								<button class="btn btn-xs btn-danger" title="KYC Rejected" disabled>
									<i class='fa fa-times'></i> KYC
								</button>
								@endif
								@if($output->kyc == 4)
								<button class="btn btn-xs btn-primary" title="KYC Approved" disabled>
									<i class='fa fa-check'></i> KYC
								</button>
								@endif
							<!-- </form> -->
							</td>
						</tr>
							{{--*/ $total_match =  $total_match + $output->amt /*--}}
						@endforeach
						<tr>
							<td></td>
							<td>Total</td>
							<td>{{round($total_match,8)}}</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</thead>
				</tbody>
			</table>
		</div>
	</div>
</div>

</div>

<div id="modalKYC" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">KYC</h2>
      </div>
      <div class="modal-body">
			<h3>Are you sure want to KYC ?</h3>
			<div class="form-group">
 			  <label for="youtube">Member</label>
 			  <input type="text" readonly class="form-control" id="uname" name="uname">
			  <input type="hidden" class="form-control" id="uid" name="uid">
 		  </div>
		  <div class="form-group">
			  <label for="youtube">KYC Note</label>
			 <textarea class="form-control" placeholer="KYC Note" name="kyc_note" id="kyc_note">{{$user->kyc_note}}</textarea>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary yes" id="yes">Yes</button>
		  <button type="button" class="btn" data-dismiss="modal" id="Cancel">Cancel</button>
      </div>
    </div>

  </div>
</div>






<script type="text/javascript">
jQuery(document).ready(function () {

	$('.btnApprove').on('click', function () {

		var outputID 			= $(this).attr('outputID');
		var outputDate 		= $(this).attr('outputDate');
		var outputUsername = $(this).attr('outputUsername');
		var outputToMatch 	= $(this).attr('outputToMatch');

		$.ajax({
			type: "POST",
			url: "/master/approval/match/"+ outputID,
			beforeSend: function (xhr) {
				var token = $('meta[name="csrf_token"]').attr('content');
				if (token) {
					return xhr.setRequestHeader('X-CSRF-TOKEN', token);
				}
			},
			success: function(msg){
				if(msg == 1){
					$.growl.error({
						message	: 	" ",
						duration	: 	"3500",
						title			: 	"<i class='fa fa-exclamation-circle'></i> Not enough PH Queue for distribution."
					});
				}else{
					$("#btnApproved"+outputID).html('<span class="btn-xs btn-primary">Approved</span>');
					$('#btnApprove'+outputID).hide();
					$.growl.notice({
						message	: 	"<br><p>Date : <strong>"+outputDate+"</strong></p>"+
											"<p>Member : <strong>"+outputUsername+"</strong></p>"+
											"<p>To Match : <strong>"+outputToMatch+"</strong></p>",
						duration	: 	"3500",
						title			: 	"<i class='fa fa-check'></i> GH Matched!"
					});
				}
			}

		});
		//alert(outputID);
	});
	$('.btnKYC').on('click', function (e) {

		$("#yes").html('Yes');
		$("#Cancel").show();
		var outputUserId = $(this).attr('outputUserId');
		var outputUsername = $(this).attr('outputUsername');
		$("#uname").val(outputUsername);
		$("#uid").val(outputUserId);
		$("#kyc_note").val();

	});
	$('.yes').on('click', function () {

		var uname = $("#uname").val();
		var uid = $("#uid").val();
		var kyc_note = $("#kyc_note").val();

		$("#yes").html('<i class="fa fa-spinner"></i> Processing....');
		$("#Cancel").hide();
		$.ajax({
			type: "POST",
			url: "/master/kyc/status/"+ uid +"/1/"+ kyc_note,
			beforeSend: function (xhr) {
				var token = $('meta[name="csrf_token"]').attr('content');
				if (token) {
					return xhr.setRequestHeader('X-CSRF-TOKEN', token);
				}
			},
			success: function(msg){
				if(msg == 1){
					$('#modalKYC').modal('toggle');
					$(".btnKYCed"+uid).html('<span class="btn-xs btn-primary">KYCed</span>');
					$('.btnKYC'+uid).hide();
					$('.btnApprove'+uid).hide();
					$.growl.warning({
						message	: 	"<br><p>Member : <strong>"+uname+"</strong></p>",
						duration	: 	"3500",
						title			: 	"<i class='fa fa-check'></i> KYC"
					});
				}
			}
		});
	});
});
</script>
