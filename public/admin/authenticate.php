<?php require_once '../../includes/adminInitialise.php'; ?>
<?php

if(!$session->checkValue('adminId') and !$cookie->checkValue('adminId')){
	$page->end("You need to be logged in to view this page. <a href='login.php'>Click</a> here to login.");
}
else{
	$session->checkValue('adminId') ? $adminId = $session->checkValue('adminId') : null;
	$cookie->checkValue('adminId') ? $adminId = $cookie->checkValue('adminId') : null;
	if(!$database->checkValue('admins','id',$adminId)){
		$page->end("You need to be logged in to view this page. <a href='login.php'>Click</a> here to login.");
	}
}

?>