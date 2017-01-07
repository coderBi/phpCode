<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>判断是否是素数</title>
</head>
<body>
	<?php 
	$res = false;
	$input = "";
	if(isset($_POST['input'])){
		$input = $_POST['input'];
	}
	if($input >= 2) {
		$i = 2;
		for(; $i*$i <= $input; ++$i){
			if($input % $i == 0)
				break;
		}
		if($i * $i > $input){
			$res = true;
		}
	}
	 ?>
	<form action="" method="post">
		输入：<input type="text" name="input" 
		<?php 
		echo "value='$input'";
		 ?>>
		<input type="submit" value="Go">
		<br>
		<?php
		if($input != "") {
			if($res == true){
				echo("数字".$input."是素数");
			} else {
				echo("数字".$input."不是素数");
			}
		}
		 ?>
	</form>
	<hr>
	<p>
		输出2~200中间的所有的素数：<br>
		<?php
		$max = 200; 
		echo "2 ";
		function is_Prime($num){
			$res = false;
			if($num >= 2) {
				$i = 2;
				for(; $i*$i <= $num; ++$i){
					if($num % $i == 0)
						break;
				}
				if($i * $i > $num){
					$res = true;
				}
			}
			return $res;
		}

		for($i = 3, $count = 1; $i <= $max; $i += 2){
			if(is_Prime($i)){
				echo $i;
				if($count % 10 == 9){
					echo "<br>";
				} else {
					echo "&emsp;";
				}
				++$count;
			}
		}
		 ?>
	</p>
	
</body>
</html>