<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/config.php");

function isMailValide(){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function compareDate($date1, $date2){
	return (date_diff($date1, $date2) > 0);
}

function isValidUsername ($name){
	return isset($users[$name]);
}

function encryptPassword($pass){
	return md5($pass.SALT);
}

?>