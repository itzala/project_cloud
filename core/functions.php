<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php");

/*
*  Structural view functions
*/

function generate_head($page_title, $js = NULL, $css = NULL)
{
	echo "<!DOCTYPE html>
<html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\" />
        <title>Calendar - ".$page_title."</title>
            <link rel=\"stylesheet\" href=\"../css/bootstrap.css\" />\n";

    if (!is_null($css))
    {
        foreach ($css as $style) {
            $script = str_replace("css/", "", $style);
            echo '<link rel=\"stylesheet\" href=\"../css/' .$style. '.css"/>'."\n";
        }
    }
    
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
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

function getAllUsers()
{
    global $users;
    return $users;
}

/*
*   Control events
*/

function getEventsSession()
{
    return isset($_SESSION['events']) ? $_SESSION['events'] : array();
}


function getAllEvents($filters = array())
{
    $events = getEventsSession();

    // $lists = array();

    // foreach ($events as $event) {

    // }

    return $events;
}

function getDisplayedEvents()
{    
    $owner = getLoggedUser();
    $ref_date = getReferenceDate();
    $end_ref_date = clone $ref_date;
    $end_ref_date->modify("+7 days");
    $all_events = getAllEvents();

    $displayed_events = array();
    $count_events = 0;

    foreach ($all_events as $event) {
        $date_event = $event->getDateEvent();        
        if ($event->getOwner() == $owner && isInPeriod($date_event, $ref_date, $end_ref_date))
        {
            $displayed_events[$date_event->format("d/m")][$date_event->format("H:i")][] = $event;
            $count_events++;
        }
    }

    $displayed_events['count'] = $count_events;

    return $displayed_events;
}

function getEventById($id)
{
    return isset($_SESSION['events'][$id]) ? $_SESSION['events'][$id] : null;
}

function loadEventsInSession()
{
    if (!isset($_SESSION['events']))
    {
        global $events;
        $_SESSION['events'] = $events;
    }
}

function addEvent($datas)
{
    $users = getAllUsers();
    loadEventsInSession();
    $guests = array();
    if (isset($datas['event_guests']))
    {
        foreach ($datas['event_guests'] as $username) {
            $guests[] = $users[$username];
        }
    }

    $new_event = new Event($datas['event_name'], getLoggedUser(), $datas['event_date'],
                        $datas['event_description'], $guests);

    $new_event->setId(count($_SESSION['events'])+1);
    $_SESSION['events'][$new_event->getId()] = $new_event;

    /*
    * $bd->persist($new_event);
    */

    return $new_event;
}

function removeEvent($event)
{    
    if (isset($_SESSION['events'][$event->getId()]))
        unset($_SESSION['events'][$event->getId()]);
}

function removeAllEvents()
{
    $_SESSION['events'] = array();
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
