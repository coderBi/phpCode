1,<!-- 常量是相对于变量而言的，是其中存储的数据不会也不应该进行改变
2，常量定义语法：
	a）define(“常量名”，常量值)，例如 define("PI"，3.14)
	b) const 常量名=常量值 例如 const PI = 123。注意必须在
		定义的时候给值 const PI; 这样的写法是不合法的
3，注意，
	a)常量如果用“”包裹会不识别，因为没有$的修饰
	b)constant()里面的参数是字符串类型，指的是常量的名字
	c）常量一般全大写，可以加下划线
	d)常量不可以销毁
	e)常量具有超全局作用域（比全局变量更大）
	f）常量只能存标量类型： int float string bool四种
	g）当使用一个未定一个未定义的常量的时候，这个时候系统会将该常量名
		当做一个值进行使用
4， 因为常量不能重复定义而且具有超全局的作用域，所以多人合作项目
	的时候使用一个常量的时候常常先用defined（）判断一下这个常量
	是不是已经被他人定义了
5, 预定义常量：大约有几百个
	M_PI:圆周率常量值
	PHP_OS: PHP裕兴所在的操作系统
	PHP_VERSION: PHP版本号
	PHP_INT _MAT: php中最大的整数值
	跟多的预定义常量可以在操作手册的 保留字->预定义常量  查询
6,魔术常量： 指的是是常量，但是值可以进行变化,以两个下划线开头
	__FILE__ : 代表当前网页文件的目录
	__DIR__: 	当前网页所在目录
	__LINE__: 当前这个常量名所在的行号
7，const定义常量只能在“顶层代码”中，不能放到大括号的位置，例如 
	if(){const var = value} 是错误的
 -->


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php常量</title>
</head>
<body>
	打印魔术常量<br><hr>
	<?php 
		echo "__DIR__".__DIR__;
		echo "<br>"."__FILE__".__FILE__;
		echo "<br>"."__LINE__".__LINE__;
		echo "<br>"."__LINE__".__LINE__;
		echo "<br>"."__LINE__".__LINE__;
		echo "<br>";
		// 要注意的是魔术常量是5.3开始有的，所以如果要向下兼容
		// 可以使用dirname（）函数
		echo "<br>"."dirname(__FILE__):".dirname(__FILE__);	
	?>
	<hr>
	常量使用例子<br>
	<?php  
		define("PI",3.14);
		echo "PI:".PI; //注意不可以写成”PI“
		echo "<br>";
		const CS1 = 123;
		if(!defined("CS1")){
			define("CS1", 100);
		}
		echo "常量CS1的值是：".constant("CS1");
	?>
</body>
</html>