 <!-- 
 1,关于预定义变量： 
	a）主要的有： $_GET $_POST $_REQUEST $_SERVER $GLOBALS
	b) 均是数组
	c）系统定义与维护，程序员不应该直接对其赋值与销毁，只应该拿来
	使用其值
	d）具有全局的作用域
	e）不同情形下可能会具有不同的值
	f）函数内部要调用自己已经定义的全局变量需要：$GLOBALS["var"]
2,$_POST变量：post提交的数据会保存在这个数组里面
3，$_GET变量： get提交的数据
4,$_REQUEST变量: 同时保存了post跟get提交的数据。如果两个
	里面出现相同的变量名称，会根据设置的顺序进行覆盖，设置
	可以在php.ini里面进行修改。默认是顺序是"GP"，因为P在后面
	所以会出现post覆盖get的情况
5,get提交一般的形式例如：form的action  a标签的href  js里面的
	location.href  js里面location.assign  
	php里面调用header("location: 目标文件.php?var=value")
6，post提交可以认为只有form表单里面进行提交
7，$_SERVER 再一次提交中浏览器端信息与服务器端信息
9,$GLOBALES:自定义的全局变量的另一种存储形式，即所有的自定义全局
	变量又都会存到这个预定义变量里面。例如$v1 = 1;则 
	$GLOBALS['V1'] = 1
 -->

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>预定义变量</title>
 </head>
 <body>
 	<form action="#" method="post">
 		数据1： <input type="text" name="data1"><br>
 		数据2： <input type="text" name="data2"><br>
		<input type="submit" value="提交">
 	</form>
 	<?php
 		// isset 判断变量是否存在或者是null（无任何内容）
 		// empty() 判断内容是否是空的。例如 0 "" "0" false 
 		// null arrary() 都是空的 
 		if(empty($_POST)){
 			echo "没有提交数据";
 			return;
 		}
 		print_r($_POST);
 		print_r("<br>");
 		$d1 = $_POST['data1'];
 		$d2 = $_POST['data2'];
 		echo "d1 = $d1 d2 = $d2";
 	 ?>
 </body>
 </html>