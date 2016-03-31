@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="b">
						<td>Date</td>
						<td>Member</td>
						<td>Referral Bonus</td>						
						<td>Days</td>
						<td>
							<form method="post" action="/master/approval/referral/all">
								{!! csrf_field() !!} 
								<button class="btn btn-xs btn-danger">Approve All</button>
							</form>
						</td>
					</thead>
					<tbody>
						{{--*/ $total_ref =  0 /*--}}
						@foreach($referrals as $output)
						<tr>							
							<td>{{$output->created_at}}</td>
							<td>
							<a href="/master/login/id/{{$output->sid1}}">{{$output->susername1}}</a>({{round($output->sph1,2)}})
							-> <a href="/master/login/id/{{$output->user_id}}">{{$output->username}}</a>({{round($output->uph,2)}})
							-> <a href="/master/login/id/{{$output->sid}}">{{$output->susername}}</a>({{round($output->sph,2)}})
							</td>
							<td>{{round($output->amt,8)}}</td>
							<td>{{Carbon\Carbon::parse($output->created_at)->diffindays()+1}}</td>
							<td>
							<form method="post" action="/master/approval/referral">
								{!! csrf_field() !!} 
								<input type="hidden" name="id" value="{{$output->id}}">
								<button class="btn btn-xs btn-success">Approve</button>
							</form>
							</td>
						</tr>
							{{--*/ $total_ref =  $total_ref + $output->amt /*--}}
						@endforeach
						<tr>							
							<td></td>
							<td>Total</td>
							<td>{{round($total_ref,8)}}</td>
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

@stop