<?php 
/**
 * DAO层，使用pdo扩展封装实现
 */
class PDODB implements i_DAO {
	private $_host;
	private $_port;
	private $_user;
	private $_password;
	private $_charset;
	private $_dbName;
	private static $_instance;
	//运行时属性
	private $_dsn;
	private $_options;
	private $_pdo;
	private function __construct($config=array()){
		//初始化服务器信息
		$this->_initServer($config);
		//实例化PDO对象
		$this->_newPDO();
	}
	private function __clone(){

	}
	//获取当前dao对象的接口方法
	public static function GetInstance($config=array()){
		//当前类的对象是否已经存在
		if(!(static::$_instance instanceof static)) {
			//不存在，创建一个
			static::$_instance = new static($config);
		}
		return static::$_instance;
	}
	/**
	 * 初始化数据库服务器配置
	 * @param  array $config 格式如下：$config=array('host' => 'localhost',
	 * 'port' => '3306', 'user' => 'root', //... );
	 */
	private function _initServer($config){
		//在初始化属性时，如果实例化没有定制，就是用默认值
		$this->_host = isset($config['host']) ? $config['host'] : 'localhost';
		$this->_port = isset($config['port']) ? $config['port'] : '3306';
		$this->_user = isset($config['user']) ? $config['user'] : '';
		$this->_password = isset($config['password']) ? $config['password'] : '';
		$this->_charset = isset($config['charset']) ? $config['charset'] : 'utf8';
		$this->_dbName = isset($config['dbName']) ? $config['dbName'] : 'default';
	}
	/**
	 * 创建PDO对象
	 */
	private function _newPDO(){
		//设置参数
		$this->_setDSN();
		//设置连接选项
		$this->_setOptions();
		//获取pdo对象
		$this->_getPDO();
	}
	/**
	 * 设置DSN
	 */
	private function _setDSN() {
		$this->_dsn = "mysql:host=$this->_host;port=$this->_port;dbname=$this->_dbName";
	}
	/**
	 * 设置Options
	 */
	private function _setOptions()
	{
		$this->_options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => "set names $this->_charset",
			);
	}
	/**
	 * 得到pdo对象
	 */
	private function _getPDO(){
		try {
			$this->_pdo = new PDO($this->_dsn,$this->_user,$this->_password,$this->_options);
		} catch (Exception $e) {
			die('数据库连接失败，请确认服务器信息');
		}
	}
	//执行sql方法
	public function query($sql=''){
		//对于查询类，返回结果对象。忽略大小写比较
		//去掉左边空格
		$sql = ltrim($sql);
		if(strtolower(substr($sql,0,6)) == 'select' || strtolower(substr($sql,0,4)) == 'show' 
			|| strtolower(substr($sql,0,4)) == 'desc') {
			$result = $this->_pdo->query($sql);
		}
		else {
			//对于非查询类，返回布尔值
			$result = $this->_pdo->exec($sql); //exec执行成功返回受影响的数量，失败返回false
		}
		//如果执行失败，报告错误信息，并停止脚本执行
		if($result === false) {
			//执行失败。结果就是false
			$error_info = $this->_pdo->errorInfo();
			echo "<p>sql语句执行失败，具体错误信息为：<br>错误代号：",
			$error_info[0]."<br>错误信息：".$error_info[2]."<br>错误语句：".$sql.'<p>';
			die();
		} else {
			//执行成功
			return $result;
		}
	}
	//获取全部数据
	public function fetchAll($sql='') {
		$result = $this->query($sql); //执行
		$rows = $result->fetchAll(PDO::FETCH_ASSOC); //获取数据
		$result ->closeCursor(); //释放结果集光标
		return $rows;
	}
	//获取一行数据
	public function fetchRow($sql='') {
		$result = $this->query($sql); //执行
		$row = $result->fetch(PDO::FETCH_ASSOC); //获取数据
		$result ->closeCursor(); //释放结果集光标
		return $row;
	}
	//获取一个数据
	public function fetchOne($sql='') {
		$result = $this->query($sql); //执行
		$string = $result->fetchColumn(); //获取数据
		$result ->closeCursor(); //释放结果集光标
		return $string;
	}
	//字符串转义，防止sql注入
	public function escapeString($str='') {
		return $this->_pdo->quote($str);
	}
}
 ?>