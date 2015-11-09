<?php

	require_once("../config_global.php");
	require_once("user.class.php");
    $database = "if15_raunkos";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);

	$User = new User($mysqli);

 ?>