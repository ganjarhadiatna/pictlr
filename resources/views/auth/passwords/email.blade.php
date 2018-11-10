@extends('layout.index')
@section('title', 'Register')
@section('path', 'register')
@section('content')
<div class="frame-home">
    <div class="frame-sign">
        <div class="mid">
            <div class="block">
                <div class="ctn-main-font ctn-standar ctn-center padding-15px">Reset Password</div>
            </div>
            <div class="block">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <div class="block">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="txt txt-primary-color" placeholder="Your Email Address" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="padding-10px"></div>
                <div class="block">
                    <div class="form-group">
                        <button type="submit" class="btn btn-main-color">
                            Send Password Reset Link
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bot">
            <div class="padding-15px"></div>
        </div>
    </div>
</div>
@endsection
