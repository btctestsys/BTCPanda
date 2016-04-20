@extends('layouts.master')


@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN BANKS PORTLET-->
		<div class="portlet light tasks-widget">
			<div class="portlet-body">
				<h2><i class="fa fa-list-ol"></i> Audit Trail</h2>
				<form action="" method="get">
				<div id="div_advance_search" class="alert alert-success">
					<h4>Search : </h4>
					<div class="row">
						<div class="col-md-2">
							<div class='input-group date' id='datepicker1'>
							  <input type='text' class="form-control"  name="inputDate" value="<?php echo $request->inputDate;?>"/>
							  <span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
							  </span>
							</div>
						</div>
						<div class="col-md-2">
							<input type="text" value="<?php echo $request->uname;?>" name="uname" class="form-control" placeholder="Enter Username" readonly>
						</div>
						<div class="col-md-2">
							<input type="text" value="<?php echo $request->ip;?>" name="ip" class="form-control" placeholder="Enter IP Address">
						</div>
						<div class="col-md-1">
							<select class="form-control" name="show_entries">
								<option value="10" <?php if($request->show_entries == 10){ echo 'selected';}?>>10</option>
								<option value="25" <?php if($request->show_entries == 25){ echo 'selected';}?>>25</option>
								<option value="50" <?php if($request->show_entries == 50){ echo 'selected';}?>>50</option>
								<option value="all" <?php if($request->show_entries == 'all'){ echo 'selected';}?>>All</option>
							</select>
						</div>
						<button class="btn btn-success" style="margin-top:2px;"><i class="fa fa-search"></i> Search</button>
						<a href="audit_trail?inputDate=&uname=<?php echo $request->uname;?>&ip=&show_entries=10&view=1" class="btn btn-primary" style="margin-top:2px;"><i class="fa fa-spinner"></i> Reset</a>
						<input type="hidden" value="1" name="view">
					</div>
				</form>

				</div>
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<th>No.</th>
						<th>Member</th>
						<th>By</th>
						<th>Action</th>
						<th>Date</th>
						<th>IP</th>
						<th>Device Info</th>
					</thead>
					<tbody class="">
						<?php $no = 1;?>
						<?php foreach($audit as $a):?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td><a href="/master/login/id/<?php echo $a->uid;?>"><?php echo $a->member;?></a></td>
							<td><a href="/master/login/id/<?php echo $a->created_by;?>"><?php echo $a->updated_by;?></a></td>
							<td><?php echo $a->action;?></td>
							<td><?php echo $a->created_at;?></td>
							<td><?php echo $a->ip_address;?></td>
							<td><?php echo $a->device;?></td>
						</tr>
						<tr>
							<td></td>
							<td colspan=6><strong>Input : </strong><?php echo $a->input;?></td>
						</tr>
					<?php $no ++ ;?>
					<?php endforeach;?>
					</tbody>

				</table>

			</div>
		</div>
		<!-- END BANKS PORTLET-->
	</div>
</div>


@stop

@section('js')
@stop

@section('docready')
<script type="text/javascript">
	jQuery(document).ready(function () {


		$(function () {
			$('#datepicker1').datepicker({
				format: 'yyyy-mm-dd',
				endDate: '0d'
			});
		});

	});
</script>
@stop
