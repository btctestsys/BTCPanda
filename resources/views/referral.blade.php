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
	@forelse($referrals as $output)
	@if($output->amt != 0)
	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-success" style="height:280px">
			<div class="panel-heading">
				<img src="/assets/images/avatar.jpg" alt="" class="thumb-md img-circle pull-right">
				<h3 class="panel-title">{{$output->name}}</h3>
			</div>
			<div class="panel-body">
				<p>
					<b>{{trans('main.username')}}</b><br/>
					{{$output->username}} ({{$output->level->name}})
				</p>
				<p>
					<b>{{trans('main.contact')}}</b><br/>
					{{$output->email}}<br/>
					{{$output->mobile}}
				</p>
				<p>
					<b>{{trans('main.ph')}}</b><br/>
					<i class="fa fa-bitcoin"></i> {{round($output->amt,8)}}
				</p>

			</div>
		</div>
	</div>
	@endif
	@empty
	<div class="col-lg-12">
		<p>{{trans('main.no_referrals')}}<p>
	</div>
	@endforelse
</div>

<div class="row">
@foreach($referrals as $output)
@if($output->amt == 0)
	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-default" style="height:280px">
			<div class="panel-heading">
				<img src="/assets/images/avatar.jpg" alt="" class="thumb-md img-circle pull-right">
				<h3 class="panel-title">{{$output->name}}</h3>
			</div>
			<div class="panel-body">
				<p>
					<b>{{trans('main.username')}}</b><br/>
					{{$output->username}} ({{$output->level->name}})
				</p>
				<p>
					<b>{{trans('main.contact')}}</b><br/>
					{{$output->email}}<br/>
					{{$output->mobile}}
				</p>
				<p>
					<b>{{trans('main.ph')}}</b><br/>
					<i class="fa fa-bitcoin"></i> {{round($output->amt,8)}}
				</p>

			</div>
		</div>
	</div>
	@endif
@endforeach
</div><!-- row -->

<div class="row">
@foreach($referrals_inactive as $output)
@if(true)
	<div class="col-lg-4">
		<div class="panel panel-default panel-border panel-danger" style="height:280px">
			<div class="panel-heading">
				<img src="/assets/images/avatar.jpg" alt="" class="thumb-md img-circle pull-right">
				<h3 class="panel-title">{{$output->name}}</h3>
			</div>
			<div class="panel-body">
				<p>
					<b>{{trans('main.username')}}</b><br/>
					{{$output->username}} ({{$output->level->name}})
				</p>
				<p>
					<b>{{trans('main.contact')}}</b><br/>
					{{$output->email}}<br/>
					{{$output->mobile}}
				</p>
				<p>
					<b>{{trans('main.ph')}}</b><br/>
					<i class="fa fa-bitcoin"></i> {{round($output->amt,8)}}
				</p>

			</div>
		</div>
	</div>
	@endif
@endforeach
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