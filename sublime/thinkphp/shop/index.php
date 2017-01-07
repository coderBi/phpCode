<?php

//使用thinkPHP开发shop商城

//thinkphp默认是生产（线上）模式，可以调到开发模式
define('APP_DEBUG',true);  //如果是define('APP_DEBUG',false); 就是生产模式

//设置今天资源访问路径
define('CSS_URL','/sublime/thinkphp/shop/Public/css/');
define('IMG_URL','/sublime/thinkphp/shop/Public/images/');
define('JS_URL','/sublime/thinkphp/shop/Public/js/');

include('../ThinkPHP/ThinkPHP.php');  //引入框架接口文件