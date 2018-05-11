@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
@if (count($notif) != 0)
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
			<div class="place-notif">
				<div class="ttl-head padding-bottom-15px">
					<div class="ctn-main-font ctn-min-color ctn-16px">Notifications</div>
				</div>
				@foreach ($notif as $dt)
					@if ($dt->type == 'comment')
						<div class="frame-notif grid grid-3x">
							<div class="grid-1">
								<a href="{{ url('/user/'.$dt->id) }}">
									<div 
										class="image image-40px image-radius"
										style="background-image: url({{ asset('/profile/thumbnails/'.$dt->foto) }});"></div>
								</a>
							</div>
							<div class="grid-2">
								<div class="notif-mid">
									<div class="ntf-mid">
										<div class="desc">
											<a href="{{ url('/user/'.$dt->id) }}">
												<strong>
													{{ $dt->username }}
												</strong>
											</a>
											{{ 'Commented "'.$dt->description.'" on your story' }}
										</div>
										<div class="desc date">
											{{ $dt->created }}
										</div>
									</div>
								</div>
							</div>
							<div class="grid-3 txt-right">
								<a href="{{ url('/story/'.$dt->idstory) }}">
									<div 
										class="image image-40px image-radius"
										style="background-image: url({{ asset('/story/thumbnails/'.$dt->image) }});"></div>
								</a>
							</div>
						</div>
					@elseif ($dt->type == 'follow')
						<div class="frame-notif grid grid-2x">
							<div class="grid-1">
								<a href="{{ url('/user/'.$dt->id) }}">
									<div 
										class="image image-40px image-radius"
										style="background-image: url({{ asset('/profile/thumbnails/'.$dt->foto) }});"></div>
								</a>
							</div>
							<div class="grid-2">
								<div class="notif-mid">
									<div class="ntf-mid">
										<div class="desc">
											<a href="{{ url('/user/'.$dt->id) }}">
												<strong>
													{{ $dt->username }}
												</strong>
											</a>
											Started following you
										</div>
										<div class="desc date">
											{{ $dt->created }}
										</div>
									</div>
								</div>
							</div>
						</div>
					@else
						<div class="frame-notif grid grid-2x">
							<div class="grid-1">
								<a href="{{ url('/user/'.$dt->id) }}">
									<div 
										class="image image-40px image-radius"
										style="background-image: url({{ asset('/profile/thumbnails/'.$dt->foto) }});"></div>
								</a>
							</div>
							<div class="grid-2">
								<div class="notif-mid">
									<div class="ntf-mid">
										<div class="desc">
											<a href="{{ url('/user/'.$dt->id) }}">
												<strong>
													{{ $dt->username }}
												</strong>
											</a>
											@if ($dt->type == 'love')
												Like your story
											@else
												Save your story
											@endif
										</div>
										<div class="desc date">
											{{ $dt->created }}
										</div>
									</div>
									<div class="padding-5px"></div>
									<a href="{{ url('/story/'.$dt->idstory) }}">
										<div 
											class="image image-full image-radius"
											style="background-image: url({{ asset('/story/thumbnails/'.$dt->image) }});"></div>
									</a>
								</div>
							</div>
						</div>
					@endif
				@endforeach
			</div>
			<div class="padding-5px"></div>
			{{ $notif->links() }}
		</div>
		<div class="rig post-grid-2">
			@include('main.side-menu')
		</div>
	</div>
</div>
@endsection