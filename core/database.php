<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php");

/*
*		EVENT PART
*/

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

/*
*		USER PART
*/

function getAllUsers()
{
    global $users;
    return $users;

    /*
        $bdd->query('SELECT username FROM USER');
    */
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