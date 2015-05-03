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
    global $bdd;
    
    $req = $bdd->query("SELECT * FROM USER");
    $req->setFetchMode(FETCH_MODE, 'User', User::getArgsConstructor());
    $datas = $req->fetchAll();
    $req->closeCursor();
    return $datas;
}


function newUser($lname, $fname, $uname, $pas, $email){
    $lastname = testInput($lname);
    $firstname = testInput($fname);
    $username = testInput($uname);
    $pass = encryptPassword($pas);
    $mail = testInput($email);
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

/*
*		EVENT PART
*/

function isRegistered($username, $password)
{    
    $password = encryptPassword($password);
    global $bdd;        
    $req = $bdd->prepare("SELECT * FROM USER 
        WHERE username = :uname AND password = :pass");
    $req->setFetchMode(FETCH_MODE, 'User', User::getArgsConstructor());
    $req->execute(array('uname' => $username, 'pass' => $password));
    $user = $req->fetch();
    $req->closeCursor();

    return ($user != false) ? $user : NULL;
}


function getAllEvents($filters = array())
{
    global $bdd;
    $req = $bdd->query('SELECT * FROM EVENT NATURAL JOIN USER');
    $req->setFetchMode(FETCH_MODE, 'Event', Event::getArgsConstructor());
    $datas = $req->fetchAll();    
    $req->closeCursor();
    foreach ($datas as $event) {
        
    }
    return $datas;
}

function addEvent($datas)
{
    global $bdd;
    
    $guests = (isset($datas['event_guests'])) ? $datas['event_guests'] : array();
    $new_event = new Event($datas['event_name'], getLoggedUser(), $datas['event_date'],
                      new DateTime(), $datas['event_description'], $guests);
    
	$req = $bdd->prepare("INSERT INTO EVENT (name, owner, guests, date_created, date_event, description) 
                    VALUES (:name,:owner,:guests,:date_created,:date_event,:description)");
	$req->execute(array(":name" => $new_event->getName(),
					":owner" => $new_event->getOwner()->getId(),
					":guests" => serialize($guests),
					":date_created" => $new_event->getDateCreated()->format(DATE_FORMAT_SQL),
					":date_event" => $new_event->getDateEvent()->format(DATE_FORMAT_SQL),
					":description" => $new_event->getDescription() ));
    $req->closeCursor();
    return $new_event;
}

function getUserById($id)
{
    global $bdd;
        
    $req = $bdd->prepare("SELECT * FROM USER WHERE id = :id");
    $req->setFetchMode(FETCH_MODE, 'User', User::getArgsConstructor());
    $req->execute(array(":id" => $id));
    $datas = $req->fetch();
    $req->closeCursor();
    return $datas;
}

function getEventById($id)
{
    global $bdd;
    $req = $bdd->prepare('SELECT * FROM EVENT WHERE id = :id');
    $req->setFetchMode(FETCH_MODE, 'Event', Event::getArgsConstructor());
    $req->execute(array('id' => $id));
    $event = $req->fetch();
    $event->setOWner(getUserById($event->getOwner()));
    $req->closeCursor();
    return $event;    
}

function removeEvent($id)
{
    $id = intval($id);
    global $bdd;
    $req = $bdd->prepare('DELETE FROM EVENT WHERE id = :id');
    $req->execute('id', $id);
    $req->closeCursor();
}

function updateEvent($event, $datas)
{
    global $bdd;

    $event->setName($datas['name_event']);
    $event->setDescription($datas['event_description']);
    $event->setDateEvent(DateTime::createFromFormat(DATE_FORMAT, $datas['date_event']));
    $guests = (isset($datas['event_guests'])) ? $datas['event_guests'] : array();
    $event->setGuests($guests);
    $req = $bdd->prepare('UPDATE EVENT 
            SET name = :name, date_event = :date_event, guests = :guests, description = :description
            WHERE id = :id');

    $req->execute(array(':id' => $event->getId(), ':name' => $event->getName(), 
                        ':date_event' => $event->getDateEvent()->format(DATE_FORMAT_SQL), 
                        ':guests' => serialize($guests),
                        ':description' => $event->getDescription()));

    return $event;
}

function getDisplayedEvents()
{
    $owner = getLoggedUser();
    $ref_date = getReferenceDate();
    $end_ref_date = clone $ref_date;
    $end_ref_date->modify("+7 days");

    $displayed_events = array();
    // if owner is logged !
    if (!is_null($owner))
    {        
        global $bdd;
        $req = $bdd->prepare("SELECT * FROM EVENT WHERE owner = :id AND date_event BETWEEN :ref_date AND :end_ref_date");
        $req->execute(array('id' => $owner->getId(), 
            'ref_date' => $ref_date->format(DATE_FORMAT_SQL),
            'end_ref_date' => $end_ref_date->format(DATE_FORMAT_SQL)));

        $req->setFetchMode(FETCH_MODE, 'Event', Event::getArgsConstructor());
        $all_events = $req->fetchAll();        
        $req->closeCursor();
    }
    else
        $all_events = array();    

   foreach ($all_events as $event) {
        $date_event = $event->getDateEvent();
        if (is_string($date_event))
            $date_event = DateTime::createFromFormat(DATE_FORMAT_SQL, $date_event);

        $displayed_events[$date_event->format("d/m")][$date_event->format("H:i")][] = $event;        
    }

    $displayed_events['count'] = count($all_events);

    return $displayed_events;
}