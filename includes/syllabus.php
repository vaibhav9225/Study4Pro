<?php

class SyllabusManager{
	public function insert($chapterNo, $chapterName, $courseId){
		global $database;
		$query = "INSERT INTO `syllabus` VALUES ('','$chapterNo','$chapterName','$courseId')";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function getNames($courseId){
		global $database;
		$result = array();
		$courseId = $database->escapeString($courseId);
		$query = "SELECT `chapterName` FROM `syllabus` WHERE `courseId`='$courseId' ORDER BY `chapterNo`";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data['chapterName'];
		}
		return $result;
	}
	public function chapterCount($courseId){
		global $database;
		$result = array();
		$courseId = $database->escapeString($courseId);
		$query = "SELECT `chapterName` FROM `syllabus` WHERE `courseId`='$courseId' ORDER BY `chapterNo`";
		$sql = $database->query($query,false);
		return $database->numRows($sql);
	}
	public function getNos($courseId){
		global $database;
		$result = array();
		$courseId = $database->escapeString($courseId);
		$query = "SELECT `chapterNo` FROM `syllabus` WHERE `courseId`='$courseId' ORDER BY `chapterNo`";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data['chapterNo'];
		}
		return $result;
	}
	public function getName($courseId, $chapterNo){
		global $database;
		$courseId = $database->escapeString($courseId);
		$chapterNo = $database->escapeString($chapterNo);
		$query = "SELECT `chapterName` FROM `syllabus` WHERE `chapterNo`='$chapterNo' AND `courseId`='$courseId'";
		$sql = $database->query($query,false);
		$data = $database->fetchAssoc($sql);
		$result = $data['chapterName'];
		return $result;
	}
	public function setName($chapterName, $chapterNo, $courseId){
		global $database;
		$courseId = $database->escapeString($courseId);
		$chapterNo = $database->escapeString($chapterNo);
		$chapterName = $database->escapeString($chapterName);
		$query = "UPDATE `syllabus` SET `chapterName`='$courseName' WHERE `chapterNo`='$chapterNo' AND `courseId`='$courseId'";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function deleteChapter($chapterNo, $courseId){
		global $database;
		$courseId = $database->escapeString($courseId);
		$chapterNo = $database->escapeString($chapterNo);
		$query = "DELETE FROM `syllabus` WHERE `chapterNo`='$chapterNo' AND `courseId`='$courseId'";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function delete($courseId){
		global $database;
		$courseId = $database->escapeString($courseId);
		$query = "DELETE FROM `syllabus` WHERE `courseId`='$courseId'";
		$sql = $database->query($query,false);
		return $sql;
	}
}

$syllabus = new SyllabusManager();

?>