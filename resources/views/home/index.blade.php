<?php use App\ProfileModel; ?>
@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')

@if (count($topStory) != 0)
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
@endif

<div>
	<div class="post-home post-grid post-grid-2x">
		<div class="lef post-grid-1" id="home-main-object">
			@foreach (ProfileModel::UserSmallData(Auth::id()) as $dt)
			<a href="{{ url('/compose/story') }}">
				<div class="frame-post">
					<div class="mid padding-5px">
						<div class="pos top-tool">
							<div class="grid grid-3x">
								<div class="grid-1">
									<div class="image image-35px image-circle" style="background-image: url({{ asset('/profile/thumbnails/'.$dt->foto) }});"></div>
								</div>
								<div class="grid-2">
									<div class="main-ttl">
										Create Your Story
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</a>
			@endforeach
			@if (count($topStory) == 0)
				<div class="frame-empty">
					<div class="icn fa fa-lg fa-thermometer-empty btn-main-color"></div>
					<div class="ttl padding-15px">Your "Home Feeds" still empty.</div>
				</div>
			@else
				<div>
					@foreach ($topStory as $story)
						@include('main.post')
					@endforeach
				</div>
			@endif
		</div>
		<div class="rig post-grid-2">
			@include('main.side-menu')
		</div>
	</div>
	{{ $topStory->links() }}
</div>
@endsection