@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<div class="sc-header padding-10px">
	<div class="sc-place">
		<div class="sc-block">
			<div class="sc-col-1">
				<h1 class="ttl-head ctn-main-font ctn-big">{{ $title }}</h1>
			</div>
		</div>
	</div>
</div>
<div class="padding-bottom-20px"></div>
<div>
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
</div>
@endsection