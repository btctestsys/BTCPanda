@extends('layouts.admin')

@section('content')
<!-- Page-Title -->
<div class="row">
	<div class="col-sm-12">
		<h4 class="page-title">Admin Dashboard</h4>
		<p class="text-muted page-title-alt">Welcome to BtcPanda.com</p>
	</div>
</div>
<div class="row">
	<!-- Statistics -->
	<div class="col-md-12 col-lg-12">
		<div class="row">
			<!-- ----------------------------------------------- -->
			<div class="col-md-3 col-lg-3">
				<div class="widget-bg-color-icon card-box fadeInDown animated">
					<div class="bg-icon bg-icon-info pull-left">
						<i class="fa fa-bitcoin text-info"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round($moneybox,0)}}</b> </h3>
						<p class="text-muted">Current Moneybox</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- ----------------------------------------------- -->
			<div class="col-md-3 col-lg-3">
				<div class="widget-bg-color-icon card-box">
					<div class="bg-icon bg-icon-pink pull-left">
						<i class="fa fa-group text-pink"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round($activeph,0)}}</b> </h3>
						<p class="text-muted">Active PH</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="col-md-3 col-lg-3">
				<div class="widget-bg-color-icon card-box">
					<div class="bg-icon bg-icon-pink pull-left">
						<i class="fa fa-group text-pink"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round($totalph,0)}}</b></h3>
						<p class="text-muted">Total PH</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- ----------------------------------------------- -->
			<div class="col-md-3 col-lg-3">
				<div class="widget-bg-color-icon card-box">
					<div class="bg-icon bg-icon-pink pull-left">
						<i class="fa fa-group text-pink"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round($totalgh,0)}}</b></h3>
						<p class="text-muted">Total GH</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="col-md-3 col-lg-3">
				<div class="widget-bg-color-icon card-box fadeInDown animated">
					<div class="bg-icon bg-icon-info pull-left">
						<i class="ti-wallet text-purple"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round($current_balance,0)}}</b></h3>
						<p class="text-muted">Current Balance</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- ----------------------------------------------- -->
			<div class="col-md-3 col-lg-3">
				<div class="widget-bg-color-icon card-box fadeInDown animated">
					<div class="bg-icon bg-icon-info pull-left">
						<i class="ti-wallet text-purple"></i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><i class="fa fa-bitcoin"></i> <b class="counter">{{round($available_balance,0)}}</b></h3>
						<p class="text-muted">Available Balance</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- ----------------------------------------------- -->
		</div>

	</div>

	<div class="col-md-6 col-lg-6">
		<div class="portlet light tasks-widget">
			<div class="portlet-body">
				<h3>Active PH by Country</h3>
				<table class="table table-striped table-bordered table-hover" id="sample_1">
					<thead>
						<th>Ctry</th>
						<th>Total PH</th>
						<th>{{$m3}} PH</th>
						<th>{{$m2}} PH</td>
						<th>{{$m1}} PH</th>
						<th>Total</th>
					</thead>
					<tbody>
						{{--*/ $total1 =  0 /*--}}
						{{--*/ $total2 =  0 /*--}}
						{{--*/ $total3 =  0 /*--}}
						{{--*/ $total_t =  0 /*--}}
						{{--*/ $total_a =  0 /*--}}
						{{--*/ $user_cnt =  1 /*--}}
						{{--*/ $total_ph =  1 /*--}}
						@foreach($statPH as $output)
						<tr title="{{$output->cname}}">
							<td>{{$output->country}}</td>
							<td align=right>{{round($output->totalph,0)}}&nbsp;</td>
							<td align=right>{{round($output->aphm3,0)}}&nbsp;</td>
							<td align=right>{{round($output->aphm2,0)}}&nbsp;</td>
							<td align=right>{{round($output->aphm1,0)}}&nbsp;</td>
							<td align=right>{{round($output->activeph,0)}}&nbsp;</td>
						</tr>
						{{--*/ $total1 =  $total1 + $output->aphm1 /*--}}
						{{--*/ $total2 =  $total2 + $output->aphm2 /*--}}
						{{--*/ $total3 =  $total3 + $output->aphm3 /*--}}
						{{--*/ $total_t =  $total_t + $output->totalph /*--}}
						{{--*/ $total_a =  $total_a + $output->activeph/*--}}
						{{--*/ $user_cnt =  $user_cnt + 1 /*--}}
						@endforeach
						<tr >
							<td>Total</td>
							<td align=right>{{round($total_t,0)}}&nbsp;</td>
							<td align=right>{{round($total3,0)}}&nbsp;</td>
							<td align=right>{{round($total2,0)}}&nbsp;</td>
							<td align=right>{{round($total1,0)}}&nbsp;</td>
							<td align=right>{{round($total_a,0)}}&nbsp;</td>
						</tr>
					</tbody>
					<tfoot>
					</tfoot>
				</table>
			</div>
		</div>
	</div>


	<div class="col-md-6 col-lg-6">
		<div class="portlet light tasks-widget">
			<div class="portlet-body">
				<h3>Pending Wallet Transaction</h3>
				@foreach($LastOpenQ as $output)
					<center><font color=red>Open Queue Processor detected dated:
					<br><strong>{{$output->created_at}} ({{$output->mdif}} minutes ago)</strong></font>
					<br><a href="/master/resetqueue/{{$output->id}}">Force terminate now</a></center>
					<br>
				@endforeach
				<table class="table table-striped table-bordered table-hover" id="sample_1">
					<thead>
						<th>No</th>
						<th>Type (Date)(Amount)/From/To</th>
					</thead>
					<tbody>
						{{--*/ $num =  1 /*--}}
						{{--*/ $total =  0 /*--}}
						@foreach($pendingQ as $output)
						<tr title="">
							<td>{{$num}}</td>
							<td><strong>{{$output->typ}}</strong> ({{$output->created_at}})({{round($output->amt,8)}})
							<br>{{$output->from}} (<a href="/master/login/id/{{$output->u1id}}">{{$output->u1username}}</a>)
							<br>{{$output->to}} (<a href="/master/login/id/{{$output->u2id}}">{{$output->u2username}}</a>)</td>
						</tr>
						{{--*/ $num =  $num + 1 /*--}}
						{{--*/ $total =  $total + $output->amt /*--}}
						@endforeach
						<tr >
							<td></td>
							<td align=right>Total {{round($total,8)}}&nbsp;</td>
						</tr>
					</tbody>
					<tfoot>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>


@stop

@section('js')

@stop

@section('docready')

@stop