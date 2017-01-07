<?php
namespace Home\Controller;
use Think\Controller;
//前台用户控制器
class UserController extends Controller {
	//登录
	function login() {
		$this->display(); //display方法如果参数名不写，代表视图名跟当前方法名一样。目录在 view/控制器/方法名.html
	}
}