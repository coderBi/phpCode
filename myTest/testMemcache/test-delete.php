<?php
$host = 'localhost';
$port = 11211;  //默认端口

$memcache = new Memcache();

//建立连接
if(!$memcache->connect($host, $port))
    die('memcache服务器连接失败');

$key = 'score-17-3'; //要删除的key

if(!$memcache->get($key)){
    echo "不存在key为{$key}的元素";
    exit;
}
if($memcache->delete($key)){
    echo '删除成功';
} else
    echo '删除失败';