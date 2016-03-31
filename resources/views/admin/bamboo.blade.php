@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="portlet light ">
			<div class="portlet-body">
			<div class="table-responsive">
				<table class="table table-striped" id="sample_1">
					<thead class="b">
						<td>Date</td>
						<td>From</td>
						<td>To</td>
						<td>Amt</td>
						<td>Notes</td>
						<td>Rate</td>
					</thead>
					<tbody>
						@foreach($bamboos as $output)
						<tr>							
							<td>{{$output->created_at}}</td>
							<td>{{$output->from}}</td>
							<td>{{$output->to}}</td>
							<td>{{$output->amt}}</td>
							<td>{{$output->notes}}</td>
							<td>@if($output->rate) {{round($output->rate,8)}} @endif</td>
						</tr>
						@endforeach
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
jQuery(document).ready(function () {
	TableAdvanced.init()
});
</script>
@stop