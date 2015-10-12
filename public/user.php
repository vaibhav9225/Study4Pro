<?php require_once '../includes/initialise.php'; ?>
<?php
$session->checkValue('loginId') ?
	$page->redirect('home.php')
	: $cookie->checkValue('loginId') ? $page->redirect('home.php')
	: null;
?>
<?php

if($form->checkPost('firstName') and
	$form->checkPost('lastName') and
	$form->checkPost('email') and
	$form->checkPost('username') and
	$form->checkPost('password') and
	$form->checkPost('confirmPassword') and
	$form->checkPost('address') and
	$form->checkPost('city') and
	$form->checkPost('zipcode') and
	$form->checkPost('country') and
	$form->checkPost('state')){
/* 		$form->sessionError = 'error';
		$form->checkString($form->getPost('firstName'),'first name',true);
		$form->checkString($form->getPost('lastName'),'last name',true);
		$form->checkEmail($form->getPost('email'),'email',true,'users','email');
		$form->checkUsername($form->getPost('username'),'username',true,'users','username');
		$form->checkPassword($form->getPost('password'),'password',true);
		$form->checkPassword($form->getPost('confirmPassword'),'confirm password',true);
		$form->checkText($form->getPost('address'),'address',true);
		$form->checkString($form->getPost('city'),'city',true);
		$form->checkZipcode($form->getPost('zipcode'),'zipcode',true);
		$form->checkString($form->getPost('country'),'country',true);
		$form->checkString($form->getPost('state'),'state',true); */
		if($session->getValue('error') == ''){
			$firstName = $page->capitalize($database->escapeString($form->getPost('firstName')));
			$lastName = $page->capitalize($database->escapeString($form->getPost('lastName')));
			$email = $database->escapeString($form->getPost('email'));
			$username = $database->escapeString($form->getPost('username'));
			$password = $database->escapeString($form->getPost('password'));
			$passwordHash = $page->encrypt($password);
			$address = $page->capitalize($database->escapeString($form->getPost('address')));
			$city = $page->capitalize($database->escapeString($form->getPost('city')));
			$zipcode = $database->escapeString($form->getPost('zipcode'));
			$country = $database->escapeString($form->getPost('country'));
			$state = $database->escapeString($form->getPost('state'));
			$passwordCheck = 'no';
			$query = "
			INSERT INTO `users` 
			VALUES ('','$firstName','$lastName','$email','$username','$passwordHash','$address','$city','$zipcode','$state','$country','$passwordCheck')";
			$sql = $database->query($query);
			$session->unsetSessions();
			$session->setValue('loginId',$database->insertId());
			$mail->to($email);
			$mail->from('Study4Pro <no-reply@study4pro.com>');
			$mail->subject('Registration Confirmation');
			$mail->body("
				You have been successfully added as a user in Study4Pro.com\n
				Your account details are:\n
				Username: $username\n
				Password: $password\n
			");
			$mail->send();
			$page->redirect('home.php');
		}
}

if($form->checkPost('loginUsername') and
	$form->checkPost('loginPassword')){
/* 		$form->sessionError = 'error2';
		$form->checkPassword($form->getPost('loginPassword'),'login password',true); */
		if($session->getValue('error2') == ''){
			$username = $database->escapeString($form->getPost('loginUsername'));
			$password = $page->encrypt($database->escapeString($form->getPost('loginPassword')));
			$query = "
			SELECT `id` 
			FROM `users` 
			WHERE `username`='$username' AND `password`='$password' OR `email`='$username' AND `password`='$password'
			";
			$sql = $database->query($query);
			$count = $database->numRows();
			if($count == 1){
				$data = $database->fetchAssoc();
				$session->unsetSessions();
				$session->setValue('loginId',$data['id']);
				$form->checkPost('rememberMe') ? $cookie->setValue('loginId',$data['id'],18144000) : null;
				$page->redirect('home.php');
			}
			else{
				$session->setValue('error2','<li>Login failed. Please check your username and password.</li>');
			}
		}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span6">
			<form class="form-horizontal" method="POST" action="user.php">
				<legend>Signup today !</legend>
				<ul class="formErrors">
					<?php echo $session->getValue('error'); ?>
				</ul>
				<div class="control-group">
					<label class="control-label" for="firstName">First Name</label>
					<div class="controls">
						<input type="text" id="firstName" name="firstName" value="<?php echo $session->getValue('first name'); ?>" placeholder="eg: Tom">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="lastName">Last Name</label>
					<div class="controls">
						<input type="text" id="lastName" name="lastName" value="<?php echo $session->getValue('last name'); ?>" placeholder="eg: Adams">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="email">Email Address</label>
					<div class="controls">
						<input type="text" id="email" name="email" value="<?php echo $session->getValue('email'); ?>" placeholder="eg: tom@gmail.com">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="username">Username</label>
					<div class="controls">
						<input type="text" id="username" name="username" value="<?php echo $session->getValue('username'); ?>" placeholder="eg: tom123">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">Password</label>
					<div class="controls">
						<input type="password" id="password" name="password" placeholder="eg: tom123adams" autocomplete="off">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="confirmPassword">Confirm Password</label>
					<div class="controls">
						<input type="password" id="confirmPassword" name="confirmPassword" placeholder="eg: tom123adams" autocomplete="off">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="address">Address</label>
					<div class="controls">
						<input type="text" id="address" name="address" value="<?php echo $session->getValue('address'); ?>" placeholder="eg: G-123 Gandhi Nagar">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="city">City</label>
					<div class="controls">
						<input type="text" id="city" name="city" value="<?php echo $session->getValue('city'); ?>" placeholder="eg: Delhi">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="zipcode">Zip Code</label>
					<div class="controls">
						<input type="text" id="zipcode" name="zipcode" value="<?php echo $session->getValue('zipcode'); ?>" placeholder="eg: 6700045">
					</div>
				</div>
				<div class="control-group hide">
					<label class="control-label" for="country">Country</label>
					<div class="controls">
						<input type="text" id="country" name="country" value="India" placeholder="eg: India">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="state">State</label>
					<div class="controls">
						<select id="state" name="state">
							<?php if($session->checkValue('state')) echo '<option value="'.$session->getValue('state').'">'.$session->getValue('state').'</option>'; ?>
							<option value="">eg : Gujarat</option>
							<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
							<option value="Andhra Pradesh">Andhra Pradesh</option>
							<option value="Arunachal Pradesh">Arunachal Pradesh</option>
							<option value="Assam">Assam</option>
							<option value="Bihar">Bihar</option>
							<option value="Chandigarh">Chandigarh</option>
							<option value="Chhattisgarh">Chhattisgarh</option>
							<option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
							<option value="Daman and Diu">Daman and Diu</option>
							<option value="Delhi">Delhi</option>
							<option value="Goa">Goa</option>
							<option value="Gujarat">Gujarat</option>
							<option value="Haryana">Haryana</option>
							<option value="Himachal Pradesh">Himachal Pradesh</option>
							<option value="Jammu and Kashmir">Jammu and Kashmir</option>
							<option value="Jharkhand">Jharkhand</option>
							<option value="Karnataka">Karnataka</option>
							<option value="Kerala">Kerala</option>
							<option value="Lakshadweep">Lakshadweep</option>
							<option value="Madhya Pradesh">Madhya Pradesh</option>
							<option value="Maharashtra">Maharashtra</option>
							<option value="Manipur">Manipur</option>
							<option value="Meghalaya">Meghalaya</option>
							<option value="Mizoram">Mizoram</option>
							<option value="Nagaland">Nagaland</option>
							<option value="Orissa">Orissa</option>
							<option value="Pondicherry">Pondicherry</option>
							<option value="Punjab">Punjab</option>
							<option value="Rajasthan">Rajasthan</option>
							<option value="Sikkim">Sikkim</option>
							<option value="Tamil Nadu">Tamil Nadu</option>
							<option value="Tripura">Tripura</option>
							<option value="Uttaranchal">Uttaranchal</option>
							<option value="Uttar Pradesh">Uttar Pradesh</option>
							<option value="West Bengal">West Bengal</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
		<div class="offset2 span4">
			<form method="POST" action="user.php">
				<legend>Login</legend>
				<ul class="formErrors">
					<?php echo $session->getValue('error2'); ?>
				</ul>
				<div class="control-group">
					<label class="control-label" for="loginUsername">Username or Email</label>
					<div class="controls">
						<input type="text" id="loginUsername" name="loginUsername" value="<?php echo $session->getValue('login username'); ?>" placeholder="eg: tom123">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="loginPassword">Password</label>
					<div class="controls">
						<input type="password" id="loginPassword" name="loginPassword" placeholder="eg: tom123adams">
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