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
			<!--
			<button class="zoom btn btn-circle" onclick="pictZoom({{ $story->idstory }})">
				<span class="fas fa-lg fa-search-plus"></span>
			</button>
			-->
			<a href="{{ url('/story/'.$story->idstory) }}">
				<div class="cover"></div>
				<img src="{{ asset('/story/thumbnails/'.$story->cover) }}" alt="pict" id="pict-{{ $story->idstory }}">
			</a>
		</div>
	</div>
	<div class="desc">
		{{ $story->description }}
	</div>
	<div class="pos bot-tool">
		<div class="nts">
			<div class="icn btn-grey2-color">
				<span>{{ ($story->views + $story->ttl_comment + $story->ttl_save) }}</span>
				<span>Notes</span>
			</div>
		</div>
		<div class="bok">
			<button class="btn btn-circle btn-sekunder-color btn-no-border" onclick="pictZoom({{ $story->idstory }})">
				<span class="fas fa-lg fa-search-plus"></span>
			</button>
			@if (is_int($story->is_save))
				<button class="btn btn-circle btn-main4-color btn-no-border" title="Remove from box?" onclick="addBookmark('{{ $story->idstory }}')">
					<span class="fas fa-lg fa-bookmark" id="bookmark-{{ $story->idstory }}"></span>
				</button>
			@else
				<button class="btn btn-circle btn-main4-color btn-no-border" title="Save to box?" onclick="addBookmark('{{ $story->idstory }}')">
					<span class="far fa-lg fa-bookmark" id="bookmark-{{ $story->idstory }}"></span>
				</button>
			@endif
		</div>
	</div>
</div>