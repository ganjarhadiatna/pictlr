<div id="home-side-object">
	<div class="frame-other">
		<strong class="ttl">Create your Story</strong>
		<p>Let's start to posting something, you can post picture and save it to your box. It's easy to use and that's all free for you...</p>
		<div class="padding-10px">
			<a href="{{ url('/compose/story') }}">
				<button class="create btn btn-main3-color width-all" onclick="opCompose('open');">
					<span class="fas fa-lg fa-plus"></span>
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
						<a href="{{ url('/user/'.$p->id) }}">{{ $p->username }}</a>
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
	<div id="footer">
		<ul>
			<li>
				<a href="{{ url('/') }}">Home Feeds</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">About Us</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Privacy</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Terms</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Policy</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">FAQ</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Jobs</a>
			</li>
			<li><span class="icn fa fa-lg fa-circle"></span></li>
			<li>
				<a href="#">Help</a>
			</li>
		</ul>
	</div>
</div>