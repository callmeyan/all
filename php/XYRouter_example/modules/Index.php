<?php
class IndexController{
	function __show(){
		echo "welcome";
	}
}
Router::getInstance()->addRoute("IndexController","__HOME");