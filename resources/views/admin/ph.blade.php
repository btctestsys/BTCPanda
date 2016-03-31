@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="portlet light ">
			<div class="portlet-body">
			<div class="table-responsive">
				<table class="table table-striped" id="sample_1">
					<thead class="b">
						<th>Date</td>
						<th>Member</td>
						<th>Sponsor</td>
						<th>Amt</td>
					</thead>
					<tbody>
						@foreach($ph as $output)
						<tr>							
							<td>{{$output->created_at}}</td>
							<td><a href="/master/login/id/{{$output->user_id}}">{{$output->username}}</a></td>
							<td><a href="/master/login/id/{{$output->sid}}">{{$output->susername}}</a></td>
							<td>{{round($output->amt,8)}}</td>
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