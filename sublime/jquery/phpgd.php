<?php
//利用php绘制一个图片

$img = imagecreatetruecolor(300,200);  //穿件画布
$pen = imagecolorallocate($img,0,50,0);  //创建画笔
imagefill($img,0,0,$pen);  ///填充画布

//imagefilledrectangle($img,0,0,300,200,$pen);  ///填充矩形

sleep(4);  //暂停4s

header('content-type:image/jpeg');
imagejpeg($img);  //输出图片
imagedestroy($img);   //销毁画布