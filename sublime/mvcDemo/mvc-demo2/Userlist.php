<?php 
require './UserModel.class.php';
require_once './ModelFactory.class.php';

$flag = 0;
//实例化模型类
$obj_user = ModelFactory::M('UserModel');
if (isset($_GET['action']) && $_GET['action'] =='del') {
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		if(!($obj_user->DeleteById($id))){
			die("删除操作执行失败".'<a href="?">返回</a>');
		}
	}

} elseif (isset($_GET['action']) && $_GET['action'] =='detail') {
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		if(!($result = $obj_user->GetUserInfoById($id))){
			die("删除操作执行失败".'<a href="?">返回</a>');
		}
		$flag = 1;
	}
} elseif (isset($_GET['action']) && $_GET['action'] =='ShowForm') {
	$flag = 2;
} elseif (isset($_GET['action']) && $_GET['action'] =='AddUser') {
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
}

if($flag == 1){
	include './ShowUserInfo.html';
} elseif ($flag == 2) {
	include './form_view.html';
}else {
	$data1 = $obj_user->GetAllUsers();
	$data2 = $obj_user->GetUserCount();
	 
	 //载入视图文件
	include './Userlist_View.html';
}
 ?>