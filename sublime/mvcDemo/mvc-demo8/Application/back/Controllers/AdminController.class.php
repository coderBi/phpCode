<?php 
class AdminController extends ModuleController {
	function LoginAction(){
		include VIEW_PATH.'login.html';
	}
	function CheckAction(){
		//收集请求表单数据
		$user = $_POST['username'];
		$password = $_POST['password'];
		//利用模型处理，校验是否合法
		$model = ModelFactory::M('AdminModel');
		if(!($model->CheckAdmin($user,$password))){
			//登录失败，提示失败信息
			$this->GotoUrl('登录失败','?p=back&c=Admin&a=Login',2);
		} else {
			//登录成功
			//记录登录状态
			//是否需要
			if(isset($_POST['remember'])){
				//需要
				setcookie('username',md5($user.'salt'),time()+30*24*3600,'/');
				setcookie('password',md5(md5($password).'salt'),time()+30*24*3600,'/');
			} else {
				//不需要
				//如果之前设置过用户名密码的cookie，就删除掉
				setcookie('username',md5($user.'salt'),time()-1,'/');
				setcookie('password',md5(md5($password).'salt'),time()-1,'/');
			}
			//存贮session，立即跳转到后台首页
			$_SESSION['username'] = $user;
			$this->_jumpNow('?p=back&c=Manage&a=index');
		}
	}
}
 ?>