<?php require_once '../includes/initialise.php'; ?>
<?php

$session->destroy();
$cookie->unsetCookie('loginId');
$page->redirect('home.php');

?>