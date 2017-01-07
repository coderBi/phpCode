<!-- 由于一开始对于 php变量的作用域不是很清楚，所以这里写的代码将html拆开嵌套在
php代码里面，这样非常影响阅读而且不便于书写，所以接下来会重写一个calc2.php
将html与php代码尽量分离 -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php实现计算器</title>
</head>
<body>
	<?php 
		if(array_key_exists('var1', $_POST)){
			$var1 = $_POST['var1'];
		} else {
			$var1 = null;
		}
		if(array_key_exists('var2', $_POST)){
			$var2 = $_POST['var2'];
		} else {
			$var2 = null;
		}
		if(array_key_exists('calc', $_POST)){
			$calc = $_POST['calc'];
		} else {
			$calc = null;
		}
		$res = null;

		echo "<form action='#' method='post'>";
		if(!empty($var1) || $var1 === "0"){
			echo "<input type='text' name='var1' value='$var1'>"; 
		} else {
			// if($var1 < )
			echo "<input type='text' name='var1'>";
		}
		if(!empty($calc)){
			echo "<select name='calc' value='$calc'>"; 
		} else {
			echo "<select name='calc'>";
		}
		if($calc == "+") {
			echo "<option value='+' selected>+</option>";
		} else {
			echo "<option value='+'>+</option>";
		}
		if($calc == "-") {
			echo "<option value='-' selected>-</option>";
		} else {
			echo "<option value='-'>-</option>";
		}
		if($calc == '*') {
			echo "<option value='*' selected>*</option>";
		} else {
			echo "<option value='*'>*</option>";
		}
		if($calc == '/') {
			echo "<option value='/' selected>/</option>";
		} else {
			echo "<option value='/'>/</option>";
		}
		
		
		
		echo "</select>";

		if(!empty($var2) || $var2 === "0"){
			echo "<input type='text' name='var2' value='$var2'>"; 
		} else {
			echo "<input type='text' name='var2'>";
		}
		echo "<input type='submit' value='='>";
		if((empty($var2) && $var2 !== "0") || (empty($var1) && $var1 !== "0")){
			echo "<input type='text' name='res'>";
		} else {
			if($calc == "/" && $var2 === "0"){
				echo "<input type='text' name='res' value ='除数不能为0'>";
				return;
			}
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
			
			echo "<input type='text' name='res' value ='$res'>";
		}
	 ?>
	</form>
</body>
</html>