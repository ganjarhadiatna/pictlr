<div class="frame-post">
	<div class="mid">
		<div class="pos top-tool padding-bottom-10px">
			<div class="grid grid-3x">
				<div class="grid-1">
					<a href="{{ url('/user/'.$story->id) }}">
						<div class="image image-35px image-circle" style="background-image: url({{ asset('/profile/thumbnails/'.$story->foto) }});"></div>
					</a>
				</div>
				<div class="grid-2">
					<div class="ttl-story">
						<a href="{{ url('/user/'.$story->id) }}">
							{{ $story->name }}
						</a>
					</div>
				</div>
				<div class="grid-3">
					<button class="icn btn btn-circle btn-primary-color" onclick="opPostPopup('open', 'menu-popup', '{{ $story->idstory }}', '{{ $story->id }}', '{{ $title }}')">
						<span class="fa fa-lg fa-ellipsis-h"></span>
					</button>
				</div>
			</div>
		</div>
		<div class="mid-tool">
			<a href="{{ url('/story/'.$story->idstory) }}">
				<div class="cover"></div>
				<img src="{{ asset('/story/thumbnails/'.$story->cover) }}" alt="pict">

			</a>
		</div>
	</div>
	<div class="desc">
		{{ $story->title }}
	</div>
	<div class="pos bot-tool">
		<div class="icn btn-grey2-color">
			<span class="fas fa-lg fa-align-center"></span>
			<span>{{ $story->views }}</span>
		</div>
		<div class="icn btn-grey2-color">
			<span class="far fa-lg fa-heart"></span>
			<span>{{ $story->loves }}</span>
		</div>
		<div class="icn btn-grey2-color">
			<span class="far fa-lg fa-comment"></span>
			<span>{{ $story->ttl_comment }}</span>
		</div>
	</div>
</div>