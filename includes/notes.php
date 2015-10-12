<?php

class NotesManager{
	public function insert($title, $filename, $chapterNo, $courseId){
		global $database;
		$query = "INSERT INTO `notes` VALUES ('','$title','$filename','$chapterNo','$courseId')";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function getFilenames($chapterNo, $courseId){
		global $database;
		$result = array();
		$courseId = $database->escapeString($courseId);
		$chapterNo = $database->escapeString($chapterNo);
		$query = "SELECT `filename` FROM `notes` WHERE `chapterNo`='$chapterNo' AND `courseId`='$courseId' GROUP BY `filename` ORDER BY `id` DESC";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data['filename'];
		}
		return $result;
	}
	public function notesCount($chapterNo, $courseId){
		global $database;
		$courseId = $database->escapeString($courseId);
		$chapterNo = $database->escapeString($chapterNo);
		$query = "SELECT `id` FROM `notes` WHERE `chapterNo`='$chapterNo' AND `courseId`='$courseId'";
		$sql = $database->query($query,false);
		return $database->numRows($sql);
	}
	public function getTitles($chapterNo, $courseId){
		global $database;
		$result = array();
		$courseId = $database->escapeString($courseId);
		$chapterNo = $database->escapeString($chapterNo);
		$query = "SELECT `title` FROM `notes` WHERE `chapterNo`='$chapterNo' AND `courseId`='$courseId' GROUP BY `filename` ORDER BY `id` DESC";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data['title'];
		}
		return $result;
	}
	public function delete($filename){
		global $database;
		$query = "DELETE FROM `notes` WHERE `filename`='$filename'";
		$sql = $database->query($query,false);
		return $sql;
	}
}

$notes = new NotesManager();

?>