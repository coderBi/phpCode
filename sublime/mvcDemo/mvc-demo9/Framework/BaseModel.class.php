<?php 

class BaseModel{
	protected $db = null;
	function __construct(){
		$config = array('host'=>'localhost',
						'user'=>'root',
						'password'=>'123',
						'charset'=>'utf8',
						'dbName'=>'learn_mysql',);
		//两种数据库操作方式，可以进行切换
		//pdo扩展是否打开
		if(extension_loaded('pdo_mysql')){
			//开启了
			$this->db = PDODB::GetInstance($config);
		} else {
			//没开启
			//是否开启了mysql扩展
			if(extension_loaded('mysql')) {
				//mysql扩展开启了 
				$this->db = mysql_tools::GetInstance($config);
			} else {
				//没开启
				die("无可用的mysql数据库操作扩展");
			}
			
		}
	}
}
 ?>