<?php require_once '../includes/initialise.php'; ?>
<?php

if(!$session->checkValue('loginId') and !$cookie->checkValue('loginId')){
	$page->end("You need to be logged in to view this page. <a href='user.php'>Click</a> here to login.");
}
else{
	$session->checkValue('loginId') ? $loginId = $session->checkValue('loginId') : null;
	$cookie->checkValue('loginId') ? $loginId = $cookie->checkValue('loginId') : null;
	if(!$database->checkValue('users','id',$loginId)){
		$page->end("You need to be logged in to view this page. <a href='user.php'>Click</a> here to login.");
	}
}

?>