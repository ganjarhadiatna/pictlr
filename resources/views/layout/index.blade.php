<?php use App\ProfileModel; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Pictlr - @yield('title')</title>
	<meta charset=utf-8>
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ICON -->
    <link href="{{ asset('/img/pictlr-4.png') }}" rel='SHORTCUT ICON'/>

	<!-- SASS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/css/fontawesome-all.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('sass/main.css') }}">

	<!-- JS -->
	<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/follow.js') }}"></script>
	<script type="text/javascript">
		var iduser = '{{ Auth::id() }}';

		function setScroll(stt) {
			if (stt === 'hide') {
				$('html').addClass('set-scroll');
			} else {
				$('html').removeClass('set-scroll');
			}
		}
		function setScrollMobile(stt) {
			if (stt === 'hide') {
				$('html').addClass('set-scroll-mobile');
			} else {
				$('html').removeClass('set-scroll-mobile');
			}
		}
		function opSearch(stt) {
			if (stt === 'open') {
				$('#search').fadeIn();
				$('#txt-search').select();
				setScroll('hide');
			} else {
				$('#search').fadeOut();
				setScroll('show');
			}
		}
		function opCreateStory(stt) {
			if (stt === 'open') {
				$('#create').fadeIn();
				setScroll('hide');
			} else {
				$('#create').fadeOut();
				setScroll('show');
			}
		}
		function opToggle(stt) {
			var tr = $('#'+stt).attr('class');
			if (tr === 'toggle fa fa-lg fa-toggle-off') {
				$('#'+stt).attr('class', 'toggle tgl-active fa fa-lg fa-toggle-on');
			} else {
				$('#'+stt).attr('class', 'toggle fa fa-lg fa-toggle-off');
			}
		}
		function addBookmark(idstory) {
			if (iduser === '') {
				opAlert('open', 'Please login berfore you can save this story.');
			} else {
				$.ajax({
					url: '{{ url("/add/bookmark") }}',
					type: 'post',
					data: {'idstory': idstory},
				})
				.done(function(data) {
					if (data === 'bookmark') {
						opAlert('open', 'Story has been saved to Box.');
						$('#bookmark-'+idstory).attr('class', 'fas fa-lg fa-bookmark');
					} else if (data === 'unbookmark') {
						opAlert('open', 'Story removed from Box.');
						$('#bookmark-'+idstory).attr('class', 'far fa-lg fa-bookmark');
					} else if (data === 'failedadd') {
						opAlert('open', 'Failed to save story to Box.');
						$('#bookmark-'+idstory).attr('class', 'far fa-lg fa-bookmark');
					} else if (data === 'failedremove') {
						opAlert('open', 'Failed to remove story from Box.');
						$('#bookmark-'+idstory).attr('class', 'fas fa-lg fa-bookmark');
					} else {
						opAlert('open', 'There is an error, please try again.');
					}
				})
				.fail(function(data) {
					//console.log(data.responseJSON);
					opAlert('open', 'There is an error, please try again.');
				});
			}
		}
		function toLink(path) {
			window.location = path;
		}
		function cekNotif() {
			$.get('{{ url("/notif/cek") }}', function(data) {
				//console.log('notif: '+data);
				if (data != 0) {
					$('#main-notif-sign').show();
				} else {
					$('#main-notif-sign').hide();
				}
			});
		}
		
		function goBack() {
			window.history.back();
		}

		function toLeft() {
			var wd = $('#ctnTag').width();
			var sc = $('#ctnTag').scrollLeft();
			if (sc >= 0) {
				$('#ctnTag').animate({scrollLeft: (sc - wd)}, 500);
			}
		}
		function toRight() {
			var wd = $('#ctnTag').width();
			var sc = $('#ctnTag').scrollLeft();
			if (true) {
				$('#ctnTag').animate({scrollLeft: (sc + wd)}, 500);
			}
		}

		window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function() {
			var pth = "@yield('path')";

			if (iduser) {
				setInterval('cekNotif()', 3000);
			}

			$(window).scroll(function(event) {
				var hg = $('#header').height();
				var top = $(this).scrollTop();
				if (top > hg) {
					$('#main-search').addClass('hide');
				} else {
					$('#main-search').removeClass('hide');
				}
			});
			
			$('#header .place .menu .pos .btn-circle').each(function(index, el) {
				$(this).removeClass('active');
				$('#'+pth).addClass('active');
			});

			$('#place-search').submit(function(event) {
				var ctr = $('#txt-search').val();
				window.location = "{{ url('/search/') }}"+'/'+ctr;
			});
			
		});
	</script>
</head>
<body>
	<div id="header">
		<div class="place bdr-bottom">
			<div class="menu col-all">
				<div class="pos lef">
					<div class="logo" >
						<a href="{{ url('/') }}">
							<img src="{{ asset('/img/5.png') }}" alt="Pictlr">
						</a>
					</div>
				</div>
				<div class="pos mid" id="main-search">
					<div class="main-search bdr-all">
						<form id="place-search" action="javascript:void(0)">
							<input type="text" name="q" class="txt txt-main-color" id="txt-search" placeholder="Search.." required="true">
							<button type="submit" class="btn btn-main4-color">
								<span class="fa fa-lg fa-search"></span>
							</button>
						</form>
					</div>
				</div>
				<div class="pos rig">
					<a href="{{ url('/') }}">
						<button class="mobile btn-icn btn btn-main2-color btn-radius" id="home">
							<span class="ttl">Home Feeds</span>
						</button>
					</a>
					<button class="btn-icn btn btn-circle btn-main2-color" id="nav-more-target" key="hide">
						<span class="fas fa-lg fa-th"></span>
					</button>

					@if (!Auth::id())
						<a href="{{ url('/login') }}">
							<button class="btn-icn btn btn-main-color ctn-up btn-radius" id="profile">
								<span>Login</span>
							</button>
						</a>
					@else
						<button class="btn-icn btn btn-circle btn-main2-color" id="op-notif" key="hide">
							<div class="notif-icn absolute fas fa-lg fa-circle" id="main-notif-sign"></div>
							<span class="fas fa-lg fa-bell"></span>
						</button>
						@foreach (ProfileModel::UserSmallData(Auth::id()) as $dt)
							<a href="{{ url('/user/'.$dt->id) }}">
								<button class="btn-icn pp btn btn-circle btn-main2-color" id="profile">
									<div class="image image-30px image-circle" style="background-image: url({{ asset('/profile/thumbnails/'.$dt->foto) }});" id="profile"></div>
								</button>
							</a>
						@endforeach
					@endif

					<a href="{{ url('/compose') }}">
						<button class="create btn btn-main3-color">
							<span class="fas fa-lg fa-plus"></span>
						</button>
					</a>
				</div>
				@include('main.category')
				@include('main.notifications')
			</div>
		</div>
	</div>
	<div id="body">
		@yield("content")
	</div>
	<div id="footer">
		<ul>
			<li>
				<a href="{{ url('/') }}">Home Feeds</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">About Us</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Privacy</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Terms</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Policy</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">FAQ</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Jobs</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Help</a>
			</li>
		</ul>
	</div>

	@include('main.loading-bar')
	@include('main.post-menu')
	@include('main.question-menu')
	@include('main.alert-menu')

</body>
</html>
