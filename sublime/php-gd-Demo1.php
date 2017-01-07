<?php 
$width = 500;
$height = 300;
//创建24位色
$img = imagecreatetruecolor($width, $height);
//分配颜色
$blue = imagecolorallocate($img, 0, 0, 0xff);
//颜色填充
imagefill($img, 0, 0, $blue);
//打印图片到浏览器
header('Content-Type:image/png');
imagepng($img);
//销毁画布
imagedestroy($img);
 ?>