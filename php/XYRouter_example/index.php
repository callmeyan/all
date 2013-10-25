<?php
/**
 * User: yancheng
 * DateTime: 13-10-25上午10:30
 * Description
 */
require '../XYRouter/Router.php';

Router::getInstance()->initMoudule("modules");
try {
	Router::getInstance()->route();
} catch (RouterException $e) {
	Router::getInstance()->showErrorPage(404);
} catch (Exception $e) {	
	Router::getInstance()->showErrorPage(500,$e);
}