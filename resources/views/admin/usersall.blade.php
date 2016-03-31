@extends('layouts.admin')

@section('content')

			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN BANKS PORTLET-->
					<div class="portlet light tasks-widget">
						<div class="portlet-body">

 	                        <div class="row">
			                    <form action="#" class="searchUser_form" id="searchUser_form" name="searchUser_form" method="get" onsubmit="/users">
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="text" id="tbname" name="tbname" class="form-control" placeholder="Enter Name" value="{{$request->tbname}}">
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="text" value="{{$request->tbuname}}" id="tbuname" name="tbuname" class="form-control" placeholder="Enter Username">
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="text" value="{{$request->tbwallet}}" id="tbwallet" name="tbwallet" class="form-control" placeholder="Enter Wallet">
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="text" value="{{$request->tbmobile}}" id="tbmobile" name="tbmobile" class="form-control" placeholder="Enter Mobile">
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
					                            <input type="text" value="{{$request->tbemail}}" id="tbemail" name="tbemail" class="form-control" placeholder="Enter Email">
				                            </div>
				                        </div>
					                    <div class="col-md-2">
				                            <div class="form-group">
									            <span class="input-group-btn">
									            <button class="btn blue" id="searchUser_btn" name="searchUser_btn">Search
									            </span>
				                            </div>
				                        </div>

                                </form>
		                    </div>
							<table class="table table-striped table-bordered table-hover" id="sample_1">
								<thead>
									<th>ID</th>
									<th>Ctry</th>
									<th>Name</th>
									<th>Member</td>
									<th>Email</th>
									<th>Pins</th>
									<th>Level</th>
								</thead>
								<tbody>
									{{--*/ $user_cnt =  1 /*--}}
									@foreach($users	 as $output)
									<tr>
										<td><a href="/master/login/id/{{$output->id}}">{{$output->id}}</a></td>
										<td>{{$output->country}}</td>
										<td>{{$output->name}}</td>
										<td><a href="/master/login/id/{{$output->id}}">{{$output->username}}</a>({{round($output->uph,2)}})
										-> <a href="/master/login/id/{{$output->sid}}">{{$output->susername}}</a>({{round($output->sph,2)}})
										-> <a href="/master/login/id/{{$output->sid1}}">{{$output->susername1}}</a>({{round($output->sph1,2)}})</td>
										<td>
											<div class="portlet-widgets">
												{{$output->email}} <a data-toggle="collapse" data-parent="#accordion1{!! $user_cnt !!}" href="#bg-default1{!! $user_cnt !!}" class="" aria-expanded="true"><span aria-hidden="true" class="icon-magnifier-add"></span></a>
											</div>
											<div id="bg-default1{!! $user_cnt !!}" class="panel-collapse collapse" aria-expanded="true">
															<?php echo $output->email ?><br/>
															<?php echo $output->mobile ?><br/>
															<?php echo $output->wallet_address ?><br/>
											</div>
										
										</td>
										<td>@if($output->bamboo_balance) {{$output->bamboo_balance}} @endif</td>
										<td>@if($output->level_id){{$output->level_id}} @endif</td>
									</tr>
									{{--*/ $user_cnt =  $user_cnt + 1 /*--}}
									@endforeach
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
	//TableAdvanced.init()
    $('#searchUser_btnx').click(function (e) {
        e.preventDefault();
		RefreshTable('#sample_1', 'users/q');
        return false;
    });

    function GetParams(sParam, sQS) {
        var sPageURL = sQS;
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }
    }

    function RefreshTable(tableId, urlData) {
		var postdata = $('.searchUser_form').serialize()
        $.getJSON(urlData, postdata, function (json,stat) {
            table = $(tableId).dataTable();
            oSettings = table.fnSettings();
            table.fnClearTable(this);

            for (var i = 0; i < json.data.length; i++) {
                table.oApi._fnAddData(oSettings, json.data[i]);
            }
				
            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            table.fnDraw();
        });
    }

});
</script>
@stop