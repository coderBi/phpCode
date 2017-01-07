<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php 设计模式</title>
</head>
<body>
	<?php 
	//设计工厂类
	echo '工厂设计模式：<br>';
	class factory{
		static function getObject($className){
			$obj = new $className();
			return $obj;
		}
	}
	class A{

	}
	$o1 = factory::getObject('A');
	var_dump($o1);
	echo '<hr>';

	//单例设计
	class single{
		var $name;
		static private $obj = null; //不允许外部修改
		private function __construct($name){
			$this->name = $name;
		}
		static public function getObject($name){
			if(!isset(self::$obj)){
				return self::$obj = new self($name);
			} else {
				return self::$obj;
			}
		}
		private function  __clone(){}
	}
	$o2 = single::getObject('张三');
	$o3 = single::getObject('李四');
	var_dump($o2);
	echo "<br>";
	var_dump($o3);
	echo "<hr>";
	//$o4 = clone $o3; // 无法进行克隆
	 ?>
</body>
</html>