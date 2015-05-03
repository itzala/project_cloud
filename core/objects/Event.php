<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/verif.php");
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/objects/User.php");

/**
* 
*/
class Event
{	
	private $id;
	private $name;
	private $owner;
	private $guests;
	private $date_created;
	private $date_event;
	private $description;

	function __construct($name, $owner, $date_event, $description = "", $guests = array())
	{
		echo "<pre>";
		var_dump($owner);
		echo "</pre>";
		$this->id = NULL;
		$this->name = $name;
		$this->owner = $owner;
		$this->guests = $guests;
		if (!is_a($date_event, "DateTime"))
			$date_event = DateTime::createFromFormat(DATE_FORMAT, $date_event);
		$this->date_event = $date_event;
		$this->description = $description;		
		$this->date_created = new DateTime();
	}

	/*
	*	Getters
	*/

	function getId()
	{
		return $this->id;
	}

	function getName()
	{
		return $this->name;
	}

	function getOwner()
	{
		return $this->owner;
	}

	function getGuests()
	{
		return $this->guests;
	}

	function getDateCreated()
	{
		return $this->date_created;
	}

	function getDateEvent()
	{
		return $this->date_event;
	}

	function getDescription()
	{
		return $this->description;
	}

	/*
	*	Setters
	*/

	function setId($id)
	{
		$this->id = $id;
	}

	function setName($name)
	{
		$this->name = $name;
	}

	function setOwner(User $owner)
	{
		$this->owner = $owner;
	}

	function setGuests($guests)
	{
		$this->guests = $guests;
	}

	function addGuest($guest)
	{
		$this->guests[] = $guest;
	}

	function removeGuest($guest)
	{
		$index = array_search($guest, $this->guests);
		if ($index !== false)
			unset($this->guests[$index]);
	}

	function setDateEvent($date_event)
	{
		$this->date_event = $date_event;
	}

	function setDescription($description)
	{
		$this->description = $description;
	}

	function isValid()
	{
		isEmpty($this->name);
		isEmpty($this->date_created);
		isEmpty($this->date_event);
		isEmpty($this->description);		

		return true;
	}
}