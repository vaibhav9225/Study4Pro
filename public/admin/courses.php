<?php require_once '../../includes/adminInitialise.php'; ?>
<?php $init->setLogin(); ?>
<?php

if($form->checkPost('name') and
	$form->checkPost('description')){
		$form->sessionError = 'error';
		$form->checkString($form->getPost('name'),'name',true);
		$form->checkText($form->getPost('description'),'description',true);
		if($session->getValue('error') == ''){
			$name = $page->capitalize($database->escapeString($form->getPost('name')));
			$description = $database->escapeString($form->getPost('description'));
			$query = "SELECT * FROM `courses` WHERE `courseName`='$name'";
			$sql = $database->query($query);
			$count = $database->numRows();
			if($count > 0){
				$session->setValue('error','<li>This course already exists.</li>');
			}
			else{
				$query = "
				INSERT INTO `courses` 
				VALUES ('','$name','$description') 
				";
				$sql = $database->query($query);
				if($sql){
					$session->setValue('success','<li>The course has been added to the database.</li>');
					$session->unsetSessions();
					$page->redirect('courses.php');
				}
				else{
					$session->setValue('error','<li>Some error has occured.</li>');
				}
			}
		}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span12">
			<form method="POST" action="courses.php">
				<legend>Add Courses</legend>
				<ul class="formErrors">
					<?php echo $session->getValue('error'); ?>
				</ul>
				<ul class="formSuccess">
					<?php echo $session->getValue('success'); ?>
				</ul>
				<div class="control-group">
					<label class="control-label" for="name">Course Name</label>
					<div class="controls">
						<input type="text" id="name" name="name" class="span10" placeholder="eg: IC 33" value="<?php echo $session->getValue('name'); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="description">Course Description</label>
					<div class="controls">
						<textarea id="description" name="description" class="span10" placeholder="eg: This course is related to insurance."><?php echo $session->getValue('description'); ?></textarea>
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