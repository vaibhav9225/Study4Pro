<?php require_once '../../includes/adminInitialise.php'; ?>
<?php require_once '../../includes/PHPExcelClass/PHPExcel/IOFactory.php'; ?>
<?php $init->setLogin(); ?>
<?php $page->magnify(); ?>
<?php

if($form->checkPost('course')){
	$form->sessionError = 'error';
	$form->checkFile('file','filename',true);
	$form->checkInt($form->getPost('course'),'course name',true);
	if($session->getValue('error') == ''){
		$courseId = $database->escapeString($form->getPost('course'));
		$array = $page->split('.',$form->getFile('file'));
		$extension = end($array);
		if($extension == 'xlsx' or $extension == 'xls'){
			$random = $page->shuffle('1234567890qwertyuiopasdfghjklzxcvbnm1234567890');
			$filename = $page->cut($random,1,10);
			$filename = $filename.'.'.$extension;
			$inputFileName = $form->getFile('file','temp');
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
			$currentSheet = 0;
			$objWorksheet = $objPHPExcel->setActiveSheetIndex($currentSheet);
			$highestRow = $objWorksheet->getHighestRow();
			$req = 1;
			$notReq = 0;
			$flag = false;
			$sql = false;
			$syllabus->delete($courseId);
			for ($row=1; $row<=$highestRow; $row++){
				$field = array();
				for($i=0; $i<$req; $i++){
					if($page->check($objWorksheet->getCellByColumnAndRow($i,$row)->getValue())){
						$field[$i] = $database->escapeString($page->capitalize($objWorksheet->getCellByColumnAndRow($i,$row)->getValue()));
					}
					else{
						$flag = true;
					}
				}
				for($i=0; $i<$notReq; $i++){
					$field[$i] = $database->escapeString($page->capitalize($objWorksheet->getCellByColumnAndRow($i,$row)->getValue()));
				}
				if($flag){
					$session->setValue('error','<li>This is a invalid excel sheet.</li>');
					$session->setValue('success','');
					break;
				}
				$sql = $syllabus->insert($row,$field[0],$courseId);
			}
			if($sql){
				$session->setValue('success','<li>This syllabus has been added to the course.</li>');
				$session->unsetSessions();
				$page->redirect('syllabus.php');
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
			<form method="POST" action="syllabus.php" enctype="multipart/form-data">
				<legend>Add Syllabus</legend>
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
					<label class="control-label" for="file">Upload syllabus file</label>
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
<?php $session->unsetSession('success'); ?>
<?php $session->unsetSessions(); ?>
<?php $init->setFooter(); ?>