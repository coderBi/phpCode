<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>百钱白鸡问题</title>
</head>
<body>
	<h2>题目：100钱求买100鸡，公鸡5钱，母鸡4钱，小鸡1钱3只 </h2>
	<hr>
	<?php
		$x_value = 5;
		$y_value = 3;
		$z_value = 1 / 3;  
		for($x = 0; $x * $x_value <= 100; ++$x){
			$leftMoney1 = 100 - $x * $x_value;
			//设置是否已经可以跳出这一层循环的标志，也就是问题得到解决
			$flag_X = false;
			for($y = 0; $y * $y_value <= $leftMoney1 ; ++$y) {
				$leftMoney2 = $leftMoney1 - $y * $y_value;
				$z = $leftMoney2 * 3;
				if($x + $y + $z == 100){
					echo("结果:<br>"."公鸡:".$x."母鸡".$y."小鸡".$z."<br>");
					// $flag_X = true;
					// break;
				}
			}
			if($flag_X == true) {
				//在php里，因为有 break n 和 continue n 语法，这里可以不用
				//标志。break n 指的是跳出 n 层循环
				break;
			}
		}
	?>
</body>
</html>