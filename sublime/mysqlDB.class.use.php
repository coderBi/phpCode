<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>mysql 工具类的使用</title>
</head>
<body>
	<?php 
	require_once '.\mysqlDB.class.php';
	$config = array('host'=>'localhost','name'=>'root','password'=>'','charset'=>'utf8','dbName'=>'learn_mysql');
	$o4 = mysql_tools::GetInstance($config);
	// $o4->set_Names($config['charset']);
	// $o4->chooseDB($config['database']);
	$result = $o4->GetOneRow("select * from tb4;");
	var_dump($result);
	echo "<br>";
	var_dump(get_object_vars($o4));	
	 ?>
</body>
</html>