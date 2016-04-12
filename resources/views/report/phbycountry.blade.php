@extends('layouts.admin')

@section('content')
@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif


<div class="col-md-12 col-lg-12">
	<h3><i class="fa fa-bar-chart"></i>  PH Report By Country By Date</h3>
	
	
		<div class="col-md-6 col-lg-6">
			<div class="portlet light tasks-widget">
				<div class="portlet-body">
					<p>Please select date </p>
						<form method="POST" action="/master/phbycountry">{!! csrf_field() !!}
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
		</div>
	
	<?php 
	#untuk 7 days----------------------
	$country_list = array();
	foreach ($phDate7d as $p7) {
		
		$c_code = $p7->country;
		$c_name = $p7->cname;
		$date = $p7->created_at;
		$date= str_replace("-","",$date);
		//$country_list[$c_name][] = array($date=>$p7->totalph);
		$country_list[$c_name][$date] = $p7->totalph;

	}
	$output = array();
	
	foreach($country_list as $name => $ph)
	{
	    $output[] = array(
		   'name' => $name,
		   'ph' => $ph
	    );
	}	
	
	#untuk 3 month----------------------
	$temp = array();
	foreach ($phDate3m as $p3) {
		
		$c_code = $p3->country;
		$c_name = $p3->cname;
		$date = $p3->created_at;
		$date= str_replace("-","",$date);
		//$country_list[$c_name][] = array($date=>$p7->totalph);
		$temp[$c_name][$date] = $p3->totalph;

	}	
	$output2 = array();
	foreach($temp as $name => $ph)
	{
	    $output2[] = array(
		   'name' => $name,
		   'ph' => $ph
	    );
	}	

	#echo "<pre>";
	#print_r($output);
	//echo $output['20']['ph']['20160403'];
	#echo "</pre>";
	?>
	
		<div class="col-md-6 col-lg-6">
			<div class="portlet light tasks-widget">
				<div class="portlet-body">
					<div class="panel panel-default panel-border panel-primary">
						<h4>By Country By Date ( <strong class="text-info"><?php echo $inputDate;?></strong> )</h4>
							<table class="table table-striped table-bordered table-hover" id="sample_1">
								<thead>
									<!--<th>Country Code</th>-->
									<th>Country Name</th>
									<th>Total PH</th>
								</thead>
								<tbody>
									<?php $totalPhDate = 0;?>
									<?php foreach($phDate as $pd):?>
									<tr >
										<!--<td><?php echo (($pd->country != '') ? $pd->country : ' - ');?></td>-->
										<td><?php echo (($pd->cname != '') ? $pd->cname : ' - ');?></td>
										<td align=right><?php echo round($pd->totalph,2);?></td>
									</tr >
									<?php $totalPhDate = $totalPhDate + $pd->totalph;?>
									<?php endforeach;?>
									<tr >
										<td><strong class="pull-right">TOTAL</strong></td>
										<td align=right><strong><?php echo round($totalPhDate,2);?></strong></td>
									</tr >
								</tbody>
							</table>
					</div>
					<?php
						if(sizeof($phDate) == '0'){
							echo '<p class="alert alert-info">No PH on this day.</p>';
						}
					?>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-lg-12">
			<div class="portlet light tasks-widget">
				<div class="portlet-body">
					<div class="panel panel-default panel-border panel-primary">
						<h4>Last 7 Days ( From <strong class="text-info"><?php echo date('Y-m-d', strtotime('-6 day', strtotime($inputDate)));?></strong> to 
						<strong  class="text-info"><?php echo $inputDate;?></strong>)</h4>
						<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
									<th>Country</th>
									<th><?php echo date('m-d',strtotime($inputDate));?></th>
									<th><?php echo date('m-d', strtotime('-1 day', strtotime($inputDate)));?></th>
									<th><?php echo date('m-d', strtotime('-2 day', strtotime($inputDate)));?></th>
									<th><?php echo date('m-d', strtotime('-3 day', strtotime($inputDate)));?></th>
									<th><?php echo date('m-d', strtotime('-4 day', strtotime($inputDate)));?></th>
									<th><?php echo date('m-d', strtotime('-5day', strtotime($inputDate)));?></th>
									<th><?php echo date('m-d', strtotime('-6 day', strtotime($inputDate)));?></th>
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
								<?php foreach($output as $cl): ?>

								<tr>
									<td><?php echo (( $cl['name'] != '') ?  $cl['name'] : ' - ');?></td>
									<td align=right>
										<?php echo $ph1 = isset($cl['ph'][date('Ymd',strtotime($inputDate))]) ? round($cl['ph'][date('Ymd',strtotime($inputDate))],2) : '-' ?>
										<?php $gtotal1= $gtotal1+  $ph1;?>
									</td>	
									<td align=right>
										<?php echo $ph2 = isset($cl['ph'][date('Ymd', strtotime('-1 day', strtotime($inputDate)))]) ? round($cl['ph'][date('Ymd', strtotime('-1 day', strtotime($inputDate)))],2) : '-' ?>
										<?php $gtotal2= $gtotal2+  $ph2;?>
									</td>
									<td align=right>
										<?php echo $ph3 = isset($cl['ph'][date('Ymd', strtotime('-2 day', strtotime($inputDate)))]) ? round($cl['ph'][date('Ymd', strtotime('-2 day', strtotime($inputDate)))],2) : '-' ?>
										<?php $gtotal3= $gtotal3+  $ph3;?>
									</td>
									<td align=right>
										<?php echo $ph4 = isset($cl['ph'][date('Ymd', strtotime('-3 day', strtotime($inputDate)))]) ? round($cl['ph'][date('Ymd', strtotime('-3 day', strtotime($inputDate)))],2) : '-' ?>
										<?php $gtotal4= $gtotal4+  $ph4;?>
									</td>	
									<td align=right>
										<?php echo $ph5 = isset($cl['ph'][date('Ymd', strtotime('-4 day', strtotime($inputDate)))]) ? round($cl['ph'][date('Ymd', strtotime('-4 day', strtotime($inputDate)))],2) : '-' ?>
										<?php $gtotal5= $gtotal5+  $ph5;?>
									</td>	
									<td align=right>
										<?php echo $ph6 = isset($cl['ph'][date('Ymd', strtotime('-5 day', strtotime($inputDate)))]) ? round($cl['ph'][date('Ymd', strtotime('-5 day', strtotime($inputDate)))],2) : '-' ?>
										<?php $gtotal6= $gtotal6+  $ph6;?>
									</td>	
									<td align=right>
										<?php echo $ph7 = isset($cl['ph'][date('Ymd', strtotime('-6 day', strtotime($inputDate)))]) ? round($cl['ph'][date('Ymd', strtotime('-6 day', strtotime($inputDate)))],2) : '-' ?>
										<?php $gtotal7= $gtotal7+  $ph7;?>
									</td>	
									<td align=right>
										<strong><?php echo $ph1+$ph2+$ph3+$ph4+$ph5+$ph6+$ph7; ?></strong>
									</td>
								</tr>
								<?php endforeach;?>
								<tr>
									<td align=right><strong>TOTAL</strong></td>
									<td align=right><strong><?php echo $gtotal1;?></strong></td>
									<td align=right><strong><?php echo $gtotal2;?></strong></td>
									<td align=right><strong><?php echo $gtotal3;?></strong></td>
									<td align=right><strong><?php echo $gtotal4;?></strong></td>
									<td align=right><strong><?php echo $gtotal5;?></strong></td>
									<td align=right><strong><?php echo $gtotal6;?></strong></td>
									<td align=right><strong><?php echo $gtotal7;?></strong></td>
									<td align=right></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12 col-lg-12">
			<div class="portlet light tasks-widget">
				<div class="portlet-body">
					<div class="panel panel-default panel-border panel-primary">
						<h4>Last 3 Month ( From <strong class="text-info"><?php echo date('Y-M', strtotime('-2 month', strtotime($inputDate)));?></strong> to 
						<strong  class="text-info"><?php echo date('Y-M',strtotime($inputDate));?></strong>)</h4>
						<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
								<th>Country</th>
								<th><?php echo $phdates['0']->created_at1;?></th>
								<th><?php echo $phdates['1']->created_at1;?></th>
								<th><?php echo $phdates['2']->created_at1;?></th>
								<th><strong>TOTAL</strong></th>
							</thead>
							<?php									
								$total1 = 0;
								$total2 = 0;
								$total3 = 0;

							?>
							<tbody>

								<?php foreach($output2 as $cl2): ?>
								<tr>
									<td><?php echo (( $cl2['name'] != '') ?  $cl2['name'] : ' - ');?></td>
									<td align=right>
										<?php echo $t1 = isset($cl2['ph'][date('Ym',strtotime($inputDate))]) ? round($cl2['ph'][date('Ym',strtotime($inputDate))],2) : '-' ?>
										<?php $total1 = $total1+$t1;?>
									</td>
									<td align=right>
										<?php echo $t2 = isset($cl2['ph'][$phdates['1']->created_at]) ? round($cl2['ph'][$phdates['1']->created_at],2) : '-' ?>
										<?php $total2 = $total2+$t2;?>
									</td>
									<td align=right>
										<?php echo $t3 = isset($cl2['ph'][$phdates['2']->created_at]) ? round($cl2['ph'][$phdates['2']->created_at],2) : '-' ?>
										<?php $total3 = $total3+$t3;?>
									</td>
									<td align=right><strong><?php echo $t1+$t2+$t3; ?></strong></td>
								</tr>
								<?php endforeach;?>
								<tr>
									<td align=right><strong>TOTAL</strong></td>
									<td align=right><strong><?php echo $total1;?></strong></td>
									<td align=right><strong><?php echo $total2;?></strong></td>
									<td align=right><strong><?php echo $total3;?></strong></td>
									<td align=right></td>
								</tr>
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
			format: 'yyyy-mm-dd',
			endDate: '0d'
		});
	});

	$.growl.notice({ 
		message	: 	"<br><p>Date : <strong><?php echo $inputDate;?></strong></p>",
		duration	: 	"20000",  
		title			: 	"<i class='fa fa-bar-chart'></i> Report Generated!"
	});
	   
});
</script>
@stop