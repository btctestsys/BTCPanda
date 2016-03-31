@extends('layouts.static')

@section('content')
<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class=" card-box">
        
        <div class="panel-body">
            @if(count($errors) > 0)
            <div class="alert alert-danger"><ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul></div>
            @endif

            <form method="post" action="/password/reset" role="form" class="text-center">{!! csrf_field() !!}
                <div class="form-group">
                    <h3>Reset Password</h3>
                    <p class="text-muted">
                        Complete the form
                    </p>
                    <div class="input-group m-t-30">
                        <input type="email" class="form-control" placeholder="Email" required="" name="email" value="{{ old('email') }}">
                        <input type="password" class="form-control" name="password" placeholder="New Password">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <button type="submit" class="btn btn-pink w-sm waves-effect waves-light btn-block m-t-20">Submit</button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop