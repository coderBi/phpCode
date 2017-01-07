<?php
class UserModel extends BaseModel{
	function __construct(){
		parent::__construct();
	}

	/**
	 * 匹配数据库 ajax_user 登录
	 * @param  string $name 用户名,对应数据库的name字段
	 * @param  string $pwd  用户密码，对应数据库的password
	 * @return boolean/Array       如果判断登录成功 返回个人信息数组。 如果失败返回false
	 */
	function login($name,$pwd){
		$sql = "select count(*) as count,name from ajax_user where name='".$name."' and password='".$pwd."';"; 
		$row = $this->db->fetchRow($sql);
		if( 1 != $row['count'] ) return false;
		$result = Array();
		foreach ($row as $key => $value) {
			if($key == 'count') continue;
			$result[$key] = $value;
		}
		return $result;
	}
}