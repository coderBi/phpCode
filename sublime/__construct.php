<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php 构造方法</title>
</head>
<body>
	<?php 
	class cls1{
		var $name,$age,$edu;
		// 这里的赋值只能是简单的，下面的new会不识别
		// var $xx = new stdclass();
		var $aa = 1*3+1;
		var $bb = array(1,2);
		//var $cc = stdclass::ok();
		static public $sv = "static";
		function work(){
			echo "{$this->name}今年{$this->age},".
			"{$this->edu}学历了，可以自己洗衣服了";
			echo "<hr>";
			//echo "static:".$this->sv; //静态没有办法用->访问
			echo "static:".self::$sv;
		}
		function __construct($name,$age,$edu){
			$this->name = $name;
			$this->age = $age;
			$this->edu = $edu;
		}
		function __destruct(){
			echo "<br>cls1析构执行";
		}
	}
	$girl = new cls1('小红',12,'中学');
	$girl->work();
	 ?>
	<?php 
	echo "<hr>";
	echo "下面是php面向对象第一次作业:<br>";
 	class student {
		var $name;
		var $age;
		var $sex;
		static public $count=0;
		const c1 = "常量1";
		function __construct($name,$age,$sex){
			$this->name = $name;
			$this->age = $age;
			$this->sex = $sex;
			self::$count++;
			echo $this->name."加入了大家庭,目前共有".self::$count."成员<br>";
		}
		function __destruct(){
			echo "student析构执行：当前共有".self::$count."学生<br>";
			self::$count--;
		}
		public function selfIntroduce(){
			echo "我叫".$this->name.",".$this->sex.",今年".$this->age."<br>";
		}
	}
	$stu1 = new student('bb',21,'男');
	$stu1->selfIntroduce();
	$stu2 = new student('ww',21,'女');
	$stu2->selfIntroduce();

	//测试父类构造私有情况
	class parent1{
		private function __destruct(){

		}
	}
	class child1 extends parent1{
		//注意构造函数进行覆盖不需要考虑权限问题。
		//这里如果不进行覆盖由于会自动执行父类的构造方法而父类的
		//私有构造方法会有warning（当前也就没有了初始化操作）
		function __destruct(){

		}
	}
	$ch1 = new child1();
	 ?>
</body>
</html>