<?php require_once '../../includes/adminInitialise.php'; ?>
<?php $init->setLogin(); ?>
<?php $init->setHeader(); ?>
<?php
$query = "SELECT * FROM `users` WHERE 1";
$sql = $database->query($query);
$userCount = $database->numRows();
$query = "SELECT * FROM `admins` WHERE 1";
$sql = $database->query($query);
$adminCount = $database->numRows();
$query = "SELECT * FROM `questions` WHERE 1";
$sql = $database->query($query);
$questionCount = $database->numRows();
$query = "SELECT * FROM `notes` WHERE 1";
$sql = $database->query($query);
$notesCount = $database->numRows();
?>
<div class="container"><br>
	<div class="row">
		<div class="span4">
			<legend>Statistics</legend>
			<h4>Admins <i class="icon-caret-right"></i></h4>
			<p>Total Admins : <?php echo $adminCount; ?></p>
			<h4>Users <i class="icon-caret-right"></i></h4>
			<p>Total Users : <?php echo $userCount; ?></p>
			<h4>Courses <i class="icon-caret-right"></i></h4>
			<p>Total Courses : <?php echo count($courses->getIds()); ?></p>
			<h4>Questions <i class="icon-caret-right"></i></h4>
			<p>Total Questions : <?php echo $questionCount; ?></p>
			<h4>Notes <i class="icon-caret-right"></i></h4>
			<p>Total Notes : <?php echo $notesCount; ?></p>
		</div>
		<div class="span7">
			<legend>Added Courses</legend>
			<table class="table table-hover">
				<tr><th>#</th><th>Course Names</th><th>Total Chapters</th></tr>
				<?php
				$courseNames = $courses->getNames();
				$courseIds = $courses->getIds();
				if(count($courseNames) == 0){
					echo '<tr><td colspan="2">No courses have been added yet.</td></tr>';
				}
				for($i=1,$j=0; $i<=count($courseNames); $i++,$j++){
					echo "
						<tr>
							<td>$i</td>
							<td>$courseNames[$j]</td>
							<td>".count($syllabus->getNames($courseIds[$j]))."</td>
						</tr>";
				}
				?>
			</table>
		</div>
	</div>
</div>
<?php $init->setFooter(); ?>