<?php

class LanguageManager{
	public function insert($language){
		global $database;
		$query = "INSERT INTO `languages` VALUES ('','$language')";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function getIds(){
		global $database;
		$result = array();
		$query = "SELECT `id` FROM `languages` WHERE 1 ORDER BY `language`";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data['id'];
		}
		return $result;
	}
	public function getNames(){
		global $database;
		$result = array();
		$query = "SELECT `language` FROM `languages` WHERE 1 ORDER BY `language`";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data['language'];
		}
		return $result;
	}
	public function delete($languageId){
		global $database;
		$query = "DELETE FROM `languages` WHERE `id`='$languageId'";
		$sql = $database->query($query,false);
		return $sql;
	}
}

$languages = new LanguageManager();

?>