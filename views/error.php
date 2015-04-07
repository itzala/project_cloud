<?php
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");
ob_start();

generate_head("ERROR");
?>

<div class="col-lg-6 col-lg-offset-3">
	<h1>ERROR</h1><hr />
	<nav>
		<a href="./" class="btn btn-info">Back to index</a>
	</nav>
</div>

<?php
generate_footer();
ob_end_flush();