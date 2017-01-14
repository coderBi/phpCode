<?php
return array(
	//'配置项'=>'配置值'
	
	//默认分组, url如果没有提供分组，就访问默认分组
	'DEFAULT_MODULE' => 'Home',
	'MODULE_ALLOW_LIST' =>array('Home','View'),  //如果设置了上面的DEFAULT_MODULE，那么这一项是必不可少的，否则会解析错误。

	//配置数据库
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'localhost',
	'DB_NAME'=>'thinkphp',
	'DB_USER'=>'root',
	'DB_PWD'=>'123',
	'DB_PORT'=>3306,
	'DB_PREFIX'=>'think_',
	'DB_CHARSET'=>'utf8',

	//如果开启了调试模式并且希望在页面显示调试信息，开启 SHOW_PAGE_TRACE
	'SHOW_PAGE_TRACE'=>true,

	//开启路由  配置动态路由  配置静态路由。 如果需要对某一个分组进行配置，可以配置到分组的config.php
	'URL_ROUTER_ON' => true,

	//添加动态路由的配置
	'URL_ROUTE_RULES' => array(
		'rtest/:router^router1/:year\d/:month\d/:day\d$' => 'Router/router1?year=100&month=:3&day=:4',
		'rtest/:router^router1$' => 'Router/router1?year=2016&month=12&day=31',
		//'/^regtest\/(\d{4})\/(\d{2})\/(\d{2})$/' => array('Router/router1',array('year'=>':2','month'=>':3','day'=>':4')), //数组形式路由地址没有办法使用 : 1引用
		'/^regtest\/(\d{4})\/(\d{2})\/(\d{2})$/' => 'Router/router1?year=:1&month=:2&day=:3',
		'rfunction/:year/:month/:day' => function($year=0,$month=0,$day=0){
			echo '闭包函数：'.$year.'-'.$month.'-'.$day;
		},
	), //动态路由
	'URL_MAP_RULES' => array(
		'map/map1' => array('Where/chain2',array('name'=>'bww')),
	), //静态路由

	//引入额外的配置文件，多个文件名中间用 ','隔开，并且不能有多余的空格。如果是应用的config中引入，会到应用的conf目录寻找文件；相似的，如果是分组的config.php中引入，就会到分组的目录下面找。
	'LOAD_EXT_CONFIG' => 'ext',
);