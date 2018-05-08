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
					<div class="cover-theme-1">
						<img src="{{ asset('/story/thumbnails/'.$story->cover1) }}" alt="pict" id="pict-{{ $story->idstory }}" key="{{ $story->idstory }}">
					</div>
				@elseif ($story->ttl_image <= 4)
					<div class="cover-theme-2">
						<div class="fr-image">
							<img src="{{ asset('/story/thumbnails/'.$story->cover1) }}" alt="pict" id="pict-{{ $story->idstory }}" key="{{ $story->idstory }}">
						</div>
						<div class="fr-image">
							<img src="{{ asset('/story/thumbnails/'.$story->cover2) }}" alt="pict" id="pict-{{ $story->idstory }}" key="{{ $story->idstory }}">
						</div>
					</div>
				@else
					<div class="cover-theme-2">
						<div class="fr-image">
							<img src="{{ asset('/story/thumbnails/'.$story->cover1) }}" alt="pict" id="pict-{{ $story->idstory }}" key="{{ $story->idstory }}">
						</div>
						<div class="fr-image">
							<img src="{{ asset('/story/thumbnails/'.$story->cover2) }}" alt="pict" id="pict-{{ $story->idstory }}" key="{{ $story->idstory }}">
						</div>
						<div class="fr-image">
							<img src="{{ asset('/story/thumbnails/'.$story->cover3) }}" alt="pict" id="pict-{{ $story->idstory }}" key="{{ $story->idstory }}">
						</div>
						<div class="fr-image">
							<img src="{{ asset('/story/thumbnails/'.$story->cover4) }}" alt="pict" id="pict-{{ $story->idstory }}" key="{{ $story->idstory }}">
						</div>
					</div>
				@endif
				@if ($story->ttl_image != 1)
					<div class="icn-image">
						<span class="fa fa-lg fa-camera"></span>
						<span>{{ $story->ttl_image }}</span>
					</div>
				@endif
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
			<!--
			<button class="btn btn-circle btn-sekunder-color btn-no-border" onclick="pictZoom({{ $story->idstory }})">
				<span class="fas fa-lg fa-search-plus"></span>
			</button>-->
			<button class="btn btn-circle btn-main4-color btn-no-border"
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