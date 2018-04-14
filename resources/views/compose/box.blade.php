@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<script type="text/javascript">
    function createBox() {
		var fd = new FormData();
		var title = $('#title-box').val();
		var content = $('#write-box').val();

		fd.append('title', title);
		fd.append('content', content);
		$.each($('#form-publish').serializeArray(), function(a, b) {
		   	fd.append(b.name, b.value);
		});

		$.ajax({
		  	url: '{{ url("/box/publish") }}',
			data: fd,
			processData: false,
			contentType: false,
			type: 'post',
			beforeSend: function() {
				open_progress('Creating your box...');
			}
		})
		.done(function(data) {
		   	if (data == 0) {
		   		opAlert('open', 'failed to create box, please try again.');
		   		close_progress();
		   	} else {
		   		$('#title-box').val('');
				$('#write-box').val('');
				close_progress();
				window.location = '{{ url("/box/") }}'+'/'+data;
		   	}
		   	//console.log(data);
		})
		.fail(function(data) {
		  	opAlert('open', "there is an error, please try again.");
		   	//console.log(data.responseJSON);
		})
		.always(function() {
			close_progress();
		});

		return false;
	}
    $(document).ready(function() {
        $('#write-box').keyup(function(event) {
			var length = $(this).val().length;
			$('#desc-lg').html(length);
			
		});
    });
</script>
<div class="sc-header">
	<div class="sc-place pos-fix">
		<div class="col-full">
			<div class="sc-grid sc-grid-3x">
				<div class="sc-col-1"></div>
				<div class="sc-col-2">
					<h3 class="ttl-head ttl-sekunder-color">Create New Box</h3>
				</div>
				<div class="sc-col-3"></div>
			</div>
		</div>
	</div>
</div>
<div class="compose" id="create">
    <div class="main">
        <div class="create-body edit">
            <div class="create-mn">
                <form id="form-publish" method="post" action="javascript:void(0)" enctype="multipart/form-data" onsubmit="createBox()">
                    <div class="create-block">
                        <div class="block-field place-tags">
                            <div class="pan">
                                <div class="left">
                                    <p class="ttl">Box Title</p>
                                </div>
                                <div class="right"></div>
                            </div>
                            <div class="block-field">
                                <input type="text" name="title" id="title-box" class="tg txt txt-main-color txt-box-shadow" placeholder="Title" required="true">
                            </div>
                        </div>
                        <div class="block-field">
                            <div class="pan">
                                <div class="left">
                                    <p class="ttl">Box Description</p>
                                </div>
                                <div class="right">
                                    <div class="count">
                                        <span id="desc-lg">0</span>/250
                                    </div>
                                </div>
                            </div>
                            <textarea name="write-box"
                            id="write-box"
                            class="txt edit-text txt-main-color txt-box-shadow ctn ctn-main ctn-sans-serif"
                            maxlength="250"
                            placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="create-bot">
                        <input type="button" name="edit-save" class="btn btn-primary-color" value="Cancel" onclick="goBack()">
                        <input type="submit" name="save" class="btn btn-main-color" value="Create" id="btn-publish">
                    </div>
                </form>
    
            </div>
            <div class="padding-10px"></div>
        </div>
    </div>
    
</div>
@endsection