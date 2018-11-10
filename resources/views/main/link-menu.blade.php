<script type="text/javascript">
	function opToLink(stt, msg='', target='') {
		if (stt === 'open') {
			$('#link-popup').fadeIn();
			$('#link-popup #message').html(msg);
			$('#link-popup #btn-yes').attr('onclick', 'toLink("'+target+'")');
		} else {
			$('#link-popup').fadeOut();
		}
	}
</script>
<div class="content-popup" id="link-popup">
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
			<input type="button" name="yes" class="btn btn-primary-color" value="No" id="btn-no" onclick="opQuestion('hide')">
			<input type="button" name="yes" class="btn btn-main-color" value="Yes" id="btn-yes">
		</div>
	</div>
</div>