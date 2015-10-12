<?php

class ShowcaseManager{
	public function insert($update){
		global $database;
		$query = "INSERT INTO `showcase` VALUES ('','$update')";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function getUpdates(){
		global $database, $page;
		$result = array();
		$query = "SELECT `update` FROM `showcase` WHERE 1 ORDER BY `id` DESC LIMIT 0, 10";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $page->strip($data['update']);
		}
		return $result;
	}
	public function delete($updateId){
		global $database;
		$query = "DELETE FROM `showcase` WHERE `id`='$updateId'";
		$sql = $database->query($query,false);
		return $sql;
	}
}

$showcase = new ShowcaseManager();

?>