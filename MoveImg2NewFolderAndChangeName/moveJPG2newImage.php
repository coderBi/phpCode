<?php
function getDirContent($path='.',$deep=0,$name=0){
	$handle = opendir($path);
	while (false !== ($filename = readdir($handle))) {
		if($filename == '.' || $filename == '..') continue;
		//echo str_repeat('&nbsp;', $deep*4),$filename,'<br>';
		//如果当前读到的是目录,递归操作
		if (is_dir($path . '/' . $filename)) {
			getDirContent($path . '/' . $filename,$deep+1,$name);
		} else{
			//在本目录下面拷贝并且命名
			$trueName = $name.".jpg";
			$write = fopen("./newImage/".$trueName,"w");
			$read = fopen($path."/".$filename,"r");
			while($content = fgets($read,1024 + 1)){
				fwrite($write,$content);
			}
			$name++;
		}
	}
}

$path = './image';
getDirContent($path,0,0);