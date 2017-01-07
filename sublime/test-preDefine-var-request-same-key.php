<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>测试request get post 里面数据覆盖</title>
	<style>
		table {
			border: 1px solid green;
			border-collapse: collapse;
		}
		td {
			border: 1px solid red;
		}
	</style>
</head>
<body>
	<!-- php里面对于同一个变量名称会进行从前到后的覆盖，所以这里每一次
	打印相应的变量 v1 跟 v2 都会进行覆盖 -->
	<form action="?v1=1&v1=2&v2=1" method="post">
		<input type="text" name="v2">
		<input type="text" name="v2">
		<input type="submit" value="submit">
	</form>
	<?php  
		echo("打印request get post内容：<br>");
		echo "get:<br>";
		var_dump($_GET);
		echo "<br>";
		echo "post:<br>";
		var_dump($_POST);
		echo "<br>";
		echo "request:<br>";
		var_dump($_REQUEST);
		echo "<br>";
	?>
	<hr>
	<h3>改用数组进行变量的name的命名，解决php变量提交覆盖问题</h3>
	<form action="?v1[]=1&v1[]=2&v2[]=1" method="post">
		<input type="text" name="v2[]">
		<input type="text" name="v2[]">
		<input type="submit" value="submit">
	</form>
	<?php 
		// 即使是这样写作数组名称，但是还是不可能解决request
		// 里面的覆盖。不过如果确定get 跟post都有变量提交，可以分别
		// 去获取 
		echo("打印request get post内容：<br>");
		echo "get:<br>";
		var_dump($_GET);
		echo "<br>";
		echo "post:<br>";
		var_dump($_POST);
		echo "<br>";
		echo "request:<br>";
		var_dump($_REQUEST);
		echo "<br>";
	?>
	<hr>
	<h3>打印$_SERVER的信息</h3>
	<?php  
		var_dump($_SERVER);
	?>
	<br>
	<h6>$_SERVER的具体消息解释</h6>
	<table>
		<tr>
			<td>元素名车</td>
			<td>使用形式</td>
			<td>结果</td>
			<td>含义</td>
		</tr>
		<tr>
			<td>HTTP_HOST</td>
			<td>$_SERVER['HTTP_HOST']</td>
			<td><?php echo $_SERVER['HTTP_HOST'] ?></td>
			<td>所请求的服务器主机名</td>
		</tr>
		<tr>
			<td>HTTP_USER_AGENT</td>
			<td>$_SERVER['HTTP_USER_AGENT']</td>
			<td><?php echo $_SERVER['HTTP_USER_AGENT'] ?></td>
			<td>请求所使用的代理，指的是相应的浏览器与其内核</td>
		</tr>
		<tr>
			<td>HTTP_ACCEPT</td>
			<td>$_SERVER['HTTP_ACCEPT']</td>
			<td><?php echo $_SERVER['HTTP_ACCEPT'] ?></td>
			<td>表示可以接受的文件类型</td>
		</tr>
		<tr>
			<td>HTTP_ACCEPT_ENCODING</td>
			<td>$_SERVER['HTTP_ACCEPT_ENCODING']</td>
			<td><?php echo $_SERVER['HTTP_ACCEPT_ENCODING'] ?></td>
			<td>表示可以文件压缩类型</td>
		</tr>
		<tr>
			<td>HTTP_ACCEPT_ENCODING</td>
			<td>$_SERVER['HTTP_CONNECTION']</td>
			<td><?php echo $_SERVER['HTTP_ACCEPT_ENCODING'] ?></td>
			<td>表示请求结束后是否保持连接</td>
		</tr>
		<tr>
			<td>PATH</td>
			<td>$_SERVER['PATH']</td>
			<td><?php echo $_SERVER['PATH'] ?></td>
			<td>表示服务器的path路径信息</td>
		</tr>
		<tr>
			<td>SystemRoot</td>
			<td>$_SERVER['SystemRoot']</td>
			<td><?php echo $_SERVER['SystemRoot'] ?></td>
			<td>表示服务器操作系统的系统根目录</td>
		</tr>
		<tr>
			<td>COMSPEC</td>
			<td>$_SERVER['COMSPEC']</td>
			<td><?php echo $_SERVER['COMSPEC'] ?></td>
			<td>表示服务器命令解释器（例如cmd）路径</td>
		</tr>
		<tr>
			<td>SERVER_SOFTWARE</td>
			<td>$_SERVER['SERVER_SOFTWARE']</td>
			<td><?php echo $_SERVER['SERVER_SOFTWARE'] ?></td>
			<td>表示使用的服务器（如Apache+php）信息</td>
		</tr>
		<tr>
			<td>SERVER_PORT</td>
			<td>$_SERVER['SERVER_PORT']</td>
			<td><?php echo $_SERVER['SERVER_PORT'] ?></td>
			<td>表示服务器端口号</td>
		</tr>
		<tr>
			<td>QUERY_STRING</td>
			<td>$_SERVER['QUERY_STRING']</td>
			<td><?php echo $_SERVER['QUERY_STRING'] ?></td>
			<td>请求的字符串（get）</td>
		</tr>
		<tr>
			<td>PHP_SELF</td>
			<td>$_SERVER['PHP_SELF']</td>
			<td><?php echo $_SERVER['PHP_SELF'] ?></td>
			<td>本网页的路径</td>
		</tr>
	</table>
</body>
</html>