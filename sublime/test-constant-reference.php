<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>测试常量的引用赋值</title>
</head>
<body>
	<?php 
	$var1 = 3;
	$var2 = & $var1;
	echo "\$var2:".$var2."<br>";
	//错误
	//$var3 = (&3);
	define("var4",3);
	echo "var4:".var4."<br>";
	//php里面没有办法在常量前面 & 。 C++ 里面定义的时候 & 在=左边
	//$var5 = (&var4);  
	 ?>
</body>
</html>