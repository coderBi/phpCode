<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>进制转换php页面</title>
</head>
<body>
	<?php  
		if(isset($_POST['src'])){
			$src = $_POST['src'];
		} else {
			$src = "";
		}
		if(isset($_POST['func'])){
			$func = $_POST['func'];
		} else {
			$func = "";
		}
		switch ($func) {
			case '10to2':
				$res = decbin($src);
				break;
			case '10to8':
				$res = decoct($src);
				break;
			case '10to16':
				$res = dechex($src);
				break;
			case '2to10':
				$res = bindec($src);
				break;
			case '8to10':
				$res = octdec($src);
				break;
			case '16to10':
				$res = hexdec($src);
				break;
			default:
				$res = "";
				break;
		}
	?>
	<form action="" method="post">
		<input type="text" name="src" <?php echo("value = '$src'") ?>>
		<select name="func" id="">
			<option value="10to2" <?php if($func == "10to2") echo "selected" ?>>10to2</option>
			<option value="10to8" <?php if($func == "10to8") echo "selected" ?>>10to8</option>
			<option value="10to16" <?php if($func == "10to16") echo "selected" ?>>10to16</option>
			<option value="2to10" <?php if($func == "2to10") echo "selected" ?>>2to10</option>
			<option value="8to10" <?php if($func == "8to10") echo "selected" ?>>8to10</option>
			<option value="16to10" <?php if($func == "16to10") echo "selected" ?>>16to10</option>
		</select>
		<input type="submit" value="转换">
		<input type="text" name="res" <?php echo("value = '$res'") ?>>
	</form>
</body>
</html>