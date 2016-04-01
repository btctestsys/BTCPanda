@extends('layouts.static')

@section('content')
<div class="account-pages"></div> 
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class=" card-box">
        
        <div class="panel-body">
            <form method="post" action="/password/email" role="form" class="text-center">{!! csrf_field() !!}
                @if (count($errors) > 0)
                <div class="alert alert-danger text-left"><ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul></div>
                @endif

                @if (Session()->has('status'))
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('status') }}
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="form-group">
                    <h3>Get Reset Password Link</h3>
                    <p class="text-muted">
                        Enter your email
                    </p>
                    <div class="input-group m-t-30">
                        <input type="email" class="form-control" placeholder="Email" required="" name="email" value="{{ old('email') }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-pink w-sm waves-effect waves-light">
                                Send Reset Link
                            </button> 
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop