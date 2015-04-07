<?php

namespace core\objects;

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/verif.php");

/**
* 
*/
class User
{	
	private $id;
	private $lastname;
	private $firstname;
	private $username;
	private $mail;

	function __construct($lastname, $firstname, $username, $mail)
	{
		$this->id = NULL;
		$this->lastname = $lastname;
		$this->firstname = $firstname;
		$this->username = $username;
		$this->mail = $mail;
	}

	/*
	*	Getters
	*/

	function getId()
	{
		return $this->id;
	}

	function getLastname()
	{
		return $this->lastname;
	}

	function getFirstname()
	{
		return $this->firstname;
	}

	function getFullname()
	{
		return $this->lastname + $this->firstname;
	}

	function getMail()
	{
		return $this->mail;
	}

	/*
	*	Setters
	*/

	function setId($id)
	{
		$this->id = $id;
	}

	function setLastname()
	{
		$lastname = $this->lastname;
	}

	function setFirstname()
	{
		$firstname = $this->firstname;
	}

	function setMail()
	{
		$mail = $this->mail;
	}

	function isValid()
	{
		return true;
	}
}