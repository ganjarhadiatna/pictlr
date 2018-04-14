@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<script type="text/javascript">
    function opQuestionDeleteBox(idboxs) {
        opQuestion('open','Are you sure you want to delete this box? All your saving stories will be deleted too.', 'deleteBox("'+idboxs+'")');
    }
    function deleteBox(idboxs) {
		$.ajax({
			url: '{{ url("/box/delete") }}',
			type: 'post',
			data: {'idboxs': idboxs},
			beforeSend: function() {
				opQuestion('hide');
				open_progress('Deleting your box...');
			}
		})
		.done(function(data) {
			close_progress();
			if (data === 'success') {
				opAlert('open', 'This box has been deleted, to take effect try refresh this page.');
			} else {
				opAlert('open', 'Failed to delete this box.');
			}
		})
		.fail(function() {
			close_progress();
			opAlert('open', 'There is an error, please try again.');
		});
		
	}
</script>
<div class="sc-header">
	<div class="sc-place pos-fix">
		<div class="col-800px">
			<div class="sc-grid sc-grid-3x">
				<div class="sc-col-1">
					@if (Auth::id())
                        <button class="btn btn-circle btn-main2-color btn-focus" onclick="opQuestionDeleteBox('{{ $idboxs }}')">
                            <span class="far fa-lg fa-trash-alt"></span>
                        </button>
                        <a href="{{ url('/box/'.$idboxs.'/edit/'.Auth::id().'/'.csrf_token()) }}">
                            <button class="btn btn-circle btn-main2-color btn-focus">
                                <span class="fas fa-lg fa-pencil-alt"></span>
                            </button>
                        </a>
					@endif
                </div>
                <div class="sc-col-2 txt-center">
                    <h3 class="ttl ttl-head-2 ttl-sekunder-color">Box</h3>
                </div>
				<div class="sc-col-3 txt-right">
					<a href="{{ url('/compose/story') }}">
                        <button class="btn btn-main2-color">
                            <span class="fas fa-lg fa-plus"></span>
                            <span>Add Story</span>
                        </button>
                    </a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-800px padding-20px">
	@foreach ($boxDetail as $dt)
		<h1 class="ttl-head ctn-main-font ctn-big ctn-white-color">{{ $dt->title }}</h1>
		<p class="ttl-head ctn-main-font ctn-thin ctn-mikro ctn-white-color">{{ $dt->description }}</p>
	@endforeach
</div>
<div class="padding-10px"></div>
@if (count($boxStory) == 0)
	@include('main.post-empty')
@else
	<div class="post">
		@foreach ($boxStory as $story)
			@include('main.post')
		@endforeach
	</div>
	{{ $boxStory->links() }}
@endif
@endsection