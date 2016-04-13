@extends('layouts.master')

@section('content')
@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif
<?php
	#echo '<pre>';
	#print_r($user);
	#echo $user->id.'-'.session('has_admin_access');
	#echo '</pre>';
?>
<div class="row" >
	<div class="col-lg-12">
        <ul class="nav nav-tabs tabs tabs-top" style="width: 100%;">
            <li class="tab active" style="width: 25%;">
                <a href="#bamboo-details" data-toggle="tab" aria-expanded="true" class="active">
                    <span class="visible-xs"><i class="fa fa-home"></i></span>
                    <span class="hidden-xs">{{trans('main.details')}}</span>
                </a>
            </li>
            <li class="tab" style="width: 25%;">
                <a href="#bamboo-history" data-toggle="tab" aria-expanded="false" class="">
                    <span class="visible-xs"><i class="fa fa-history"></i></span>
                    <span class="hidden-xs">{{trans('main.history')}}</span>
                </a>
            </li>
            <li class="tab" style="width: 25%;">
                <a href="#bamboo-buy" data-toggle="tab" aria-expanded="false" class="">
                    <span class="visible-xs"><i class="fa fa-bitcoin"></i></span>
                    <span class="hidden-xs">{{trans('main.buy')}}</span>
                </a>
            </li>
            <li class="tab" style="width: 25%;">
                <a href="#bamboo-send" data-toggle="tab" aria-expanded="false" class="">
                    <span class="visible-xs"><i class="fa fa-paper-plane"></i></span>
                    <span class="hidden-xs">{{trans('main.send')}}</span>
                </a>
            </li>
        <div class="indicator" style="right: 367px; left: 0px;"></div></ul>
        <div class="tab-content">
            <div class="tab-pane" id="bamboo-details" style="display: block;">
            	<div class="row">
                	<div class="col-sm-12">
						<div class="widget-inline-box text-center">
							<h3 class="text-success"><i class="fa fa-thumb-tack"></i> <b>{{$user->bamboo_balance}}</b></h3>
							<h4 class="text-muted">{{trans('main.pin_balance')}}</h4>
						</div>
					</div>
                </div>
            </div>
            <div class="tab-pane" id="bamboo-history" style="display: none;">
				<div class="table-responsive">

                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>{{trans('main.when')}}</th>
                                <th>{{trans('main.amount')}}</th>
                                <th>{{trans('main.balance')}}</th>
                                <th>{{trans('main.notes')}}</th>
                            </tr>
                        </thead>
                            <tbody>
                            @forelse($history as $output)
                            <tr class="@if($output->from == $user->id) crimson @else blue @endif">
                                <td>{{$output->created_at}} <!-- ({{ Carbon\Carbon::parse($output->created_at)->diffForHumans()}}) --></td>

                                @if($output->from == $user->id)
                                <td>-{{$output->amt}}</td>
                                @else
                                <td>+{{$output->amt}}</td>
                                @endif

                                @if($output->from == $user->id)
                                <td>{{$output->from_balance}}</td>
                                @else
                                <td>{{$output->to_balance}}</td>
                                @endif

                                <td>{{$output->notes}}</td>
                            </tr>
                            @empty
                            <tr><td>{{trans('main.no_history')}}</td></tr>
                            @endforelse
                            </tbody>
                    </table>
					*Showing last 50 records
                </div>
			</div>

            <div class="tab-pane" id="bamboo-buy" style="display: block;">
                @if($user->walletBamboo->pending_balance != 0.00000000)
                    <div class="alert alert-danger text-center">{{trans('main.just_made_purchase')}}</div>
                @else
                    <div id="step1">
                    <h4 style="margin:0" class="b">Step 1</h4>
                    <p>How many PIN you wish to buy?</p>
                    <input type="text" class="form-control" placeholder="PIN Amount" name="bamboo" id="bamboo">

                    <br/>
                    </div>

                    <div id="step2">
                    <h4 style="margin:0" class="b">Step 2</h4>
                    <p>Send the Bitcoins to the QR code below</p>
                    <a href="bitcoin:{{$user->walletBamboo->wallet_address}}"><div id="qrcode"></div></a>
                    <div class="text-muted small">{{$user->walletBamboo->wallet_address}}</div>
                    <div class="text-muted small"><i class="fa fa-bitcoin"></i> {{round(app('App\Classes\Custom')->getPinBTCAmount(),8)}} x <span id="pin">1</span> Pin = <i class="fa fa-bitcoin orange"></i> <span class="orange" id="pin_total">{{round(app('App\Classes\Custom')->getPinBTCAmount(),8)}}</span></div>

                    <br/>
                    </div>

                    <div id="step3">
                    <h4 style="margin:0" class="b">Step 3</h4>
                    <p>Once Bitcoin is sent. Click check payment.</p>
                    <button class="btn btn-primary" id="bamboo_btn">{{trans('main.check_payment')}}</button>

                    <br/>
                    </div>

                    <div id="step4">
                    <br/>
                    <h4 style="margin:0" class="b">Step 4</h4>
                    <p>Confirm PIN Purchase</p>
                    <form class="form" method="post" action="/bamboo/buy">{!! csrf_field() !!}
                        <button class="btn btn-success" id="bamboo_btn">Confirm PIN Purchase</button>
                    </form>
                    <br/>
                    </div>

                    @if (in_array(session('AdminLvl'),array(3,4)))
                    <hr/>
                    <form class="form" method="post" action="/bamboo/buyx">{!! csrf_field() !!}
                        <button class="btn btn-primary btn-warning" id="bamboo_btnx">ADMIN: Credit PIN on Confirmed Balance</button>
                    </form>
                    @endif
                @endif
            </div>

            <div class="tab-pane" id="bamboo-send" style="display: none;">
					<?php
						$disabled = '';
						if(in_array(session('AdminLvl'),array(1,2))){
							if($user->id == session('has_admin_access')){
								$disabled = '';
							}else{
								$disabled = 'disabled';
							}
						}elseif($user->otp){
							$disabled = 'disabled';
						}
					?>
                <form class="form" method="post" action="/bamboo/send">
                    {!! csrf_field() !!}
                	<label class="form-label">{{trans('main.send_to')}}:</label>
                	<input type="text" class="form-control" placeholder="Username" name="username">
                	<br/>
                	<label class="form-label">{{trans('main.pin_amt')}}:</label>
                	<input type="text" class="form-control" placeholder="Amount" name="amt">
                    <br/>
                    <label class="form-label">{{trans('main.otp')}}:</label>
                    <input type="text" class="form-control" placeholder="OTP" name="otp">
                	<br/>
                	<button class="btn btn-block btn-success" <?php echo $disabled;?>>{{trans('main.send')}}</button>
                </form>

               <form role="form" method="post" action="/sms/otp" target="iframe">{!! csrf_field() !!}
               <button <?php echo $disabled;?> onclick="sendotpnow(); return false;" id="otp_btn" type="submit" class="btn btn-block btn-warning waves-effect waves-light m-t-10">
						@if($user->otp) {{trans('main.otp_sent')}} @else {{trans('main.request_otp')}} @endif
					</button>
               </form>
               <iframe name="iframe" class="hide"></iframe>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript" src="/js/jquery.qrcode.min.js"></script>
<script>
function checkPayment()
{
    var jqxhr = $.ajax( "/bamboo/checkajax" )
    .done(function(data) {
        if(data == 0)
        {
            $('#bamboo_btn').html("Check Payment Again");
        }
        else
        {
            $('#bamboo_btn').html("<i style='color:white' class='fa fa-check'></i> Payment Found");
            $('#step4').toggle();
        }
    })
    .fail(function(data) {
        alert("There was some error. Try again.");
    })
    .always(function(data) {
        return null;
    });
}

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
			window.location.href="/bamboo#bamboo-send"
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
    //start
    $('#step2').hide();
    $('#step3').hide();
    $('#step4').hide();
    $('#qrcode').qrcode("{{$user->walletBamboo->wallet_address}}");

    //on keypress
    $('#bamboo').keyup(function() {
        var bamboo_price = {{round(app('App\Classes\Custom')->getPinBTCAmount(),8)}};
        var total = $(this).val()*bamboo_price;
        total = total.toFixed(8);

        $('#pin').html($(this).val());
        $('#pin_total').html(total);
        $('#qrcode').html('');
        $('#qrcode').qrcode("bitcoin:{{$user->walletBamboo->wallet_address}}?amount="+total);
        $('#step2').show();
        $('#step3').show();
    });

    //otp
    $('#otp').click(function() {
        $('#otp').hide();
    });

    //checkpayment
    $('#bamboo_btn').click(function() {
        $('#bamboo_btn').html("<i class='fa fa-spinner fa-spin'></i> Checking");
        checkPayment();
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
