<?php 
require './UserModel.class.php';

//实例化模型类，取得数据
$obj_user = new UserModel();
$data1 = $obj_user->GetAllUsers();
$data2 = $obj_user->GetUserCount();
 
 //载入视图文件
include './Userlist_View.html'
 ?>