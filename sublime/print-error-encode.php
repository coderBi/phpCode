<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>打印所有的错误代码跟相应值</title>
	<style>
		table {
			border-collapse: collapse;
		}
		td {
			border: 1px solid silver;
		}
	</style>
</head>
<body>
	<table>
		<tr>
			<td>错误代号</td>
			<td>十进制表示</td>
			<td>二进制表示</td>
			<td>错误代号</td>
			<td>十进制表示</td>
			<td>二进制表示</td>
		</tr>
		<?php 
		$errCode = array("E_ERROR","E_WARNING","E_PARSE",
			"E_NOTICE","E_CORE_ERROR","E_CORE_WARNING",
			"E_COMPILE_ERROR","E_COMPILE_WARNING",
			"E_USER_ERROR","E_USER_WARNING","E_USER_NOTICE",
			"E_STRICT","E_ALL");
		for($i = 0; $i < count($errCode); ++$i){
			if($i % 2 == 0){
				echo("<tr>");
			}
			$_10Code = constant($errCode[$i]);
			$_2Code = str_pad(decbin($_10Code), 16,
			 "0", STR_PAD_LEFT);
			$_2Code = str_replace("1", "<font color='red'>1</font>", $_2Code);

			echo "<td>".$errCode[$i]."</td>";
			echo "<td>".$_10Code."</td>";
			echo "<td>".$_2Code."</td>";
			if($i % 2 == 1){
				echo("</tr>");
			}
		}
		 ?>

	</table>
	
</body>
</html>