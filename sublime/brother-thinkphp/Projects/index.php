<?php 
	//确定应用名称，前台应用一般取名为Home， 后台一般取名Admin
	//第一次运行，会自动在index同级目录创建Home文件夹
	define('APP_NAME', 'Home');

	//确定应用路径, 当前index文件目录下面的Home文件夹
	define('APP_PATH', './Home/'); //注意这个路径的写法后面一定要有那个 "/",否则会出问题

	//开启debug模式，默认是关闭的。debug模式下，没有缓存（也就是相应的runtime目录下面会少很多东西），修改配置文件会立即生效。
	define('APP_DEBUG',true);

	//引入核心文件
	require './ThinkPHP_3.2.3/ThinkPHP.php'; //注意区分大小写，因为可能项目需要迁移到linux这样区分文件名大小写的系统
	
 ?>