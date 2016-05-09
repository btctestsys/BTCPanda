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
<div class="col-sm-12">
	<div class="card-box widget-inline">
		<div class="row">
			<div class="col-lg-4 col-sm-6">
				<div class="widget-inline-box text-center">
					<h3><i class="text-success fa fa-download"></i> <b>{{round($gh_balance,8)}}</b></h3>
					@if($gh_balance != 0)
					<h4 class="text-muted text-success">{{trans('main.available_gh')}}</h4>
					@else
					<h4 class="text-muted">{{trans('main.no_gh_available')}}</h4>
					@endif
				</div>
			</div>

			<?php /*
			<div class="col-lg-3 col-sm-6">
				<div class="widget-inline-box text-center">
					<h3><i class="text-danger fa fa-exclamation-circle"></i> <b>{{round($gh_pending,8)}}</b></h3>
					<h4 class="text-muted">{{trans('main.pending_approval')}}</h4>
				</div>
			</div>
			*/ ?>

			<div class="col-lg-4 col-sm-6">
				<div class="widget-inline-box text-center">
					<h3><i class="text-warning fa fa-spinner @if($pending_sent != 0) fa-spin @endif"></i> <b>{{round($pending_sent,8)}}</b></h3>
					<h4 class="text-muted">{{trans('main.pending_sent')}}</h4>
				</div>
			</div>

			<div class="col-lg-4 col-sm-6">
				<div class="widget-inline-box text-center b-0">
					<h3><i class="text-danger fa fa-cloud-upload"></i> <b>{{round($total_gh,8)}}</b></h3>
					<h4 class="text-muted">{{trans('main.total_gh')}}</h4>
				</div>
			</div>

		</div><!-- row -->
	</div><!-- card-box -->
</div><!-- col 12 -->

<div class="col-md-4 @if($referral == 0) @endif">
	<div class="mini-stat clearfix card-box">
		<span class="mini-stat-icon bg-info"><i class="fa fa-group text-white"></i></span>
		<div class="mini-stat-info text-right text-dark">
			<span class="text-dark"><i class="fa fa-bitcoin"></i> {{round($referral,8)}}</span>
			{{trans('main.available_referral_gh')}}
		</div>

		<div class="row m-t-20">
			@if($referral > 0)
			<form role="form" method="post" action="/get_help/create/referrals">{!! csrf_field() !!}
			@endif
				<button  <?php echo $btn_LeaderCase;?>
				@if (app('App\Http\Controllers\GhController')->get_next_trans_inmin_ingh() > 0) disabled @endif
				class="btn btn-info btn-block @if($referral == 0) disabled @else gh-success @endif">GH <i class="fa fa-bitcoin"></i> {{round($referral,8)}}</button>
			</form>
		</div>
	</div>
</div>


<div class="col-md-4 @if($unilevel == 0) @endif">
	<div class="mini-stat clearfix card-box">
		<span class="mini-stat-icon bg-success"><i class="fa fa-sort-amount-asc text-white"></i></span>
		<div class="mini-stat-info text-right text-dark">
			<span class="text-dark"><i class="fa fa-bitcoin"></i> {{round($unilevel,8)}}</span>
			{{trans('main.available_unilevel_gh')}}
		</div>

		<div class="row m-t-20">
			@if($unilevel > 0)
			<form role="form" method="post" action="/get_help/create/unilevels">{!! csrf_field() !!}
			@endif
				<button <?php echo $btn_LeaderCase;?>
				@if (app('App\Http\Controllers\GhController')->get_next_trans_inmin_ingh() > 0) disabled @endif
				class="btn btn-success btn-block @if($unilevel == 0) disabled @else gh-success @endif">GH <i class="fa fa-bitcoin"></i> {{round($unilevel,8)}}</button>
			</form>
		</div>
	</div>
</div>


<div class="col-md-4 @if($earning == 0) @endif">
	<div class="mini-stat clearfix card-box">
		<span class="mini-stat-icon bg-pink"><i class="fa fa-money text-white"></i></span>
		<div class="mini-stat-info text-right text-dark">
			<span class="text-dark"><i class="fa fa-bitcoin"></i> {{round($earning,8)}}</span>
			{{trans('main.available_earning_gh')}}
		</div>

		<div class="row m-t-20">
			@if($earning > 0)
			<form role="form" method="post" action="/get_help/create/earnings">{!! csrf_field() !!}
			@endif
				<button <?php echo $btn_LeaderCase;?>
				@if (app('App\Http\Controllers\GhController')->get_next_trans_inmin_ingh() > 0) disabled @endif
				class="btn btn-pink btn-block @if($earning == 0) disabled @else gh-success @endif">GH <i class="fa fa-bitcoin"></i> {{round($earning,8)}}</button>
				<input type="hidden" name="ph_id" value="<?php echo isset($ph_id['0']) ? $ph_id['0']->ph_id : '';?>">
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<div class="col-lg-12">
				<table class="table table-striped">
					<thead class="b">
						<td>GH History</td>
						<td>Amt</td>
						<td>Type</td>
						<td>Status</td>
					</thead>
					<tbody>
						{{--*/ $gh_cnt =  1 /*--}}
						@foreach($history as $output)
						<tr>
							<td title="{{$output->created_at}}">{{$output->created_at}} <!-- ({{Carbon\Carbon::parse($output->created_at)->diffForHumans()}}) --></td>
							<td>
								<div class="portlet-widgets">
									{{round($output->amt,8)}} <a data-toggle="collapse" data-parent="#accordion1{!! $gh_cnt !!}" href="#bg-default1{!! $gh_cnt !!}" class="" aria-expanded="true"><span aria-hidden="true" class="icon-magnifier-add"></span></a>
								</div>
								<div id="bg-default1{!! $gh_cnt !!}" class="panel-collapse collapse" aria-expanded="true">
									<div class="portlet-body">
											Helper(s):<br />
											@foreach($output->ph_users_list as $output2)
												<?php echo $output2 ?><br/>
											@endforeach
									</div>
								</div>
							</td>
							<td>
							@if($output->type == 1) Referral @endif
							@if($output->type == 2) Unilevel @endif
							@if($output->type == 3) Profit @endif
							</td>
							<td>
							@if($output->status == 0) <label class="label label-danger">Getting Help</label> @endif
							@if($output->status == 1) <label class="label label-warning">Getting Help</label> @endif
							@if($output->status == 2) <label class="label label-inverse">Done</label> @endif
							</td>
						</tr>
						{{--*/ $gh_cnt =  $gh_cnt + 1 /*--}}
						@endforeach
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>

@if (in_array(session('AdminLvl'),array(1,2,3,4)))
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<div class="col-lg-12">
				<h3><span class="btn btn-sm btn-warning">Admin View</span> Last 100 Wallet History</h3> <small>Mouse over to the transaction to view the blockchain status</small>
				<table class="table table-striped table-bordered table-hover" id="sample_1">
					<thead>
						<th>No</th>
						<th>Date</th>
						<th>From</th>
						<th>Type</td>
						<th>Amount</td>
					</thead>
					<tbody>
						{{--*/ $cnt =  1 /*--}}
						@foreach($walletqueue_history as $output)
						<tr title="{{$output->json}}">
							<td>{{$cnt}}&nbsp;</td>
							<td>{{$output->created_at}}&nbsp;</td>
							<td>{{$output->from}}&nbsp;</td>
							<td>{{$output->typ}}&nbsp;</td>
							<td>{{round($output->amt,8)}}&nbsp;</td>
						</tr>
						{{--*/ $cnt =  $cnt + 1 /*--}}
						@endforeach
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

@stop

@section('js')
<script>
//Success Message
$('.gh-success').click(function(){
swal("GH Submitted!", "We will find a match for it within 1-5 days.", "success")
});
</script>
@stop

@section('docready')
<script>
jQuery(document).ready(function($) {
	swal("IMPORTANT! GH Fees", "Please note that there will be a compulsary Bitcoin Network Fee that will be deducted from your GH amount. \n\n You will be receiving SLIGHTLY less amount. \nDepending on the Bitcoin network load. \n\n Please try to GH a lump sum amount instead of many small tiny fraction of GH to save on fees.");
});
</script>
@stop
