@extends('layouts.admin')

@section('content')
<a class="btn btn-sm btn-success" href="/master/updatebalance">Update All Wallets</a> 
<a class="btn btn-sm btn-success" href="/master/updatebalanceselected">Update Selected Wallets</a> <br>

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
					@foreach($ph_sum as $output)
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

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="b">
						<td>Date</td>
						<td width=40%>Member</td>
						<td>Wallet</td>
						<td>PH</td>
						<td>Balance</td>
						<td>Days</td>
						<td></td>
						<td>
							<a href='javascript:;' class="data-add-all-div btn btn-sm btn-success" > + </a>
							<a href='javascript:;' class="data-del-all-div btn btn-sm btn-warning" > - </a>
						</td>
					</thead>
					<tbody>
						{{--*/ $total_w =  0 /*--}}
						{{--*/ $total_bal =  0 /*--}}
						{{--*/ $total_queue =  0 /*--}}
						{{--*/ $total_w_sel =  0 /*--}}
						{{--*/ $total_bal_sel =  0 /*--}}
						{{--*/ $total_queue_sel =  0 /*--}}
						@foreach($ph as $output)
						<tr>							
							<td>{{$output->created_at}}</td>
							<td width=40%><a href="/master/login/id/{{$output->user_id}}">{{$output->username}}</a>({{round($output->uph,2)}})
							-> <a href="/master/login/id/{{$output->sid}}">{{$output->susername}}</a>({{round($output->sph,2)}})
							-> <a href="/master/login/id/{{$output->sid1}}">{{$output->susername1}}</a>({{round($output->sph1,2)}})</td>
							<td>{{round($output->current_balance,8)}}</td>
							<td>{{round($output->amt,8)}}</td>
							<td>{{round($output->amt - $output->amt_distributed,8)}}</td>
							<td>{{$output->ddifc}}</td>
							<td>
							@if ($output->selected) <i class='icon-like'></i> @endif
							</td>
							<td>
							<a href='javascript:;' class="data-add-div btn btn-sm btn-success" data-id='{{$output->pid}}' > + </a>
							<a href='javascript:;' class="data-del-div btn btn-sm btn-warning" data-id='{{$output->pid}}' > - </a>
							</td>
						</tr>
							{{--*/ $total_w =  $total_w + $output->current_balance /*--}}
							{{--*/ $total_queue =  $total_queue + $output->amt /*--}}
							{{--*/ $total_bal =  $total_bal + $output->amt_distributed /*--}}
							@if ($output->selected) 
							{{--*/ $total_w_sel =  $total_w_sel + $output->current_balance /*--}}
							{{--*/ $total_queue_sel =  $total_queue_sel + $output->amt /*--}}
							{{--*/ $total_bal_sel =  $total_bal_sel + $output->amt_distributed /*--}}
							 @endif
						@endforeach
						<tr>							
							<td></td>
							<td>Total</td>
							<td>{{round($total_w,8)}}</td>
							<td>{{round($total_queue,8)}}</td>
							<td>{{round($total_queue - $total_bal,8)}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>							
							<td></td>
							<td>Total Selected</td>
							<td>{{round($total_w_sel,8)}}</td>
							<td>{{round($total_queue_sel,8)}}</td>
							<td>{{round($total_queue_sel -$total_bal_sel,8)}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</thead>
				</tbody>
			</table>
		</div>

	</div>
</div>
</div>
@stop

@section('js')

@stop

@section('docready')
<script type="text/javascript">
jQuery(document).ready(function () {
	$('.data-add-all-div').on('click', function () {
		$.get("/master/selectallph/", function (data, status) {
			//alert(data);
			window.location.reload();
		});
	});

	$('.data-del-all-div').on('click', function () {
		$.get("/master/removeallph/", function (data, status) {
			//alert(data);
			window.location.reload();
		});
	});

	$('.data-add-div').on('click', function () {
		var vid = $(this).attr('data-id');
		$.get("/master/selectph/" + vid, function (data, status) {
			//alert(data);
		});
	});

	$('.data-del-div').on('click', function () {
		var vid = $(this).attr('data-id');
		$.get("/master/removeph/" + vid, function (data, status) {
			//alert(data);
		});
	});

});

</script>

@stop