<?php 
interface i_DAO {
	//获取当前dao对象的接口方法
	public static function GetInstance($config=array());
	//执行sql方法
	public function query($sql='');
	//获取全部数据
	public function fetchAll($sql='');
	//获取一行数据
	public function fetchRow($sql='');
	//获取一个数据
	public function fetchOne($sql='');
	//字符串转义，防止sql注入
	public function escapeString($str='');
}
 ?>