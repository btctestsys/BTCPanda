@extends('layouts.master')

@section('content')
<h4 style="margin-top:0">{{trans('main.active')}}</h4>

<div class="row">
{{--*/ $ph_cnt =  1 /*--}}
@foreach($ph as $output)
<div class="col-lg-4">
	<div class="panel panel-color @if($output->status == 1 && $output->ddifc >= 15) panel-success @else panel-danger @endif">
		<div class="panel-heading">
			<h3 class="panel-title">{{@$output->ddifc}} {{trans('main.days')}} ({{@round($output->amt_distributed / @$output->amt * 100,2)}}%) {{@$output->created_at}}</h3>
		</div>
		<div class="panel-body">	

			<button class="btn-rounded btn-primary btn-block btn-custom" disabled><i class="fa fa-bitcoin"></i> {{round($output->amt,8)}} x 1% x {{$output->ddifc}} - {{round($output->earnings_claimed,2)}} = <i class="fa fa-bitcoin"></i> {{$output->earnings}}</button>		
			
			@if($output->status == 1 && $output->ddifc >= 15)
			<form role="form" method="post" action="/add/earnings">{!! csrf_field() !!}
				<input type="hidden" name="hidden" value="{{Crypt::encrypt($output->id.'~'.$output->earnings)}}">
				<button class="btn-rounded btn-success btn-block m-t-10 @if($output->earnings == 0)  @else claim-earnings @endif" @if($output->earnings == 0) disabled @endif>{{trans('main.gh_earnings')}} <i class="fa fa-bitcoin"></i> {{$output->earnings}}</button>
			</form>
			<form role="form" method="post" action="/add/earnings">{!! csrf_field() !!}
				<input type="hidden" name="hidden" value="{{Crypt::encrypt($output->id.'~'.($output->earnings+$output->amt).'~1')}}">				
				<button class="btn-rounded btn-success btn-block m-t-10 claim-earnings">{{trans('main.gh_all')}} <i class="fa fa-bitcoin"></i> {{round($output->earnings + $output->amt,8)}}</button>
			</form>
			@else
			<button class="btn-rounded btn-danger btn-block m-t-10" disabled>{{trans('main.gh_earnings')}} <i class="fa fa-bitcoin"></i> {{$output->earnings}}</button>
			<button class="btn-rounded btn-danger btn-block m-t-10" disabled>{{trans('main.gh_all')}} <i class="fa fa-bitcoin"></i> {{round($output->earnings + $output->amt,8)}}</button>
			@endif
			
			@if($output->status == 0)
			<hr>

			{{--*/ $total_bal =  0 /*--}}
			<div class="row">
				<div class="col-lg-4">Distribution
				</div>
				<div class="col-lg-8">
				<div class="progress progress-lg" style="border:1px solid #ddd;background:#ddd">
					<div class="progress-bar @if (($output->amt_distributed / $output->amt * 100) < 50) btn-danger @else btn-success @endif progress-bar-striped @if($output->status == 1) progress-bar-success @else progress-bar-danger active @endif progress-lg" role="progressbar" aria-valuenow="{{round($output->amt_distributed / $output->amt * 100)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($output->amt_distributed / $output->amt * 100,2)}}%;">
						{{round($output->amt_distributed / $output->amt * 100,2)}}% {{trans('main.distributed')}}
					</div>
				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">Maturity
				</div>
				<div class="col-lg-8">
				<div class="progress progress-lg" style="border:1px solid #ddd;background:#ddd">
					<div class="progress-bar @if (($output->ddifc / 15 * 100) < 50) btn-danger @else btn-success @endif progress-bar-striped @if($output->status == 1) progress-bar-success @else progress-bar-danger active @endif progress-lg" role="progressbar" aria-valuenow="{{round($output->ddifc / 15 * 100)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($output->ddifc / 15 * 100,2)}}%;">
						{{round(@$output->ddifc / 15 * 100,2)}}% {{trans('main.days')}}
					</div>
				</div>
				</div>
			</div>
			@endif

			@if($output->status == 1)
			<div class="portlet m-t-20">
				<div class="portlet-heading portlet-default">
					<h3 class="portlet-title text-dark">
						{{trans('main.help_receivers')}}
					</h3>
					<div class="portlet-widgets">
						<a data-toggle="collapse" data-parent="#accordion2{!! $ph_cnt !!}" href="#bg-default2{!! $ph_cnt !!}" class="" aria-expanded="true"><i class="ion-plus-round"></i></a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div id="bg-default2{!! $ph_cnt !!}" class="panel-collapse collapse" aria-expanded="true">
					<div class="portlet-body">
						@foreach($output->gh_users_list as $output2)
							<?php echo $output2 ?>
							<br/>
						@endforeach
					</div>
				</div>
			</div>
			@endif

		</div>
	</div>
</div>
{{--*/ $ph_cnt =  $ph_cnt + 1 /*--}}
@endforeach
</div>

<h4>{{trans('main.ended')}}</h4>

<div class="row">
{{--*/ $ph_cnt =  1 /*--}}
@foreach($ph_ended as $output_ended)
	<div class="col-lg-4">
		<div class="panel panel-color panel-inverse">
			<div class="panel-heading">
				<h3 class="panel-title">{{trans('main.created')}}: {{@$output->created_at}}</h3>
			</div>
			<div class="panel-body">	

				<button class="btn-rounded btn-inverse btn-block btn-custom" disabled><i class="fa fa-bitcoin"></i> {{round($output_ended->amt,8)}} -> <i class="fa fa-bitcoin"></i> {{round($output_ended->earnings_claimed,8)}}</button>
				
				@if($output_ended->status == 0)
				<hr>
				<div class="progress progress-lg" style="border:1px solid #ddd;background:#ddd">
					<div class="progress-bar progress-bar-striped @if($output_ended->status == 1) progress-bar-success @else progress-bar-danger active @endif progress-lg" role="progressbar" aria-valuenow="{{round($output_ended->amt_distributed / $output_ended->amt * 100)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($output_ended->amt_distributed / $output_ended->amt * 100,2)}}%;">
						{{round($output_ended->amt_distributed / $output_ended->amt * 100,2)}}% {{trans('main.distributed')}}
					</div>
				</div>
				@endif

				@if($output_ended->status == 2)
				<div class="portlet m-t-20">
					<div class="portlet-heading portlet-default">
						<h3 class="portlet-title text-dark">
							{{trans('main.help_receivers')}}
						</h3>
						<div class="portlet-widgets">
							<a data-toggle="collapse" data-parent="#accordion1{!! $ph_cnt !!}" href="#bg-default1{!! $ph_cnt !!}" class="" aria-expanded="true"><i class="ion-plus-round"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div id="bg-default1{!! $ph_cnt !!}" class="panel-collapse collapse" aria-expanded="true">
						<div class="portlet-body">
							@foreach($output_ended->gh_users_list as $output2)
								<?php echo $output2 ?>
								<br/>
							@endforeach
						</div>
					</div>
				</div>
				@endif

			</div>
		</div>
	</div>
	{{--*/ $ph_cnt =  $ph_cnt + 1 /*--}}
@endforeach
</div>

@if($ph_left > 0)
<h4>{{trans('main.new')}}</h4>
@endif

<div class="row">
@if($ph_left > 0)
<div class="col-lg-4">
	<div class="panel panel-color panel-warning">
		<div class="panel-heading">
			<h3 class="panel-title">{{trans('main.add_ph')}}</h3>
		</div>
		<div class="panel-body">
			<form role="form" method="post" action="/provide_help/create">
			{!! csrf_field() !!}
	            <div class="form-group">
	                <label for="PH Amount">{{trans('main.ph_amount')}} ({{trans('main.ph_left')}}: @if ($ph_left<0.0001) 0 @else {{$ph_left}} @endif BTC)</label>
	                <input type="text" class="form-control" id="amt" placeholder="{{trans('main.enter_btc')}}" name="amt">
	            </div>
	            <button type="submit" 
				@if (app('App\Http\Controllers\PhController')->get_next_trans_inmin_inph() > 0) disabled @endif
				class="btn btn-warning waves-effect waves-light btn-block ph-clicked">{{trans('main.submit')}}</button>
	        </form>
		</div>
	</div>
</div>
@endif
</div>


@if(session('isAdmin')=='true')
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
						<th>To</th>
						<th>Type</td>
						<th>Amount</td>
					</thead>
					<tbody>
						{{--*/ $cnt =  1 /*--}}
						@foreach($walletqueue_history as $output)
						<tr title="{{$output->json}}">
							<td>{{$cnt}}&nbsp;</td>
							<td>{{$output->created_at}}&nbsp;</td>
							<td>{{$output->to}}&nbsp;</td>
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
$('.claim-earnings').click(function(){
swal("Processing", "System is checking if your GH is valid. Please allow some time to reflect in your GH page.", "success")
window.location=('/get_help');
});

$('.ph-clicked').click(function(){
swal("Adding PH", "Please wait till this popup closes.", "success")
$('.ph-clicked').toggle();
});
</script>

@stop

@section('docready')
@stop