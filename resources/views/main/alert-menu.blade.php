<script type="text/javascript">
	function opAlert(stt, msg='') {
		if (stt === 'open') {
			$('#alert-popup').fadeIn();
			$('#alert-popup #message').html(msg);
		} else {
			$('#alert-popup').fadeOut();
		}
	}
</script>
<div class="content-popup" id="alert-popup">
	<div class="place-popup question-popup">
		<div class="pos top">
			Message
		</div>
		<div class="pos mid">
			<div id="message">
				Message will be in here
			</div>
		</div>
		<div class="pos bot">
			<input type="button" name="yes" class="btn btn-main-color" value="Ok" id="btn-Ok" onclick="opAlert('hide')">
		</div>
	</div>
</div>