@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<script type="text/javascript">
	$(document).ready(function() {
		$('#post-nav ul li').each(function(index, el) {
			$(this).removeClass('active');
			$('#{{ $nav }}').addClass('active');
		});
	});
</script>
@foreach ($profile as $p)
<div class="sc-header">
	<div class="sc-place pos-fix">
		<div class="col-small">
			<div class="sc-grid sc-grid-2x">
				<div class="sc-col-1">
					@if (Auth::id() == $p->id)
						<a href="{{ url('/me/setting') }}">
							<button class="btn btn-circle btn-main2-color">
								<span class="fas fa-lg fa-cog"></span>
							</button>
						</a>
						<a href="{{ url('/me/setting/profile') }}">
							<button class="btn btn-circle btn-main2-color">
								<span class="fas fa-lg fa-pencil-alt"></span>
							</button>
						</a>
						<a href="{{ url('/compose') }}">
							<button class="btn btn-circle btn-main2-color">
								<span class="fas fa-lg fa-plus"></span>
							</button>
						</a>
					@else
						<h3 class="ttl-head-2 ttl-sekunder-color">
							{{ $p->username }}
						</h3>
					@endif
				</div>
				<div class="sc-col-2 txt-right">
					@if (Auth::id() == $p->id)
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
						<a href="{{ route('logout') }}" 
							onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
							<button class="btn btn-main2-color">
								<span class="fas fa-lg fa-power-off"></span>
								<span class="">Logout</span>
							</button>
						</a>
					@else
						@if (!is_int($statusFolow))
							<input 
								type="button" 
								name="edit" 
								class="btn btn-main2-color" 
								id="add-follow-{{ $p->id }}" 
								value="Follow" 
								onclick="opFollow('{{ $p->id }}', '{{ url("/") }}', '{{ Auth::id() }}')">
						@else
							<input 
								type="button" 
								name="edit" 
								class="btn btn-main3-color" 
								id="add-follow-{{ $p->id }}" 
								value="Unfollow" 
								onclick="opFollow('{{ $p->id }}', '{{ url("/") }}', '{{ Auth::id() }}')">
						@endif
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<div class="frame-profile">
	<div class="profile">
		<div class="foto">
			<div 
				class="image image-150px image-circle" 
				id="place-picture" 
				style="background-image: url({{ asset('/profile/thumbnails/'.$p->foto) }});"></div>
		</div>
		<div class="info">
			<div class="user-name ctn-main-font ctn-standar" id="edit-name">{{ $p->name }}</div>
			<div>
				<p id="edit-about"><strong>{{ $p->username }}</strong></p>
			</div>
			<div>
				<p id="edit-about">{{ $p->about }}</p>
			</div>
			<div class="other">
				<a class="link" href="{{ $p->website }}" target="_blank">{{ $p->website }}</a>
			</div>
			<div>
				<div class="other mrg-bottom">
					<ul>
						<li>
							<a href="{{ url('/user/'.$p->id.'/story') }}">
								<div class="val">{{ $p->ttl_story }}</div>
								<div class="ttl">Stories</div>
							</a>
						</li>
						<li>
							<a href="{{ url('/user/'.$p->id.'/save') }}">
								<div class="val">{{ $p->ttl_save }}</div>
								<div class="ttl">Saves</div>
							</a>
						</li>
						<li>
							<a href="{{ url('/user/'.$p->id.'/following') }}">
								<div class="val">{{ $p->ttl_following }}</div>
								<div class="ttl">Following</div>
							</a>
						</li>
						<li>
							<a href="{{ url('/user/'.$p->id.'/followers') }}">
								<div class="val">{{ $p->ttl_followers }}</div>
								<div class="ttl">Followers</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="padding-5px"></div>
	<div class="navigator nav-2x nav-theme-3 col-400px" id="post-nav">
		<ul>
			<a href="{{ url('/user/'.$p->id.'/story') }}">
				<li id="story">Stories</li>
			</a>
			<a href="{{ url('/user/'.$p->id.'/save') }}">
				<li id="bookmark">Saves</li>
			</a>
		</ul>
	</div>
</div>
@endforeach
<div class="block pp-bot">
	@if (count($userStory) == 0)
		@include('main.post-empty')	
	@else
		<div class="post">
			@foreach ($userStory as $story)
				@include('main.post')
			@endforeach
		</div>
		{{ $userStory->links() }}
	@endif
</div>
@endsection