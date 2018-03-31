<?php use App\TagModel; ?>
<script type="text/javascript">
	$(document).on('click', function(event) {
		$('#more-menu').hide();
		$('#nav-more-target').removeClass('active');
		$('#nav-more-target').attr('key', 'hide');
		setScrollMobile('show');
	});
	$(document).ready(function() {
		$('#nav-more-target').on('click', function(event) {
			var tr = $(this).attr('key');
			if (tr == 'hide') {
				event.stopPropagation();
				$('#more-menu').show();
				$('#notifications').hide();
				$(this).addClass('active');
				$(this).attr('key', 'open');
				setScrollMobile('hide');
			} else {
				$('#more-menu').hide();
				$(this).removeClass('active');
				$(this).attr('key', 'hide');
				setScrollMobile('show');
			}
		});

		$('#more-menu *').on('click', function(event) {
			event.stopPropagation();
			$('#more-menu').show();
			$('#notifications').hide();
			$('#nav-more-target').addClass('active');
			$('#nav-more-target').attr('key', 'open');
		});
	});
</script>
<div class="more-menu" id="more-menu">
	<div class="block">
		<div class="ttl-ctr">
			Top Choice
		</div>
		<div class="column">
			<div class="frame-more-menu">
				<div class="fm-side">
					<a href="{{ url('/box') }}">
						<div class="icn btn btn-circle btn-main-color">
							<span class="fas fa-lg fa-bookmark"></span>
						</div>
					</a>
				</div>
				<div class="fm-main">
					<div class="ttl">My Box</div>
				</div>
			</div>

			<div class="frame-more-menu">
				<div class="fm-side">
					<a href="{{ url('/fresh') }}">
						<div class="icn btn btn-circle btn-main-color">
							<span class="fas fa-lg fa-clock"></span>
						</div>
					</a>
				</div>
				<div class="fm-main">
					<div class="ttl">Fresh</div>
				</div>
			</div>
			
			<div class="frame-more-menu">
				<div class="fm-side">
					<a href="{{ url('/popular') }}">
						<div class="icn btn btn-circle btn-main-color">
							<span class="fas fa-lg fa-fire"></span>
						</div>
					</a>
				</div>
				<div class="fm-main">
					<div class="ttl">Popular</div>
				</div>
			</div>
			
			<div class="frame-more-menu">
				<div class="fm-side">
					<a href="{{ url('/trending') }}">
						<div class="icn btn btn-circle btn-main-color">
							<span class="fas fa-lg fa-bolt"></span>
						</div>
					</a>
				</div>
				<div class="fm-main">
					<div class="ttl">Trending</div>
				</div>
			</div>
		</div>
	</div>
	<div class="block">
		<div class="ttl-ctr">
			All Collections
		</div>
		<div class="place-collect">
			<div class="column-2">
				<ul class="mn">
					@foreach (TagModel::AllTags() as $tag)
						<?php 
							$replace = array('[',']','@',',','.','#','+','-','*','<','>','-','(',')',';','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
							$title = str_replace($replace, '', $tag->tag); 
						?>
						<li>
							<a href="{{ url('/tags/'.$title) }}">
								{{ $tag->tag }}
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>