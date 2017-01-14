<?php
namespace Home\Controller;
use Think\Controller;

class VarController extends Controller{
	//强制转换  邮箱验证  path获取  正则表达式过滤
	public function var1(){
		$id = I('id/d'); //获取id并且强制转换为整型
		$email = I('email', 'a@a.com','validate_email'); //邮箱验证，默认
		$path = I('path.0'); //获取pathinfo中第一个参数
		$reg = I('reg','1','/^\d{5,}$/'); //正则判断
		$float = I('f/f', '0.0');
		echo '<pre>';
		echo 'id: '; print_r($id); echo '<br>';
		echo 'email: '; print_r($email); echo '<br>';
		echo 'path: '; print_r($path); echo '<br>';
		echo 'reg: '; print_r($reg); echo '<br>';
		echo 'float: '; print_r($float); echo '<br>';
		echo '</pre>';
	}

	//各个范围数组
	public function var2(){
		$session = I('session.'); //获取整个session
		$cookie = I('cookie.'); //获取整个cookie
		$server = I('server.'); //获取整个server
		$put = I('put.');
		$get = I('get.');
		$post = I('post.');
		$param = I('param.');
		echo '<pre>';
		echo 'session: '; print_r($session); echo '<br>';
		echo 'cookie: '; print_r($cookie); echo '<br>';
		echo 'server: '; print_r($server); echo '<br>';
		echo 'put: '; print_r($put); echo '<br>';
		echo 'get: '; print_r($get); echo '<br>';
		echo 'post: '; print_r($post); echo '<br>';
		echo 'param: '; print_r($param); echo '<br>';
		echo '</pre>';
	}

	//php内置filter测试
	public function phpFilter(){
		//filter_var()验证成功返回验证的对象，验证失败返回false
		var_dump(filter_var('alfjlajlf',FILTER_VALIDATE_EMAIL)); //验证邮箱
		echo '<br>';
		var_dump(filter_var('http://www.baidu.com',FILTER_VALIDATE_URL)); //验证url
		echo '<br>';
		var_dump(filter_var('192.168.1.1', FILTER_VALIDATE_IP)); //验证ipv4
		echo '<br>';
		var_dump(filter_var('2001:dd2:2de::e13')); //验证ipv6
		echo '<br>';
		var_dump(filter_var(50,FILTER_VALIDATE_INT,array('options'=>array('min_range'=>10, 'max_range'=>100)))); //验证整数，区间在10~100
		echo '<br>';
		var_dump(filter_var(1.0,FILTER_VALIDATE_FLOAT)); //验证浮点
	}
}