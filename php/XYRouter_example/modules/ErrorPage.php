<?php
class Page404{
	function __show(){
		header("HTTP/1.0 404 Not Found");
		echo "404 page";
	}
}
class Page500{
	function __show($param){
		header("HTTP/1.0 500 Server Internal Error");
		echo "SERVER Say:<span style='color:#f00;font-weight:bold;'>".$param->getMessage()."</span>";
	}
}

Router::getInstance()->addRoute("Page404","__CODE_404");
Router::getInstance()->addRoute("Page500","__CODE_500");