<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php");

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

function isLogged($reverse = true){
    if (!isset($_SESSION['user']) && $reverse){
        header("Location:../views/login.php");
    }else if(isset($_SESSION['user']) && !$reverse){
        header("Location:../views/error.php");
    }
}

function isRegistered($username, $password){
    global $users;
    if (isset($users[$username]) && $users[$username]->getPassword() == $password)
        return $users[$username];
    return NULL;
}

function getLoggedUser()
{
    return $_SESSION['user'];
}

function setReferenceDate($date = null)
{
    if ($date == null)
    {
        $date = new DateTime('last '.FIRST_DAY_WEEK);        
    }

    $_SESSION['ref_date'] = $date;
}

function getReferenceDate()
{
    if (!isset($_SESSION['ref_date']))
        setReferenceDate();    
    return clone $_SESSION['ref_date'];
}


function getFormattedDate($date = null)
{
    if ($date == null)
        $date = getReferenceDate();
    return is_object($date) ? $date->format(DATE_FORMAT) : $date;
}

function getDateEvent($offset_day, $time = "")
{    
    $offset_day = intval($offset_day);
    $items = explode(":", $time);
    $hour = intval($items[0]);
    $minutes = 0;
    if (count($items) == 2)
        $minutes = intval($items[1]);

    $date_event = getReferenceDate();    
    $date_event->modify("+" .$offset_day. "day");
    $date_event->setTime($hour, $minutes);
    return $date_event;
}

?>
