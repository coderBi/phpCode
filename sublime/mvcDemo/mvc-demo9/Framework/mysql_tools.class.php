<?php 
//设计一个mysql操作类
class mysql_tools implements i_DAO {
	private $link = null; //存储连接资源
	private $host;
	private $name;
	private $password;
	private $charset;
	private $dbName;
	static private $obj;  //存储单例对象
	private function __construct($config){
		$this->host = isset($config['host']) ? $config['host'] : 'localhost';
		$this->name = isset($config['user']) ? $config['user'] : 'root';
		$this->password = isset($config['password']) ? $config['password'] : '123';
		$this->charset = isset($config['charset']) ? $config['charset'] : 'uft8';
		$this->dbName = isset($config['dbName']) ? $config['dbName'] : 'learn_mysql';
		$this->link = @mysql_connect($this->host,$this->name,$this->password) or die("数据库连接失败，请确认服务器信息");
		if($this->charset != ''){
			$this->set_Names($this->charset);
		}
		if($this->dbName != ''){
			$this->chooseDB($this->dbName);
		}
	}
	function __destruct(){
		$this->close_Connect();
	}
	//设计单例
	static function GetInstance($config=array()){
		if(/*!isset(self::$obj)*/ !(self::$obj instanceof self)){
			self::$obj = new self($config);
		}
		return self::$obj;
	}
	/**
	 * 设置数据库连接编码
	 */
	function set_Names($charset){
		$this->charset = $charset;
		mysql_query("set names=".$charset.";");
	}
	/**
	 * 设置选择的数据库
	 * @param  string $db 数据库名称
	 */
	function chooseDB($db){
		$this->dbName = $db;
		mysql_query("use ".$db.";");
	}
	/**
	 * 关闭数据库连接
	 */
	function close_Connect(){
		!empty($this->link) ? mysql_close($this->link) : '';
	}

	//执行一条sql语句
	function query($sql=''){
		$result = mysql_query($sql);
		if($result == false){
			echo "<p>sql语句执行失败，具体错误信息为：<br>错误代号：".mysql_errno()."<br>错误信息：".mysql_error()."<br>错误语句：".$sql.'<p>';
			die();
		} else 
			return $result;
	}
	//返回一行查询数据
	function fetchRow($sql=''){
		$result = $this->query($sql);
		$arr = mysql_fetch_array($result);
		mysql_free_result($result);
		return $arr;
	}
	//返回多行查询数据，二维数据
	function fetchAll($sql=''){
		$result = $this->query($sql);
		$arr = array();
		while ($row = mysql_fetch_array($result)) {
			$arr[] = $row;
		}
		//如果不手动释放就需要页面执行完成自动释放
		mysql_free_result($result);
		return $arr;
	}
	//返回查询的一个数据
	function fetchOne($sql=''){
		$result = $this->query($sql);
		$row = mysql_fetch_array($result);
		mysql_free_result($result);
		if ($row) {
			return $row[0];
		} else {
			return null;
		}
	}
	/**
	 * mysql字符串转义
	 * @param  string $str 待转义的字符串
	 * @return [type]      被带引号包裹的转义之后的字符串
	 */
	public function escapeString($str=''){
		return "'".mysql_real_escape_string($str,$this->link)."'";
	}
}
?>