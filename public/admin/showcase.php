<?php require_once '../../includes/adminInitialise.php'; ?>
<?php $init->setLogin(); ?>
<?php

if($form->checkPost('update')){
	$form->sessionError = 'error';
	$form->checkString($form->getPost('update'),'update',true);
	if($session->getValue('error') == ''){
		$update = $database->escapeString($form->getPost('update'));
		$sql = $showcase->insert($update);
		if($sql){
			$session->unsetSessions();
			$session->setValue('success','<li>The update has been added.</li>');
			$page->redirect('showcase.php');
		}
	}
}

?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<div class="row">
		<div class="span12">
			<form method="POST" action="showcase.php">
				<legend>Add Update</legend>
				<ul class="formErrors">
					<?php echo $session->getValue('error'); ?>
				</ul>
				<ul class="formSuccess">
					<?php echo $session->getValue('success'); ?>
				</ul>
				<div class="control-group">
					<label class="control-label" for="update">Post the update</label>
					<div class="controls">
						<textarea id="update" name="update" class="span8"><?php echo $session->getValue('update'); ?></textarea>
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