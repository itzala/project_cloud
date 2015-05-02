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

// Function which verify data in the form before create a new user
function registration($lname, $fname, $uname, $pas, $pas2 ,$email){

    $lastname = testInput($lname);
    $firstname = testInput($fname);
    $username = testInput($uname);
    $pass = testInput($pas);
    $pass2 = testInput($pas2);
    $mail = testInput($email);

    // Last name verification 
    if(empty($lastname)){
        $errors[] = 'Last name is empty';
    }else if(strlen($lastname) < 3){
        $errors[] = 'Last name is too short';
    }else if(strlen($lastname) > 32){
        $errors[] = 'Last name is too long';
    }else if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
        $errors[] = "Last name: only letters and white space allowed";
    }

    // First name verification
    if(empty($firstname)) {
        $errors[] = 'First name is empty'; 
    }else if(strlen($firstname) < 3){
        $errors[] = 'First name is too short';
    }else if(strlen($firstname) > 32){
        $errors[] = 'First name is too long';
    }else if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
        $errors[] = "First name: only letters and white space allowed";
    }
    // Username verification
    if(empty($username)) {
        $errors[] = 'Username is empty';
    }else if(strlen($username) < 3){
        $errors[] = 'Username is too short';
    }else if(strlen($username) > 32){
        $errors[] = 'Username is too long';
    }else if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
        $errors[] = "Only letters and white space allowed";
    }
    if (isValidUsername($username)){
        $errors[] = 'Username is already used';
    }

    // Pass verification
    if(empty($pass) || empty($pass2)){
        $errors[] = 'pass is empty';
    } else if ($pass != $pass2){
        $errors[] = 'Invalid password';
    }

    // Mail verification
    if(empty($mail)) {
        $errors[] = 'mail is empty';
    } else if (!isMailValid($mail)){
        $errors[] = 'Invalid mail';
    }

    if (count($errors) > 0) {
        return $errors;        
    }
}

function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function newUser($lname, $fname, $uname, $pas, $email){
    $lastname = testInput($lname);
    $firstname = testInput($fname);
    $username = testInput($uname);
    $pass = encryptPassword($pas);
    $mail = testInput($email);
    $user = new User($lastname, $firstname, $username, $pass, $mail);
    global $users;
    $users[] = $username;
    //echo $user->getAll();
    echo $users->getAllUsers;
}


function connectDB(){
     if ( ! class_exists('Mongo')) {
        echo "<h1>Mongo's driver is not installed on this server :(</h1>";
    } else {
        try {
            // $uri = SERVER;
            // $options = array("connectTimeoutMS" => 30000, "replicaSet" => "replicaSetName");

            // // Open the connexion (localhost by default)
            // $client = new MongoClient($uri, $options);

            $options = array(
                "db" => DBNAME,
                "username" => USERNAME,
                "password" => USERPASS,
                "connectTimeoutMS" => 30000,
                //"replicaSet" => "replicaSetName"
                );

            $client = new MongoClient(SERVER, $options);

            // Database's selection
            $db = $client->selectDB(DBNAME);

            // Collection's selection "Users"
            $c_users = new MongoCollection($db, "Users");

            // Get all users
            $get_users = $c_users->find();

            // Get the number of users
            $count_users = $c_users->count();

            echo "<h1>Count users : ".$count_users."</h1";
            // Close the connexion
            $client->close();

        } catch (MongoConnectionException $exception) {
            echo "<h1>Connexion impossible to the server MongoDB :( Because '".$exception->getMessage()."'</h1>";
        }
    }
}

?>
