<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php");

/*
*  Structural view functions
*/

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

/*
*   Control user
*/


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

function getAllUsers()
{
    global $users;
    return $users;
}

/*
*   Control events
*/

function getAllEvents($filters = array())
{
    global $events;
    $list = $events;

    return $list;
}

function addEvent($datas)
{

    $guests = isset($datas['event_guests']) ? $datas['event_guests'] : array();

    $new_event = new Event($datas['event_name'], getLoggedUser(), $datas['event_date'],
                        $datas['event_description'], $guests);

    $new_event->setId(count($_SESSION['events'])+1);
    $_SESSION['events'][$new_event->getId()] = $new_event;

    /*
    * $bd->persist($new_event);
    */

    return $new_event;
}

function getEventsSession()
{
    return $_SESSION['events'];
}

function loadEventsInSession()
{
    if (!isset($_SESSION['events']))
    {
        global $events;
        $_SESSION['events'] = $events;
    }
}

function removeEvent($event)
{
    global $events;
    if (isset($_SESSION['events'][$event->getId()]))
        unset($_SESSION['events'][$event->getId()]);
}

function removeAllEvents()
{
    $_SESSION['events'] = array();
}

/*
*   Manage dates
*/

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

function connectDB(){
// Loading the library
require "predis/autoload.php";
Predis\Autoloader::register();

// Connect to redis
$redis = new Predis\Client(array(
    "scheme" => "tcp",
    "host" => DBNAME,
    "port" => PORT,
    "password" => USERPASS));
echo "Connected to Redis";
}

?>
