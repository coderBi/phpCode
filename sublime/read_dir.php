<?php 
header("content-type:text/html;charset=gbk");
/**
 * 获取一个目录的所有文件
 * @param  string $path 文件路径
 * @param  int $deep 文件深度
 * @return [type]       [description]
 */
function getDirContent($path='.',$deep=0){
	$handle = opendir($path);
	while (false !== ($filename = readdir($handle))) {
		if($filename == '.' || $filename == '..') continue;
		echo str_repeat('&nbsp;', $deep*4),$filename,'<br>';
		//如果当前读到的是目录,递归操作
		if (is_dir($path . '/' . $filename)) {
			getDirContent($path . '/' . $filename,$deep+1);
		}
	}
}

function deleteDir($path){
	$handle = opendir($path);
	while (false !== ($filename = readdir($handle))) {
		if($filename == '.' || $filename == '..') continue;
		echo str_repeat('&nbsp;', $deep*4),$filename,'<br>';
		//如果当前读到的是目录,递归操作
		if (is_dir($path . '/' . $filename)) {
			$current_func = __FUNCTION__;
			$current_func($path . '/' . $filename);
		} else {
			echo 'delete: ',$path . '/' . $filename,'<br>';
			//是文件，直接删除
			unlink($path . '/' . $filename);
		}
	}
	echo 'delete: ',$path,'<br>';
	return rmdir($path);
}
$path = '.';
getDirContent($path,0);
//deleteDir('.');