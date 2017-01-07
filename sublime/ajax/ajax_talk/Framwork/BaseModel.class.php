<?php
class BaseModel {
	var $db = null; //数据库操作对象
	function __construct(){
		$this->db = mysql_tool::getInstance();
	}
}