@extends('layouts.master')

@section('content')
@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success panel-border">
			<div class="panel-heading">
				<h3 class="panel-title text-center">{{$current_user->name}}'s ({{$current_user->level->name}}) Downlines</h3>
			</div>
			<div class="panel-body">
				<p>
					@forelse($users as $output)
						<a href="/tree/{{Crypt::encrypt($output->id)}}">
							<div class="col-lg-4 nametag">
								@if($output->level->id == 1)
									<span style="color:grey"><b>{{$output->level->name}}</b> @if($output->country) ({{$output->country}}) @endif<br/>{{ucwords(strtolower($output->name))}}</span>
								@endif

								@if($output->level->id == 2)
									<span style="color:blue"><b>{{$output->level->name}}</b> @if($output->country) ({{$output->country}}) @endif<br/>{{ucwords(strtolower($output->name))}}</span>
								@endif

								@if($output->level->id == 3)
									<span style="color:orange"><b>{{$output->level->name}}</b> @if($output->country) ({{$output->country}}) @endif<br/>{{ucwords(strtolower($output->name))}}</span>
								@endif

								@if($output->level->id == 4)
									<span style="color:crimson"><b>{{$output->level->name}}</b> @if($output->country) ({{$output->country}}) @endif<br/>{{ucwords(strtolower($output->name))}}</span>
								@endif

								@if($output->level->id == 5)
									<span style="color:green"><b>{{$output->level->name}}</b> @if($output->country) ({{$output->country}}) @endif<br/>{{ucwords(strtolower($output->name))}}</span>
								@endif

								@if($output->level->id == 6)
									<span style="color:gold"><b>{{$output->level->name}}</b> @if($output->country) ({{$output->country}}) @endif<br/>{{ucwords(strtolower($output->name))}}</span>
								@endif							
							</div>
						</a>
					@empty
						No Downlines
					@endforelse
				</p>
			</div>
		</div>
	</div>
</div>
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