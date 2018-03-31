@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<div class="sc-header bdr-bottom-mobile">
	<div class="sc-place pos-fix">
		<div class="col-full">
			<div class="sc-grid sc-grid-1x">
				<div class="sc-col-2">
					<h2 class="ttl-head ttl-sekunder-color">{{ $ttl_followers }} Followers</h2>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="frame-home">
	<div class="place-follow">
		<div>
			@foreach ($profile as $p)
				<div class="frame-follow">
					<div class="ff-top top">
						<a href="{{ url('/user/'.$p->id) }}">
							<div class="image image-35px image-circle" style="background-image: url({{ asset('/profile/thumbnails/'.$p->foto) }});"></div>
						</a>
					</div>
					<div class="ff-mid mid">
						<div class="fl-ttl">
							<a href="{{ url('/user/'.$p->id) }}">{{ $p->name }}</a>
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
	</div>
</div>
@endsection