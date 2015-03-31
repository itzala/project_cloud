<?php

function generate_head($page_title)
{
	echo "<!DOCTYPE html>
<html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\" />
        <title>Calendar - ".$page_title."</title>
            <link rel=\"stylesheet\" href=\"../css/bootstrap.css\" />
    </head>
    <body>";
}

function generate_footer()
{
	echo "</body>
</html>";
}

?>