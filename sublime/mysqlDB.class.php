<?php 
//设计一个mysql操作类
class mysql_tools{
	private $link = null; //存储连接资源
	private $host;
	private $name;
	private $password;
	private $charset;
	private $dbName;
	static private $obj;
	private function __construct($config){
		$this->host = isset($config['host']) ? $config['host'] : '';
		$this->name = isset($config['name']) ? $config['name'] : '';
		$this->password = isset($config['password']) ? $config['password'] : '';
		$this->charset = isset($config['charset']) ? $config['charset'] : '';
		$this->dbName = isset($config['dbName']) ? $config['dbName'] : '';
		$this->link = @mysql_connect($this->host,$this->name,$this->password) or die("数据库连接失败");
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
	static function GetInstance($config){
		if(/*!isset(self::$obj)*/ !(self::$obj instanceof self)){
			self::$obj = new self($config);
		}
		return self::$obj;
	}
	function set_Names($charset){
		$this->charset = $charset;
		mysql_query("set names=".$charset.";");
	}
	function chooseDB($db){
		$this->dbName = $db;
		mysql_query("use ".$db.";");
	}
	function close_Connect(){
		mysql_close($this->link);
	}

	//执行一条sql语句
	function exec($sql){
		$result = mysql_query($sql);
		if($result == false){
			echo "<p>sql语句执行失败，具体错误信息为：<br>错误代号：".mysql_errno()."<br>错误信息：".mysql_error()."<br>错误语句：".$sql.'<p>';
			die();
		} else 
			return $result;
	}
	//返回一行查询数据
	function GetOneRow($sql){
		$result = $this->exec($sql);
		$arr = mysql_fetch_array($result);
		mysql_free_result($result);
		return $arr;
	}
	//返回多行查询数据，二维数据
	function GetRows($sql){
		$result = $this->exec($sql);
		$arr = array();
		while ($row = mysql_fetch_array($result)) {
			$arr[] = $row;
		}
		//如果不手动释放就需要页面执行完成自动释放
		mysql_free_result($result);
		return $arr;
	}
	//返回查询的一个数据
	function GetOneData($sql){
		$result = $this->exec($sql);
		$data = mysql_fetch_array($result)[0];
		mysql_free_result($result);
		return $data;
	}
}
?>