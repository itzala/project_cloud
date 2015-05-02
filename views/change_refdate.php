<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

if (isset($_GET['d']))
{
	session_start();

	$offset = intval($_GET['d']);
	$ref_date = getReferenceDate();

	if ($offset == 1)
	{
		$ref_date->modify("+7 days");
	}
	else if ($offset == -1)
	{
		$ref_date->modify("-7 days");
	}

	setReferenceDate($ref_date);
	header("Location:./");
}