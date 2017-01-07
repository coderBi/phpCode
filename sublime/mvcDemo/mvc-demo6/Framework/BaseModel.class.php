<?php 

class BaseModel{
	protected $db = null;
	function __construct(){
		$config = array('host'=>'localhost',
						'name'=>'root',
						'password'=>'',
						'charset'=>'utf8',
						'dbName'=>'learn_mysql',);
		$this->db = mysql_tools::GetInstance($config);
	}
}
 ?>