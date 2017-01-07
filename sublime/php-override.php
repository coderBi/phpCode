<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>override</title>
</head>
<body>
	<?php 
	class A{
		var $p1='A';
		function __construct(){
			echo $this->p1.'<br>';
		}
	}
	class B extends A{
		var $p1 = 'B';
		function show(){
			echo $this->p1;
		}
	}
	class C extends B{
		var $p1 = 'C';
		function show(){
			B::show();
		}
	}
	$obj = new C();
	echo "this->\$p1:".$obj->p1.'<br>';
	//下面没有办法向C++中的那样调用，只能在类不用parent或者父类名调
	// echo "this->A::\$p1:".$obj->A::$p1.'<br>';
	// echo "this->B::\$p1:".$obj->B::$p1.'<br>';
	$obj->show(); //打印结果是 'C'
	 ?>
</body>
</html>