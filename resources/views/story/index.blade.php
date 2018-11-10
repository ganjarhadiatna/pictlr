@extends('layout.index')
@section('title',$title)
@section('path',$path)
@section('content')
@foreach ($getStory as $story)
<script type="text/javascript">
	var id = '{{ Auth::id() }}';
	var server = '{{ url("/") }}';

	function getComment(idstory, stt) {
		var offset = $('#offset-comment').val();
		var limit = $('#limit-comment').val();
		if (stt == 'new') {
			var url_comment = '{{ url("/get/comment/") }}'+'/'+idstory+'/0/'+offset;
		} else {
			var url_comment = '{{ url("/get/comment/") }}'+'/'+idstory+'/'+offset+'/'+limit;
		}
		$.ajax({
			url: url_comment,
			dataType: 'json',
		})
		.done(function(data) {
			var dt = '';
			for (var i = 0; i < data.length; i++) {
				var server_foto = server+'/profile/thumbnails/'+data[i].foto;
				var server_user = server+'/user/'+data[i].id;
				if (data[i].id == id) {
					var op = '<span class="fa fa-lg fa-circle"></span>\
							<span class="del pointer" onclick="opQuestion('+"'open'"+','+"'Delete this comment ?'"+','+"'deleteComment("+data[i].idcomment+")'"+')" title="Delete comment.">Delete</span>';
				} else {
					var op = '';
				}
				dt += '\
					<div class="frame-comment comment-owner">\
						<div class="dt-1">\
							<a href="'+server_user+'" title="'+data[i].username+'">\
								<div class="image image-45px image-circle" style="background-image: url('+server_foto+')"></div>\
							</a>\
						</div>\
						<div class="dt-2">\
							<div class="desk comment-owner-radius">\
								<div class="comment-main">\
									<a href="'+server_user+'" title="'+data[i].username+'"><strong class="comment-name">'+data[i].username+'</strong></a>\
									<div>'+data[i].description+'</div>\
								</div>\
							</div>\
							<div class="tgl">\
								<span>'+data[i].created+'</span>\
								'+op+'\
							</div>\
						</div>\
					</div>\
				';
			}
			if (stt === 'new') {
				$('#place-comment').html(dt);
			} else {
				$('#place-comment').append(dt);

				var ttl = (parseInt($('#offset-comment').val()) + 5);
				$('#offset-comment').val(ttl);
			}
			if (data.length >= limit) {
				$('#frame-more-comment').show();
			} else {
				$('#frame-more-comment').hide();
			}
		})
		.fail(function(data) {
			console.log(data.responseJSON);
		});
		
	}
	function deleteComment(idcomment) {
		$.ajax({
			url: '{{ url("/delete/comment") }}',
			type: 'post',
			data: {'idcomment': idcomment},
		})
		.done(function(data) {
			if (data === 'success') {
				getComment('{{ $story->idstory }}', 'new');
			} else {
				opAlert('open', 'Deletting comment failed.');
			}
		})
		.fail(function(data) {
			console.log(data.responseJSON);
		}).
		always(function() {
			opQuestion('hide');
		});
	}
	function toComment() {
		var top = $('#tr-comment').offset().top;
		$('html, body').animate({scrollTop : (Math.round(top) - 70)}, 300);
		$('#comment-description').focus();
	}
	$(document).ready(function() {
		$('#offset-comment').val(0);
		$('#limit-comment').val(5);
		getComment('{{ $story->idstory }}', 'add');

		$('#comment-publish').submit(function(event) {
			var idstory = '{{ $story->idstory }}';
			var desc = $('#comment-description').val();
			if (desc === '') {
				$('#comment-description').focus();
			} else {
				$.ajax({
					url: '{{ url("/add/comment") }}',
					type: 'post',
					data: {
						'description': desc,
						'idstory': idstory
					},
				})
				.done(function(data) {
					if (data === 'failed') {
						opAlert('open', 'Sending comment failed.');
						$('#comment-description').focus();
					} else {
						$('#comment-description').val('');
						//refresh comment
						getComment('{{ $story->idstory }}', 'new');
					}
				})
				.fail(function(data) {
					console.log(data.responseJSON);
					opAlert('open', 'There is an error, please try again.');
				});
			}
		});

		$('#load-more-comment').on('click', function(event) {
			getComment('{{ $story->idstory }}', 'add');
		});

		$('.change-img').on('click', function(event) {
			var idimage = $(this).attr('key');
			$.ajax({
				url: server+'/image/'+idimage,
				type: 'get',
				beforeSend: function() {
					opLoadingCircle('open');
				}
			})
			.done(function(data) {
				if (data && data.length) {
					for (let i = 0; i < data.length; i++) {
						var img = '{{ asset("/story/covers/") }}'+'/'+data[i].image;
						$('#place-img').attr('src', img);
						$('#frame-img').css({'padding-bottom': ((data[i].height / data[i].width) * 100)+'%'});	
					}
				} else {
					opAlert('open', 'Failed to load image.');
				}
			})
			.fail(function(e) {
				opAlert('open', 'There is an error, please try again.');
			})
			.always(function () {
				opLoadingCircle('hide');
			});
		});

	});
</script>
<div class="place-story">
	<div class="main">
		<div class="place">
			<div class="frame-story col-600px">
				<div class="sc-header padding-bottom-5px">
					<div class="sc-place no-background col-full">
						<div class="sc-grid sc-grid-2x">
							<div class="sc-col-1">
								<div style="display: inline-block; vertical-align: middle;">
									<a href="{{ url('/user/'.$story->id) }}" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
										<div class="image image-45px image-circle" style="background-image: url({{ asset('/profile/thumbnails/'.$story->foto) }});"></div>
									</a>
									<div class="ctn-main-font ctn-min-color ctn-16px ctn-link" style="display: inline-block; vertical-align: middle;">
										<a href="{{ url('/user/'.$story->id) }}">
											{{ $story->username }}
										</a>
									</div>
								</div>
							</div>
							<div class="sc-col-2 txt-right">
								<div>
									<button class="icn btn btn-circle btn-primary-color" onclick="opPostPopup('open', 'menu-popup', '{{ $story->idstory }}', '{{ $story->id }}', '{{ $title }}')">
										<span class="fa fa-lg fa-ellipsis-h"></span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="grids-2x">
					<div class="grid-1">
						<!--
						<div class="mid">
							<div class="pict padding-bottom-5px">
								<div class="cover-pict" style="padding-bottom: {{ (($story->height / $story->width) * 100) }}%;" id="frame-img">
									<img src="{{ asset('/story/covers/'.$story->cover) }}" id="place-img" class="pict">
								</div>
							</div>
						</div>
						@if ($story->ttl_image > 1)
						-->
							@foreach ($images as $img)
								<div class="mid">
									<div class="pict padding-bottom-5px">
										<div class="cover-pict" style="padding-bottom: {{ (($img->height / $img->width) * 100) }}%;" id="frame-img">
											<img src="{{ asset('/story/covers/'.$img->image) }}" id="place-img" class="pict">
										</div>
									</div>
								</div>
							@endforeach
						<!-- @endif -->
					</div>
					<div class="grid-2">
						<div class="pos mid">
							@if ($story->description != "")
								<div class="content ctn-main-font ctn-sans-serif padding-bottom-15px">
									<?php echo $story->description; ?>
								</div>
							@endif
							@if (count($tags) > 0)
								<div class="padding-bottom-15px">
									@foreach($tags as $tag)
									<?php 
										$replace = array('[',']','@',',','.','#','+','-','*','<','>','-','(',')',';','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
										$title = str_replace($replace, '', $tag->tag); 
									?>
									<a href="{{ url('/tags/'.$title) }}" class="frame-top-tag">
										<div>{{ $tag->tag }}</div>
									</a>
									@endforeach
								</div>
							@endif
						</div>
						<div class="pos mid">
							<div class="grid grid-2x padding-bottom-10px">
								<div class="grid-1">
									<a href="{{ url('/story/'.$story->idstory) }}">
										<button class="btn btn-sekunder-color btn-no-border btn-pad-5px">
											<span>{{ $story->views }}</span>
											<span>Views</span>
										</button>
									</a>
								</div>
								<div class="grid-2 text-right crs-default">
									<button 
										class="btn btn-sekunder-color btn-no-border btn-pad-5px love" 
										onclick="addLove('{{ $story->idstory }}')">
										@if (is_int($story->is_love))
											<span class="love-{{ $story->idstory }} fas fa-lg fa-heart"></span>
										@else
											<span class="love-{{ $story->idstory }} far fa-lg fa-heart"></span>
										@endif
										<span>{{ $story->ttl_love }}</span>
									</button>
									<button class="btn btn-sekunder-color btn-no-border btn-pad-5px" onclick="toComment()">
										<span class="far fa-lg fa-comment"></span>
										<span>{{ $story->ttl_comment }}</span>
									</button>
									<button class="btn btn-circle btn-sekunder-color btn-no-border save"
										key="{{ $story->idstory }}" 
										onclick="addBookmark('{{ $story->idstory }}')">
										@if (is_int($story->is_save))
											<span class="bookmark-{{ $story->idstory }} fas fa-lg fa-bookmark" id="bookmark-{{ $story->idstory }}"></span>
										@else
											<span class="bookmark-{{ $story->idstory }} far fa-lg fa-bookmark" id="bookmark-{{ $story->idstory }}"></span>
										@endif
										<span>{{ $story->ttl_save }}</span>
									</button>
								</div>
							</div>
						</div>
						<div class="pos bot">
							<div class="padding-bottom-20px">
								<div class="top-comment" id="tr-comment">
									@if (Auth::id())
									<form method="post" action="javascript:void(0)" id="comment-publish">
										<div class="comment-head">
											<div>
												<input class="txt comment-text txt-primary-color" id="comment-description" placeholder="Type comment here.." />
											</div>
										</div>
									</form>
									@endif
									<div class="comment-content" id="place-comment"></div>
								</div>
								<div class="frame-more" id="frame-more-comment">
									<input type="hidden" name="offset" id="offset-comment" value="0">
									<input type="hidden" name="limit" id="limit-comment" value="0">
									<button class="btn btn-sekunder-color btn-radius" id="load-more-comment">
										<span class="Load More Comment">Load More</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</div>
@endforeach
<div class="padding-20px">
	<div>
		<div class="post">
			@foreach ($newStory as $story)
				<a href="#">
					@include('main.post')
				</a>
			@endforeach
		</div>
	</div>
</div>
@endsection
