@extends('layouts.admin')

@section('content')
@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif


<div class="col-md-12 col-lg-12">
	<h3><i class="fa fa-bar-chart"></i>  Report Country Leaders</h3>


		<!--<div class="col-md-6 col-lg-6">
			<div class="portlet light tasks-widget">
				<div class="portlet-body">
					<p>Please select month and year </p>
						<form method="POST" action="/master/countryleader">{!! csrf_field() !!}
							  <div class="form-group">
								 <div class='input-group date' id='datepicker1'>
									<input type='text' class="form-control"  name="inputDate" value="<?php echo $inputDate;?>"/>
									<span class="input-group-addon">
									    <span class="glyphicon glyphicon-calendar"></span>
									</span>
								 </div>
								 <button class="input-group btn btn-primary pull-right" style="margin-top:10px; "><i class="fa fa-refresh"></i> Generate</button>
								 <br>
							  </div>
						</form>
				</div>
			</div>
		</div>-->

	<?php


	#echo "<pre>";
	#print_r($output);
	//echo $output['20']['ph']['20160403'];
	#echo "</pre>";
	?>

	<div class="col-md-12 col-lg-12">
		<div class="portlet light tasks-widget">
			<div class="portlet-body">
				<div class="panel panel-default panel-border panel-primary">
					<h4>Top DSV Leaders by Country</h4>
					<table class="table table-striped table-bordered table-hover" id="sample_1">
						<thead>
								<th>Country</th>
								<th>1st</th>
								<th>DSV</th>
								<th>2nd</th>
								<th>DSV</th>
								<th>3rd</th>
								<th>DSV</th>
								<th>TOTAL</th>
						</thead>
						<tbody>
							<?php
								$gtotal1 = 0;
								$gtotal2 = 0;
								$gtotal3 = 0;
								$gtotal4 = 0;
								$gtotal5 = 0;
								$gtotal6 = 0;
								$gtotal7 = 0;
							?>
							<?php foreach($output as $o): ?>
							<?php
								$dsv1 = isset($o['leaders']['0']->activedownlinePH) ? $o['leaders']['0']->activedownlinePH : 0;
								$dsv2 = isset($o['leaders']['1']->activedownlinePH) ? $o['leaders']['1']->activedownlinePH : 0;
								$dsv3 = isset($o['leaders']['2']->activedownlinePH) ? $o['leaders']['2']->activedownlinePH : 0;
							?>
							<?php if($dsv1 + $dsv2 + $dsv3 != 0){?>
							<tr>
								<td><?php echo $o['country'];?></td>
								<td><a href="/master/login/id/{{$o['leaders']['0']->referral_id}}"><?php if($dsv1 != 0){ echo $o['leaders']['0']->username; }else{ echo '-';}?></a></td>
								<td align=right>
									<?php if($dsv1 != 0){ echo round($dsv1,2); }else{ echo '-';}?>
								</td>
								<td><a href="/master/login/id/{{$o['leaders']['1']->referral_id}}"><?php if($dsv2 != 0){ echo $o['leaders']['1']->username; }else{ echo '-';}?></a></td>
								<td align=right>
									<?php if($dsv2 != 0){ echo round($dsv2,2); }else{ echo '-';}?>
								</td>
								<td><a href="/master/login/id/{{$o['leaders']['2']->referral_id}}"><?php if($dsv3 != 0){ echo $o['leaders']['2']->username; }else{ echo '-';}?></a></td>
								<td align=right>
									<?php if($dsv3 != 0){ echo round($dsv3,2); }else{ echo '-';}?>
								</td>
								<td align=right>
									<strong><?php echo round($dsv1+$dsv2+$dsv3,2); ?></strong>
								</td>


							</tr>
							<?php } ?>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>






</div>



@stop

@section('js')

@stop

@section('docready')
<script type="text/javascript">

$(document).ready(function($) {

	$(function () {
		$('#datepicker1').datepicker({
			format: 'yyyy-mm',
			endDate: '0d',
			startView: "months",
			minViewMode: "months"
		});
	});

});
</script>
@stop
