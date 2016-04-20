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
						<td>Unilevel Bonus</td>
						<td>Days</td>
						<td>
							<form method="post" action="/master/approval/unilevel/all">
								{!! csrf_field() !!}
								<button class="btn btn-xs btn-danger">Approve All</button>
							</form>
						</td>
					</thead>
					<tbody>
						{{--*/ $total_uni =  0 /*--}}
						@foreach($unilevels as $output)
						<tr>
							<td>{{$output->created_at}}</td>
							<td>
							@if($output->u3s>=1)
							<a href="/master/login/id/{{$output->sid1}}"><mark><strike>{{$output->susername1}}</strike></mark></a>({{round($output->sph1,2)}})
							@else
							<a href="/master/login/id/{{$output->sid1}}">{{$output->susername1}}</a>({{round($output->sph1,2)}})
							@endif
							@if($output->u1s>=1)
							-> <a href="/master/login/id/{{$output->user_id}}"><mark><strike>{{$output->username}}</strike></mark></a>({{round($output->uph,2)}})
							@else
							-> <a href="/master/login/id/{{$output->user_id}}">{{$output->username}}</a>({{round($output->uph,2)}})
							@endif
							@if($output->u2s>=1)
							-> <a href="/master/login/id/{{$output->sid}}"><mark><strike>{{$output->susername}}</strike></mark></a>({{round($output->sph,2)}})
							@else
							-> <a href="/master/login/id/{{$output->sid}}">{{$output->susername}}</a>({{round($output->sph,2)}})
							@endif
							</td>
							<td>{{round($output->amt,8)}}</td>
							<td>{{Carbon\Carbon::parse($output->created_at)->diffindays()}}</td>
							<td>
							<form method="post" action="/master/approval/unilevel">
								{!! csrf_field() !!}
								<input type="hidden" name="id" value="{{$output->id}}">
								<input type="hidden" name="member" value="{{$output->susername1}}">
								<input type="hidden" name="ref_bonus" value="{{round($output->amt,8)}}">
								<button class="btn btn-xs btn-success">Approve</button>
							</form>
							</td>
						</tr>
							{{--*/ $total_uni =  $total_uni + $output->amt /*--}}
						@endforeach
						<tr>
							<td></td>
							<td>Total</td>
							<td>{{round($total_uni,8)}}</td>
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
