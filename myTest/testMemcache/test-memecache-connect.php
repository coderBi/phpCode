<?php
$host = 'localhost';
$port = 11211;  //默认端口

$memcache = new Memcache();

//建立连接
if(!$memcache->connect($host, $port))
    die('memcache服务器连接失败');

//第三个参数表示是否使用zlib进行压缩  第四个参数表示过期时间  如果是0表示永不过期
$memcache->add('testkey','testvalue',false,0);

$value = $memcache->get('testkey');

echo $value;
