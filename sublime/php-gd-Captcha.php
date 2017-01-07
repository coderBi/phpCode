<?php 
//生成验证码
//生成码值
$char_list = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; //所有可能的字符集合
$list_length = strlen($char_list);
$code_length = 4;
$code = '';
for($i = 0; $i < $code_length; ++$i){
	$rand_index = mt_rand(0,$list_length - 1); //随机下标
	$code .= $char_list[$rand_index];
}
//存储验证码值到session里面
session_start();
$_SESSION['code'] = $code;
//确定随机背景图片
$bg_file = './image/captcha/captcha_bg'.mt_rand(1,5).'.jpg';
$img = imagecreatefromjpeg($bg_file); //打开画布
//分配颜色
if (mt_rand(1,2) == 1) {
	$code_color = imagecolorallocate($img, 0, 0, 0); //黑
} else {
	$code_color = imagecolorallocate($img, 255, 255, 255); //白
}
$font = 5; //字体大小
$img_w = imagesx($img);
$img_h = imagesy($img);
$font_w = imagefontwidth($font);
$font_h = imagefontheight($font);
$str_x = ($img_w - $font_w * $code_length) / 2; //验证码值在画布上位置x
$str_y = ($img_h - $font_h) / 2;; //验证码值在画布上位置y
//书写验证码值到画布
imagestring($img, $font, $str_x, $str_y, $code, $code_color);
header('Content-Type:image/png');
imagepng($img);
//销毁画布
imagedestroy($img);
 ?>