<?php

class Initialiser{
	public function __construct(){
		$this->setFiles();
	}
	public function setFiles(){
		global $page, $database, $session, $cookie, $mail, $form, $languages, $courses, $syllabus, $notes, $questions, $showcase, $topper;
		require_once('../includes/config.php');
		require_once('../includes/page.php');
		require_once('../includes/database.php');
		require_once('../includes/session.php');
		require_once('../includes/cookie.php');
		require_once('../includes/mail.php');
		require_once('../includes/form.php');
		require_once('../includes/languages.php');
		require_once('../includes/courses.php');
		require_once('../includes/syllabus.php');
		require_once('../includes/notes.php');
		require_once('../includes/questions.php');
		require_once('../includes/showcase.php');
		require_once('../includes/toppers.php');
	}
	public function setHeader(){
		global $page, $database, $session, $cookie, $mail, $form, $languages, $courses, $syllabus, $notes, $questions, $showcase, $topper;
		require_once('header.php');
	}
	public function setLogin(){
		global $page, $database, $session, $cookie, $mail, $form, $languages, $courses, $syllabus, $notes, $questions, $showcase, $topper;
		require_once('authenticate.php');
	}
	public function setFooter(){
		global $page, $database, $session, $cookie, $mail, $form, $languages, $courses, $syllabus, $notes, $questions, $showcase, $topper;
		require_once('footer.php');		
	}
}

$init = new Initialiser();

?>