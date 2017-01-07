<?php
return array(
	//'配置项'=>'配置值'
	'URL_HTML_SUFFIX' => 'xml', //修改默认的伪静态后缀为xml
	'SHOW_PAGE_TRACE' => true,  //页面底部显示跟踪信息。
	'DEFAULT_MODULE' => 'Home', //默认home分组
	'MODULE_ALLOW_LIST' => array('Home','Admin'), //所有的允许分组
	//'TMPL_ENGINE_TYPE' => 'Smarty', //thinkphp有自己的引擎think。 这里切换为smarty
	
	//修改smarty的默认文件标记
	// 'TMPL_ENGINE_CONFIG' => array(
	// 	'left_delimiter' => '<@@',
	// 	'right_delimiter' => '@@>'
	// 	),

	//配置数据库
	'DB_TYPE'      		 => 	'mysql', //数据库类型
	'DB_HOST'      		 => 	'localhost', //服务器地址
	'DB_NAME'      		 => 	'learn_mysql', //数据库名
	'DB_USER'      		 => 	'root', //用户名
	'DB_PWD' 	   		 => 	'123', //用户密码
	'DB_PORT' 	   		 => 	'', //端口号，默认3306
	'DB_PREFIX'    		 => 	'sw_', //数据库表前缀
	'DB_PARAMS'    		 => 	array(), //数据库连接参数
	'DB_DEBUG' 	   		 => 	true, //数据库调试模式，开启之后可以记录sql日志
	'DB_FIELEDS_CACHE'	 => 	true, //是否启用字段缓存
	'DB_CHARSET' 		 => 	'utf8', //字符集编码
);