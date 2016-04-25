@extends('layouts.master')


@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN BANKS PORTLET-->
		<div class="portlet light tasks-widget">
			<div class="portlet-body">
				<h2><i class="fa fa-list-ol"></i> Downline</h2>
            <p>Listing of your downline. </p>

            <form action="" method="get">
				<div id="div_advance_search" class="alert alert-success">
					<h4>Search : </h4>
					<div class="row">
						<div class="col-md-2">
							<input type="text" value="<?php echo $request->uname;?>" name="uname" class="form-control" placeholder="Enter Username">
						</div>
						<div class="col-md-2">
                     <select class="form-control" name="select_ph">
								<option value="" <?php echo ($request->select_ph == '') ? 'selected' : '';?>>ALL</option>
								<option value="1" <?php echo ($request->select_ph == '1') ? 'selected' : '';?>>Has Ph</option>
								<option value="2" <?php echo ($request->select_ph == '2') ? 'selected' : '';?>>Has Active Ph</option>
                        <option value="3" <?php echo ($request->select_ph == '3') ? 'selected' : '';?>>Ph = 0</option>
                        <option value="4" <?php echo ($request->select_ph == '4') ? 'selected' : '';?>>Active Ph = 0</option>
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
						<button class="btn btn-success" style="margin-top:2px;"><i class="fa fa-search"></i> Search</button>

					</div>
               </div>
				</form>


            <h4>Return <strong><?php echo sizeof($u);?></strong> result(s). Limit to <strong><?php echo ($request->show_entries == '') ? '50' : $request->show_entries;?> </strong>records.</h4>
				<table class="table table-striped table-bordered table-hover">
					<thead>
                  <th>No</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Ph</th>
                  <th>Ph Active</th>
					</thead>
					<tbody class="">
						<?php $no = 1;?>
						<?php foreach($u as $a):?>
						<tr>
                     <td><?php echo $no;?></td>
                     <td><?php echo $a->name;?></td>
                     <td>
                     <?php echo $a->username;?> -> <?php echo $a->susername;?></td>
                     <td>
                        <?php
                        if($a->referral_id == session('user_id')){
                           echo $a->email;
                        }else{
                           echo '<i class="text-muted">Hidden</i>';
                        }
                        ?>
                     </td>
                     <td>
                        <?php
                        if($a->referral_id == session('user_id')){
                           echo $a->mobile;
                        }else{
                           echo '<i class="text-muted">Hidden</i>';
                        }
                        ?>
                     </td>
                     <td><?php echo round($a->phall,4);?></td>
                     <td><?php echo round($a->phactive,4);?></td>
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
	//
});

jQuery(document).ready(function () {
	TableAdvanced.init()


});
</script>
@stop
