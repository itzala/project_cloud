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

<?php
	// First arrival
	if (!isset($_POST['register'])) {
		$nbErr = 0;
	// After submit form
	} else {
		$erreurs = registration($_POST['lastname'], $_POST['firstname'], $_POST['username'], $_POST['pass'], $_POST['pass2'], $_POST['mail']);
		$nbErr = count($erreurs);
		// Displays errors
		if ($nbErr > 0) {
			echo '<br>This following errors were detected:';
			foreach ($erreurs as $key => $value) {
				echo '<br>', $value;
			}
		// Insert into the database and redirect to login.php
		}else{
			newUser($_POST['lastname'], $_POST['firstname'], $_POST['username'], $_POST['pass'], $_POST['mail']);
			echo "Success !";
			//header("Location:./views/login.php");
		}
	}
?>

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<h1>Registration</h1><hr />
			<form role="form" id="form_registration" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="form-group">              
					<div class="form-group">
					   	<label class="control-label" for="lastname" name=>Last name</label>
						<input class="form-control" type="text" placeholder="My last name" name="lastname" autofocus/>
					</div>
					<div class="form-group">
						<label class="control-label" for="firstname">First name</label>
						<input class="form-control" type="text" placeholder="My first name" name="firstname"/>
					</div>
					<div class="form-group">
						<label class="control-label" for="username">Username</label>
						<input class="form-control" type="text" placeholder="My username" name="username"/>
					</div>
					<div class="form-group">
						<label class="control-label" for="pass">Password</label>
						<input class="form-control" type="password" placeholder="My password" name="pass"/>
					</div>
					<div class="form-group">
						<label class="control-label" for="pass2">Retype password</label>
						<input class="form-control" type="password" placeholder="My password" name="pass2"/>
					</div>
					<div class="form-group">
						<label class="control-label" for="mail">E-mail</label>
						<input class="form-control" type="text" placeholder="My e-mail" name="mail"/>
					</div>
				</div>
				<hr />
				<div class="form-group">
					<input type="submit" class="btn btn-primary" name="register" value="Register"></input>
				</div>
			</form>
		</div>
	</div>

<?php
generate_footer();
ob_end_flush();