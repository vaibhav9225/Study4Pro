<?php

class CourseManager{
	public function insert($courseName, $description){
		global $database;
		$courseName = $database->escapeString($courseName);
		$description = $database->escapeString($description);
		$query = "INSERT INTO `courses` VALUES ('','$courseName','$description')";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function getNames(){
		global $database;
		$result = array();
		$query = "SELECT `courseName` FROM `courses` WHERE 1 ORDER BY `courseName`";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data['courseName'];
		}
		return $result;
	}
	public function getDescriptions(){
		global $database, $page;
		$result = array();
		$query = "SELECT `description` FROM `courses` WHERE 1 ORDER BY `courseName`";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $page->strip(
				$page->replace('\r\n',"<br>",
				$page->replace("\n","<br>",
				$data['description']))); 
		}
		return $result;
	}
	public function getIds(){
		global $database;
		$result = array();
		$query = "SELECT `id` FROM `courses` WHERE 1 ORDER BY `courseName`";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data['id'];
		}
		return $result;
	}
	public function getName($courseId){
		global $database;
		$courseId = $database->escapeString($courseId);
		$query = "SELECT `courseName` FROM `courses` WHERE `id`='$courseId'";
		$sql = $database->query($query,false);
		$data = $database->fetchAssoc($sql);
		$result = $data['courseName'];
		return $result;
	}
	public function getDescription($courseId){
		global $database;
		$courseId = $database->escapeString($courseId);
		$query = "SELECT `description` FROM `courses` WHERE `id`='$courseId'";
		$sql = $database->query($query,false);
		$data = $database->fetchAssoc($sql);
		$result = $data['description'];
		return $result;
	}
	public function setName($courseName, $courseId){
		global $database;
		$courseId = $database->escapeString($courseId);
		$courseName = $database->escapeString($courseName);
		$query = "UPDATE `courses` SET `courseName`='$courseName' WHERE `id`='$courseId'";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function delete($courseId){
		global $database;
		$courseId = $database->escapeString($courseId);
		$query = "DELETE FROM `courses` WHERE `id`='$courseId'";
		$sql = $database->query($query,false);
		return $sql;
	}
}

$courses = new CourseManager();

?>