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
							{{ $story->username }}
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
				@if ($story->ttl_image == 1)
					<div class="cover-theme-1 cover-pict" style="padding-bottom: {{ (($story->height / $story->width) * 100) }}%;">
						<img src="{{ asset('/story/thumbnails/'.$story->cover1) }}" class="pict" id="pict-{{ $story->idstory }}" key="{{ $story->idstory }}">
					</div>
				@elseif ($story->ttl_image <= 3)
					<div class="cover-theme cover-theme-2">
						<div class="image image-all"
						style="background-image: url({{ asset('/story/thumbnails/'.$story->cover1) }});"></div>
						<div class="image image-all"
						style="background-image: url({{ asset('/story/thumbnails/'.$story->cover2) }});"></div>
					</div>
				@else
					<div class="cover-theme cover-theme-2">
						<div class="image image-all"
						style="background-image: url({{ asset('/story/thumbnails/'.$story->cover1) }});"></div>
						<div class="image image-all"
						style="background-image: url({{ asset('/story/thumbnails/'.$story->cover2) }});"></div>
						<div class="image image-all"
						style="background-image: url({{ asset('/story/thumbnails/'.$story->cover3) }});"></div>
						<div class="image image-all"
						style="background-image: url({{ asset('/story/thumbnails/'.$story->cover4) }});"></div>
					</div>
				@endif
				@if ($story->ttl_image != 1)
					<div class="icn-image">
						<span class="fa fa-lg fa-images"></span>
						<span>{{ $story->ttl_image }}</span>
					</div>
				@endif
			</a>
		</div>
	</div>
	@if ($story->description)
		<div class="desc">
			{{ $story->description }}
		</div>
	@endif
	<div class="pos bot-tool">
		<div class="nts">
			<div class="notes ctn-main-font ctn-14px ctn-sek-color">
				{{ ($story->views + $story->ttl_love + $story->ttl_comment + $story->ttl_save) }} Notes
			</div>
		</div>
		<div class="bok">
			<button 
				class="btn btn-sekunder-color btn-no-border btn-pad-5px love" 
				onclick="addLove('{{ $story->idstory }}')">
				@if (is_int($story->is_love))
					<span class="love-{{ $story->idstory }} fas fa-lg fa-heart"></span>
				@else
					<span class="love-{{ $story->idstory }} far fa-lg fa-heart"></span>
				@endif
			</button>
			<a href="{{ url('/story/'.$story->idstory) }}">
				<button class="btn btn-sekunder-color btn-no-border btn-pad-5px">
					<span class="far fa-lg fa-comment"></span>
				</button>
			</a>
			<button class="btn btn-circle btn-sekunder-color btn-no-border save"
				key="{{ $story->idstory }}" 
				onclick="addBookmark('{{ $story->idstory }}')">
				@if (is_int($story->is_save))
					<span class="bookmark-{{ $story->idstory }} fas fa-lg fa-bookmark" id="bookmark-{{ $story->idstory }}"></span>
				@else
					<span class="bookmark-{{ $story->idstory }} far fa-lg fa-bookmark" id="bookmark-{{ $story->idstory }}"></span>
				@endif
			</button>
		</div>
	</div>
</div>