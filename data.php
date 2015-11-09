<?php
    require_once("functions.php");
	require_once("InterestManager.class.php");
    
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
		
		//Ära enne suunamist midagi rohkem tee
		exit();
    }
    
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: login.php");
    }
	
	##HALDUS##
	
	$InterestManager = new InterestManager($mysqli, $_SESSION['id_from_db']{

?>

Tere, <?=$_SESSION['user_email'];?> <a href="?logout=1">Logi välja</a>

<br>

<?php if(isset($_SESSION["login_message"])): ?>

  <p style="color:green;">
    <?=$_SESSION["login_message"]?>
  </p>

<?php 
	//Kustutan muutuja, et rohkem ei naidataks
	unset($_SESSION["login_message"]);
endif; ?>














