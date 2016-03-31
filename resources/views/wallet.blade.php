@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-lg-12"> 
        <ul class="nav nav-tabs tabs tabs-top" style="width: 100%;">
            <li class="tab active" style="width: 25%;">
                <a href="#wallet-details" data-toggle="tab" aria-expanded="true" class="active"> 
                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                    <span class="hidden-xs">{{trans('main.details')}}</span> 
                </a> 
            </li> 
            <li class="tab" style="width: 25%;"> 
                <a href="#wallet-receive" data-toggle="tab" aria-expanded="false" class=""> 
                    <span class="visible-xs"><i class="fa fa-qrcode"></i></span> 
                    <span class="hidden-xs">{{trans('main.deposit')}}</span> 
                </a> 
            </li> 
            <li class="tab" style="width: 25%;"> 
                <a href="#wallet-send" data-toggle="tab" aria-expanded="false" class=""> 
                    <span class="visible-xs"><i class="fa fa-rocket"></i></span> 
                    <span class="hidden-xs">{{trans('main.send')}}</span> 
                </a> 
            </li> 
            <li class="tab" style="width: 25%;"> 
                <a href="#wallet-history" data-toggle="tab" aria-expanded="false" class=""> 
                    <span class="visible-xs"><i class="fa fa-rocket"></i></span> 
                    <span class="hidden-xs">{{trans('main.history')}}</span> 
                </a> 
            </li> 

        <div class="indicator" style="right: 367px; left: 0px;"></div></ul> 
        
        <div class="tab-content"> 

            <div class="tab-pane" id="wallet-details" style="display: block;"> 
                <p @if(Agent::isMobile()) class="small" @endif>
                	<b>{{trans('main.your_wallet')}}</b><br/>
                	<span>{{$user->wallet->wallet_address}}</span>
                </p>
                <p @if(Agent::isMobile()) class="small" @endif>
                	<b>{{trans('main.wallet_links')}}</b><br/>
                	<a target="_blank" href="https://blockchain.info/address/{{$user->wallet->wallet_address}}">Blockchain</a>,
                	<a target="_blank" href="https://blockexplorer.com/address/{{$user->wallet->wallet_address}}">Blockexplorer</a>,
                	<a target="_blank" href="https://chain.so/address/BTC/{{$user->wallet->wallet_address}}">SoChain</a>
                </p>
                <hr/>
                <p @if(Agent::isMobile()) class="small" @endif>
                	<b>{{trans('main.current_balance')}}</b><br/>
                	<i class="fa fa-bitcoin"></i> {{round($user->wallet->current_balance,8)}}
                </p>
                <p class="@if(Agent::isMobile()) small @endif orange hide">
                	<b>{{trans('main.pending_cfm')}}</b><br/>
                	<i class="fa fa-bitcoin"></i> {{round($user->wallet->pending_balance,8)}}
                </p>

                <p class="@if(Agent::isMobile()) small @endif text-success">
                	<b>{{trans('main.available_balance')}}</b><br/>
                	<i class="fa fa-bitcoin"></i> <span title="{{round($available_balance,8)}}">@if($available_balance < 0.000001) 0 @else {{round($available_balance,8)}} @endif</span>
                </p>

                <p class="@if(Agent::isMobile()) small @endif text-success">
                	<b>Withdrawal Queue</b><br/>
                	<i class="fa fa-bitcoin"></i> <span title="{{round($wallet_queue,8)}}">@if($wallet_queue < 0.000001) 0 @else {{round($wallet_queue,8)}} @endif</span>
                </p>
                <br>
                <a href="/wallet"><button id="sync" class="btn btn-warning">{{trans('main.sync')}}</button></a>
	@if(session('isAdmin')=='true') 
		<br><br>
		Admin View:<br>
		current_balance = {{$current_balance}}<br>
		pending_balance = {{$pending_balance}}<br>
		available_balance = {{$available_balance}}<br>
		wallet_queue = {{$wallet_queue}}<br>
		sumPhActive = {{$sumPhActive}}<br>
		sumPhActiveDistributed = {{$sumPhActiveDistributed}}<br>
		available_balance_final = {{$available_balance_final}}<br>
	@endif

            </div> 
            <div class="tab-pane" id="wallet-receive" style="display: none;">
				<a href="bitcoin:{{$user->wallet->wallet_address}}"><div id="qrcode" align="center"></div></a>
                <div class="text-center small">{{$user->wallet->wallet_address}}</div>
			</div> 
            <div class="tab-pane" id="wallet-send" style="display: none;">
                @if($available_balance < 0.01)
                    {{trans('main.not_enough')}} {{trans('main.min_required')}}
                @else
                    @if($user->otp) <form class="form" method="post" action="/wallet/send">{!! csrf_field() !!} @endif
                    <input type="hidden" name="hidden" value="{{Crypt::encrypt($user->id)}}">
                	<label class="form-label">{{trans('main.send_to')}}</label>
					@if ($user->wallet1 or $user->wallet2)
	    			<select class="form-control" name="address" id="address">
						@if ($user->wallet1)
							<option value="{{$user->wallet1}}">{{$user->wallet1}}</option>						
						@endif
						@if ($user->wallet2)
							<option value="{{$user->wallet2}}">{{$user->wallet2}}</option>						
						@endif
    				</select>
					@else
                	<input disabled type="text" class="form-control" placeholder="No wallet registered. Click My Settings to register." name="err">
					@endif

                	<br/>
                	<label class="form-label">{{trans('main.btc_amt')}}</label>
                	<input type="text" class="form-control" placeholder="{{trans('main.amount')}}" name="amt">
                	<br/>
                    <label class="form-label">{{trans('main.fee')}}</label>
                    <input type="text" class="form-control" placeholder="{{trans('main.fee')}}" name="fee" value="0.0005">
                    <br/>
                    <label class="form-label">{{trans('main.verify_with_otp')}}</label>
                    <input type="text" class="form-control" placeholder="{{trans('main.otp')}}" name="otp">
                    <br/>
                    <button 
					@if (app('App\Http\Controllers\WalletController')->get_next_trans_inmin_inwallet() > 0) disabled @endif
					class="btn btn-block btn-primary btc_sent">{{trans('main.send')}} BTC</i></button>
                    @if($user->otp) </form> @endif
                    
                    @if($user->otp)
                    <button class="btn btn-block disabled m-t-10" id="otp_btn">{{trans('main.otp_sent')}}</i></button>                    
                    @else
                        <button class="btn btn-block btn-warning m-t-10 otp_requested" onclick="sendotpnow(); return false;" id="otp_btn">{{trans('main.request_otp')}}</i></button>
                    @endif                    
                @endif
            </div> 

            <div class="tab-pane" id="wallet-history" style="display: block;"> 
                <p @if(Agent::isMobile()) class="small" @endif>
                    <span>Please refer "The Blockchain" for your transaction history. (It's more accurate)</span>
                    <br/>
                    <br/>
                    <a target="_blank" href="https://blockchain.info/address/{{$user->wallet->wallet_address}}">Blockchain</a>
                    <br/>
                    <a target="_blank" href="https://blockexplorer.com/address/{{$user->wallet->wallet_address}}">Blockexplorer</a>
                    <br/>
                    <a target="_blank" href="https://chain.so/address/BTC/{{$user->wallet->wallet_address}}">SoChain</a>
					 @if(session('isAdmin')=='true')
					<hr>
					<h3><span class="btn btn-sm btn-warning">Admin View</span> Last 100 Wallet History</h3> <small>Mouse over to the transaction to view the blockchain status</small>
					<table class="table table-striped table-bordered table-hover" id="sample_1">
						<thead>
							<th>No</th>
							<th>Date</th>
							<th>From</th>
							<th>To</td>
							<th>Type</td>
							<th>Amount</td>
						</thead>
						<tbody>
							{{--*/ $cnt =  1 /*--}}
							@foreach($walletqueue_history as $output)
							<tr title="{{$output->json}}">
								<td>{{$cnt}}&nbsp;</td>
								<td>{{$output->created_at}}&nbsp;</td>
								<td>{{$output->from}}&nbsp;</td>
								<td>{{$output->to}}&nbsp;</td>
								<td>{{$output->typ}}&nbsp;</td>
								<td>{{round($output->amt,8)}}&nbsp;</td>
							</tr>
							{{--*/ $cnt =  $cnt + 1 /*--}}
							@endforeach
						</tbody>
					</table>
					@endif
				</p>
            </div>

        </div> 
    </div>
</div>
@stop

@section('js')
<script type="text/javascript" src="/js/jquery.qrcode.min.js"></script>
<script>
function sendotpnow()
{
    var jqxhr = $.ajax( "/sms/otp" )
    .done(function(data) {
		$.each(data, function(i, obj) {
		  if(obj.status=="Error")
		  {
			$('#otp_btn').html("{{trans('main.otp_sent')}}");
		  }
		  else
		  { 
		    swal("OTP Sent!", "Please wait till this popup closes.", "success")
			$('#otp_btn').html("{{trans('main.request_otp')}}");
			window.location.href="/wallet#wallet-send"
			location.reload();
		  }
		});        
    })
    .fail(function(data) {
        alert("There was some error. Try again.");
    })
    .always(function(data) {
        return null;
    });
}
</script>

@stop

@section('docready')
<script type="text/javascript">
$(document).ready(function($) {
	$('#qrcode').qrcode("{{$user->wallet->wallet_address}}");
    $('#sync').click(function() 
    {        
        $('#sync').html('Syncing...');
    });
    
    $('.otp_requested_disabled').click(function(){
    swal("OTP Sent!", "Please wait till this popup closes.", "success")
    });

    $('.btc_sent').click(function(){
    swal("BTC Sent!", "You will be redirected to the TX Hash page.", "success")
    });

	var url = document.location.toString();
	if (url.match('#')) {
		$('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
		$('#'+url.split('#')[1]+'').show() ;
	}

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		window.location.hash = e.target.hash;
	});
});
</script>
@stop