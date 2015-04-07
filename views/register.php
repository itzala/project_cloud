<?php
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

session_start();
isLogged(false);
ob_start();

generate_head("Register me");
?>

<nav>
	<a href="./login.php" class="btn btn-primary">Log in</a>
	<a href="./" class="btn btn-info">Back to index</a>
</nav>

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
				<h1>Registration</h1><hr />
				<form role="form" id="form_registration">
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
							<label class="control-label" for="pass">Password</label>
							<input class="form-control" type="password" placeholder="My password" id="pass"/>
						</div>
						<div class="form-group">
							<label class="control-label" for="pass2">Retype password</label>
							<input class="form-control" type="password" placeholder="My password" id="pass2"/>
						</div>
						<div class="form-group">
							<label class="control-label" for="mail">E-mail</label>
							<input class="form-control" type="email" placeholder="My e-mail" id="mail"/>
						</div>
					</div>
					<hr /><div class="form-group">
					<button type="submit" class="btn btn-primary">Register</button>
				</form>
			</div>
		</div>

<?php
generate_footer();
ob_end_flush();