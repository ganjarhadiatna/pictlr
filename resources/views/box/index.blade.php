@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<script type="text/javascript">
	$(document).ready(function() {

	});
</script>
<div class="sc-header">
	<div class="sc-place pos-fix">
		<div class="col-800px">
			<div class="sc-grid sc-grid-2x">
				<div class="sc-col-1">
					<h3 class="ttl-head-2 ttl-sekunder-color">My Boxs</h3>
				</div>
				<div class="sc-col-2 txt-right">
					<a href="{{ url('/compose/box') }}">
                        <button class="btn btn-main2-color">
                            <span class="fas fa-lg fa-plus"></span>
                            <span>Add Box</span>
                        </button>
                    </a>
				</div>
			</div>
		</div>
	</div>
</div>
<div>
    @if (count($box) == 0)
        <div class="frame-empty">
            <div class="icn fa fa-lg fa-thermometer-empty btn-main-color"></div>
            <div class="ttl padding-15px">Box empty, try to create one.</div>
            <a href="{{ url('/compose/box') }}">
                <button class="create btn btn-main3-color width-all" onclick="opCompose('open');">
                    <span class="fas fa-lg fa-plus"></span>
                    <span>Create Your First Box</span>
                </button>
            </a>
        </div>
    @else
        <div class="post-flex">
            @foreach ($box as $bx)
                @include('main.box')
            @endforeach
        </div>
        {{ $box->links() }}
    @endif
</div>
@endsection