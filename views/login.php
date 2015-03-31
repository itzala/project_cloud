<?php
require($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");
ob_start();

generate_head("Login");

?>
    	<section>
    		<div>
    			<form>
    				<div class="form-group">
	    				<label for="username">Username : </label>
	    				<input type="text" id="username" name="username"/>
    				</div>
    				<div class="form-group">
	    				<label for="password">Password : </label>
	    				<input type="password" id="password" name="password"/>
    				</div>
    				<input type="submit" class="btn btn-default" value="Log in"/>
                    <a href="./register.php" class="btn btn-default">Register</a>
    			</form>
    		</div>
    	</section>
        <a href="./" class="btn btn-info">Back to index</a>
<?php
generate_footer();
ob_end_flush();