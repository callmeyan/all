<?php
/**
 * User: yancheng
 * DateTime: 13-10-25上午10:34
 * Description
 */

class Files {
	
    public function __handle(){
        echo "Files";
    }
    public function index(){
        echo "Files.Index<hr>";
        print_r($_REQUEST);
    }
}

Router::getInstance()->addRoute("Files","files");