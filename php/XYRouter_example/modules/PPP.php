<?php
class PPP{
	function __handle($param){
		print_r($param);
	}
}
Router::getInstance()->addPregRoute("PPP","^/core/type/(\d+)/page/(\d+)$");