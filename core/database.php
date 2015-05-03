<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php"))
{
    echo "Configuration missing";
    die();
}
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php");
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");
/*
*		USER PART
*/

function getAllUsers()
{
    global $is_local_db;
    if ($is_local_db)
    {
        global $users;
        return $users;
    }
    else
    {
        global $bdd;       
        
        $req = $bdd->query("SELECT * FROM USER");
        $req->setFetchMode(FETCH_MODE, 'User', array("lastname", "firstname", "username", "password", "mail"));
        $datas = $req->fetchAll();
        $req->closeCursor();
        return $datas;
    }

}

function loadUsersInSession()
{
    if (!isset($_SESSION['bd_users']))
    {        
        $_SESSION['bd_users'] = getAllUsers();
    }    
}


function newUser($lname, $fname, $uname, $pas, $email){
    global $is_local_db;

    $lastname = testInput($lname);
    $firstname = testInput($fname);
    $username = testInput($uname);
    $pass = encryptPassword($pas);
    $mail = testInput($email);
    if ($is_local_db)
    {
        $new_user = new User($lastname, $firstname, $username, $pass, $mail);
        loadUsersInSession();
        $_SESSION['bd_users'] = $new_user;
    }
    else
    {
        global $bdd;
        $req = $bdd->prepare('INSERT INTO USER (lastname, firstname, username, password, mail)
                             VALUES (:lastname, :firstname, :username, :pass, :mail)');

        $req->execute(array('lastname' => $lastname, 
                            'firstname' => $firstname,
                            'username' => $username,
                            'pass' => $pass,
                            'mail' => $mail));
        $req->closeCursor();
    }    

}

/*
*		EVENT PART
*/

function isRegistered($username, $password)
{
    global $is_local_db;
    $password = encryptPassword($password);
    if ($is_local_db)
    {
        if (isset($users[$username]) && $users[$username]->getPassword() == $password)
            return $users[$username];
        return NULL;
    }
    else
    {
        global $bdd;        
        $req = $bdd->prepare("SELECT * FROM USER 
            WHERE username = :uname AND password = :pass");
        $req->setFetchMode(FETCH_MODE, 'User', array("lastname", "firstname", "username", "password", "mail"));
        $req->execute(array('uname' => $username, 'pass' => $password));
        $user = $req->fetch();
        $req->closeCursor();

        return ($user != false) ? $user : NULL;
    }
}


function getAllEvents($filters = array())
{
    global $is_local_db;

    if ($is_local_db)
    {
        $events = getEventsSession();
    }
    else
    {
        global $bdd;
        $req = $bdd->query('SELECT * FROM EVENT NATURAL JOIN USER');
        $req->setFetchMode(FETCH_MODE, 'Event', array("name", "owner", "date_event", "description", "guests"));
        $datas = $req->fetchAll();
        $req->closeCursor();
        foreach ($datas as $event) {
            
        }
        return $datas;
    }

    return $events;    
}


function loadEventsInSession()
{
    if (!isset($_SESSION['events']))
    {        
        $_SESSION['events'] = getAllEvents();
    }
}

function getEventsSession()
{
    return isset($_SESSION['events']) ? $_SESSION['events'] : array();
}

function addEvent($datas)
{
    global $is_local_db;
    $users = getAllUsers();    
    $guests = array();
    if (isset($datas['event_guests']))
    {
        foreach ($datas['event_guests'] as $username) {
            $guests[] = $users[$username];
        }
    }

    $new_event = new Event($datas['event_name'], getLoggedUser(), $datas['event_date'],
                        $datas['event_description'], $guests);

    if ($is_local_db)
    {
    	loadEventsInSession();
        $new_event->setId(count($_SESSION['events'])+1);
    	$_SESSION['events'][$new_event->getId()] = $new_event;
    }
    else
    {
        global $bdd;
    	$req = $bdd->prepare("INSERT INTO EVENT (name, owner, guests, date_created, date_event, description) 
                        VALUES (:name,:owner,:guests,:date_created,:date_event,:description)");
    	$req->execute(array(":name" => $new_event->getName(),
    					":owner" => $new_event->getOwner()->getId(),
    					":guests" => serialize($guests),
    					":date_created" => $new_event->getDateCreated(),
    					":date_event" => $new_event->getDateEvent(),
    					":description" => $new_event->getDescription()));
        $req->closeCursor();
    }



    return $new_event;
}

function getUserById($id)
{
    global $is_local_db;
    if ($is_local_db)
    {        
        return isset($users[$id]) ? $users[$id] : NULL;
    }
    else
    {
        global $bdd;       
        
        $req = $bdd->prepare("SELECT * FROM USER WHERE id = :id");
        $req->setFetchMode(FETCH_MODE, 'User', array("lastname", "firstname", "username", "password", "mail"));
        $req->execute(array(":id" => $id));
        $datas = $req->fetch();
        $req->closeCursor();
        return $datas;
    }
}

function getEventById($id)
{
    global $is_local_db;
    if ($is_local_db)
        return isset($_SESSION['events'][$id]) ? $_SESSION['events'][$id] : null;
    else
    {
        global $bdd;
        $req = $bdd->prepare('SELECT * FROM EVENT WHERE id = :id');
        $req->setFetchMode(FETCH_MODE, 'Event', array("name", "owner", "date_event", "description", "guests"));
        $req->execute(array('id' => $id));
        $event = $req->fetch();
        $event = getUserById($event->getOwner());
        //$event->setDateCreated();
        $req->closeCursor();
        return $event;
    }   
}

function removeEvent($id)
{
    global $is_local_db;
    $id = intval($id);
    if ($is_local_db)
    {
        if (isset($_SESSION['events'][$id]))
            unset($_SESSION['events'][$id]);
    }
    else
    {
        global $bdd;
        $req = $bdd->prepare('DELETE FROM EVENT WHERE id = :id');
        $req->execute('id', $id);
        $req->closeCursor();
    }
}

function removeAllEvents()
{
    global $is_local_db;
    if ($is_local_db)
        $_SESSION['events'] = array();
}

function updateEvent($event, $datas)
{
    global $is_local_db;

    $users = getAllUsers();

    $event->setName($datas['name_event']);
    $event->setDateEvent($datas['date_event']);
    $event->setDescription($datas['event_description']);
    if (isset($datas['event_guests']))
    {
        foreach ($datas['event_guests'] as $username) {
            $guests[] = $users[$username];
        }
    }
    $event->setGuests($guests);
    if ($is_local_db)
        $_SESSION['events'][$event->getId()] = $event;
    else
    {
        $req = $bdd->prepare('UPDATE EVENT 
            SET name = :name, date_event = :date_event, guests = :guests, description = :description
            WHERE id = :id');

        $req->execute(array('id' => $event->getId(), 'name' => $datas['name_event'], 
                            'date_event' => $datas['date_event'], 
                            'guests' => $guests,
                            'description' => $datas['event_description']));
        
    }

    return $event;
}

function getDisplayedEvents()
{
    global $is_local_db;

    $owner = getLoggedUser();
    $ref_date = getReferenceDate();
    $end_ref_date = clone $ref_date;
    $end_ref_date->modify("+7 days");

    $displayed_events = array();
    $count_events = 0;
    if ($is_local_db)    
        $all_events = getAllEvents();
    else
    {
        // if owner is logged !
        if (!is_null($owner))
        {
            global $bdd;
            $req = $bdd->prepare("SELECT * FROM EVENT WHERE owner = :id AND date_event BETWEEN :ref_date AND :end_ref_date");
            $req->execute(array('id' => $owner->getId(), 
                'ref_date' => getFormattedDate($ref_date),
                'end_ref_date' => getFormattedDate($end_ref_date)));

            $req->setFetchMode(FETCH_MODE, 'Event', array("name", "owner", "date_event", "description", "guests"));
            $all_events = $req->fetchAll();
            echo "<pre>";
            var_dump($all_events);
            echo "</pre>";
            $req->closeCursor();
        }
        else
            $all_events = array();
    }

    foreach ($all_events as $event) {
        $date_event = $event->getDateEvent();

        // We need sort events by date and time
        // The second part of the condition is already done if the database is not local
        if (!$is_local_db || ($event->getOwner() == $owner && isInPeriod($date_event, $ref_date, $end_ref_date)))
        {            
            $displayed_events[$date_event->format("d/m")][$date_event->format("H:i")][] = $event;
            $count_events++;
        }
    }

    $displayed_events['count'] = $count_events;

    return $displayed_events;

}