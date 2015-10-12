<?php require_once '../../includes/adminInitialise.php'; ?>
<?php require_once '../../includes/PHPExcelClass/PHPExcel/IOFactory.php'; ?>
<?php $init->setLogin(); ?>
<?php $page->magnify(); ?>
<?php

if($form->checkPost('language')){
	$form->sessionError = 'error';
	$form->checkString($form->getPost('language'),'language name',true);
	if($session->getValue('error') == ''){
		if(!$database->checkValue('languages','language',$form->getPost('language'))){
			$language = $page->capitalize($database->escapeString($form->getPost('language')));
			$sql = $languages->insert($language);
			if($sql){
				$session->unsetSessions();
				$session->setValue('success','<li>The language has been added.</li>');
				$page->redirect('languages.php');
			}
		}
		else{
			$session->setValue('error','<li>The language has already been added.</li>');
		}
	}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span12">
			<form method="POST" action="languages.php">
				<legend>Add Languages</legend>
				<ul class="formErrors">
					<?php echo $session->getValue('error'); ?>
				</ul>
				<ul class="formSuccess">
					<?php echo $session->getValue('success'); ?>
				</ul>
				<div class="control-group">
					<label class="control-label" for="language">Enter language name</label>
					<div class="controls">
						<input type="text" id="language" name="language" class="span8" value="<?php echo $session->getValue('language name'); ?>">
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