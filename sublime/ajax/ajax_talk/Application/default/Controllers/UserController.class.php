<?php
class UserController extends ModuleController{

	function __contruct(){
		parent::__contruct();
	}

	/**
	 * 检查登录状态
	 * @return json obj  如果已经登录，返回session里面的name，否则返回 “”
	 */
	function checkLoginAction(){
		$name = !empty($_SESSION['name']) ? $_SESSION['name'] : '';
		echo json_encode($name);
	}

	/**
	 * 登录
	 * @return boolean 成功匹配数据库返回true  否则返回false
	 */
	function loginAction(){
		//获取页面的提交的 u pw。 分别表示用户名跟密码
		if(empty($_GET['u'])) echo json_encode("");
		$name = $_GET['u'];
		if(empty($_GET['pw'])) echo json_encode("");
		$pwd = $_GET['pw'];

		//调用usermodel 查询数据库
		$userModel = new UserModel();
		$result =  $userModel->login($name,$pwd);
		if($result) $_SESSION['name'] = $result['name'];
		echo json_encode($result);
	}

	/**
	 * 登出
	 * @return boolean 成功true 失败false
	 */
	function logoutAction(){
		unset( $_SESSION['name'] );
	}
}