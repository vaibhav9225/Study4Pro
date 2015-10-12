<?php require_once '../../includes/adminInitialise.php'; ?>
<?php $form->checkGet('passwordCheck') ? 
		$database->checkValue('admins','passwordCheck',$form->getGet('passwordCheck')) ?
			$passwordCheck = $form->getGet('passwordCheck')
			: $page->redirect('dashboard.php')
		: $page->redirect('dashboard.php');
?>
<?php $session->checkValue('adminId') or $cookie->checkValue('adminId') ? $page->redirect('dashboard.php') : null; ?>
<?php

if($form->checkPost('email') and 
	$form->checkPost('password') and 
	$form->checkPost('confirmPassword')){
	$form->sessionError = 'error';
	$form->checkEmail($form->getPost('email'),'email',true);
	$form->checkPassword($form->getPost('password'),'password',true);
	$form->checkPassword($form->getPost('confirmPassword'),'confirm password',true);
	if($session->getValue('error') == ''){
		$email = $database->escapeString($form->getPost('email'));
		$username = $database->otherValue('admins','email',$email,'username');
		$password = $database->escapeString($form->getPost('password'));
		$passwordHash = $page->encrypt($password);
		$query = "
		UPDATE `admins` 
		SET `passwordCheck`='no',`password`='$passwordHash' 
		WHERE `email`='$email' AND `passwordCheck`='$passwordCheck'
		";
		$sql = $database->query($query);
		$count = $database->affectedRows();
		if($count > 0){
			$session->unsetSessions();
			$session->setValue('success','<li>Your password has been changed.</li>');
			$mail->to($email);
			$mail->from('Study4Pro <no-reply@study4pro.com>');
			$mail->subject('Information Retrieval');
			$mail->body("
				Your password has been reset.\n
				Your new account details are:\n
				Username: $username\n
				Password: $password\n
			");
			$mail->send();
			$page->redirect('reset.php');
		}
		else{
			$session->setValue('error','<li>This password reset token does not exist.</li>');
		}
	}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span12">
			<form method="POST" action="reset.php?passwordCheck=<?php echo $passwordCheck; ?>">
				<legend>Reset Your Password</legend>
				<ul class="formErrors">
					<?php echo $session->getValue('error'); ?>
				</ul>
				<ul class="formSuccess">
					<?php echo $session->getValue('success'); ?>
				</ul>
				<div class="control-group">
					<label class="control-label" for="email">Enter your email address</label>
					<div class="controls">
						<input type="text" id="email" name="email" class="span6" value="<?php echo $session->getValue('email'); ?>" placeholder="eg: tom123@gmail.com">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">New Password</label>
					<div class="controls">
						<input type="password" id="password" name="password" class="span6" placeholder="eg: tom123adams" autocomplete="off">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="confirmPassword">Confirm Password</label>
					<div class="controls">
						<input type="password" id="confirmPassword" name="confirmPassword" class="span6" placeholder="eg: tom123adams" autocomplete="off">
					</div>
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
<?php $session->unsetSession('success'); ?>
<?php $init->setFooter(); ?>