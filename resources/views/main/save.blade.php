<?php use App\BoxModel; ?>
<script type="text/javascript">
	var server = '{{ url("/") }}';
	var iduser = '{{ Auth::id() }}';
	function opSave(ctr, idstory='') {
		if (ctr == 'open') {
			var pict = $('#pict-'+idstory).attr('src');
			$('#save-popup').show().attr('key',idstory);
			setScroll('hide');
			$("#image-save").css('background-image', 'url('+pict+')');
		} else {
			$('#save-popup').hide().attr('key','0');
			setScroll('show');
		}
	}
	function removeBookmark(idbookmark, idstory) {
		if (iduser === '') {
			opAlert('open', 'Please login berfore you can save this story.');
		} else {
			$.ajax({
				url: '{{ url("/box/remove/story") }}',
				type: 'post',
				data: {'idbookmark': idbookmark},
			})
			.done(function(data) {
				if (data == 1) {
					opAlert('open', 'Story has been removed from Box.');
					$('#bookmark-'+idstory).attr({
						'onclick':"opSave('open','"+idstory+"')",
						'title':'Save to box?'
					});
					$('#bookmark-'+idstory+' #ic').attr('class', 'far fa-lg fa-bookmark');
				} else if (data == 0) {
					opAlert('open', 'Failed to remove story from Box.');
					$('#bookmark-'+idstory).attr({
						'onclick':'removeBookmark('+idbookmark+')',
						'title':'Remove from box?'
					});
					$('#bookmark-'+idstory+' #ic').attr('class', 'fas fa-lg fa-bookmark');
				} else {
					opAlert('open', 'Please try again.');
				}
				//console.log(data);
			})
			.fail(function(data) {
				//console.log(data.responseJSON);
				opAlert('open', 'There is an error, please try again.');
			});
		}
	}
	function addBookmark(idboxs) {
		if (iduser === '') {
			opAlert('open', 'Please login berfore you can save this story.');
		} else {
			var idstory = $('#save-popup').attr('key');
			$.ajax({
				url: '{{ url("/box/save/story") }}',
				type: 'post',
				data: {'idstory': idstory,'idboxs': idboxs},
			})
			.done(function(data) {
				if (data) {
					opAlert('open', 'Story has been saved to Box.');
					$('#bookmark-'+idstory).attr({
						'onclick':'removeBookmark('+data+','+idstory+')',
						'title':'Remove from box?'
					});
					$('#bookmark-'+idstory+' #ic').attr('class', 'icn fas fa-lg fa-bookmark');
				} else if (data == 0) {
					opAlert('open', 'Failed to save story to Box.');
					$('#bookmark-'+idstory).attr({
						'onclick':"opSave('open','"+idstory+"')",
						'title':'Save to box?'
					});
					$('#bookmark-'+idstory+' #ic').attr('class', 'far fa-lg fa-bookmark');
				} else {
					opAlert('open', 'Please try again.');
				}
				//console.log(data);
			})
			.fail(function(data) {
				//console.log(data.responseJSON);
				opAlert('open', 'There is an error, please try again.');
			})
			.always(function() {
				opSave('hide');
			});
		}
	}
	$(document).ready(function() {
	});
</script>
<div class="content-popup" id="save-popup" key="0">
	<div class="save">
		<div class="pos top">
			<div class="lef">
				<strong class="ttl">Choose Box</strong>
			</div>
			<div class="rig">
				<button class="btn btn-circle btn-primary-color btn-no-border" onclick="opSave('hide')">
					<span class="fas fa-lg fa-times"></span>
				</button>
			</div>
		</div>
		<div class="mid">
			@if (count(BoxModel::GetAllBox()) == 0)
				<div class="frame-empty">
					<div class="ctn-main-font ctn-big ctn-mikro ctn-sek-color padding-15px">Box empty, try to create one.</div>
					<a href="{{ url('/compose/box') }}">
						<button class="create btn btn-main3-color width-all" onclick="opCompose('open');">
							<span class="fas fa-lg fa-plus"></span>
							<span>Create Your First Box</span>
						</button>
					</a>
				</div>
			@else
				@foreach (BoxModel::GetAllBox() as $bx)
					<div class="frame-small-box" onclick="addBookmark({{ $bx->idboxs }})">
						<div class="lef">
							<div class="image image-40px image-radius">
								<span class="icn fas fa-lg fa-box-open"></span>
							</div>
						</div>
						<div class="mid">
							<div class="ttl">
								<span class="ctn-main-font ctn-14px ctn-min-color">{{ $bx->title }}</span>
							</div>
						</div>
						<div class="rig">
							<button class="btn btn-circle btn-main-color">
								<span class="fas fa-lg fa-bookmark"></span>
							</button>
						</div>
					</div>
				@endforeach
			@endif
		</div>
		<div class="pos bot">
		</div>
	</div>
</div>	