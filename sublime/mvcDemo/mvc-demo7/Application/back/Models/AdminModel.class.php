<?php 
class AdminModel extends BaseModel{
	function CheckAmin($user,$password){
		$sql = 'select count(*) from admin_user where name="'.$user.'" and password=password('
		."'$password'".');';
		$result =  $this->db->GetOneData($sql);
		if($result == 1){
			$sql = "update admin_user set login_times=login_times+1,
			last_login_time=now() where name='$user' and password=password('$password');";
			$this->db->exec($sql);
			return true;
		}	
		else
			return false;
	}
}
 ?>