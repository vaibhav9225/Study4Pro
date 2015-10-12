<?php require_once '../../includes/adminInitialise.php'; ?>
<?php $init->setLogin(); ?>
<?php

if($form->checkPost('course') and 
	$form->checkPost('topper') and 
	$form->checkPost('score') and 
	$form->checkPost('company') and 
	$form->checkPost('branch')
){
	$form->sessionError = 'error';
	$form->checkString($form->getPost('course'),'course name',true);
	$form->checkString($form->getPost('topper'),'topper name',true);
	$form->checkInt($form->getPost('score'),'score',true);
	$form->checkString($form->getPost('company'),'company',true);
	$form->checkString($form->getPost('branch'),'branch',true);
	if($session->getValue('error') == ''){
		if(!$database->checkValue('topper','name',$form->getPost('topper'))){
			$courseId = $database->escapeString($form->getPost('course'));
			$name = $page->capitalize($database->escapeString($form->getPost('topper')));
			$score = $database->escapeString($form->getPost('score'));
			$company = $page->capitalize($database->escapeString($form->getPost('company')));
			$branch = $page->capitalize($database->escapeString($form->getPost('branch')));
			$sql = $topper->insert($name,$score,$company,$branch,$courseId);
			if($sql){
				$session->unsetSessions();
				$session->setValue('success','<li>The topper has been added.</li>');
				$page->redirect('toppers.php');
			}
		}
		else{
			$session->setValue('error','<li>The name has already been added.</li>');
		}
	}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span12">
			<form method="POST" action="toppers.php">
				<legend>Add Topper</legend>
				<ul class="formErrors">
					<?php echo $session->getValue('error'); ?>
				</ul>
				<ul class="formSuccess">
					<?php echo $session->getValue('success'); ?>
				</ul>
				<div class="control-group">
					<label class="control-label" for="course">Select course name</label>
					<div class="controls">
						<select id="course" name="course" class="span6">
							<?php if($session->checkValue('course name')) echo '<option value="'.$session->getValue('course name').'">'.$database->otherValue('courses','id',$session->getValue('course name'),'courseName').'</option>'; ?>
							<option value="">eg: IC 33</option>
							<?php
							$courseNames = $courses->getNames();
							$courseIds = $courses->getIds();
							for($i=0; $i<count($courseNames); $i++){
								echo "<option value='$courseIds[$i]'>$courseNames[$i]</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="topper">Enter topper name</label>
					<div class="controls">
						<input type="text" id="topper" name="topper" class="span6" value="<?php echo $session->getValue('topper name'); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="score">Enter topper score</label>
					<div class="controls">
						<input type="text" id="score" name="score" class="span6" value="<?php echo $session->getValue('score'); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="company">Enter topper company</label>
					<div class="controls">
						<input type="text" id="company" name="company" class="span6" value="<?php echo $session->getValue('company'); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="branch">Enter topper branch</label>
					<div class="controls">
						<input type="text" id="branch" name="branch" class="span6" value="<?php echo $session->getValue('branch'); ?>">
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