<?php

class TopperManager{
	public function insert($name, $score, $company, $branch, $courseId){
		global $database;
		$query = "INSERT INTO `topper` VALUES ('','$name','$score','$company','$branch','$courseId')";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function getNames(){
		global $database, $page;
		$result = array();
		$query = "SELECT `name` FROM `topper` WHERE 1 ORDER BY `score` DESC LIMIT 0, 10";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $page->strip($data['name']);
		}
		return $result;
	}
	public function getScores(){
		global $database, $page;
		$result = array();
		$query = "SELECT `score` FROM `topper` WHERE 1 ORDER BY `score` DESC LIMIT 0, 10";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $page->strip($data['score']);
		}
		return $result;
	}
	public function getCompany(){
		global $database, $page;
		$result = array();
		$query = "SELECT `company` FROM `topper` WHERE 1 ORDER BY `score` DESC LIMIT 0, 10";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $page->strip($data['company']);
		}
		return $result;
	}
	public function getBranch(){
		global $database, $page;
		$result = array();
		$query = "SELECT `branch` FROM `topper` WHERE 1 ORDER BY `score` DESC LIMIT 0, 10";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $page->strip($data['branch']);
		}
		return $result;
	}
	public function delete($updateId){
		global $database;
		$query = "DELETE FROM `topper` WHERE `id`='$updateId'";
		$sql = $database->query($query,false);
		return $sql;
	}
}

$topper = new TopperManager();

?>