@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<div class="sc-header">
	<div class="sc-place pos-fix">
		<div class="col-full">
			<div class="place-search-tag col-full">
				<div class="st-lef">
					<div class="btn-circle btn-black2-color" onclick="toLeft()">
						<span class="fa fa-lg fa-angle-left"></span>
					</div>
				</div>
				<div class="st-mid" id="ctnTag">
					@foreach ($topTags as $tag)
					<?php 
						$replace = array('[',']','@',',','.','#','+','-','*','<','>','-','(',')',';','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
						$title = str_replace($replace, '', $tag->tag); 
					?>
					<a href="{{ url('/tags/'.$title) }}">
						<div class="frame-top-tag">
							{{ $tag->tag }}
						</div>
					</a>
					@endforeach 
				</div>
				<div class="st-rig">
					<div class="btn-circle btn-black2-color" onclick="toRight()">
						<span class="fa fa-lg fa-angle-right"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-full">
	<div class="frame-home place-ctr">
		<div class="display-mobile">
			@foreach ($topUsers as $usr)
			<div class="frame-user">
				<a href="{{ url('/user/'.$usr->id) }}">
					<div class="top" style="background-image: url({{ asset('/profile/thumbnails/'.$usr->foto) }});"></div>
				</a>
				<div class="mid">
					{{ explode(' ', $usr->name)[0] }}
				</div>
			</div>
			@endforeach
		</div>
		@foreach ($allTags as $tag)
		<?php 
			$replace = array('[',']','@',',','.','#','+','-','*','<','>','-','(',')',';','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
			$title = str_replace($replace, '', $tag->tag); 
		?>
		<a href="{{ url('/tags/'.$title) }}">
			<div class="category" style="background-image: url({{ asset('img/cover.jpg') }})">
				<div class="cover">
				<h3>{{ $tag->tag }}</h3>
				</div>
			</div>
		</a>
		@endforeach 
	</div>
</div>
@endsection