<?php

function str_endwith($str,$search){
	return preg_match('['.$str.'$]', $search);
	if(substr($str, 0,0-strlen($search)) == $search){
		return true;
	}
	return false;
}

function str_startwith($str,$search){
	return preg_match('[^'.$str.']', $search);
}

/**
 * 获取文件名后缀
 */
function getFileSuffix($fileName) {
	return strtolower(pathinfo($fileName,  PATHINFO_EXTENSION));
}


function getDirFiles($dirpath,$filter = ''){
	$dir = opendir($dirpath);
	$files = array();
	while (($file = readdir($dir)) !== false)
	{
		if(!str_startwith($file, '.') && !str_startwith($file, '..')){
			if($filter){
				if(preg_match('/'.$filter.'/', $file)){
					$files[] = $file;
				}
			}else{
				$files[] = $file;
			}
		}
	}
	closedir($dir);
	return $files;
}