<?php 
$c = !empty($_GET['c']) ? $_GET['c'] : 'User';
$a = !empty($_GET['a']) ? $_GET['a'] : 'index';
$p = !empty($_GET['p']) ? $_GET['p'] : 'front';

//定义常量
define('ACTION',$a);  //当前动作
define('CONTROLLER',$c);  //当前控制器
define('PLAT',$p);   //当前平台
define("DS", DIRECTORY_SEPARATOR); //目录分隔符，DERECTORY_SEPARATOR只有两个， \ /
define('ROOT', __DIR__.DS);
define("APP", ROOT.'Application'.DS); //application根目录
define('FRAMEWORK', ROOT.'Framework'.DS); //框架基础类所在路径
define('PLAT_PATH', APP.PLAT.DS); //当前平台路径
define('CTRL_PATH', PLAT_PATH."Controllers".DS); //当前控制器目录
define('MODEL_PATH', PLAT_PATH."Models".DS); //当前模型类目录
define('VIEW_PATH', PLAT_PATH."Views".DS); //当前视图目录

//Framework目录下面的映射列表
$class_list = array('mysql_tools' => 'class',
	'ModelFactory' => 'class',
	'BaseModel' => 'class',
	'BaseController' => 'class',
	'PDODB' => 'class',
	'i_DAO' => 'interface',
	'Captcha' => 'class',
	);

//自动加载
function __autoload($class){
	if (array_key_exists($class, $GLOBALS['class_list'])) {
		//在framework目录下面
		require FRAMEWORK.$class.'.'.$GLOBALS['class_list'][$class].'.php';
	} elseif (substr($class,-5) == 'Model') {
		//最后5个字符是Model的文件
		require MODEL_PATH.$class.'.class.php';
	} elseif (substr($class,-10) == 'Controller') {
		//最后10个字符是Controller的文件
		require CTRL_PATH.$class.'.class.php';
	}
}

$c .= "Controller"; $a .= "Action";
$ctrl = new $c();
$ctrl->$a();
 ?>