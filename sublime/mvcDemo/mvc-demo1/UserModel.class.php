<?php 
require_once './mysqlDB.class.php';
class UserModel{
	private $config = array('host'=>'localhost','name'=>'root','password'=>'','charset'=>'utf8','dbName'=>'learn_mysql');
	function GetAllUsers(){
		$sql = "select * from user";
		$db = mysql_tools::GetInstance($this->config);
		$data = $db->GetRows($sql);
		return $data;
	}
	function GetUserCount(){
		$sql = "select count(*)  from user";
		$db = mysql_tools::GetInstance($this->config);
		$data = $db->GetOneData($sql);
		return $data;
	}
}
 ?>