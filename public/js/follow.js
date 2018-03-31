function opFollow(iduser, server, idmain) {
	if (idmain === '') {
		opAlert('open', 'Please login berfore you can Follow this user.');
	} else {
		var tr = $('#add-follow-'+iduser).val();
		if (tr === 'Follow') {
			addFollow(iduser, server);
		} else {
			removeFollow(iduser, server);
		}
	}
}
function addFollow(iduser, server) {
	$.ajax({
		url: server+'/follow/add',
		type: 'post',
		data: {'iduser': iduser},
		beforeSend: function() {
			$('#add-follow-'+iduser).val('Wait..');
		}
	})
	.done(function(data) {
		if (data === 'success') {
			$('#add-follow-'+iduser).val('Unfollow').attr('class', 'btn btn-main3-color');
		} else {
			$('#add-follow-'+iduser).val('Follow').attr('class', 'btn btn-main2-color');
			opAlert('open', 'Failed to Follow this user.');
		}
	})
	.fail(function() {
		$('#add-follow-'+iduser).val('Follow').attr('class', 'btn btn-main2-color');
		opAlert('open', 'There is an error, please try again.');
	});
	
}
function removeFollow(iduser, server) {
	$.ajax({
		url: server+'/follow/remove',
		type: 'post',
		data: {'iduser': iduser},
		beforeSend: function() {
			$('#add-follow-'+iduser).val('Wait..');
		}
	})
	.done(function(data) {
		if (data === 'success') {
			$('#add-follow-'+iduser).val('Follow').attr('class', 'btn btn-main2-color');
		} else {
			$('#add-follow-'+iduser).val('Unfollow').attr('class', 'btn btn-main3-color');
			opAlert('open', 'Failed to Unfollow this user.');
		}
	})
	.fail(function() {
		$('#add-follow-'+iduser).val('Unfollow').attr('class', 'btn btn-main3-color');
		opAlert('open', 'There is an error, please try again.');
	});
}