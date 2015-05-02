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
		$erreurs = registration();
		$nbErr = count($erreurs);
	}

	// Displays errors
	if ($nbErr > 0) {
		echo 'This following errors were detected:';
		foreach ($erreurs as $key => $value) {
			echo '<br>', $value;
		}
	// Insert into the database and redirect to login.php
	}else{
		newUser();
		//header("Location:./views/login.php");
	}
?>

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<h1>Registration</h1><hr />
			<form role="form" id="form_registration" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="form-group">              
					<div class="form-group">
					   	<label class="control-label" for="lastname" name=>Last name</label>
						<input class="form-control" type="text" placeholder="My last name" id="lastname" autofocus/>
					</div>
					<div class="form-group">
						<label class="control-label" for="firstname">First name</label>
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
						<input class="form-control" type="text" placeholder="My e-mail" id="mail"/>
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
// define variables and set to empty values
$lastname = $firstname = $username = $pass = $pass2 = $mail = "";
$errors = array();

// Function which verify data in the form before create a new user
function registration(){
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$lastname = testInput($_POST["lastname"]);
		$firstname = testInput($_POST["firstname"]);
		$username = testInput($_POST["username"]);
		$pass = testInput($_POST["pass"]);
 		$pass2 = testInput($_POST["pass2"]);
	  	$mail = testInput($_POST["mail"]);
	}

	// Last name verification 
	if(empty($lastname)) $erreurs[] = 'Last name is empty';
    else if(strlen($lastname) < 3) $erreurs[] = 'Last name is too short';
    else if(strlen($lastname) > 32) $erreurs[] = 'Last name is too long';

	// First name verification
	if(empty($firstname)) $erreurs[] = 'First name is empty';
    else if(strlen($firstname) < 3) $erreurs[] = 'First name is too short';
    else if(strlen($firstname) > 32) $erreurs[] = 'First name is too long';

	// Username verification
	if(empty($username)) $erreurs[] = 'Username is empty';
    else if(strlen($username) < 3) $erreurs[] = 'Username is too short';
    else if(strlen($username) > 32) $erreurs[] = 'Username is too long';
	if (isValidUsername($username)){
		$erreurs[] = 'Username already used';
	}

	// Pass verification
	if(empty($pass) || empty($pass2)) $erreurs[] = 'pass is empty';
	if ($pass != $pass2){
		$erreurs[] = 'Invalid password';
	}

	// Mail verification
	if(empty($mail)) $erreurs[] = 'mail is empty';
	if (isMailValid($mail)){
		$erreurs[] = 'Invalid mail';
	}

	if (count($erreurs) > 0) {
		return $erreurs;		
	}
}

function testInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function newUser(){
	$lastname = testInput($_POST["lastname"]);
	$firstname = testInput($_POST["firstname"]);
	$username = testInput($_POST["username"]);
	$pass = encryptPassword(testInput($_POST["pass"]));
  	$mail = testInput($_POST["mail"]);
	$admin = new User($lastname, $firstname, $username, $pass, $mail);
	echo $admin->getId();
}

generate_footer();
ob_end_flush();