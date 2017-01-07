<?php

class mysql_tool {
	private $link; // 存贮连接对象
	static private $obj; //存储单例对象

	/**
	 * 这里简洁化处理，写死了连接信息跟操作的数据库
	 */
	private function __construct(){
		$link = @mysql_connect("localhost","root",'123') or die('数据库连接失败');
		mysql_query("set names utf8");
		mysql_query('use learn_mysql;');
	} 

	/**
	 * 私有化克隆方法
	 */
	private function __clone(){}

	/**
	 * 得到单例的mysql操作对象
	 * @return [type] 单例的mysql对象
	 */
	static function  getInstance() {
		if(!(self::$obj instanceof self))  self::$obj = new self();
		return self::$obj;
	}

	/**
	 * 执行一条sql指令
	 * @param  string $sql 待执行的sql语句
	 * @return [type]      数据库结果集对象
	 */
	function query($sql=''){
		$result = mysql_query($sql);
		if(!$result) {
			die(mysql_error());
		}
		return $result;
	}
	/**
	 * 取得多行多列的数据集
	 * @param  string $sql sql语句
	 * @return array      二维数组 结果集
	 */
	function fetchAll($sql=''){
		$result = $this->query($sql);
		$arr = Array();
		while ($row = mysql_fetch_array($result)) {
			$arr[] = $row;
		}
		mysql_free_result($result);
		return $arr;
	}

	/**
	 * 取得一行记录
	 * @param  string $sql 待执行的sql
	 * @return [type]      一行记录，一维数组
	 */
	function fetchRow($sql=''){
		$result = $this->query($sql);
		$arr = Array();
		if ($row = mysql_fetch_array($result)) {
			$arr = $row;
		}
		mysql_free_result($result);
		return $arr;	
	}

	/**
	 * 返回一条记录
	 * @param  string $sql 待执行sql
	 * @return [type]      一个数据
	 */
	function fetchOne($sql=''){
		$result = $this->fetchRow($sql);
		return  $result ? $result[0] : null;
	}
}