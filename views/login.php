<?php
require("../core/functions.php");
ob_start();

generate_head("Login");

?>
    	<section>
    		<div class="col-xs-1 col-sm-2 col-md-2 col-lg-6 col-lg-offset-3">
                <h1>Login</h1><hr />
    			<form class="form-horizontal" role="form">
    				<div class="form-group">
	    				<label class="control-label" for="username">Username : </label>
                        <div class="col-sm-3">
	    				   <input class="form-control input-small" type="text" id="username" name="username"/>
                        </div>
    				</div>
    				<div class="form-group">
	    				<label class="control-label" for="password">Password : </label>
                        <div class="col-sm-3">
	    				   <input class="form-control input-small" type="password" id="password" name="password"/>
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