<?php require_once '../../includes/adminInitialise.php'; ?>
<?php

$session->destroy();
$cookie->unsetCookie('adminId');
$page->redirect('login.php');

?>