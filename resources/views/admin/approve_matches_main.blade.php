@extends('layouts.admin')

@section('content')
<div class="row text-center">
	<div class="col-sm-12 col-lg-12">
		<div class="card-box">
			<div class="chart easy-pie-chart-1" data-percent="{{$total_ph/($total_ph+$total_gh)*100}}">
				<span class="percent">{{$total_ph/$total_ph+$total_gh*100}}</span>
				<canvas height="220" width="220" style="height: 110px; width: 110px;"></canvas>
			</div>
			<h5 class="text-center"><span style="color:crimson">GH <i class="fa fa-bitcoin"></i> {{$total_gh}}</span> | <span style="color:#0066cc">PH <i class="fa fa-bitcoin"></i>  {{$total_ph}}</span> | <span style="color:orange">Selected PH <i class="fa fa-bitcoin"></i>  {{$total_phsel}}</span></h5>
			@foreach($current_q as $output)
			<h5 class="text-center">Current Queue: <span style="color:orange">{{round($output->amt_distributed,8)}}</span> / {{round($output->amt,8)}} @ <span style="color:crimson">Day {{$output->ddifc}}</span></h5>
			@endforeach
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="b">
						<td align=center>D1</td>
						<td align=center>D2</td>
						<td align=center>D3</td>
						<td align=center>D4</td>
						<td align=center>D5</td>
						<td align=center>D6</td>
						<td align=center>D7</td>
						<td align=center>D8</td>
						<td align=center>D9</td>
						<td align=center>D10</td>
						<td align=center>D11</td>
						<td align=center>D12</td>
						<td align=center>D13</td>
						<td align=center>D14</td>
						<td align=center>D15</td>
						<td align=center>D16</td>
						<td align=center>D17</td>
						<td align=center>D18</td>
						<td align=center>D19</td>
						<td align=center>D20</td>
					</thead>
					@foreach($matches_sum as $output)
					<tbody>
						<td align=center>{{round($output->sd1,0)}}</td>
						<td align=center>{{round($output->sd2,0)}}</td>
						<td align=center>{{round($output->sd3,0)}}</td>
						<td align=center>{{round($output->sd4,0)}}</td>
						<td align=center>{{round($output->sd5,0)}}</td>
						<td align=center>{{round($output->sd6,0)}}</td>
						<td align=center>{{round($output->sd7,0)}}</td>
						<td align=center>{{round($output->sd8,0)}}</td>
						<td align=center>{{round($output->sd9,0)}}</td>
						<td align=center>{{round($output->sd10,0)}}</td>
						<td align=center>{{round($output->sd11,0)}}</td>
						<td align=center>{{round($output->sd12,0)}}</td>
						<td align=center>{{round($output->sd13,0)}}</td>
						<td align=center>{{round($output->sd14,0)}}</td>
						<td align=center>{{round($output->sd15,0)}}</td>
						<td align=center>{{round($output->sd16,0)}}</td>
						<td align=center>{{round($output->sd17,0)}}</td>
						<td align=center>{{round($output->sd18,0)}}</td>
						<td align=center>{{round($output->sd19,0)}}</td>
						<td align=center>{{round($output->sd20,0)}}</td>
					</tbody>
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>
<ul class="nav nav-tabs" role="tablist">
   <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#content1" role="tab" id="tab1">All</a>
   </li>
   <li class="nav-item active">
      <a class="nav-link" data-toggle="tab" href="#content2" role="tab" id="tab2">No KYC</a>
   </li>
   <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#content3" role="tab" id="tab3">KYC</a>
   </li>
   <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#content4" role="tab" id="tab4">KYC Verified</a>
   </li>
</ul>

<div class="tab-content">
   <div id="loading"><i class="fa fa-spinner fa-spin fa-3x fa-fw margin-bottom"></i><span class="sr-only">Loading...</span></div>
   <div class="tab-pane" id="content1" role="tabpanel"></div>
   <div class="tab-pane active" id="content2" role="tabpanel"></div>
   <div class="tab-pane" id="content3" role="tabpanel"></div>
   <div class="tab-pane" id="content4" role="tabpanel"></div>
</div>
@stop

@section('js')
<!-- EASY PIE CHART JS -->
<script src="/assets/plugins/jquery.easy-pie-chart/dist/easypiechart.min.js"></script>
<script src="/assets/plugins/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<script src="/assets/pages/easy-pie-chart.init.js"></script>

<script>
//Success Message
//$('.match-success').click(function(){
//swal("GH Matched!", "Please wait till this popup closes.", "success")
//});
</script>
@stop

@section('docready')
<script type="text/javascript">
$(document).ready(function($) {

   $('#content2').load('../match/<?php echo $type;?>/nokyc', function() {
      $('#loading').hide();
      $('#content1,#content3,#content4').html('');
   });

   $('#tab1').on('click', function () {
      $('#loading').show();
      $('#content1').load('../match/<?php echo $type;?>/all', function() {
         $('#loading').hide();
         $('#content2,#content3,#content4').html('');
      });
   });
   $('#tab2').on('click', function () {
      $('#loading').show();
      $('#content2').load('../match/<?php echo $type;?>/nokyc', function() {
         $('#loading').hide();
         $('#content1,#content3,#content4').html('');
      });
   });
   $('#tab3').on('click', function () {
      $('#loading').show();
      $('#content3').load('../match/<?php echo $type;?>/kyc', function() {
         $('#loading').hide();
         $('#content1,#content2,#content4').html('');
      });
   });
   $('#tab4').on('click', function () {
      $('#loading').show();
      $('#content4').load('../match/<?php echo $type;?>/verified', function() {
         $('#loading').hide();
         $('#content1,#content2,#content3').html('');
      });
   });
});
</script>

@stop
