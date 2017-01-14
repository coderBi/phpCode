<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>find</title>
</head>
<body>
	<!-- 打印查询到的结果。注意这里用的是 $result.id 而不是 ->id -->
	<?php echo ($result["id"]); ?> => <?php echo ($result["data"]); ?>
</body>
</html>