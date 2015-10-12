<?php require_once '../includes/initialise.php'; ?>
<?php $init->setLogin(); ?>
<?php $init->setHeader(); ?>
<?php
$form->checkGet('courseId') ? 
	$database->checkValue('questions','courseId',$form->getGet('courseId')) ?
		null
		: $page->kill('Chapter Wise Questions','This chapter does not have any questions.')
	: $page->kill('Chapter Wise Questions','This chapter does not have any questions.');
?>
<?php
$form->checkGet('chapterNo') ? 
	$database->checkValue('questions','chapterNo',$form->getGet('chapterNo')) ?
		null
		: $page->kill('Chapter Wise Questions','This chapter does not have any questions.')
	: $page->kill('Chapter Wise Questions','This chapter does not have any questions.');
?>
<div class="container"><br>
	<legend>Chapter Wise Questions</legend>
	<ul>
	<?php
	$chapterNo = $form->getGet('chapterNo');
	$courseId = $form->getGet('courseId');
	$problem = $questions->getFields($chapterNo,$courseId,'question');
	$option1 = $questions->getFields($chapterNo,$courseId,'option1');
	$option2 = $questions->getFields($chapterNo,$courseId,'option2');
	$option3 = $questions->getFields($chapterNo,$courseId,'option3');
	$option4 = $questions->getFields($chapterNo,$courseId,'option4');
	$answer = $questions->getFields($chapterNo,$courseId,'answer');
	for($i=0; $i<count($problem); $i++){
		echo "
		<li>
			<p><strong>$problem[$i]</strong></p>
			<p><i class='icon-caret-right'></i> $option1[$i]</p>
			<p><i class='icon-caret-right'></i> $option2[$i]</p>
			<p><i class='icon-caret-right'></i> $option3[$i]</p>
			<p><i class='icon-caret-right'></i> $option4[$i]</p>
			<p id='ansHover'>Hover to view the answer : <span>$answer[$i]</span></p>
		</li>
		";
	}
	?>
	</ul>
</div>
<?php $init->setFooter(); ?>