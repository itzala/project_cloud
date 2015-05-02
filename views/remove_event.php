<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/objects/Event.php");

session_start();
isLogged();

ob_start();
generate_head("Edit event");

$event = removeEvent(intval($_GET['e']));

?>

<section>
	<p>
    	This event is removed ! Thanks :p
	</p>
</section>
<hr /><a href="./" class="btn btn-info">Back to index</a>

<?php

generate_footer();

ob_end_flush();