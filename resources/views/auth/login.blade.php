@extends('layouts.static')

@section('content')
        <div class="account-pages"></div>&nbsp;
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class=" card-box">
                <div class="panel-heading"> 
                    <h3 class="text-center"> {{trans('main.login_to')}} <strong class="text-custom"><span>BTC <img src="/assets/images/avatar.jpg" height="50"> Panda</span></strong></h3>
                </div> 

                <div class="panel-body">
				
                    @if (count($errors) > 0)
                    
                    @foreach ($errors->all() as $error)
					@if ($error == 'Successfully activate your account. You can login now.')
					<div class="alert alert-success"><ul>
                    <li>{{ $error }}</li>
					</ul></div>
					  
					@else
					<div class="alert alert-danger"><ul>
                    <li>{{ $error }}</li>
					</ul></div>
					@endif   
                    @endforeach
                    
                    @endif       
					
					
                    <form class="form-horizontal m-t-20" method="POST" action="/auth/login">{!! csrf_field() !!}

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" required="" placeholder="{{trans('main.email')}}" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" placeholder="{{trans('main.password')}}" name="password" id="password">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox" name="remember">
                                    <label for="checkbox-signup">
                                        {{trans('main.remember_me')}}
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">{{trans('main.login')}}</button>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-12">
                                <a href="/password/email" class="text-dark"><i class="fa fa-lock m-r-5"></i> {{trans('main.forget_pass')}}</a>
                            </div>
                        </div>
                    </form> 
                </div>   
            </div>                              
            <div class="row">
                <div class="col-sm-12 text-center">
                    <p>{{trans('main.dont_have')}}<a href="/register" class="text-primary m-l-5"><b>{{trans('main.register_now')}}</b></a></p>
                </div>
            </div>

            <div class="text-center"><a href="/lang/en">English</a> | <a href="/lang/cn">华语</a> | <a href="/lang/id">Indonesia</a> | <a href="/lang/vn">Việt Nam</a></div>
        </div>
@stop
