@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<script type="text/javascript">
	function loadFoto() {
		var OFReader = new FileReader();
		OFReader.readAsDataURL(document.getElementById("change-picture").files[0]);
		OFReader.onload = function (oFREvent) {
			$('#place-picture').css('background-image', 'url("'+oFREvent.target.result+'")');
		}
	}
	function saveProfile() {
		var fd = new FormData();
		var name = $('#edit-name').val();
		var email = $('#edit-email').val();
		var about = $('#edit-about').text();
		var website = $('#edit-website').val();
		var foto = $('#change-picture')[0].files[0];

		fd.append('foto', foto);
		fd.append('name', name);
		fd.append('email', email);
		fd.append('about', about);
		fd.append('website', website);
		$.each($('#form-edit-profile').serializeArray(), function(a, b) {
		   	fd.append(b.name, b.value);
		});

		$.ajax({
			url: '{{ url("/save/profile") }}',
			data: fd,
			processData: false,
			contentType: false,
			type: 'post',
			beforeSend: function() {
				open_progress('Editing your Profile...');
			}
		})
		.done(function(data) {
			if (data === 'success') {
				window.location = '{{ url("/me") }}';
			} else {
				alert("failed to Saving, please try again.");
			}
			close_progress();
		})
		.fail(function(data) {
			console.log(data.responseJSON);
			//alert("there is an error, please try again.");
			close_progress();
		})
		.always(function() {
			close_progress();
		});
		
		return false;
	}
	function editProfile(stt) {
		if (stt === 'edit') {
			$('#edit-name').attr({'required': 'true','contenteditable': 'true'}).addClass('info-active').focus();
			$('#edit-email').attr({'required': 'true','contenteditable': 'true'}).addClass('info-active');
			$('#edit-about').attr({'required': 'true','contenteditable': 'true'}).addClass('info-active');
			$('#btn-edit-profile').attr({'onclick': "editProfile('cancel')", 'value': 'Cancel Editing'});
			$('#btn-save-edit').show();
			$('#change').show();
		} else {
			$('#edit-name').removeAttr('contenteditable', 'true').removeAttr('required', 'true').removeClass('info-active');
			$('#edit-email').removeAttr('contenteditable', 'true').removeAttr('required', 'true').removeClass('info-active');
			$('#edit-about').removeAttr('contenteditable', 'true').removeAttr('required', 'true').removeClass('info-active');
			$('#btn-edit-profile').attr({'onclick': "editProfile('edit')", 'value': 'Edit Profile'});
			$('#btn-save-edit').hide();
			$('#change').hide();
		}
	}
</script>
<div class="sc-header">
	<div class="sc-place pos-fix">
		<div class="col-full">
			<div class="sc-grid sc-grid-3x">
				<div class="sc-col-1"></div>
				<div class="sc-col-2">
					<h3 class="ttl-head ttl-sekunder-color">Edit Profile</h3>
				</div>
				<div class="sc-col-3"></div>
			</div>
		</div>
	</div>
</div>
<div class="frame-home frame-edit">
	<div class="compose" id="create">
		<div class="main">
			<div class="edit-body">
				@foreach ($profile as $p)
				<form id="form-edit-profile" method="post" action="javascript:void(0)" enctype="multipart/form-data" onsubmit="saveProfile()">
					<div class="edit-block">
						<div>
							<div class="change" id="change">
								<div class="foto image image-200px image-circle" id="place-picture" style="background-image: url({{ asset('/profile/photos/'.$p->foto) }});"></div>
								<input type="file" name="change-picture" id="change-picture" onchange="loadFoto()">
								<label for="change-picture">
									<div class="btn btn-main3-color" id="btn-save-foto">
										<span class="fas fa-lg fa-camera"></span>
									</div>
								</label>
							</div>
						</div>
						<div class="place-edit">
							<div class="pe-1">
								<span class="fa fa-lg fa-user"></span>
							</div>
							<div class="pe-2">
								<input type="text" name="edit-name" class="txt txt-primary-color" id="edit-name" required="true" value="{{ $p->name }}">
							</div>
						</div>
						<div class="place-edit">
							<div class="pe-1">
								<span class="fa fa-lg fa-envelope"></span>
							</div>
							<div class="pe-2">
								<input type="text" name="edit-email" class="txt txt-primary-color" id="edit-email" required="true" value="{{ $p->email }}">
							</div>
						</div>
						<div class="place-edit">
							<div class="pe-1">
								<span class="fa fa-lg fa-info"></span>
							</div>
							<div class="pe-2">
								<textarea class="txt edit-text txt-primary-color" id="edit-about" contenteditable="true" required="true">{{ $p->about }}</textarea>
							</div>
						</div>
						<div class="place-edit">
							<div class="pe-1">
								<span class="fa fa-lg fa-link"></span>
							</div>
							<div class="pe-2">
								<input type="text" name="edit-website" class="txt txt-primary-color" id="edit-website" value="{{ $p->website }}">
							</div>
						</div>
						<div class="place-edit">
							<div class="pe-2 pe-btn">
								<input type="button" name="edit-save" class="btn btn-primary-color" value="Cancel" onclick="goBack()">
								<input type="submit" name="edit-save" class="btn btn-main-color" value="Save Edit">
							</div>
						</div>
					</div>
				</form>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
