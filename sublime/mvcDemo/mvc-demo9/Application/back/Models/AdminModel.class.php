<?php 
class AdminModel extends BaseModel{
	function CheckAdmin($user,$password){
		$escape_user = $this->db->escapeString($user);
		$escape_password = $this->db->escapeString($password);
		$sql = "select count(*) from admin_user where name= $escape_user and password=md5($escape_password);";
		$result =  $this->db->fetchOne($sql);
		if($result == 1){
			$sql = "update admin_user set login_times=login_times+1,
			last_login_time=now() where name='$user' and password=password('$password');";
			$this->db->query($sql);
			return true;
		}	
		else
			return false;
	}
	/**
	 * 通过记录的用户名跟密码对，校验是否 合法
	 * @param  [type] $md5_username 加密之后的用户名
	 * @param  [type] $md5_password 加密之后的密码
	 * @return [type]               成功，管理员信息数组；失败，false
	 */
	public function checkRemember($md5_username,$md5_2_password){
		$sql = "SELECT * FROM `admin_user` WHERE md5(concat(`name`,'salt'))='$md5_username' AND 
		md5(concat(`password`,'salt'))='$md5_2_password';";
		return $this->db->fetchRow($sql);
	}
}
 ?>