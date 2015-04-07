<?php
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

isLogged();
header("Location:./views/index.php");