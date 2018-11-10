@extends('layout.index')
@section('title', 'Login')
@section('path', 'login')
@section('content')
<div class="frame-home">
    <div class="frame-sign">
        <div class="mid">
            <div class="block">
                <div class="ctn-main-font ctn-standar ctn-center padding-15px">Login</div>
            </div>
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="block">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="text" class="txt txt-primary-color" name="email" value="{{ old('email') }}" placeholder="Email or Username" required autofocus>
                    </div>
                </div>
                <div class="block">
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="txt txt-primary-color" placeholder="Password" name="password" required>
                    </div>
                </div>
                <div>
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
                <div class="block">
                    <div class="checkbox padding-10px">
                        <label class="btn btn-main4-color">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                </div>
                <div class="block">
                    <input type="submit" name="login" class="btn btn-main-color" value="Login">
                </div>
            </form>
            <div class="block">
                <a href="{{ route('password.request') }}">
                    <button class="btn btn-main4-color">
                        Forgot your Password?
                    </button>
                </a>
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
                    <strong>Doesn't have an Account?</strong>
                </div>
                <a href="{{ url('/register') }}">
                    <input type="button" name="signup" class="btn btn-sekunder-color" value="Register Here">
                </a>
            </div>
            <!--
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
