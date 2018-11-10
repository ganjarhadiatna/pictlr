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
	<link rel="stylesheet" type="text/css" href="{{ asset('css/css/fontawesome-all.min.css') }}">
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
				$('#search').show();
				$('#txt-search').select();
				setScroll('hide');
			} else {
				$('#search').hide();
				setScroll('show');
			}
		}
		function opCreateStory(stt) {
			if (stt === 'open') {
				$('#create').show();
				setScroll('hide');
			} else {
				$('#create').hide();
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
		function pictZoom(idstory) {
			var img = $('#pict-'+idstory).attr('src');
			var str = img.replace('/thumbnails/','/covers/');
			var dt = '<img src="'+str+'" alt="pict">';
			$('#zoom-pict').show();
			$('#zoom-pict .zp-main').html(dt);
			setScroll('hide');
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

		function opLoadingCircle(stt) {
			if (stt == 'open') {
				$('#frame-loading-circle').show();
			} else {
				$('#frame-loading-circle').hide();
			}
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

		function addLove(idstory) {
			if (iduser === '') {
				opAlert('open', 'Please login berfore you can love this story.');
			} else {
				$.ajax({
					url: '{{ url("/add/love") }}',
					type: 'post',
					data: {'idstory': idstory},
				})
				.done(function(data) {
					if (data === 'love') {
						$('.love-'+idstory).attr('class', 'love-'+idstory+' fas fa-lg fa-heart');
					} else if (data === 'unlove') {
						$('.love-'+idstory).attr('class', 'love-'+idstory+' far fa-lg fa-heart');
					} else if (data === 'failedadd') {
						opAlert('open', 'Failed to love story.');
						$('.love-'+idstory).attr('class', 'love-'+idstory+' far fa-lg fa-heart');
					} else if (data === 'failedremove') {
						opAlert('open', 'Failed to unlove story.');
						$('.love-'+idstory).attr('class', 'love-'+idstory+' fas fa-lg fa-heart');
					} else {
						opAlert('open', 'There is an error, please try again.');
					}
				})
				.fail(function() {
					opAlert('open', 'There is an error, please try again.');
				});
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
						$('.bookmark-'+idstory).attr('class', 'bookmark-'+idstory+' fas fa-lg fa-bookmark');
					} else if (data === 'unbookmark') {
						$('.bookmark-'+idstory).attr('class', 'bookmark-'+idstory+' far fa-lg fa-bookmark');
					} else if (data === 'failedadd') {
						opAlert('open', 'Failed to save story to bookmark.');
						$('.bookmark-'+idstory).attr('class', 'bookmark-'+idstory+' far fa-lg fa-bookmark');
					} else if (data === 'failedremove') {
						opAlert('open', 'Failed to remove story from bookmark.');
						$('.bookmark-'+idstory).attr('class', 'bookmark-'+idstory+' fas fa-lg fa-bookmark');
					} else {
						opAlert('open', 'There is an error, please try again.');
					}
					//console.log(data);
				})
				.fail(function(data) {
					//console.log(data.responseJSON);
					opAlert('open', 'There is an error, please try again.');
				});
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

			$('#txt-search').focusin(function () {
				$('#main-search .main-search').addClass('select');
			}).focusout(function () {
				$('#main-search .main-search').removeClass('select');
			});

			$('#close-zoom, #zoom-pict').on('click',function () {
				$('#zoom-pict').hide();
				setScroll('show');
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
		<div class="place">
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
						<form id="place-search" action="javascript:void(0)" method="get">
							<button type="submit" class="btn btn-main4-color">
								<span class="fa fa-lg fa-search"></span>
							</button>
							<input type="text" name="q" class="txt txt-main-color txt-no-shadow" id="txt-search" placeholder="Search.." required="true">
						</form>
					</div>
				</div>
				<div class="pos rig">
					<a href="{{ url('/') }}">
						<button class="mobile btn-icn btn btn-main2-color btn-radius" id="home">
							<span class="ttl">Home</span>
						</button>
					</a>
					<a href="{{ url('/categories') }}">
						<button class="btn-icn btn btn-circle btn-main2-color" id="category" key="hide">
							<span class="fas fa-lg fa-th"></span>
						</button>
					</a>
					@if (!Auth::id())
						<a href="{{ url('/login') }}">
							<button class="btn-icn btn btn-circle btn-main2-color">
								<span class="fas fa-lg fa-sign-in-alt"></span>
							</button>
						</a>
						<a href="{{ url('/register') }}">
							<button class="create btn btn-radius btn-main3-color">
								<span class="fas fa-lg fa-plus"></span>
								<span>Register</span>
							</button>
						</a>
					@else
						<a href="{{ url('/me/notifications') }}">
							<button class="btn-icn btn btn-circle btn-main2-color" id="notif" key="hide">
								<div class="notif-icn absolute fas fa-lg fa-circle" id="main-notif-sign"></div>
								<span class="fas fa-lg fa-bell"></span>
							</button>
						</a>
						@foreach (ProfileModel::UserSmallData(Auth::id()) as $dt)
							<a href="{{ url('/user/'.$dt->id) }}">
								<button class="btn-icn pp btn btn-main2-color btn-radius" id="profile">
									<div class="image image-35px image-circle" style="background-image: url({{ asset('/profile/thumbnails/'.$dt->foto) }});" id="profile"></div>
								</button>
							</a>
						@endforeach
						<a href="{{ url('/compose') }}">
							<button class="create btn btn-radius btn-main3-color" id="op-add" key="hide" style="margin-left: 20px;">
								<span class="fas fa-lg fa-plus"></span>
								<span>Create Story</span>
							</button>
						</a>
					@endif
				</div>
			</div>
		</div>
		<!--
		<div class="zoom-pict" id="zoom-pict">
			<button class="close btn btn-circle btn-main2-color" id="close-zoom">
				<span class="fas fa-lg fa-times"></span>
			</button>
			<div class="zp-main"></div>
		</div>
		-->
	</div>
	<div id="body">
		<div class="frame-loading-circle" id="frame-loading-circle">
			<div class="icn btn btn-circle btn-normal-color">
				<div class="tr fas fa-lg fa-spin fa-circle-notch"></div>
			</div>
		</div>
		@yield("content")
	</div>
	@include('main.loading-bar')
	@include('main.post-menu')
	@include('main.question-menu')
	@include('main.alert-menu')
</body>
</html>
