<?php

function generate_head($page_title, $js = NULL)
{
	echo "<!DOCTYPE html>
<html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\" />
        <title>Calendar - ".$page_title."</title>
            <link rel=\"stylesheet\" href=\"../css/bootstrap.css\" />";
    
    echo '<script type="text/javascript" src="../js/jquery.js"></script>'."\n";
    echo '<script type="text/javascript" src="../js/bootstrap.js"></script>'."\n";
    if (!is_null($js))
    {
    	foreach ($js as $script) {
    		$script = str_replace("js/", "", $script);
    		echo '<script type="text/javascript" src="../js/' .$script. '.js"></script>'."\n";
    	}
    }
    
    echo "</head>
    <body>";
}

function generate_footer()
{
	echo "</body>
</html>";
}

?>