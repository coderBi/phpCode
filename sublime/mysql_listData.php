<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>数据库</title>
	<style>
		table {
			border-collapse: collapse;
		}
		table td {
			border: 1px solid silver;
		}
	</style>
</head>
<body>
	<?php
	function printDatabases(){
		if(!($dbs = mysql_query("show databases;"))){
			return;
		}
		while ($row = mysql_fetch_array($dbs)) {
			echo $row[0]." <a href='?action=showTB&db=".$row[0].
			"'>查看表</a><br>";
		}
	}
	function printTables($dbName){
		if(!mysql_query("use ".$dbName.";")){
			return;
		}
			
		if(!($tbs = mysql_query("show tables;"))){
			return;
		}
			
		while ($row = mysql_fetch_array($tbs)) {
			echo $row[0]." <a href='?action=showTBstruct&db=$dbName&tb=".$row[0].
			"'>查看表结构</a>"." <a href='?action=showTBdata&db=$dbName&tb=".$row[0].
			"'>查看数据</a><br>";
		}
	}
	function printTabaleStruct($dbName,$tbName){
		if(!mysql_query("use $dbName;"))
			return;
		$sql = "desc ".$tbName.";";
		$result = mysql_query($sql);
		printQueryRes($result);
	} 
	function printTabaleData($dbName,$tbName){
		if(!mysql_query("use $dbName;"))
			return;
		$sql = "select * from ".$tbName.";";
		$result = mysql_query($sql);
		printQueryRes($result);
	}
	function printQueryRes($result){
		if(!$result){
			return;
		}
			
		$colNum = mysql_num_fields($result);
		echo "<table>";
		echo "<tr>";
		for($i = 0; $i < $colNum; ++$i){
			echo "<td>".mysql_field_name($result,$i)."</td>";
		}
		echo "</tr>";
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
			for($i = 0; $i < $colNum; ++$i){
				echo "<td>".$row[$i]."</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	} 
	$link = mysql_connect("localhost","root","");
	mysql_query("set names utf8");
	//mysql_query("use learn_mysql");
	if(!isset($_REQUEST['action'])){
		printDatabases();
	} else {
		$action = $_REQUEST['action'];
		if(!isset($_REQUEST['db'])){
			echo "database未提供！<br>";
		} else{
			$dbName = $_REQUEST['db'];
			if($action == 'showTB'){
				printTables($dbName);
			} else if($action == 'showTBstruct'){
				if(!isset($_REQUEST['tb'])){
					echo "table未提供！<br>";
				} else {
					$tbName = $_REQUEST['tb'];
					printTabaleStruct($dbName,$tbName);
				}
			} else if($action == 'showTBdata'){
				if(!isset($_REQUEST['tb'])){
					echo "table未提供！<br>";
				} else {
					$tbName = $_REQUEST['tb'];
					printTabaleData($dbName,$tbName);
				}
			} else {
				echo "未定义的action操作";
			}
		}
		} 
		
	 ?>
</body>
</html>