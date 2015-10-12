<?php require_once '../includes/initialise.php'; ?>
<?php $init->setLogin(); ?>
<?php $init->setHeader(); ?>
<?php
$form->checkGet('courseId') ? 
	$database->checkValue('notes','courseId',$form->getGet('courseId')) ?
		null
		: $page->kill('Chapter Wise Notes','This chapter does not have any notes.')
	: $page->kill('Chapter Wise Notes','This chapter does not have any notes.');
?>
<?php
$form->checkGet('chapterNo') ? 
	$database->checkValue('notes','chapterNo',$form->getGet('chapterNo')) ?
		null
		: $page->kill('Chapter Wise Notes','This chapter does not have any notes.')
	: $page->kill('Chapter Wise Notes','This chapter does not have any notes.');
?>
<div class="container"><br>
	<legend>Chapter Wise Notes</legend>
	<ul>
	<?php
	$chapterNo = $form->getGet('chapterNo');
	$courseId = $form->getGet('courseId');
	$filenames = $notes->getFilenames($chapterNo,$courseId);
	$titles = $notes->getTitles($chapterNo,$courseId);
	for($i=0; $i<count($filenames); $i++){
		echo "<li><a href='pdf.php?courseId=$courseId&chapterNo=$chapterNo&key=$filenames[$i]'>$titles[$i]</a></li>";
	}
	?>
	</ul>
</div>
<?php $init->setFooter(); ?>