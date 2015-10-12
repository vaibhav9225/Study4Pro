<?php

class QuestionManager{
	private $languageId;
	public function __construct(){
		global $session, $cookie;
		$cookie->checkValue('languageId') ? $this->languageId = $session->setValue('languageId', $cookie->getValue('languageId')) : null;
		$session->checkValue('languageId') ? $this->languageId = $session->getValue('languageId') : $this->languageId = 1;
	}
	public function insert($filename, $question, $option1, $option2, $option3, $option4, $answer, $chapterNo, $languageId, $courseId){
		global $database;
		$query = "INSERT INTO `questions` VALUES ('','$filename','$question','$option1','$option2','$option3','$option4','$answer','$chapterNo','$languageId','$courseId')";
		$sql = $database->query($query,false);
		return $sql;
	}
	public function getFields($chapterNo, $courseId, $field){
		global $database, $page;
		$result = array();
		$courseId = $database->escapeString($courseId);
		$chapterNo = $database->escapeString($chapterNo);
		$languageId = $database->escapeString($this->languageId);
		$query = "SELECT `$field` FROM `questions` WHERE `chapterNo`='$chapterNo' AND `courseId`='$courseId' AND `languageId`='$languageId' ORDER BY `id` DESC";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $page->strip($data[$field]);
		}
		return $result;
	}
	public function getRow($questionId){
		global $database;
		$query = "SELECT * FROM `questions` WHERE `id`='$questionId'";
		$sql = $database->query($query,false);
		$data = $database->fetchAssoc($sql);
		return $data;
	}
	public function getTestQuestions($courseId, $field, $limit=50, $random=true){
		global $database;
		$result = array();
		$courseId = $database->escapeString($courseId);
		$languageId = $database->escapeString($this->languageId);
		$random ? $append = "ORDER BY RAND()" : $append = "ORDER BY `id`";
		$query = "SELECT `$field` FROM `questions` WHERE `courseId`='$courseId' AND `languageId`='$languageId' $append LIMIT 0,$limit";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data[$field];
		}
		return $result;
	}
	public function getFilenames(){
		global $database;
		$result = array();
		$query = "SELECT `filename` FROM `questions` WHERE 1 GROUP BY `filename` ORDER BY `id` DESC";
		$sql = $database->query($query,false);
		while($data = $database->fetchAssoc($sql)){
			$result[] = $data['filename'];
		}
		return $result;
	}
	public function questionCount($chapterNo, $courseId){
		global $database;
		$courseId = $database->escapeString($courseId);
		$chapterNo = $database->escapeString($chapterNo);
		$languageId = $database->escapeString($this->languageId);
		$query = "SELECT `id` FROM `questions` WHERE `chapterNo`='$chapterNo' AND `courseId`='$courseId' AND `languageId`='$languageId'";
		$sql = $database->query($query,false);
		return $database->numRows($sql);
	}
	public function fileCount($filename){
		global $database;
		$query = "SELECT `id` FROM `questions` WHERE `filename`='$filename'";
		$sql = $database->query($query,false);
		return $database->numRows($sql);
	}
	public function delete($filename){
		global $database;
		$query = "DELETE FROM `questions` WHERE `filename`='$filename'";
		$sql = $database->query($query,false);
		return $sql;
	}
}

$questions = new QuestionManager();

?>