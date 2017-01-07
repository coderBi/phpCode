<!-- php语法形式：
1，推荐形式
 <?php 
	中间存放复合php语法的形式
 ?>

2，php是众多脚本语言的一种
<script language="php">
	这里写复合php语法的语句
</script>
3, 不推荐写法，前提是要将php.ini 里面的short_open_tag
的值由默认的off改为on（也需要重启服务器生效）
<? 
	中间存放符合php语法的语句
 ?> -->

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>php语法形式</title>
 </head>
 <body>
 	<?php 
 		echo "第一种形式<br>";
 	 ?>
 	<script language="php">
 		echo "第二种形式<br>"
 	</script>
 </body>
 </html>