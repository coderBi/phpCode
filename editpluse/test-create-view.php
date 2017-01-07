<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style type="text/css">
		td {
			border:1px solid silver;
		}
	</style>	
</head>
<body>
<?php
	if(!(mysql_connect("localhost","root","")))
		return;
	mysql_query("set names utf8");
	$sql="use learn_mysql";
	if(!mysql_query($sql))
		return;
	$sql = "show create view v2";
	if(!($result = mysql_query($sql)))
		return;
	printRes($result);
	function printRes($result){
		$cols = mysql_num_fields($result);
		echo	"<table>";
		echo	"<tr>";
		for($i = 0; $i < $cols; ++$i){
			echo "<td>";
			echo mysql_field_name($result,$i);
			echo "</td>";
		}
		echo	"<tr>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			for($i = 0; $i < $cols; ++$i){
				echo "<td>";
				echo $row[$i];
				echo "</td>";
			}
			echo "</tr>";
		}
		echo	"</table>";
	}
?>	
</body>
</html>