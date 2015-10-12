<?php require_once '../includes/initialise.php'; ?>
<?php
$form->checkGet('languageId') ? 
	$database->checkValue('languages','id',$form->getGet('languageId')) ?
		null
		: $page->kill('Languages','This language does not exist.')
	: $page->kill('Languages','This language does not exist.');
?>
<?php

$languageId = $form->getGet('languageId');
$cookie->setValue('languageId',$languageId,18144000);
$page->redirect('home.php');

?>