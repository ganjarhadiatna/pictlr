@extends('layout.index')
@section('title',$title)
@section('content')
<div class="frame-home">
	<div class="frame-sign">
		<div class="top">
			<a href="{{ url('/') }}">
				<img src="{{ asset('/img/Qyublog/4.png') }}" alt="">
			</a>
		</div>
		<div class="mid">
			<div class="block">
				<h2>Signup Here</h2>
			</div>
			<form>
				<div class="block">
					<input type="email" name="email" class="txt txt-primary-color" placeholder="Your Email" required="required">
				</div>
				<div class="block">
					<input type="password" name="password" class="txt txt-primary-color" placeholder="Create Password" required="required">
				</div>
				<div class="block">
					<input type="password" name="repassword" class="txt txt-primary-color" placeholder="Re-type Password" required="required">
				</div>
				<div class="block">
					<input type="submit" name="signup" class="btn btn-main-color" value="Signup">
					<a href="{{ url('/login') }}">
						<input type="button" name="login" class="btn btn-grey-color" value="Login">
					</a>
				</div>
			</form>
			<div class="padding-bottom">
				<span class="fa fa-lg fa-circle"></span>
				<span class="fa fa-lg fa-circle"></span>
				<span class="fa fa-lg fa-circle"></span>
			</div>
			<div class="block">
				<button class="btn btn-color-fb">
					<span class="fa fa-lg fa-facebook"></span>
					<span>Facebook</span>
				</button>
				<button class="btn btn-color-tw">
					<span class="fa fa-lg fa-twitter"></span>
					<span>Twitter</span>
				</button>
				<button class="btn btn-color-gg">
					<span class="fa fa-lg fa-google"></span>
					<span>Google</span>
				</button>
			</div>
		</div>
		<div class="bot"></div>
	</div>
</div>
@endsection