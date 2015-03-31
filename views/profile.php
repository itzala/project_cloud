<?php
require("../core/functions.php");
ob_start();

generate_head("My profile");

?>        
<?php
generate_footer();
ob_end_flush();