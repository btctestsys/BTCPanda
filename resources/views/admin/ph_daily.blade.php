@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="b">
						<td>Date</td>
						<td>PH</td>
					</thead>
					<tbody>
						@foreach($ph as $output)
						<tr>							
							<td>{{$output->date}}</td>
							<td>{{round($output->total_ph,8)}}</td>
						</tr>
						@endforeach
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

@stop