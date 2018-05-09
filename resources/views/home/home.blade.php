@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<div class="frame-guess">
	<div class="block bdr-bottom">
		<div class="logo" style="background-image: url('{{ asset('/img/5.png') }}')"></div>
		<div class="ttl ctn-main-font ctn-small ctn-center padding-10px">
			You Have New World Now.
		</div>
	</div>
	<div class="banner bdr-bottom">
		<div class="cover">
			<div class="title">
				<div class="padding-bottom-15px">
					<h2>Join Pictlr Today.</h2>
				</div>
				<div class="frame-info width-all">
					<a href="{{ url('/login') }}">
						<button class="mrg-bottom create btn btn-sekunder-color" id="compose">
							<span class="ttl-post">Login</span>
						</button>
					</a>
					<a href="{{ url('/register') }}">
						<button class="btn btn-main-color" id="compose">
							<span class="ttl-post">Register</span>
						</button>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="block bdr-bottom">
		<div class="ttl ctn-main-font ctn-small ctn-center padding-20px">What you can do?</div>
		<div class="frame-info">
			<div class="pos top">
				<div class="icn fa fa-lg fa-pencil-alt"></div>
			</div>
			<div class="mid">
				Create and Share Stories.
			</div>
		</div>
		<div class="frame-info">
			<div class="pos top">
				<div class="icn far fa-lg fa-thumbs-up"></div>
			</div>
			<div class="mid">
				Likes or Dislikes Stories.
			</div>
		</div>
		<div class="frame-info">
			<div class="pos top">
				<div class="icn fas fa-lg fa-bookmark"></div>
			</div>
			<div class="mid">
				Save Much Stories.
			</div>
		</div>
	</div>
	<div class="block bdr-bottom">
		<div class="ttl ctn-main-font ctn-small ctn-center padding-20px">Start with it, for example.</div>
		<div class="frame-info">
			<div class="pos top">
				<div class="icn fas fa-lg fa-clock"></div>
			</div>
			<div class="mid">
				Fresh Stories
				<div class="padding-10px"></div>
				<a href="{{ url('/fresh') }}">
					<input type="button" class="btn btn-main3-color" value="View More">
				</a>
			</div>
		</div>
		<div class="frame-info">
			<div class="pos top">
				<div class="icn fas fa-lg fa-fire"></div>
			</div>
			<div class="mid">
				Populars Stories
				<div class="padding-10px"></div>
				<a href="{{ url('/popular') }}">
					<input type="button" class="btn btn-main3-color" value="View More">
				</a>
			</div>
		</div>
		<div class="frame-info">
			<div class="pos top">
				<div class="icn fas fa-lg fa-bolt"></div>
			</div>
			<div class="mid">
				Trending Stories
				<div class="padding-10px"></div>
				<a href="{{ url('/trending') }}">
					<input type="button" class="btn btn-main3-color" value="View More">
				</a>
			</div>
		</div>
	</div>
	<div class="block">
		<div class="cover">
			<div class="frame-info width-all">
				<div>
					<h2>So, Let's get Started.</h2>
				</div>
				<div class="padding-10px"></div>
				<a href="{{ url('/login') }}">
					<button class="mrg-bottom create btn btn-sekunder-color" id="compose">
						<span class="ttl-post">Login</span>
					</button>
				</a>
				<a href="{{ url('/register') }}">
					<button class="btn btn-main-color" id="compose">
						<span class="ttl-post">Register</span>
					</button>
				</a>
			</div>
		</div>
	</div>
	<div class="block bdr-top bdr-bottom">
		<div class="ttl ctn-main-font ctn-small ctn-center padding-20px">Find Us on.</div>
		<div>
			<div class="frame-info">
				<div class="pos top">
					<div class="icn fab fa-lg fa-facebook-f"></div>
				</div>
				<div class="mid">
					Facebook
				</div>
			</div>
			<div class="frame-info">
				<div class="pos top">
					<div class="icn fab fa-lg fa-instagram"></div>
				</div>
				<div class="mid">
					Instagram
				</div>
			</div>
			<div class="frame-info">
				<div class="pos top">
					<div class="icn fab fa-lg fa-twitter"></div>
				</div>
				<div class="mid">
					Twitter
				</div>
			</div>
			<div class="frame-info">
				<div class="pos top">
					<div class="icn fab fa-lg fa-google"></div>
				</div>
				<div class="mid">
					Google
				</div>
			</div>
		</div>
	</div>
</div>
@endsection