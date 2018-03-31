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

<div class="col-full padding-10px">
	<div class="post-home post-grid post-grid-2x">
		<div class="lef post-grid-1" id="home-main-object">
			@foreach (ProfileModel::UserSmallData(Auth::id()) as $dt)
				<a href="{{ url('/compose') }}">
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
			<div id="home-side-object">
				<div class="frame-other">
					<strong class="ttl">Create your Story</strong>
					<p>Let's start to create something, you can create anything in here, such as story, picture, movie streaming, download link, comics, news, magazine etc. That's all free for you...</p>
					<div class="padding-10px">
						<a href="{{ url('/compose') }}">
							<button class="create btn btn-main3-color width-all">
								<span class="fas fa-lg fa-pencil-alt"></span>
								<span>Create your Story</span>
							</button>
						</a>
					</div>
				</div>
				<div class="frame-other">
					<strong class="ttl">Who to Follows</strong>
					@foreach($topUsers as $p)
						<div class="frame-follow">
							<div class="ff-top top">
								<a href="{{ url('/user/'.$p->id) }}">
									<div class="image image-35px image-circle" style="background-image: url({{ asset('/profile/thumbnails/'.$p->foto) }});"></div>
								</a>
							</div>
							<div class="ff-mid mid">
								<div class="fl-ttl">
									<a href="{{ url('/user/'.$p->id) }}">{{ explode(' ', $p->name)[0] }}</a>
								</div>
							</div>
							<div class="ff-bot bot">
								@if (Auth::id() != $p->id)
									@if (is_int($p->is_following))
										<input type="button" name="follow" class="btn btn-main3-color" id="add-follow-{{ $p->id }}" value="Unfollow" onclick="opFollow('{{ $p->id }}', '{{ url("/") }}', '{{ Auth::id() }}')">
									@else
										<input type="button" name="follow" class="btn btn-sekunder-color" id="add-follow-{{ $p->id }}" value="Follow" onclick="opFollow('{{ $p->id }}', '{{ url("/") }}', '{{ Auth::id() }}')">
									@endif
								@endif
							</div>
						</div>
					@endforeach
				</div>
				<div class="frame-other">
					<strong class="ttl">Tranding Nows</strong>
					<div>
						@foreach($topTags as $tag)
						<?php 
							$replace = array('[',']','@',',','.','#','+','-','*','<','>','-','(',')',';','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
							$title = str_replace($replace, '', $tag->tag); 
						?>
						<div class="frame-trending">

							<div class="ttl-head">
								<a href="{{ url('/tags/'.$title) }}">
									{{ $tag->tag }}
								</a>
							</div>
							<div class="ttl-ctn">{{ $tag->ttl_tag }} Stories</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	{{ $topStory->links() }}
</div>
@endsection