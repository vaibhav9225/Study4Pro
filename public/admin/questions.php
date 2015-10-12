<?php require_once '../../includes/adminInitialise.php'; ?>
<?php require_once '../../includes/PHPExcelClass/PHPExcel/IOFactory.php'; ?>
<?php $init->setLogin(); ?>
<?php $page->magnify(); ?>
<?php

if($form->checkPost('course')){
	$form->sessionError = 'error';
	$form->checkFile('file','filename',true);
	$form->checkInt($form->getPost('course'),'course name',true);
	$form->checkInt($form->getPost('language'),'language name',true);
	if($session->getValue('error') == ''){
		$courseId = $database->escapeString($form->getPost('course'));
		$languageId = $database->escapeString($form->getPost('language'));
		$array = $page->split('.',$form->getFile('file'));
		$extension = end($array);
		if($extension == 'xlsx' or $extension == 'xls'){
			$random = $page->shuffle('1234567890qwertyuiopasdfghjklzxcvbnm1234567890');
			$filename = $page->cut($random,1,10);
			$filename = $filename.'.'.$extension;
			$inputFilename = $form->getFile('file','temp');
			$inputFileType = PHPExcel_IOFactory::identify($inputFilename);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFilename);
			$form->moveFile($inputFilename,"uploads/$filename");
			$currentSheet = 0;
			$objWorksheet = $objPHPExcel->setActiveSheetIndex($currentSheet);
			$highestRow = $objWorksheet->getHighestRow();
			$req = 6;
			$notReq = 1;
			$flag = false;
			$superFlag = 0;
			for($row=1; $row<=$highestRow; $row++){
				$field = array();
				for($i=0; $i<$req; $i++){
					if($page->check($objWorksheet->getCellByColumnAndRow($i,$row)->getValue())){
						$field[$i] = $database->escapeString($page->capitalize($objWorksheet->getCellByColumnAndRow($i,$row)->getValue()));
					}
					else{
						$flag = true;
						break;
					}
				}
				for($i=$req; $i<$req+$notReq; $i++){
					if($page->check($objWorksheet->getCellByColumnAndRow($i,$row)->getValue())){
						$field[$i] = $database->escapeString($page->capitalize($objWorksheet->getCellByColumnAndRow($i,$row)->getValue()));
					}
					else{
						$field[$i] = 0;
					}
				}
				if($flag){
					$session->setValue('error','<li>This is a invalid excel sheet.</li>');
					$session->setValue('success','');
					break;
				}
				else{
					if(!$database->checkValue('questions','question',$field[0])){
						$sql = $questions->insert($filename,$field[0],$field[1],$field[2],$field[3],$field[4],$field[5],$field[6],$languageId,$courseId);
						if($sql){
							$superFlag++;
						}
					}
				}
			}
			if($superFlag > 0){
				$session->unsetSessions();
				$session->setValue('success','<li>The questions have been added to the course.</li>');
				$page->redirect('questions.php');
			}
			else{
				$session->setValue('error','<li>The file has already been added to the course.</li>');	
			}
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
			<form method="POST" action="questions.php" enctype="multipart/form-data">
				<legend>Add Questions</legend>
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
					<label class="control-label" for="language">Select language name</label>
					<div class="controls">
						<select id="language" name="language" class="span6">
							<?php if($session->checkValue('language name')) echo '<option value="'.$session->getValue('language name').'">'.$database->otherValue('languages','id',$session->getValue('language name'),'language').'</option>'; ?>
							<option value="">eg: English</option>
							<?php
							$languageNames = $languages->getNames();
							$languageIds = $languages->getIds();
							for($i=0; $i<count($languageNames); $i++){
								echo "<option value='$languageIds[$i]'>$languageNames[$i]</option>";
							}
							?>
						</select>
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