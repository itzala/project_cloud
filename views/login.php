<?php
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

session_start();

$user = NULL;
if (isset($_POST) && !empty($_POST))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (($user = isRegistered($username, $password)) != NULL)
    {
        $_SESSION['user'] = $user;
        header("Location:./index.php");
    }
    else
    {
        echo "ERROR : You are not allowed. Bad credentials.";        
    }
}

ob_start();

generate_head("Login");

?>
	<section>
		<div class="col-lg-6 col-lg-offset-3">
            <h1>Login</h1><hr />
			<form class="form-horizontal" role="form" method="POST" action="./login.php">
				<div class="form-group">
                    <div class="col-sm-2">
    				   <label class="control-label" for="username">Username: </label>
                    </div>
                    <div class="col-sm-3">
    				   <input class="form-control input-small" type="text" id="username" name="username" 
                       value="<?php if (isset($_POST['username'])) echo $_POST['username'];?>" />
                    </div>
				</div>
				<div class="form-group">
                    <div class="col-sm-2">
    				   <label class="control-label" for="password">Password: </label>
                    </div>
                    <div class="col-sm-3">
    				   <input class="form-control input-small" type="password" id="password" name="password"
                       value="<?php if (isset($_POST['password'])) echo $_POST['password'];?>" />
                    </div>
				</div>
				<input type="submit" class="btn btn-default" value="Log in"/>
                <a href="./register.php" class="btn btn-default">Register</a>
			</form>
            <hr /><a href="./" class="btn btn-info">Back to index</a>
		</div>
	</section>     
<?php
generate_footer();
ob_end_flush();