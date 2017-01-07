<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>计算正整数N的阶乘</title>
</head>
<body>
	<?php 
		// 利用递归求N!
		function recursion_getFactorial($var){
			if(((int)$var != $var) || $var <= 0){
				return "数据范围不是正整数";
			}
			if($var == 1){
				return 1;
			} else {
				return $var * recursion_getFactorial($var -1);
			}
		}
		// 利用递推求N!
		function derivation_getFactorial($var){
			if(((int)$var != $var) || ($var <= 0)){
				return "数据范围不是正整数";
			}
			$res = 1;
			for($i = 2; $i <= $var; ++$i){
				$res *= $i;
			}
			return $res;
		}
		$input = "";
		if(isset($_POST['input'])){
			$input = $_POST['input'];
			$arr = array(recursion_getFactorial($input), derivation_getFactorial($input));
			
		}
	 ?>
	 <form action="" method="post">
	 	<input type="text" name="input" <?php echo "value='$input'"; ?>>
	 	<input type="submit" value="求值">
	 	<?php 
	 	if(isset($_POST['input'])){
	 		echo("<br>用递归求得的结果：".$arr[0].
				"<br>"."用递推求得的结果:".$arr[1]);
	 	}
	 	 ?>
	 </form>
</body>
</html>