@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="b">
						<td>Username</td>
						<td>ID</td>
						<td>Youtube</td>
						<td>Action</td>
							
					</thead>
					<tbody>
						@foreach($kyc as $output)
						@if(strstr($output->youtube,'youtube'))
						<tr>							
							<td>{{$output->username}}</td>
							<td><a target="_blank" href="{{app('App\Http\Controllers\UserController')->getIdUrl($output->id)}}">{{$output->identification}}</a></td>
							<td><a target="_blank" href="{{$output->youtube}}">{{$output->youtube}}</a></td>
							<td>
								<form method="post" action="/master/approval/kyc">
									{!! csrf_field() !!}
									<input type="hidden" name="status" value="1">
									<input type="hidden" name="user_id" value="{{$output->id}}">
									<button class="btn btn-block btn-xs btn-success">Approve</button>
								</form>
								<form method="post" action="/master/approval/kyc">
									{!! csrf_field() !!} 
									<input type="hidden" name="status" value="0">
									<input type="hidden" name="user_id" value="{{$output->id}}">
									<button class="btn btn-block btn-xs btn-danger">Reject</button>
								</form>
							</td>
						</tr>
						@endif
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