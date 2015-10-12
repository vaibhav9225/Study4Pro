<?php

class MailManager{
	private $emailTo;
	private $emailFrom;
	private $emailSubject;
	private $emailBody;
	public function to($to){
		$this->emailTo = $to;
	}
	public function from($from){
		$this->emailFrom = $from;
	}
	public function subject($subject){
		$this->emailSubject = $subject;
	}
	public function body($body){
		$this->emailBody = $body;
	}
	public function send(){
		global $page;
		$page->error(0);
		if(isset($this->emailTo,$this->emailSubject,$this->emailBody,$this->emailFrom)){
			mail($this->emailTo,$this->emailSubject,$this->emailBody,$this->emailFrom);
		}
		$page->error(-1);
	}
}

$mail = new MailManager();

?>