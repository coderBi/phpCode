<!-- 
1,变量区分大小写
2，常量默认区分大小写，但是可以认为的设定为不区分大小写
3.，其他场合不区分，例如函数名，关键字(for if return...)
4, php 中间不允许不给变量赋值的定义： $var; php会认为
	这是没有意义的。不过可以$var = null 表示这个
	变量没有任何内容 
5, 判断一个变量是否存在的函数: isset($var)
6, 删除一个变量 unset： 删除一个变量是指将引用断开。这个时候对这个
	变量进行isset的结果是false。 其指向的空间如果没有任何引用会
	被系统回收
7，php注释：
	a）单行注释 # 和 //
	b) 多行注释 /**/
	c) 多行注释与反注释代码：
		注释： /*
				ajfl
				ajfl
				//*/
		反注释: //*
				ajfl
				ajfl
				//*/
		注释： if(1 == 0){
					里面存放想要注释的内容
				}
8,变量命名规则与C相同
9,变量的传递： 值传递 $var1 = $var2 引用传递 $var1 = &$var2
10， 关于预定义变量： 
	a）主要的有： $_GET $_POST $_REQUEST $_SERVER $_GLOBALS
	b) 均是数组
	c）系统定义与维护，程序员不应该直接对其赋值与销毁，只应该拿来
	使用其值
	d）具有全局的作用域
	e）不同情形下可能会具有不同的值
 -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php变量与注释</title>
</head>
<body>
	<?php 
		echo "php变量与注释<br>";
		$v1 = 1;
		unset($v1);
		$s1 = 1;
		$s1 = isset($v1);
		// 不能用echo 因为如果$1 true 则打印出1 如果$1
		// false echo 不会打印任何东西
		// echo $s1;
		var_dump($s1);
		echo "<br>";

		//分析下面的结果,连续出现$的变量是可变变量
		$var1 = "abc";
		$abc = 10;
		echo $$var1; 
		//分析$($var1),由于var1的值是abc 所以也就是变量$abc

		//利用上面的技巧去求下面数据之和
		$v1 = 1;
		$v2 = 1;
		$v3 = 1;
		$v4 = 1;
		$v5 = 1;
		$sum = 0;
		for($i = 1; $i <= 5; $i++){
			$v = "v".$i; //字符串拼接
			$sum += $$v;
		}
		echo "上面各项之和：$sum<br>";
		echo "<hr>";

		//查看null变量的isset
		$v6 = null;
		var_dump($v6);
		$v7 = isset($v6);
		echo "<br>";
		//结果是false isset 可以判断变量是否未定义或者定义成了null
		var_dump($v7);
	?>
</body>
</html>