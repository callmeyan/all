<?php
class AppException extends Exception{
	function AppException($message,$code = -1){
		$this->code = $code;
		$this->message = $message;
	}
	function __construct($message, $code = -1) {
		$this->AppException($message, $code);
	}
}
class RouterException extends AppException{

	function RouterException($message){
		parent::__construct($message,1001);
	}
}