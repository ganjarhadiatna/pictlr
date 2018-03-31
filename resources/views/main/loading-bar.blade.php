<script type="text/javascript">
	var server = "<?php echo url('/'); ?>";
	function change_title_progress(title='') {
		$('.frame-progress').find('#title').html(title);
	}
	function open_progress(title='') {
		$('.frame-progress').show().find('#title').html(title);
	}
	function close_progress() {
		$('.frame-progress').hide();
	}
	$(document).ready(function() {
		$('#main-progressbar').progressbar({
			value: false,
		});
	});
</script>
<div class="frame-progress">
	<div class="place-progress">
		<div id="title">Loading...</div>
		<div id="main-progressbar"></div>
	</div>
</div>