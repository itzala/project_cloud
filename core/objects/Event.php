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

	function __construct($name, $owner, $date_event, $date_created, $description = "", $guests = array())
	{		
		$this->id = NULL;
		$this->name = $name;
		$this->owner = $owner;
		$this->guests = $guests;
		$this->setDateEvent($date_event);
		$this->description = $description;
		$this->setDateCreated($date_created);		
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
		if (is_string($this->guests))
			$this->guests = unserialize($this->guests);
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
		if (is_string($guests))
			$guests = unserialize($guests);
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
		if (is_string($date_event) && $date_event != "date_event")
		{
			$mask = (strpos($date_event, SEPARATOR_DATE) !== false) ? DATE_FORMAT : DATE_FORMAT_SQL;
			$date = DateTime::createFromFormat($mask, $date_event);
			if (!$date)
				$this->date_event = new DateTime();
			else				
				$this->date_event = $date;
		}
		else if (is_a($date_event, 'DateTime'))
			$this->date_event = $date_event;
		else
			$this->date_event = new DateTime();
	}

	function setDateCreated($date_created)
	{		
		if (is_string($date_created) && $date_created != "date_created")
		{
			$mask = (strpos($date_created, SEPARATOR_DATE) !== false) ? DATE_FORMAT : DATE_FORMAT_SQL;
			$date = DateTime::createFromFormat($mask, $date_created);
			if (!$date)
				$this->date_created = new DateTime();
			else				
				$this->date_created = $date;
		}
		else if (is_a($date_created, 'DateTime'))
			$this->date_created = $date_created;
		else
			$this->date_created = new DateTime();
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

	static function getArgsConstructor()
	{
		return array("name", "owner", "date_event", "date_created", "description", "guests");
	}
}