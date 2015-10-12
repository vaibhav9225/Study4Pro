<?php

class PageManager{
	public $redirectedFrom;
	public $isRedirected = false;
	public function __construct(){
		isset($_SERVER['HTTP_REFERER']) ? $redirectedFrom = $_SERVER['HTTP_REFERER'] : $redirectedFrom = '';
		//$this->error();
	}
	public function redirect($location=null){
		$this->isRedirected = true;
		$location == null ? $location = $redirectedFrom : null;
		header("Location: $location");
		//die('The page redirection failed.');
	}
	public function error($level=0){
		error_reporting($level);
	}
	public function encrypt($string){
		return md5($string);
	}
	public function strip($string){
		return stripslashes($string);
	}
	public function capitalize($string){
		return ucwords($string);
	}
	public function lower($string){
		return strtolower($string);
	}
	public function random($min, $max){
		return rand($min, $max);
	}
	public function check($string){
		if(isset($string) and !empty($string)){
			return true;
		}
		else{
			return false;
		}
	}
	public function upper($string){
		return strtoupper($string);
	}
	public function cut($string, $start, $end){
		return substr($string, $start, $end);
	}
	public function shuffle($string){
		return str_shuffle($string);
	}
	public function split($object, $string){
		return explode($object, $string);
	}
	public function join($object, $array){
		return implode($object, $array);
	}
	public function replace($replace, $replacement, $string){
		return str_replace($replace, $replacement, $string);
	}
	public function end($string){
		global $page, $database, $session, $cookie, $mail, $form, $languages, $courses, $syllabus, $notes, $questions, $showcase, $topper;
		require_once('header.php');
		echo "<div class='container'><br><br><ul><li>$string</li></ul><br></div>";
		require_once('footer.php');
		die();
	}
	public function stop(){
		require_once('footer.php');
		die();
	}
	public function kill($legend, $string){
		global $page, $database, $session, $cookie, $mail, $form, $languages, $courses, $syllabus, $notes, $questions, $showcase, $topper;
		require_once('header.php');
		echo "<div class='container'><br><legend>$legend</legend><ul><li>$string</li></ul><br></div>";
		require_once('footer.php');
		die();
	}
	public function magnify(){
		ini_set('post_max_size','5000M');
		ini_set('upload_max_filesize','5000M');
		ini_set('memory_limit','5000M');
		ini_set('session.gc_maxlifetime',5000);
		ini_set('max_input_time',5000);
		ini_set('max_execution_time',5000);
	}
}

$page = new PageManager();

?>