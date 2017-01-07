<?php 
class AdminController extends BaseController{
	function LoginAction(){
		include VIEW_PATH.'login.html';
	}
	function CheckLoginAction(){
		$user = $_POST['username'];
		$password = $_POST['password'];
		$model = ModelFactory::M('AdminModel');
		if(!($model->CheckAmin($user,$password))){
			$this->GotoUrl('登录失败','?p=back&c=Admin&a=Login',2);
		}
		echo "登录成功";
	}
}
 ?>