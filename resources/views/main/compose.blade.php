<script type="text/javascript">
	var server = '{{ url("/") }}';
	function loadCover() {
		var OFReader = new FileReader();
		OFReader.readAsDataURL(document.getElementById("cover").files[0]);
		OFReader.onload = function (oFREvent) {
			$("#image-review").css('background-image', 'url('+oFREvent.target.result+')');
		}
		$('#image-review').show();
		$('#cover-icn').hide();
	}
	function publish() {
		var fd = new FormData();
		var cover = $('#cover')[0].files[0];
		var content = $('#write-story').val();
		var tags = $('#tags-story').val();

		fd.append('cover', cover);
		fd.append('content', content);
		fd.append('tags', tags);
		$.each($('#form-publish').serializeArray(), function(a, b) {
		   	fd.append(b.name, b.value);
		});

		$.ajax({
		  	url: '{{ url("/story/publish") }}',
			data: fd,
			processData: false,
			contentType: false,
			type: 'post',
			beforeSend: function() {
				open_progress('Uploading your Story...');
			}
		})
		.done(function(data) {
		   	if (data === 'failed') {
		   		opAlert('open', 'failed to publish story.');
		   		close_progress();
		   	} else {
		   		$('#cover').val('');
				$('#write-story').val('');
				$('#tags-story').val('')
				close_progress();
				opCompose('hide');
				opToLink('open', 'Story has been published. Look it now?', server+'/story/'+data);
		   	}
		   	//console.log(data);
		})
		.fail(function(data) {
		  	opAlert('open', "there is an error, please try again.");
		   	close_progress();
		   	//console.log(data.responseJSON);
		});

		return false;
	}
	$(document).ready(function() {
		$('#write-story').keyup(function(event) {
			var length = $(this).val().length;
			$('#desc-lg').html(length);
			
		});
	});
</script>
<div class="content-popup" id="compose-popup">
	<form id="form-publish" method="post" action="javascript:void(0)" enctype="multipart/form-data" onsubmit="publish()">
		<div class="compose">
			<div class="grid-1">
				<input type="file" name="cover" id="cover" required="required" autofocus="autofocus" onchange="loadCover()">
				<label for="cover">
					<div class="cover-icn" id="cover-icn">
						<div class="icn fa fa-lg fa-plus"></div>
					</div>
					<div class="image-icn" id="image-review">
						<div class="change-cover">
							<span>To change Picture just click again.</span>
						</div>
					</div>
				</label>
			</div>
			<div class="grid-2">
				<div class="block-field padding-bottom-10px">
					<div class="pan">
						<div class="left">
							<p class="ttl">Description</p>
						</div>
						<div class="right">
							<div class="count">
								<span id="desc-lg">0</span>/250
							</div>
						</div>
					</div>
					<textarea name="write-story" id="write-story" class="txt edit-text txt-main-color txt-box-shadow ctn ctn-main ctn-sans-serif" maxlength="250"></textarea>
				</div>
				<div class="block-field padding-bottom-15px">
					<div class="pan">
						<div class="left">
							<p class="ttl">Tags</p>
						</div>
						<div class="right"></div>
					</div>
					<input type="text" name="tags" id="tags-story" class="tg txt txt-main-color txt-box-shadow" placeholder="Tags1, Tags2, Tags N...">
				</div>
				<div class="block-field place-button">
					<input type="button" name="edit-save" class="btn btn-primary-color" value="Cancel" onclick="opCompose('hide');">
					<input type="submit" name="save" class="btn btn-main-color" value="Post" id="btn-publish">
				</div>
			</div>
		</div>
	</form>
</div>