<?php 
class Captcha {
	/**
	 * 生成验证码
	 * @param  integer $code_length 验证码长度，默认是4
	 */
	public function makeImage($code_length=4){
		//生成验证码
		//生成码值
		$char_list = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; //所有可能的字符集合
		$list_length = strlen($char_list);
		$code = '';
		for($i = 0; $i < $code_length; ++$i){
			$rand_index = mt_rand(0,$list_length - 1); //随机下标
			$code .= $char_list[$rand_index];
		}
		//存储验证码值到session里面
		@session_start();
		$_SESSION['captcha_code'] = $code;
		//确定随机背景图片
		$bg_file = FRAMEWORK.'captcha/captcha_bg'.mt_rand(1,5).'.jpg';
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
		alert('gaga');
		//销毁画布
		imagedestroy($img);
	}
	/**
	 * 验证码校验
	 * @param  string $request_code 提交表单是填写的验证码	
	 * @return bool              匹配返回true，失败false
	 */
	public function checkCode($request_code='') {
		@session_start();
		//用户填写的是否存在 && session中是否存在  && 相等
		$result = isset($request_code) && isset($_SESSION['captcha_code']) && 
		strtolower($request_code) == strtolower($_SESSION['captcha_code']);
		//不论正确与否，删除session里面的验证码
		if(isset($_SESSION['captcha_code'])){
			unset($_SESSION['captcha_code']);
		}
		return $result;
	}
}
 ?>