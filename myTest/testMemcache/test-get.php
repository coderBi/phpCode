<?php
$host = 'localhost';
$port = 11211;  //默认端口

$memcache = new Memcache();

//建立连接
if(!$memcache->connect($host, $port))
    die('memcache服务器连接失败');

//获取一个值
$value = $memcache->get('testkey');
var_dump($value);

//替换一个值  通过实验证明 这个函数如果指定的key不存在并不会进行新的set
$memcache->replace('testkey','newtestvalue',false,0);

//重新获取
$value = $memcache->get('testkey');
var_dump($value);

//获取一个不存在的值  如果不存在返回false
$value = $memcache->get('noexist');
var_dump($value);