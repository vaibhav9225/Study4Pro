<?php require_once '../../includes/adminInitialise.php'; ?>
<?php $init->setLogin(); ?>
<?php $page->magnify(); ?>
<?php

if($form->checkPost('course') and 
	$form->checkPost('chapter') and 
	$form->checkPost('title')){
	$form->sessionError = 'error';
	$form->checkFile('file','filename',true);
	$form->checkInt($form->getPost('course'),'course name',true);
	$form->checkInt($form->getPost('chapter'),'chapter number',true);
	$form->checkString($form->getPost('title'),'title',true);
	if($session->getValue('error') == ''){
		$courseId = $database->escapeString($form->getPost('course'));
		$chapterNo = $database->escapeString($form->getPost('chapter'));
		$title = $database->escapeString($form->getPost('title'));
		$array = $page->split('.',$form->getFile('file'));
		$extension = end($array);
		if($extension == 'pdf'){
			$random = $page->shuffle('1234567890qwertyuiopasdfghjklzxcvbnm1234567890');
			$key = $page->cut($random,1,10);
			$filename = $key.'.'.$extension;
			$inputFilename = $form->getFile('file','temp');
			$form->moveFile($inputFilename,"uploads/$filename");
			$notes->insert($title,$key,$chapterNo,$courseId);
			$session->unsetSessions();
			$session->setValue('success','<li>The notes have been added to the course.</li>');
			$page->redirect('notes.php');
		}
		else{
			$session->setValue('error','<li>This is an invalid filename.</li>');
		}
	}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span12">
			<form method="POST" action="notes.php" enctype="multipart/form-data">
				<legend>Add Notes</legend>
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
					<label class="control-label" for="chapterNo">Chapter Number</label>
					<div class="controls">
						<input type="text" id="chapterNo" name="chapter" class="span6" value="<?php echo $session->getValue('chapter number'); ?>" placeholder="eg: 5">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="title">Enter Title</label>
					<div class="controls">
						<input type="text" id="title" name="title" class="span6" value="<?php echo $session->getValue('title'); ?>" placeholder="eg: IC 33 English Chapter 1">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="file">Upload questions file</label>
					<div class="controls">
						<input type="file" id="file" name="file" class="span4">
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