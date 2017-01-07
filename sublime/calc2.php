<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php实现计算器改进版本</title>
</head>
<body>
	<?php  
		if(array_key_exists("var1", $_POST)){
			$var1 = $_POST["var1"];
		}
		if(array_key_exists("var2", $_POST)){
			$var2 = $_POST["var2"];
		}
		if(array_key_exists("calc", $_POST)){
			$calc = $_POST["calc"];
		}
	?>
	<form action="" method="post">
		<input type="text" name="var1" 
		<?php 
			if(isset($var1)){
				echo("value='$var1'");
			}
		?>">
		<select name="calc" id="">
			<option value="+" 
			<?php  
				if(!isset($calc) || $calc == "+"){
					$calc = "+";
					echo("selected");
				}
			?>>+</option>
			<option value="-" 
			<?php  
				if(isset($calc) && $calc == "-"){
					echo("selected");
				}
			?>>-</option>
			<option value="*" 
			<?php  
				if(isset($calc) && $calc == "*"){
					echo("selected");
				}
			?>>*</option>
			<option value="/" 
			<?php  
				if(isset($calc) && $calc == "/"){
					echo("selected");
				}
			?>>/</option>
		</select>
		<input type="text" name="var2" 
		<?php 
			if(isset($var2)){
				echo("value='$var2'");
			}
		?>">
		<input type="submit" value="=">
		<input type="text" name="res" 
		<?php
			if(!isset($var1) || !isset($var2)){
				// return; //这里的return会导致php代码后面的input闭合标签丢失
			}  
			else if($calc == "/" && $var2 == "0"){
				echo "value='除数不能为0'";
			} else {
				switch ($calc) {
					case '+':
						$res = $var1 + $var2;
						break;

					case '-':
						$res = $var1 - $var2;
						break;
					case '*':
						$res = $var1 * $var2;
						break;

					case '/':
						$res = $var1 / $var2;
						break;
					default:
						$res = $var1 + $var2;
						break;
				}
				echo "value ='$res'";
			}
		?>>
	</form>
	<?php
		// 可以发现，结果的类型跟操作数类型与结果真实值都有关系，
		// 如果操作数中间有float 结果类型一定是float即使没有
		// 小数部分；如果操作数都是整数，结果得到小数，例如
		// 1/2 = 0.5 php会自动用float来表示结果。这是跟C等语言
		// 不同的
		if(isset($res)){
			var_dump($res); 
		}	
	?>
	
</body>
</html>