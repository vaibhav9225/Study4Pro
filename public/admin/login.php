<?php require_once '../../includes/adminInitialise.php'; ?>
<?php 
$session->checkValue('adminId') ?
	$page->redirect('dashboard.php')
	: $cookie->checkValue('adminId') ? $page->redirect('dashboard.php')
	: null;
?>
<?php

if($form->checkPost('username') and
	$form->checkPost('password')){
/* 		$form->sessionError = 'error';
		$form->checkPassword($form->getPost('password'),'password',true); */
		if($session->getValue('error') == ''){
			$username = $database->escapeString($form->getPost('username'));
			$password = $page->encrypt($database->escapeString($form->getPost('password')));
			$query = "
			SELECT `id` 
			FROM `admins` 
			WHERE `username`='$username' AND `password`='$password' OR `email`='$username' AND `password`='$password'
			";
			$sql = $database->query($query);
			$count = $database->numRows();
			if($count == 1){
				$data = $database->fetchAssoc();
				$session->unsetSessions();
				$session->setValue('adminId',$data['id']);
				$form->checkPost('rememberMe') ? $cookie->setValue('adminId',$data['id'],18144000) : null;
				$page->redirect('dashboard.php');
			}
			else{
				$session->setValue('error','<li>Login failed. Please check your username and password.</li>');
			}
		}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span12">
			<form method="POST" action="login.php">
				<legend>Admin Login</legend>
				<ul class="formErrors">
					<?php echo $session->getValue('error'); ?>
				</ul>
				<div class="control-group">
					<label class="control-label" for="username">Username or Email</label>
					<div class="controls">
						<input type="text" id="username" name="username" class="span6" value="<?php echo $session->getValue('username'); ?>" placeholder="eg: tom123">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">Password</label>
					<div class="controls">
						<input type="password" id="password" name="password" class="span6" placeholder="eg: tom123adams">
					</div>
				</div>
				<div class="control-group">
					<a href="forgot.php" id="forgotPassword">Forgot Password ?</a>
				</div>
				<div class="control-group">
					<label class="control-label" for="rememberMe">
						Remember Me <input type="checkbox" id="rememberMe" name="rememberMe">
					</label>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php $session->unsetSessions(); ?>
<?php $init->setFooter(); ?>