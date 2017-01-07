<!-- 注意： 在进制转换参数进行自动类型转换的时候，如果10进制数字
	中间某一位不符合相应进制字符串的要求会被省略掉  
	例如otcdec（9） 参数9在转换过程中被忽略，所以结果是
		otcdec（”“）
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>test php 进制转换</title>
</head>
<body>
	<?php  
		$str8 = "13";
		$int8 = 013;

		//php 对于数据类型不相符的情况会进行默认的转换
		echo("octdec(\$str8)".octdec($str8)."<br>");
		echo $int8."<br>";
		// octdec的参数是013也就是10进制的11，由于不是string
		// 系统会自动的将其转换为”11“作为octdec参数
		echo("octdec(\$int8)".octdec($int8)."<br>");
	?>
</body>
</html>