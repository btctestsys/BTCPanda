@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success panel-border">
			<div class="panel-heading">
				<h3 class="panel-title text-left">{{$current_user->name}}'s ({{$current_user->level->name}}) Downlines</h3>
			</div>
			<div class="panel-body">
				<div id="tree_1" class="tree-demo">
					<ul><!-- main -->
				{{--*/ $lvl1_cnt =  1 /*--}}
				{{--*/ $lvl2_cnt =  1 /*--}}
				{{--*/ $lvl3_cnt =  1 /*--}}

				{{--*/ $lastlvl = 0 /*--}}
				{{--*/ $close2 = '' /*--}}
				{{--*/ $close3 = '' /*--}}

				@foreach ($users2 as $usertree) 
					@if(app('App\user')->isIDAdmin($usertree->id))
						//dont show this record
					@else
						@if($usertree->lvl == 1)
							@if($lastlvl==2)
								{!! $close2 !!}
								{{--*/ $close2 =  '' /*--}}
							@endif
							@if($lastlvl==3)
								{!! $close2 !!}
								{{--*/ $close2 =  '' /*--}}
								{!! $close3 !!}
								{{--*/ $close3 =  '' /*--}}
							@endif
							<li data-jstree='{ "icon" : "fa fa-user" }'><a href="/unitree/{{Crypt::encrypt($usertree->id)}}"><span style="color:{{ $usertree->color }}">{{ $usertree->country }}-{{ $usertree->id }}:{{ $usertree->username }} ({{ $usertree->title }}) - PH:{{  round($usertree->ph,8) }}</span></a>
							{{--*/ $lvl2_cnt =  1 /*--}}
							{{--*/ $lastlvl = 1 /*--}}
						@endif

						@if($usertree->lvl == 2)
							@if($lastlvl==3)
								{!! $close3 !!}
								{{--*/ $close3 =  '' /*--}}
							@endif
							@if($lvl2_cnt==1)
								<ul> <!-- lvl2 -->
								{{--*/ $close2 =  '</ul></li> <!-- lvl 2 -->' /*--}}
							@endif
							<li data-jstree='{ "icon" : "fa fa-user" }'><a href="/unitree/{{Crypt::encrypt($usertree->id)}}"><span style="color:{{ $usertree->color }}">{{ $usertree->country }}-{{ $usertree->id }}:{{ $usertree->username }} ({{ $usertree->title }}) - PH:{{  round($usertree->ph,8) }}</span></a>
							{{--*/ $lvl2_cnt = $lvl2_cnt + 1 /*--}}
							{{--*/ $lvl3_cnt =  1 /*--}}
							{{--*/ $lastlvl = 2 /*--}}
						@endif

						@if($usertree->lvl == 3)
							@if($lvl3_cnt==1)
								<ul> <!-- lvl 3 -->
								{{--*/ $close3 =  '</ul></li> <!-- lvl 3 -->' /*--}}
							@endif
							<li data-jstree='{ "icon" : "fa fa-user" }'><a href="/unitree/{{Crypt::encrypt($usertree->id)}}"><span style="color:{{ $usertree->color }}">{{ $usertree->country }}-{{ $usertree->id }}:{{ $usertree->username }} ({{ $usertree->title }}) - PH:{{  round($usertree->ph,8) }}</span></a>
							{{--*/ $lvl3_cnt = $lvl3_cnt + 1 /*--}}
							{{--*/ $lastlvl = 3 /*--}}
						@endif
					@endif
				@endforeach
					</ul> <!-- main -->
				</div>
				
				<br>
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