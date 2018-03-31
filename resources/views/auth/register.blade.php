@extends('layout.index')
@section('title', 'Register')
@section('path', 'register')
@section('content')
<div class="frame-home">
    <div class="frame-sign">
        <div class="mid">
            <div class="block">
                <div class="ctn-main-font ctn-standar ctn-center padding-15px">Register</div>
            </div>
            <div class="block center">
                <div class="padding-bottom-10px">
                    <strong>Please put your data on all the fields.</strong>
                </div>
            </div>
            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="block">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input id="name" type="text" class="txt txt-primary-color" placeholder="Full Name" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>
                <div class="block">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="txt txt-primary-color" placeholder="Your Email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="block">
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="txt txt-primary-color" placeholder="Create Password" name="password" required>
                    </div>
                </div>
                <div class="block">
                    <div class="form-group">
                        <input id="password-confirm" type="password" class="txt txt-primary-color" placeholder="Confirm Password" name="password_confirmation" required>
                    </div>
                </div>
                <div>
                    <div>
                        @if ($errors->has('name'))
                        <div class="block">
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        </div>
                        @endif
                        @if ($errors->has('email'))
                        <div class="block">
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        </div>
                        @endif
                        @if ($errors->has('password'))
                        <div class="block">
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="padding-10px"></div>
                <div class="block">
                    <input type="submit" name="signup" class="btn btn-main-color" value="Register">
                </div>
                <div class="padding-20px">
                    <div class="padding-bottom">
                        <span class="fa fa-lg fa-circle"></span>
                        <span class="fa fa-lg fa-circle"></span>
                        <span class="fa fa-lg fa-circle"></span>
                    </div>
                </div>
                <div class="block center">
                    <div class="padding-bottom-10px">
                        <strong>Has been have an account?</strong>
                    </div>
                    <a href="{{ url('/login') }}">
                        <input type="button" name="login" class="btn btn-sekunder-color" value="Login">
                    </a>
                </div>
            </form>
            <!--
            <div class="padding-bottom">
                <span class="fa fa-lg fa-circle"></span>
                <span class="fa fa-lg fa-circle"></span>
                <span class="fa fa-lg fa-circle"></span>
            </div>
            <div class="padding-5px"></div>
            <div class="block">
                <button class="btn btn-color-fb">
                    <span class="fab fa-lg fa-facebook"></span>
                    <span>Facebook</span>
                </button>
                <button class="btn btn-color-tw">
                    <span class="fab fa-lg fa-twitter"></span>
                    <span>Twitter</span>
                </button>
                <button class="btn btn-color-gg">
                    <span class="fab fa-lg fa-google"></span>
                    <span>Google</span>
                </button>
            </div>
            -->
        </div>
        <div class="bot">
            <div class="padding-15px"></div>
        </div>
    </div>
</div>
@endsection
