<?php
require($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");
ob_start();

generate_head("Register me");

?>

<nav>
	<a href="./login.php" class="btn btn-primary">Log in</a>
	<a href="./" class="btn btn-info">Back to index</a>
</nav>


<?php
generate_footer();
ob_end_flush();