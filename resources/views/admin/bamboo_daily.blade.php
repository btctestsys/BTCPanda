@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="b">
						<td>Date</td>
						<td>Pins</td>
					</thead>
					<tbody>
						@foreach($bamboos as $output)
						<tr>							
							<td>{{$output->date}}</td>
							<td>{{$output->pins}}</td>
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