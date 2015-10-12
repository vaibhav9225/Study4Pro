<?php require_once '../includes/initialise.php'; ?>
<?php

if($form->checkPost('fullName') and
	$form->checkPost('email') and
	$form->checkPost('contactNo') and
	$form->checkPost('message')){
		$form->sessionError = 'error';
		$form->checkString($form->getPost('fullName'),'full name',true);
		$form->checkEmail($form->getPost('email'),'email',true);
		$form->checkInt($form->getPost('contactNo'),'contact number',true);
		$form->checkText($form->getPost('message'),'message',false);
		if($session->getValue('error') == ''){
			$fullName = $page->capitalize($database->escapeString($form->getPost('fullName')));
			$contactNo = $database->escapeString($form->getPost('contactNo'));
			$email = $database->escapeString($form->getPost('email'));
			$message = $page->capitalize($database->escapeString($form->getPost('message')));
			$mail->to('Study4Pro <support@study4pro.com>');
			$mail->from($email);
			$mail->subject('Contact Us');
			$mail->body("
				Name: $fullName\n
				Contact Number: $contactNo\n
				Email Address: $email\n
				Message: $message\n
			");
			$mail->send();
			$mail->to($email);
			$mail->subject('Copy of Contact Us');
			$mail->send();
			$session->unsetSessions();
			$session->setValue('success','<li>An email has been sent.</li>');
		}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<form class="form-horizontal" method="POST" action="contact.php">
		<legend>Contact Us</legend>
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
			<label class="control-label" for="contactNo">Contact Number</label>
			<div class="controls">
				<input type="text" id="contactNo" name="contactNo" class="span6" value="<?php echo $session->getValue('contact number'); ?>" placeholder="eg: +916789878887">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="message">Message</label>
			<div class="controls">
				<textarea id="message" name="message" class="span6" placeholder="eg: This is a really cool website !"><?php echo $session->getValue('message'); ?></textarea>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>
</div>
<?php $session->unsetSessions(); ?>
<?php $session->unsetSession('success'); ?>
<?php $init->setFooter(); ?>