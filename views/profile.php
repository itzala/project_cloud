<?php
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");
ob_start();

 generate_head("Register me");

?>
<nav>
	<a href="./" class="btn btn-info">Back to index</a>
</nav>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
		Profile edit
	</button>
	<div class="row">
		<div class="col-xs-1 col-sm-2 col-md-2 col-lg-6 col-lg-offset-3">
			<h1>Profile</h1><hr />
			<div class="form-group" id="">              
				<div class="form-group">
				   	<label class="control-label" for="lastname">Last name</label>
					<input class="form-control validate[optional,custom[noSpecialCaracters],length[0,20]]" type="text" placeholder="My last name" id="lastname"/>
				</div>
				<div class="form-group">
					<label class="control-label" for="firstlastname">First name</label>
					<input class="form-control" type="text" placeholder="My first name" id="firstlastname"/>
				</div>
				<div class="form-group">
					<label class="control-label" for="username">Username</label>
					<input class="form-control" type="text" placeholder="My username" id="username"/>
				</div>
				<div class="form-group">
					<label class="control-label" for="mail">E-mail</label>
					<input class="form-control" type="email" placeholder="My e-mail" id="mail"/>
				</div>
			</div>
		</div>
	</div>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-profil-edit" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="modal-profil-edit">Profile edit</h4>
						<div class="modal-body">
							<div class="row">
								<div class="col-xs-1 col-sm-2 col-md-2 col-lg-6 col-lg-offset-3">
									<form role="form" id="form_profile">
										<div class="form-group" id="">             
											<div class="form-group">
												<label class="control-label" for="pass">New password</label>
												<input class="form-control" type="password" placeholder="My password" id="pass"/>
											</div>
											<div class="form-group">
												<label class="control-label" for="pass2">Retype password</label>
												<input class="form-control" type="password" placeholder="My password" id="pass2"/>
											</div>
											<div class="form-group">
												<label class="control-label" for="mail">New e-mail</label>
												<input class="form-control" type="email" placeholder="My e-mail" id="mail"/>
											</div>
										</div>					
										<hr /><div class="form-group">
										<button type="submit" class="btn btn-primary">Save changes</button>
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