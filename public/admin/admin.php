<?php require_once '../../includes/adminInitialise.php'; ?>
<?php $init->setLogin(); ?>
<?php

if($form->checkPost('fullName') and
	$form->checkPost('email') and
	$form->checkPost('username') and
	$form->checkPost('password') and
	$form->checkPost('confirmPassword')){
		$form->sessionError = 'error';
		$form->checkString($form->getPost('fullName'),'full name',true);
		$form->checkEmail($form->getPost('email'),'email',true,'admins','email');
		$form->checkUsername($form->getPost('username'),'username',true,'admins','username');
		$form->checkPassword($form->getPost('password'),'password',true);
		$form->checkPassword($form->getPost('confirmPassword'),'confirm password',true);
		if($session->getValue('error') == ''){
			$fullName = $page->capitalize($database->escapeString($form->getPost('fullName')));
			$email = $database->escapeString($form->getPost('email'));
			$username = $database->escapeString($form->getPost('username'));
			$password = $database->escapeString($form->getPost('password'));
			$passwordHash = $page->encrypt($password);
			$passwordCheck = 'no';
			$query = "
			INSERT INTO `admins` 
			VALUES ('','$fullName','$username','$passwordHash','$email','$passwordCheck')";
			$sql = $database->query($query);
			$session->unsetSessions();
			$session->setValue('success','<li>Admin has been added to the database.</li>');
			$mail->to($email);
			$mail->from('Study4Pro <no-reply@study4pro.com>');
			$mail->subject('Registration Confirmation');
			$mail->body("
				You have been successfully added as an admin in Study4Pro.com\n
				Your account details are:\n
				Username: $username\n
				Password: $password\n
			");
			$mail->send();
			$page->redirect('admin.php');
		}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span12">
			<form method="POST" action="admin.php">
				<legend>Add Admin</legend>
				<ul class="formErrors">
					<?php echo $session->getValue('error'); ?>
				</ul>
				<ul class="formSuccess">
					<?php echo $session->getValue('success'); ?>
				</ul>
				<div class="control-group">
					<label class="control-label" for="fullName">Full Name</label>
					<div class="controls">
						<input type="text" id="fullName" name="fullName" class="span6" value="<?php echo $session->getValue('full name'); ?>" placeholder="eg: Tom Adams">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="email">Email Address</label>
					<div class="controls">
						<input type="text" id="email" name="email" class="span6" value="<?php echo $session->getValue('email'); ?>" placeholder="eg: tom@gmail.com">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="username">Username</label>
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
					<label class="control-label" for="confirmPassword">Password</label>
					<div class="controls">
						<input type="password" id="confirmPassword" name="confirmPassword" class="span6" placeholder="eg: tom123adams">
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
<?php $session->unsetSession('success'); ?>
<?php $session->unsetSessions(); ?>
<?php $init->setFooter(); ?>