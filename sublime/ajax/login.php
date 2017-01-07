<?php
//设置上传文件最大限制
ini_set('post_max_size', "300M");
ini_set('upload_max_filesize', "250M");

echo 'post:';
print_r($_POST);
echo "<br>file:";
print_r($_FILES);

//处理上传文件，移动到 ./upload/name
if( !isset($_FILES['userpic']) ) die("FILES 索引错误");
$path='./upload/';
$file = $_FILES['userpic'];

if($file['error'] > 0) die('附件上传失败');

 //操作系统是gbk，php内置是utf8，考虑到可能包含中文，这里，将新的文件名转成gbk
move_uploaded_file($file['tmp_name'], iconv("utf-8", "gbk", $path.$file['name'])); 