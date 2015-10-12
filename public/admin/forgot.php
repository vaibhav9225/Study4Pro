<?php require_once '../../includes/adminInitialise.php'; ?>
<?php 
$session->checkValue('adminId') ?
	$page->redirect('dashboard.php')
	: $cookie->checkValue('adminId') ? $page->redirect('dashboard.php')
	: null;
?>
<?php

if($form->checkPost('email')){
	$form->sessionError = 'error';
	$form->checkEmail($form->getPost('email'),'email',true);
	if($session->getValue('error') == ''){
		$email = $database->escapeString($form->getPost('email'));
		$random = $page->shuffle('1234567890qwertyuiopasdfghjklzxcvbnm1234567890');
		$random = $page->cut($random,1,9);
		$query = "
		UPDATE `admins` 
		SET `passwordCheck`='$random' 
		WHERE `email`='$email'
		";
		$sql = $database->query($query);
		if($sql){
			$session->unsetSessions();
			$session->setValue('success','<li>An email has been sent.</li>');
			$mail->to($email);
			$mail->from('Study4Pro <no-reply@study4pro.com>');
			$mail->subject('Information Retrieval');
			$mail->body("
				We have received a request from you to reset your login password.\n
				Click on the link below to reset your password:\n
				http://www.study4pro.com/public/admin/reset.php?passwordCheck=$random \n
				Ignore this email if you do not want to reset your password.\n
			");
			$mail->send();
			$page->redirect('forgot.php');
		}
	}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span12">
			<form method="POST" action="forgot.php">
				<legend>Forgot Password?</legend>
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