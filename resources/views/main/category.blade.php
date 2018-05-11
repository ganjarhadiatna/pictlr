@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')

<script type="text/javascript">
	$(document).ready(function() {
		$(window).scroll(function(event) {
			var top = $(window).scrollTop();
			var hg = Math.floor($('#home-main-object').height() - $('#home-side-object').height());
			var top1 = Math.floor($('#home-side-object').height() - ($(window).height() - 100));
			if (top >= top1) {
				$('#home-side-object').attr('class', 'side-fixed');
			}
			if (top >= (hg + top1)) {
				$('#home-side-object').attr('class', 'side-absolute');
			}
			if (top < top1) {
				$('#home-side-object').attr('class', '');
			}
		});
	});
</script>

<div>
	<div class="post-home post-grid post-grid-2x">
		<div class="lef post-grid-1" id="home-main-object">
			<div class="place-notif">
				<div class="ttl-head padding-bottom-15px">
					<div class="ctn-main-font ctn-min-color ctn-16px">
						Categories
					</div>
				</div>
				<div class="ctr">
					<ul>
						<li>
							<a href="{{ url('/') }}" class="ctn-main-font ctn-sek-color ctn-14px">
								Home Feeds
							</a>
						</li>
						<li>
							<a href="{{ url('/fresh') }}" class="ctn-main-font ctn-sek-color ctn-14px">
								Fresh
							</a>
						</li>
						<li>
							<a href="{{ url('/popular') }}" class="ctn-main-font ctn-sek-color ctn-14px">
								Popular
							</a>
						</li>
						<li>
							<a href="{{ url('/trending') }}" class="ctn-main-font ctn-sek-color ctn-14px">
								Trending
							</a>
						</li>
						@foreach ($allTags as $tag)
							<?php 
								$replace = array('[',']','@',',','.','#','+','-','*','<','>','-','(',')',';','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
								$title = str_replace($replace, '', $tag->tag); 
							?>
							<li>
								<a href="{{ url('/tags/'.$title) }}" class="ctn-main-font ctn-sek-color ctn-14px">
									{{ $tag->tag }}
								</a>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
			<div class="padding-bottom-15px"></div>
		</div>
		<div class="rig post-grid-2">
			@include('main.side-menu')
		</div>
	</div>
</div>
@endsection