<?php require_once '../../includes/adminInitialise.php'; ?>
<?php $init->setHeader(); ?>
<div class="container"><br>
	<legend>Uploaded Files</legend>
	<h4>Uploaded Questions <i class="icon-caret-right"></i></h4>
	<table class="table table-hover">
		<tr><th>#</th><th>Chapter No</th><th>Course Name</th><th>Total</th></tr>
		<?php
		$filename = $questions->getFilenames();
		for($i=0,$j=1; $i<count($filename); $i++,$j++){
			$chapterNo = $database->otherValue('questions','filename',$filename[$i],'chapterNo');
			$courseId = $database->otherValue('questions','filename',$filename[$i],'courseId');
			$courseName = $database->otherValue('courses','id',$courseId,'courseName');
			$total = $questions->fileCount($filename[$i]);
			echo "<tr>
				<td>$j</td>
				<td>$chapterNo
					<div id='tableLinks'>
						<a href='uploads/$filename[$i]'>Export File</a>
					</div>
				</td>
				<td>$courseName</td>
				<td>$total</td>
			</tr>";
		}
		?>
	</table>
</div>
<?php $init->setFooter(); ?>