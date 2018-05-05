@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<script type="text/javascript">
	var server = '{{ url("/") }}';
	function opDialog(stt, path='') {
		if (stt === 'open') {
			$('#'+path).fadeIn();
		} else {
			$('.compose .create-dialog').fadeOut();
		}
	}
	function putToText(html) {
		document.getElementById('write-story').focus();
	    var sel, range;
	    if (window.getSelection) {
	        // IE9 and non-IE
	        sel = window.getSelection();
	        if (sel.getRangeAt && sel.rangeCount) {
	            range = sel.getRangeAt(0);
	            range.deleteContents();
	            // Range.createContextualFragment() would be useful here but is
	            // non-standard and not supported in all browsers (IE9, for one)
	            var el = document.createElement("div");
	            el.innerHTML = html;
	            var frag = document.createDocumentFragment(), node, lastNode;
	            while ( (node = el.firstChild) ) {
	                lastNode = frag.appendChild(node);
	            }
	            range.insertNode(frag);
	            // Preserve the selection
	            if (lastNode) {
	                range = range.cloneRange();
	                range.setStartAfter(lastNode);
	                range.collapse(true);
	                sel.removeAllRanges();
	                sel.addRange(range);
	            }
	        }
	    } else if (document.selection && document.selection.type != "Control") {
	        // IE < 9
	        document.selection.createRange().pasteHTML(html);
	    }
	}
	function getImage() {
		var fd = new FormData();
		var image = $('#get-image')[0].files[0];
		
		fd.append('image', image);
		$.each($('#form-image').serializeArray(), function(a, b) {
	    	fd.append(b.name, b.value);
	    });
	    $.ajax({
	    	url: '{{ url("/story/image/upload") }}',
			data: fd,
			processData: false,
			contentType: false,
			type: 'post',
			beforeSend: function() {
				$('#progressbar').show();
			}
	    })
	    .done(function(data) {
	    	var dt = '<img src="'+server+'/story/images/'+data+'" alt="image">';
	    	$('#progressbar').hide();
	    	$('#get-image').val('');
	    	putToText(dt);
	    })
	    .fail(function() {
	    	opAlert('open', 'We can not upload your Picture, please try again.');
	    	$('#progressbar').hide();
	    });
	}
	function getImageUrl() {
		var url = $('#image-url').val();
		if (url === '') {
			$('#image-url').focus();
		} else {
			var dt = '<img src="'+url+'" alt="image">';
			putToText(dt);
			opDialog('hide');
			$('#image-url').val('');
		}
	}
	function getLinkUrl() {
		var url = $('#link-url').val();
		if (url === '') {
			$('#link-url').focus();
		} else {
			var dt = '<a href="'+url+'" class="link">'+url+'</a>';
			putToText(dt);
			opDialog('hide');
			$('#link-url').val('');
		}
	}
	function getEmbed() {
		var url = $('#embed-code').val();
		if (url === '') {
			$('#embed-code').focus();
		} else {
			putToText(url);
			opDialog('hide');
			$('#embed-code').val('');
		}
	}
	function publish() {
		var fd = new FormData();
		var idstory = $('#id-story').val();
		var content = $('#write-story').val();
		var tags = $('#tags-story').val();

		fd.append('idstory', idstory);
		fd.append('content', content);
		fd.append('tags', tags);
		$.each($('#form-publish').serializeArray(), function(a, b) {
		   	fd.append(b.name, b.value);
		});

		$.ajax({
		  	url: '{{ url("/story/save/editting") }}',
			data: fd,
			processData: false,
			contentType: false,
			type: 'post',
			beforeSend: function() {
				open_progress('Updating your Story...');
			}
		})
		.done(function(data) {
		   	if (data === 'failed') {
		   		opAlert('open', 'failed to saving story, your story still the same with previous content. To fix problem try with edit content story.');
		   		close_progress();
		   	} else {
				$('#title-story').val('');
				$('#write-story').val('');
				opCreateStory('close');
				close_progress();
				window.location = '{{ url("/story/") }}'+'/'+data;
		   	}
		   	//console.log(data);
		})
		.fail(function() {
		  	opAlert('open', "there is an error, please try again.");
		   	close_progress();
		});

		return false;
	}
	$(document).ready(function() {
		$('#progressbar').progressbar({
			value: false,
		});
		$('#write-story').keyup(function(event) {
			var length = $(this).val().length;
			$('#desc-lg').html(length);
			
		});
		$('#btnToolStory').on('click', function(e) {
			e.preventDefault();
			var stt = $('#btnToolStory #tool-icn').attr('key');
			if (stt == 'hidden') {
				var x = ($(this).offset().top - 155);
				var y = ($(this).offset().left - 145);
				$('#toolStory')
				.css({
					'top': x+'px',
					'right': '40px'
				})
				.show();
				$('#btnToolStory #tool-icn').attr('key','open');
				$('#btnToolStory #tool-icn').attr('class', 'icn fa fa-lg fa-times');
				$('#btnToolStory').addClass('active');
			} else {
				$('#toolStory').hide();
				$('#btnToolStory #tool-icn').attr('key','hidden');
				$('#btnToolStory #tool-icn').attr('class', 'icn fa fa-lg fa-plus');
				$('#btnToolStory').removeClass('active');
			}
		});
	});
</script>
<div class="sc-header">
	<div class="sc-place pos-fix">
		<div class="col-full">
			<div class="sc-grid sc-grid-3x">
				<div class="sc-col-1"></div>
				<div class="sc-col-2">
					<h3 class="ttl-head ttl-sekunder-color">Edit Story</h3>
				</div>
				<div class="sc-col-3"></div>
			</div>
		</div>
	</div>
</div>
@foreach ($getStory as $story)
<div>
	<div class="compose" id="create">
		<div class="main">
			<div class="create-body">
				<div class="create-mn">

					<form id="form-publish" method="post" action="javascript:void(0)" enctype="multipart/form-data" onsubmit="publish()">
						<div class="create-block no-pad">
							<!--progress bar-->
							<div class="loading mrg-bottom" id="progressbar"></div>

							<input type="hidden" name="idstory" id="title-story" required="required" value="{{ $story->idstory }}">

							<div class="block-field">
								<div class="pan">
									<div class="left">
										<p class="ttl">Edit your Story Here</p>
									</div>
									<div class="right">
										<div class="count">
											<span id="desc-lg">0</span>/250
										</div>
									</div>
								</div>
								<textarea name="write-story" id="write-story" class="txt edit-text txt-main-color txt-box-shadow ctn ctn-main ctn-sans-serif" maxlength="250"><?php echo $story->description; ?></textarea>
							</div>
							<div class="padding-5px"></div>
							<div class="block-field">
								<div class="pan">
									<div class="left">
										<p class="ttl">Tags</p>
									</div>
								</div>
								<div class="place-tags">
									<div class="block-field">
										<input type="text" name="tags" id="tags-story" class="tg txt txt-main-color txt-box-shadow" placeholder="Tags1, Tags2, Tags N..." value="{{ $tags }}">
									</div>
								</div>
							</div>
						</div>
						<div class="padding-5px"></div>
						<div class="create-bot padding-bottom-5px">
							<input type="button" name="edit-save" class="btn btn-primary-color" value="Cancel" onclick="goBack()">
							<input type="submit" name="save" class="btn btn-main-color" value="Save" id="btn-publish">
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
@endforeach
@endsection