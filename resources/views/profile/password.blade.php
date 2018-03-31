@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<div class="sc-header">
	<div class="sc-place pos-fix">
		<div class="col-full">
			<div class="sc-grid sc-grid-3x">
				<div class="sc-col-1"></div>
				<div class="sc-col-2">
					<h3 class="ttl-head ttl-sekunder-color">Change Password</h3>
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
				<form id="form-edit-profile" method="post" action="javascript:void(0)">
					<div class="edit-block">
						<div class="place-edit">
							<div class="pe-1">
								<span class="fas fa-lg fa-key"></span>
							</div>
							<div class="pe-2">
								<input type="text" name="old-password" class="txt txt-primary-color" id="old-password" required="true" placeholder="Old Password">
							</div>
						</div>
						<br>
						<div class="place-edit">
							<div class="pe-1">
								<span class="fas fa-lg fa-key"></span>
							</div>
							<div class="pe-2">
								<input type="text" name="new-password" class="txt txt-primary-color" id="new-password" required="true" placeholder="New Password">
							</div>
						</div>
						<div class="place-edit">
							<div class="pe-1">
								<span class="fas fa-lg fa-key"></span>
							</div>
							<div class="pe-2">
								<input type="text" name="renew-password" class="txt txt-primary-color" id="renew-password" placeholder="Re-type New Password">
							</div>
						</div>
						<div class="place-edit">
							<div class="pe-2 pe-btn">
								<input type="button" name="edit-save" class="btn btn-primary-color" value="Cancel" onclick="goBack()">
								<input type="submit" name="edit-save" class="btn btn-main-color" value="Save">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection