<?php 
class UserController extends BaseController{
	/**
	 * 删除一个用户
	 */
	function delAction(){
		$obj_user = ModelFactory::M('UserModel');
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			if(!($obj_user->DeleteById($id))){
				die("删除操作执行失败".'<a href="?">返回</a>');
			}
		}
		$this->indexAction();
	}
	/**
	 * 显示一个用户的详细信息
	 */
	function detailAction(){
		$obj_user = ModelFactory::M('UserModel');
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			if(!($result = $obj_user->GetUserInfoById($id))){
				die("显示详细信息操作执行失败".'<a href="?">返回</a>');
			}
			include VIEW_PATH.'ShowUserInfo.html';
		} else {
			//$this->indexAction();
			$this->GotoUrl("执行失败","?",5);
		}
	}
	/**
	 * 展示添加用户表单
	 */
	function ShowFormAction(){
		include VIEW_PATH.'form_view.html';
	}
	/**
	 * 添加一个用户
	 */
	function AddUserAction(){
		$obj_user = ModelFactory::M('UserModel');
		$newUser = array();
		$newUser['name'] = isset($_POST['name']) ? $_POST['name'] : '';
		$newUser['password'] = isset($_POST['password']) ? $_POST['password'] : '';
		$newUser['age'] = isset($_POST['age']) ? $_POST['age'] : 0;
		if(isset($_POST['xueli'])){
			switch ($_POST['xueli']) {
				case 0:
					$newUser['xueli'] = '';
					break;
				case 1:
					$newUser['xueli'] = '中学';
					break;
				case 2:
					$newUser['xueli'] = '大学';
					break;
				default:
					$newUser['xueli'] = '';
					break;
			}
		} else{
			$newUser['xueli'] = '';
		}
		$newUser['fav'] = isset($_POST['fav']) ? array_sum($_POST['fav']) : 0;
		if(isset($_POST['aspect'])){
			$aspect = array('东北','华北','西北','华东','华南','华西');
			$newUser['aspect'] = $aspect[$_POST['aspect'] -1];
		} else{
			$newUser['aspect'] = '';
		}
		$result = $obj_user->InsertUser($newUser);
		if($result == false){
			die("添加操作执行失败".'<a href="?">返回</a>');
		}
		$this->indexAction();
	}
	/**
	 * 默认index页面，展示所有用户信息列表
	 */
	function indexAction(){
		$obj_user = ModelFactory::M('UserModel');
		$data1 = $obj_user->GetAllUsers();
		$data2 = $obj_user->GetUserCount();
		 
		 //载入视图文件
		include VIEW_PATH.'Userlist_View.html';
	}
	/**
	 * 编辑一个用户信息
	 */
	function editAction(){
		$obj_user = ModelFactory::M('UserModel');
		if(isset($_GET['id'])){
			if(!($user = $obj_user->GetUserInfoById($_GET['id']))){
				die("修改操作执行失败".'<a href="?">返回</a>');
			}
			include VIEW_PATH.'user_form_view.html';
		} else {
			$this->indexAction();
		}
	}
	/**
	 * 更新一个用户信息
	 */
	function UpdateUserAction(){
		$obj_user = ModelFactory::M('UserModel');
		$UpdateUser = array();
		$UpdateUser['id'] = isset($_POST['id']) ? $_POST['id'] : '';
		$UpdateUser['name'] = isset($_POST['name']) ? $_POST['name'] : '';
		$UpdateUser['password'] = isset($_POST['password']) ? $_POST['password'] : '';
		$UpdateUser['age'] = isset($_POST['age']) ? $_POST['age'] : 0;
		if(isset($_POST['xueli'])){
			switch ($_POST['xueli']) {
				case 0:
					$UpdateUser['xueli'] = '';
					break;
				case 1:
					$UpdateUser['xueli'] = '中学';
					break;
				case 2:
					$UpdateUser['xueli'] = '大学';
					break;
				default:
					$UpdateUser['xueli'] = '';
					break;
			}
		} else{
			$UpdateUser['xueli'] = '';
		}
		$UpdateUser['fav'] = isset($_POST['fav']) ? array_sum($_POST['fav']) : 0;
		if(isset($_POST['aspect'])){
			$aspect = array('东北','华北','西北','华东','华南','华西');
			$UpdateUser['aspect'] = $aspect[$_POST['aspect'] -1];
		} else{
			$UpdateUser['aspect'] = '';
		}
		if(!$obj_user->UpdateUser($UpdateUser)){
			die("修改操作执行失败".'<a href="?">返回</a>');
		}
		$this->indexAction();
	}
}
 ?>