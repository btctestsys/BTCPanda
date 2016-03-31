@extends('layouts.master')

@section('content')
test all day long
<h4 style="margin-top:0">{{trans('main.active')}}</h4>

<div class="row">
@foreach($ph as $output)
<div class="col-lg-4">
	<div class="panel panel-color @if($output->status == 1 && $output->days >= 15) panel-success @else panel-danger @endif">
		<div class="panel-heading">
			<h3 class="panel-title">{{@$output->days}} {{trans('main.days')}} / {{@Carbon\Carbon::parse($output->created_at)->diffinhours() + 24 -$output->days*24}} {{trans('main.hours')}} ({{@round($output->amt_distributed / @$output->amt * 100,2)}}%)</h3>
		</div>
		<div class="panel-body">	

			<button class="btn-rounded btn-primary btn-block btn-custom" disabled><i class="fa fa-bitcoin"></i> {{round($output->amt,8)}} x 1% x {{$output->days}} - {{round($output->earnings_claimed,2)}} = <i class="fa fa-bitcoin"></i> {{$output->earnings}}</button>		
			
			@if($output->status == 1 && $output->days >= 15)
			<form role="form" method="post" action="/add/earnings">{!! csrf_field() !!}
				<input type="hidden" name="hidden" value="{{Crypt::encrypt($output->id.'~'.$output->earnings)}}">
				<button class="btn-rounded btn-success btn-block m-t-10 @if($output->earnings == 0) opa-25 @else claim-earnings @endif" @if($output->earnings == 0) disabled @endif>{{trans('main.gh_earnings')}} <i class="fa fa-bitcoin"></i> {{$output->earnings}}</button>
			</form>
			<form role="form" method="post" action="/add/earnings">{!! csrf_field() !!}
				<input type="hidden" name="hidden" value="{{Crypt::encrypt($output->id.'~'.($output->earnings+$output->amt).'~1')}}">				
				<button class="btn-rounded btn-danger btn-block m-t-10 claim-earnings">{{trans('main.gh_all')}} <i class="fa fa-bitcoin"></i> {{round($output->earnings + $output->amt,8)}}</button>
			</form>
			@else
			<button class="btn-rounded btn-success btn-block opa-25 m-t-10" disabled>{{trans('main.gh_earnings')}} <i class="fa fa-bitcoin"></i> {{$output->earnings}}</button>
			<button class="btn-rounded btn-danger btn-block opa-25 m-t-10" disabled>{{trans('main.gh_all')}} <i class="fa fa-bitcoin"></i> {{round($output->earnings + $output->amt,8)}}</button>
			@endif
			
			@if($output->status == 0)
			<hr>
			<div class="progress progress-lg" style="border:1px solid #ddd;background:#ddd">
				<div class="progress-bar progress-bar-striped @if($output->status == 1) progress-bar-success @else progress-bar-danger active @endif progress-lg" role="progressbar" aria-valuenow="{{round($output->amt_distributed / $output->amt * 100)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($output->amt_distributed / $output->amt * 100,2)}}%;">
					{{round($output->amt_distributed / $output->amt * 100,2)}}% {{trans('main.distributed')}}
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
						<a data-toggle="collapse" data-parent="#accordion1" href="#bg-default" class="" aria-expanded="true"><i class="ion-plus-round"></i></a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div id="bg-default" class="panel-collapse collapse" aria-expanded="true">
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
@endforeach
</div>

<h4>{{trans('main.ended')}}</h4>

<div class="row">
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
							<a data-toggle="collapse" data-parent="#accordion1" href="#bg-default" class="" aria-expanded="true"><i class="ion-plus-round"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div id="bg-default" class="panel-collapse collapse" aria-expanded="true">
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
	                <label for="PH Amount">{{trans('main.ph_amount')}} ({{trans('main.ph_left')}}: {{$ph_left}} BTC)</label>
	                <input type="text" class="form-control" id="amt" placeholder="{{trans('main.enter_btc')}}" name="amt">
	            </div>
	            <button type="submit" class="btn btn-warning waves-effect waves-light btn-block ph-clicked">{{trans('main.submit')}}</button>
	        </form>
		</div>
	</div>
</div>
@endif
</div>

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