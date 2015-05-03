<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php"))
{
    echo "Configuration missing";
    die();
}
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php");
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/database.php");

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


function getLoggedUser()
{    
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}


/*
*   Control events
*/

function getEventsSession()
{
    return isset($_SESSION['events']) ? $_SESSION['events'] : array();
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

?>
