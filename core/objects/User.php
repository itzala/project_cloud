<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/verif.php");

/**
* 
*/
class User
{	

	private $count_id = 0;

	private $id;
	private $lastname;
	private $firstname;
	private $username;
	private $password;
	private $mail;

	function __construct($lastname, $firstname, $username, $password, $mail)
	{
		$this->id = $count_id;
		$count_id++;
		$this->lastname = $lastname;
		$this->firstname = $firstname;
		$this->username = $username;
		$this->mail = $mail;
		$this->password = $password;
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

	function getUsername()
	{
		return $this->username;
	}

	function getPassword(){
		return $this->password;
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
		$this->lastname = $this->lastname;
	}

	function setFirstname()
	{
		$this->firstname = $this->firstname;
	}

	function setMail()
	{
		$this->mail = $this->mail;
	}

	function setPassword($password){
		$this->password = $password;
	}

	function setUsername($username)
	{
		$this->username = $username;
	}

	function isValid()
	{
		return true;
	}
}