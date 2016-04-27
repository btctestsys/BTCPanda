@extends('layouts.admin')


@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN BANKS PORTLET-->
		<div class="portlet light tasks-widget">
			<div class="portlet-body">
				<h2><i class="fa fa-ban"></i> KYC List</h2>
            <p>Listing of KYC users. </p>

            <form action="" method="get">
				<div id="div_advance_search" class="alert alert-success">
					<h4>Search : </h4>
					<div class="row">
						<div class="col-md-2">
							<input type="text" value="<?php echo $request->uname; ?>" name="uname" class="form-control" placeholder="Enter Username">
						</div>
						<div class="col-md-2">
							<select class="form-control" name="status_kyc">
								<option value="" <?php echo ($request->status_kyc == '') ? 'selected' : '';?>>ALL</option>
								<option value="1" <?php echo ($request->status_kyc == '1') ? 'selected' : '';?>>Verification</option>
								<option value="2" <?php echo ($request->status_kyc == '2') ? 'selected' : '';?>>Endorsed</option>
                        <option value="3" <?php echo ($request->status_kyc == '3') ? 'selected' : '';?>>Rejected</option>
								<option value="4" <?php echo ($request->status_kyc == '4') ? 'selected' : '';?>>Verified</option>
							</select>
						</div>
						<div class="col-md-1">
							<select class="form-control" name="show_entries">
								<option value="50" <?php echo ($request->show_entries == '50') ? 'selected' : '';?>>50</option>
								<option value="100" <?php echo ($request->show_entries == '100') ? 'selected' : '';?>>100</option>
								<option value="500" <?php echo ($request->show_entries == '500') ? 'selected' : '';?>>500</option>
								<option value="1000" <?php echo ($request->show_entries == '1000') ? 'selected' : '';?>>1000</option>
							</select>
						</div>
						<div class="col-md-2">
							<button class="btn btn-success" style="margin-top:2px;"><i class="fa fa-search"></i> Search</button>
						</div>
					</div>
               </div>
				</form>


            <h4>Return <strong><?php echo sizeof($users_kyc);?></strong> result(s). Limit to <strong><?php echo ($request->show_entries == '') ? '50' : $request->show_entries;?> </strong>records.</h4>
				<table class="table table-striped table-bordered table-hover">
					<thead>
                  <th>No</th>
						<th>User ID</th>
                  <th>Name</th>
                  <th>Username</th>
						<th>Status</th>
						<th>Date KYC</th>
						<th>Date Endorse</th>
						<th>Date Approve</th>
					</thead>
					<tbody class="">
						<?php $no = 1;?>
						<?php
						$array_status_kyc = array(	'1'=>'Verification','2'=>'Endorsed','3'=>'Rejected','4'=>'Verified',
															'label1'=>'label-default','label2'=>'label-warning','label3'=>'label-danger','label4'=>'label-success');
						?>
						<?php foreach($users_kyc as $u):?>
						<tr>
                     <td rowspan=2><?php echo $no;?></td>
                     <td><?php echo $u->id;?></td>
							<td><?php echo $u->name;?></td>
                     <td><a href="/master/login/id/<?php echo $u->id;?>"><?php echo $u->username;?></a></td>
							<td><span class="label <?php echo $array_status_kyc['label'.$u->kyc];?>"><?php echo $array_status_kyc[$u->kyc];?></span></td>
							<td><?php echo $u->kyc_date;?></td>
							<td><?php echo $u->kyc_endorse_date;?></td>
							<td><?php echo $u->kyc_approve_date;?></td>
						</tr>
						<tr>
							<td colspan="7">Note : <?php echo $u->kyc_note;?></td>
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
$(document).ready(function($) {


});

jQuery(document).ready(function () {
	TableAdvanced.init()


});
</script>
@stop
