<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>测试打印 0 null false</title>
</head>
<body>
	<?php 
		// 0 null false 在内存里面都是0  只是类型不同
		echo 0;
		echo "<br>";
		echo null;
		echo "<br>";
		echo false;
		echo "<hr>";

		print 0;
		print "<br>";
		print null;
		print "<br>";
		print false;
		print "<hr>";

		var_dump(0);
		var_dump("<br>");
		var_dump(null);
		var_dump("<br>");
		var_dump(false);
		var_dump("<hr>");
	?>
</body>
</html>