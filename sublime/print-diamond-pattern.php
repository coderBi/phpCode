<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>利用逻辑控制语句打印出一个菱形</title>
</head>
<body>
	<?php  
		$rows = 7;
		$cols = 2 * $rows - 1;
		$mid = $cols/2;
		//$mid 虽然是两个整数相除的结果，但是在 php里面float
		//因为如果int保存不了，会自动改变为float
		settype($mid, "int");
		for($i = 0; $i <= $mid; ++$i){
			for($j = 0; $j <= $mid + $i; ++$j){
				if($j == ($mid + $i) || $j == ($mid - $i)) {
					echo("*");
				} else{
					//&nbsp;在不同的浏览器里面可能显示效果不一样，
					//用ensp 或者emsp效果是一样的
					echo "&ensp;";
				}
			}
			echo "<br>";
		}
		for($i = $mid - 1; $i >= 0; --$i){
			for($j = 0; $j <= $mid + $i; ++$j){
				if($j == ($mid + $i) || $j == ($mid - $i)) {
					echo("*");
				} else{
					echo "&ensp;";
				}
			}
			echo "<br>";
		}
	?>
</body>
</html>