<?php
$c = !empty($_GET['c']) ? $_GET['c'] : 'default';
$a = !empty($_GET['a']) ? $_GET['a'] : 'index';
$p = !empty($_GET['p']) ? $_GET['p'] : 'default';

define('CONTROLLER',$c); //当前控制器
define('ACTION',$a); //当前动作
define('PLAT',$p); //当前平台
define('DS',DIRECTORY_SEPARATOR); //目录分割符
define('ROOT',__DIR__.DS); //跟目录，也是index所在目录
define('APP',ROOT.'Application'.DS); //application 目录
define('FRAMEWORK',ROOT.'Framwork'.DS); //framwork 目录
define('PLAT_PATH',APP.PLAT.DS); //当前平台路径
define('CONTROLLER_PATH',PLAT_PATH.'Controllers'.DS); //控制器所在目录
define('VIEW_PATH',PLAT_PATH.'Views'.DS); //视图所在目录
define('MODEL_PATH',PLAT_PATH.'Models'.DS); //模型所在目录

//framwork 下面的类名列表
$class_list = Array('BaseController',
	'mysql_tool',
	'BaseModel',
	);

//自动加载
function __autoload($class){
	if( in_array($class, $GLOBALS['class_list']) ) require FRAMEWORK.$class.'.class.php';
	else if(substr($class,-5) == 'Model') require MODEL_PATH.$class.".class.php";
	else if (substr($class,-10) == 'Controller') require CONTROLLER_PATH.$class.".class.php";
	else die($class.'没找到');
}

$c .= 'Controller'; $a .= 'Action';
$ctrl = new $c();
$ctrl->$a();