<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>pdo连接数据库</title>
</head>
<body>
	<?php 
	$dsn = "mysql:host=localhost;port=3306;dbname=learn_mysql";
	$opt = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8');
	$pdo = new PDO($dsn,'root','123',$opt);
	var_dump($pdo);
	$sql = "selectt from user";
	$result = $pdo->exec($sql);
	if(!$result){
		echo "发生错误，".$pdo->errorCode()."";
		$e = $pdo->errorInfo();
		var_dump($e);
	}
	echo '<hr>';
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	try {
		$sql = "selectt from user";
		$result = $pdo->exec($sql);
		echo '执行成功';
	} catch (Exception $e) {
		echo '错误代码：'.$e->GetCode();
		echo '<br>错误信息：'.$e->GetMessage();
	}
	echo '<hr>';
	$sql = 'select * from user where id=? and name= ?;';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1,3);
	$stmt->bindValue(2,'bww');
	$stmt->execute();
	$arr = $stmt->fetch(PDO::FETCH_ASSOC);
	print_r($arr);
	 ?>
</body>
</html>