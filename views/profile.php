<?php
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

session_start();
isLogged();
ob_start();

generate_head("Profile");

$user = getLoggedUser();

?>

<nav>
	<a href="./" class="btn btn-info">Back to index</a>
</nav>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
		Edit Profile
	</button>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<h1>Profile</h1><hr />
			<div class="form-group" id="">              
				<div class="form-group">
				   	<label class="control-label" for="lastname">Last name</label>
					<input class="form-control" readonly type="text" placeholder="My last name" id="lastname"
					value="<?php echo $user->getLastName();?>"/>
				</div>
				<div class="form-group">
					<label class="control-label" for="firstlastname">First name</label>
					<input class="form-control" readonly type="text" placeholder="My first name" id="firstlastname"
					value="<?php echo $user->getFirstName();?>"/>
				</div>
				<div class="form-group">
					<label class="control-label" for="username">Username</label>
					<input class="form-control" readonly type="text" placeholder="My username" id="username"
					value="<?php echo $user->getUserName();?>"/>
				</div>
				<div class="form-group">
					<label class="control-label" for="mail">E-mail</label>
					<input class="form-control" readonly type="email" placeholder="My e-mail" id="mail"
					value="<?php echo $user->getMail();?>"/>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal part -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-profil-edit" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="modal-profil-edit">Edit profile</h4>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3">
									<form role="form" id="form_profile">
										<div class="form-group" id="">
											<div class="form-group">
												<label class="control-label" for="pass">Current password</label>
												<input class="form-control" type="password" placeholder="My password" id="pass" name="current_pass"/>
											</div>
											<div class="form-group">
												<label class="control-label" for="pass">New password</label>
												<input class="form-control" type="password" placeholder="My password" id="pass" name="new_pass"/>
											</div>
											<div class="form-group">
												<label class="control-label" for="pass2">Retype password</label>
												<input class="form-control" type="password" placeholder="My password" id="pass2" name="confirm_pass"/>
											</div>
											<div class="form-group">
												<label class="control-label" for="mail">New e-mail</label>
												<input class="form-control" type="email" placeholder="My e-mail" id="mail"/>
											</div>
										</div>					
										<hr /><div class="form-group">
										<input type="submit" class="btn btn-primary" value="Save changes"
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
generate_footer();
ob_end_flush();