<?php 
require_once './BaseModel.class.php';

class UserModel extends BaseModel{
	function GetAllUsers(){
		$sql = "select * from user";
		$data = $this->db->GetRows($sql);
		return $data;
	}
	function GetUserCount(){
		$sql = "select count(*)  from user";
		$data = $this->db->GetOneData($sql);
		return $data;
	}
	function DeleteById($id){
		$sql = "delete from user where id=".$id.';';	
		return $this->db->exec($sql);
	}
	function GetUserInfoById($id){
		$sql = "select * from user where id=".$id.';';
		return $this->db->GetOneRow($sql);
	}
	function InsertUser($arr){
		$sql = "insert into user(name,password,age,xueli,fav,aspect) values(".
			"'".$arr['name']."'".','."'".$arr['password']."'".','.$arr['age'].','."'".$arr['xueli']."'".
			','.$arr['fav'].','."'".$arr['aspect']."'".");";
		return $this->db->exec($sql);
	}
}
 ?>