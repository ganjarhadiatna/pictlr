@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')

@if (count($topTags) != 0)
<div class="sc-header">
	<div class="sc-place pos-fix">
		<div>
			<div class="place-search-tag col-full">
				<div class="st-lef">
					<div class="btn btn-circle btn-main-color" onclick="toLeft()">
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
					<div class="btn btn-circle btn-main-color" onclick="toRight()">
						<span class="fa fa-lg fa-angle-right"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

<div>
	@if (count($topStory) == 0)
		@include('main.post-empty')	
	@else
		<div class="post">
			@foreach ($topStory as $story)
				@include('main.post')
			@endforeach
		</div>
		{{ $topStory->links() }}
	@endif
</div>
@endsection