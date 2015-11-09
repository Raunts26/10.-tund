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
		exit();
    }
	
	

	
	##HALDUS##
	
	$InterestManager = new InterestManager($mysqli, $_SESSION['user_id']);
	
	if(isset($_GET["insert"])){
		$int_name = $_GET["insert"];
		$InterestManager->addInterest($int_name);
		$interest_response = $InterestManager->addInterest($int_name);
	}

	if(isset($_GET["dropdown_interest"])) {
		$InterestManager->addUserInterests($_SESSION['user_id'], $_GET["dropdown_interest"]);
		$user_int_response = $InterestManager->addUserInterests($_SESSION['user_id'], $_GET["dropdown_interest"]);
		var_dump($user_int_response);
	}


	
	

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


<?php if(isset($interest_response->success)): ?>

<p style="color:green;">
<?=$interest_response->success->message;?>
</p>

<?php elseif(isset($interest_response->error)): ?>

<p style="color:red;">
<?=$interest_response->error->message;?>
</p>

<?php endif; ?>

<h2>Lisa uus</h2>
<form method="get">

<input name="insert" type="text" placeholder="Huvi...">
<input type="submit" name="create" value="Loo huvi">

</form>

<h2>Minu huvialad</h2>

<?php if(isset($user_int_response->success)): ?>

<p style="color:green;">
<?=$user_int_response->success->message;?>
</p>

<?php elseif(isset($user_int_response->error)): ?>

<p style="color:red;">
<?=$user_int_response->error->message;?>
</p>

<?php endif; ?>

<form>
<?=$InterestManager->createDropdown();?>
<input type="submit" value="Lisa">

</form>

<h2>Loetelu</h2>
<?=$InterestManager->getUserInterests();?>






