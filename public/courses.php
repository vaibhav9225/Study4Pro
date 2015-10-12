<?php require_once '../includes/initialise.php'; ?>
<?php $init->setHeader(); ?>
<?php
$form->checkGet('courseId') ? 
	$database->checkValue('courses','id',$form->getGet('courseId')) ?
		null
		: $page->kill('Courses','This course does not exist.')
	: $page->kill('Courses','This course does not exist.');
?>
<div class="container"><br>
	<legend>
		<?php echo $database->otherValue('courses','id',$form->getGet('courseId'),'courseName'); ?> Syllabus
		<?php echo "
			<small class='pull-right'><strong>
				<a href='test.php?courseId=".$form->getGet('courseId')."'>Take mock test. <i class='icon-share-alt'></i></a>
			</strong></small>";
		?>
	</legend>
	<table class="table table-hover">
		<tr><th id="courseId">#</th><th id="courseName">Chapter Names</th></tr>
		<?php
		$courseId = $form->getGet('courseId');
		if($syllabus->chapterCount($courseId) == 0){
			echo '<tr><td colspan="2">No chapters have been added yet.</td></tr>';
		}
		$chapterNames = $syllabus->getNames($courseId);
		$chapterNos = $syllabus->getNos($courseId);
		for($i=1,$j=0; $i<=count($chapterNames); $i++,$j++){
			echo "
				<tr>
					<td>$i</td>
					<td>$chapterNames[$j]
						<div id='tableLinks'>
							<a href='questions.php?chapterNo=$chapterNos[$j]&courseId=$courseId'>
								View Questions (".$questions->questionCount($chapterNos[$j],$courseId).")
							</a>
							<a href='notes.php?chapterNo=$chapterNos[$j]&courseId=$courseId'>
								View Notes (".$notes->notesCount($chapterNos[$j],$courseId).")
							</a>
						</div>
					</td>
				</tr>";
		}
		?>
	</table>
</div>
<?php $init->setFooter(); ?>