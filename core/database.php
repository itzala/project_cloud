<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php");

/*
*		USER PART
*/

function getAllUsers()
{
    global $users;
    return $users;

    $bdd->query('SELECT username FROM USER');
}

function isRegistered($username, $password){
    global $users;    
    if (isset($users[$username]) && $users[$username]->getPassword() == $password)
        return $users[$username];
    return NULL;

    /* Faut peut être encrypter le pass pour la vérif, je sais pas comment il arrive dans la fonction
    $req = $bdd->prepare('SELECT username, password FROM USER 
    WHERE username = :uname AND password <= :pass');

    $req->execute(array('uname' => $username, 'pass' => $password));
    */
}


function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function loadUsersInSession()
{
    if (!isset($_SESSION['bd_users']))
    {
        global $users;
        $_SESSION['bd_users'] = $users;
    }

    /*Du coup on a plus besoin de cette fonction ?*/
}

function newUser($lname, $fname, $uname, $pas, $email){
    $lastname = testInput($lname);
    $firstname = testInput($fname);
    $username = testInput($uname);
    $pass = encryptPassword($pas);
    $mail = testInput($email);
    $user = new User($lastname, $firstname, $username, $pass, $mail);

    if ($local_db)
    {

    }
    global $users;
    $users[] = $username;


    echo $users->getAllUsers;
}



/*
*		EVENT PART
*/

function loadEventsInSession()
{
    if (!isset($_SESSION['events']))
    {
        global $events;
        $_SESSION['events'] = $events;
    }

    /*Du coup on a plus besoin de cette fonction ?*/
}

function addEvent($datas)
{
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

    if ($local_db)
    {
    	loadEventsInSession();
        $new_event->setId(count($_SESSION['events'])+1);
    	$_SESSION['events'][$new_event->getId()] = $new_event;
    }
    else
    {
    	$bdd->prepare("INSERT INTO EVENT (:name,:owner,:guests,:date_created,:date_event,:description)");
    	$bdd->execute(array(":name" => $event->getName(),
    					":owner" => $event->getOwner()->getId(),
    					":guests" => serialize($guests),
    					":date_created" => $event->getDateCreated(),
    					":date_event" => $event->getDateEvent(),
    					":description" => $event->getDescription() ));
    }



    return $new_event;
}

function getAllEvents($filters = array())
{
    $events = getEventsSession();

    // $lists = array();

    // foreach ($events as $event) {

    // }

    return $events;

    /*
        $bdd->query('SELECT * FROM EVENT');
    */
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

    /* En fait j'ai rien compris à ce que tu voulais ici
        $events = $all_events->fetch();
    */
}

function getEventById($id)
{
    return isset($_SESSION['events'][$id]) ? $_SESSION['events'][$id] : null;

    
        $req = $bdd->prepare('SELECT * FROM EVENT WHERE id = :id');

        $req->execute(array('id' => $id));    
}

function removeEvent($id)
{    
    $id = intval($id);
    if (isset($_SESSION['events'][$id]))
        unset($_SESSION['events'][$id]);
}

function removeAllEvents()
{
    $_SESSION['events'] = array();
}


function updateEvent($event, $datas)
{
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

    $_SESSION['events'][$event->getId()] = $event;

    return $event;
}
