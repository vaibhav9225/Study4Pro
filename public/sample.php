<?php require_once '../includes/initialise.php'; ?>
<?php $init->setHeader(); ?>
<?php
$form->checkGet('courseId') ? 
	$database->checkValue('questions','courseId',$form->getGet('courseId')) ?
		null
		: $page->kill('Take Mock Test','This course does not have any questions.')
	: $page->kill('Take Mock Test','This course does not have any questions.');
?>
<?php
$courseIds = $courses->getIds();
$random = $page->random(0,count($courseIds)-1);
?>
<div class="container"><br>
	<legend>Take Sample Test <span class="pull-right btn btn-small" id="timer">60 Minutes Remaining</span></legend>
	<div class="row">
		<div class="span11">
			<ol>
				<?php
				$courseId = $form->getGet('courseId');
				$ids = $questions->getTestQuestions($courseId,'id',50,false);
				$count=0;
				foreach($ids as $id){
					$count++;
					$data = $questions->getRow($id);
					$question = $page->strip($data['question']);
					$option1 = $page->strip($data['option1']);
					$option2 = $page->strip($data['option2']);
					$option3 = $page->strip($data['option3']);
					$option4 = $page->strip($data['option4']);
					$answer = $data['answer'];
					echo"
					<li id='question_$count' rel='$answer'>
						<strong>$question</strong> 
						<span class='right' id='right_$count'><i class='icon-ok'></i></span>
						<span class='wrong' id='wrong_$count'><i class='icon-remove'></i></span>
						<ol type='a'>
							<li><label class='radio'><input type='radio' name='option_$count' id='option1_$count' value='1'>
								$option1
								<span class='right' id='optRight1_$count'><i class='icon-ok'></i></span>
								<span class='wrong' id='optWrong1_$count'><i class='icon-remove'></i></span>
							</label></li>
							<li><label class='radio'><input type='radio' name='option_$count' id='option2_$count' value='2'>
								$option2
								<span class='right' id='optRight2_$count'><i class='icon-ok'></i></span>
								<span class='wrong' id='optWrong2_$count'><i class='icon-remove'></i></span>
							</label></li>
							<li><label class='radio'><input type='radio' name='option_$count' id='option3_$count' value='3'>
								$option3
								<span class='right' id='optRight3_$count'><i class='icon-ok'></i></span>
								<span class='wrong' id='optWrong3_$count'><i class='icon-remove'></i></span>
							</label></li>
							<li><label class='radio'><input type='radio' name='option_$count' id='option4_$count' value='4'>
								$option4
								<span class='right' id='optRight4_$count'><i class='icon-ok'></i></span>
								<span class='wrong' id='optWrong4_$count'><i class='icon-remove'></i></span>
							</label></li>
						</ol>
					</li>
					";
				}
				?>
			</ol>
			<ul>
				<?php
				if($count == 0){
					echo '<li>We are very sorry. No questions have been added to this course yet.</li>';
				}
				?>
			</ul>
			<button class="btn btn-primary" id="submit">Submit</button>
			<a href="test.php?courseId=<?php echo $courseIds[$random]; ?>" class="btn">Take another test</a>
			<br/>
			<br/>
		</div>
	</div>
</div>
<div class="modal hide fade" id="disclaimerModal">
	<div class="modal-header">
		<a href="#testModal" class="close" data-dismiss="modal" data-toggle="modal" aria-hidden="true">&times;</a>
		<h3>Disclaimer</h3>
	</div>
	<div class="modal-body">
		<ul>
			<li>The purpose of this test is to help candidates assess their knowledge before they attempt the real test.</li>
			<li>This test does not guarantee that a candidate would pass the exam if he passes this test.</li>
			<li>The pattern and questions in the actual test may be different from these tests.</li>
		</ul>
		<p>Please proceed if you have understood above terms and conditions.</p>
	</div>
	<div class="modal-footer">
		<a href="#testModal" class="btn btn-primary" data-dismiss="modal" data-toggle="modal">Next</a>
	</div>
</div>
<div class="modal hide fade" id="testModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Test Pattern</h3>
	</div>
	<div class="modal-body">
		<ul>
			<li>This test has maximum of 50 questions.</li>
			<li>Total time allotted to attempt these questions is 60 minutes.</li>
			<li>No marks are deducted for wrong answers.</li>
		</ul>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" data-dismiss="modal">Proceed</a>
	</div>
</div>
<div class="modal hide fade" id="alertModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Your time is up.</h3>
	</div>
	<div class="modal-body">
		<ul>
			<li>Your alloted time of 60 minutes is over.</li>
			<li>Your paper is being automatically submited.</li>
		</ul>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
	</div>
</div>
<div class="modal hide fade" id="resultModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Your Result</h3>
	</div>
	<div class="modal-body" id="resultBody">
	</div>
	<div class="modal-footer">
		<a href="test.php?courseId=<?php echo $courseIds[$random]; ?>" class="btn">Take anoher test</a>
		<a href="#" class="btn" data-dismiss="modal">View answers</a>
		<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
	</div>
</div>
<?php $init->setFooter(); ?>
<script type="text/javascript" src="../js/test.js"></script>