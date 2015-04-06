<?php
require($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

ob_start();

generate_head("Create an event");

?>

	<nav>
		<a href="./" class="btn btn-primary">Back to index</a>
	</nav>

	<form>
		<input type="submit" value="Create" class="btn btn-success"/>
	</form>


<?php
generate_footer();
ob_end_flush();