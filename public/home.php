<?php require_once '../includes/initialise.php'; ?>
<?php $init->setHeader(); ?>
<?php
$courseIds = $courses->getIds();
$random = $page->random(0,count($courseIds)-1);
?>
<?php
if(!$session->checkValue('loginId') and !$cookie->checkValue('loginId')){
echo '
<div class="container"><br>
	<div class="row">
		<div class="span4">
			<h3>Study4Pro</h3>
			<p class="lead">Get chapter wise notes and practice tests for IRDA IC-33 test in English, Hindi, Telugu and Marathi.</p>
			<a class="btn btn-large btn-primary" href="sample.php?courseId='.$courseIds[$random].'">Take sample test</a>
        </div>
		<div class="span4">
			<h3>Get Started</h3>
			<p class="lead">Login to start taking practice tests, read chapter wise notes and much more. Click on the button below to get started.</p>
			<a class="btn btn-large btn-warning" href="user.php">Login now</a>
        </div>
		<div class="span4">
			<h3>Join Now</h3>
			<p class="lead">Register to get access to hundreds of practice questions and detailed chapter wise notes.</p>
			<a class="btn btn-large btn-info" href="user.php">Sign up today</a>
        </div>
	</div>
</div>
';
}
?>
<div class="container"><br>
	<div class="row">
		<div class="span3">
			<div class="accordion"><br>
				<div class='accordion-group' id='noBorder'>
					<div class='accordion-heading'>
						<a class='accordion-toggle btn btn-inverse' data-toggle='collapse' href='#collapseUpdate' id='alignLeft'>
							Recent Updates <i class='icon-reorder'></i>
						</a>
					</div>
					<div id='collapseUpdate' class='accordion-body collapse in'>
						<div class='accordion-inner'>
							<?php $updatesPosted = $showcase->getUpdates(); ?>
							<ul>
							<?php
							for($i=0; $i<count($updatesPosted); $i++){
								echo "<li>$updatesPosted[$i]</li>";
							}
							if(count($updatesPosted) == 0){
								echo "No results found.";
							}
							?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion"><br>
				<div class='accordion-group' id='noBorder'>
					<div class='accordion-heading'>
						<a class='accordion-toggle btn btn-inverse' data-toggle='collapse' href='#collapseTopper' id='alignLeft'>
							Toppers ( Scores ) <i class='icon-reorder'></i>
						</a>
					</div>
					<div id='collapseTopper' class='accordion-body collapse in'>
						<div class='accordion-inner'>
							<?php $topperNames = $topper->getNames(); ?>
							<?php $topperScores = $topper->getScores(); ?>
							<ul>
							<?php
							for($i=0; $i<count($topperNames); $i++){
								echo "<li>$topperNames[$i] ( $topperScores[$i] )</li>";
							}
							if(count($topperNames) == 0){
								echo "No results found.";
							}
							?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="span9"><br/>
			<div class="accordion">
			<?php $courseIds = $courses->getIds(); ?>
			<?php $courseNames = $courses->getNames(); ?>
			<?php $descriptions = $courses->getDescriptions(); ?>
			<?php
			for($i=0; $i<count($courseIds); $i++){
				if($i==0){
					$in = 'in';
				}
				else{
					$in = '';
				}
				echo "
				<div class='accordion-group' id='noBorder'>
					<div class='accordion-heading'>
						<a class='accordion-toggle btn btn-inverse' data-toggle='collapse' href='#collapse$i' id='alignLeft'>
							$courseNames[$i] <i class='icon-reorder'></i>
						</a>
					</div>
					<div id='collapse$i' class='accordion-body collapse $in'>
						<div class='accordion-inner'>".
							$page->replace('<br>','',$descriptions[$i])."<br/><br/>
							<a href='courses.php?courseId=$courseIds[$i]' class='btn btn-primary btn-small'>View Chapters</a>
						</div>
					</div>
				</div>
				";
			}
			?>
			</div>
        </div>
	</div>
</div>
<?php $init->setFooter(); ?>