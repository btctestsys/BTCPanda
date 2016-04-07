@extends('layouts.master')

@section('content')
@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif
<div class="row">	
	<div class="col-lg-12 m-b-20">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn waves-effect waves-light btn-primary">{{trans('main.referral_link')}}</button>
			</div>
			<input class="form-control" type="text" value="http://btcpanda.com/register/{{$user->username}}">
		</div>
	</div>
</div>
	
<h4 style="margin-top:0">{{trans('main.currentactive')}}</h4>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">

				<table class="table table-striped">
				<thead class="b" style="background:green;color:white;">
					<td>Name</td>
					<td>Username</td>
					<td>Level</td>
					<td>Email</td>
					<td>Mobile</td>
					<td>PH</td>
				</thead>
				<tbody>
				@forelse($referrals as $output)
				@if($output->amt != 0)
					<tr>
					<td>{{$output->name}}</td>
					<td><a href="/referral/{{$output->username}}">{{$output->username}}</a></td>
					<td>{{$output->level->name}}</td>
					<td>{{$output->email}}</td>
					<td>@if($output->mobile) {{$output->mobile}} @else - @endif</td>
					<td>{{round($output->amt,8)}}</td>
					</tr>
				@endif
				@empty
					<tr><td colspan="6">-</td></tr>
				@endforelse
				</tbody>
				</table>

			</div>
		</div>
	</div>
</div>

<h4 style="margin-top:0">{{trans('main.quiet')}}</h4>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="b" style="background:grey;color:white;">
						<td>Name</td>
						<td>Username</td>
						<td>Level</td>
						<td>Email</td>
						<td>Mobile</td>
						<td>PH</td>
					</thead>
					<tbody>
						@forelse($referrals as $output)
						@if($output->amt == 0)
							<tr>
							<td>{{$output->name}}</td>
							<td><a href="/referral/{{$output->username}}">{{$output->username}}</a></td>
							<td>{{$output->level->name}}</td>
							<td>{{$output->email}}</td>
							<td>@if($output->mobile) {{$output->mobile}} @else - @endif</td>
							<td>{{round($output->amt,8)}}</td>
							</tr>
						@endif
						@empty
						<div class="col-lg-12">
							<tr><td colspan="6">-</td></tr>
						</div>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div><!-- row -->

<h4 style="margin-top:0">{{trans('main.nonactive')}}</h4>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-border panel-primary">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="b" style="background:crimson;color:white;">
						<td>Name</td>
						<td>Username</td>
						<td>Level</td>
						<td>Email</td>
						<td>Mobile</td>
						<td>PH</td>
					</thead>
					<tbody>
						@forelse($referrals_inactive as $output)
							<tr>
							<td>{{$output->name}}</td>
							<td><a href="/referral/{{$output->username}}">{{$output->username}}</a></td>
							<td>{{$output->level->name}}</td>
							<td>{{$output->email}}</td>
							<td>@if($output->mobile) {{$output->mobile}} @else - @endif</td>
							<td>{{round($output->amt,8)}}</td>
							</tr>
						@empty
						<div class="col-lg-12">
							<tr><td colspan="6">-</td></tr>
						</div>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div><!-- row -->

@stop

@section('js')
@stop

@section('docready')
<script type="text/javascript">
$(document).ready(function($) {
	//
});
</script>
@stop