@extends('layouts.master')

@section('content')
@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif



<div class="row">


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

});
</script>
@stop