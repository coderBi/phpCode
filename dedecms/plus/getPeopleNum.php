<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");


//获取传入的模型mid  文档aid
isset($_GET['aid']) ? $aid = $_GET['aid'] : die();
isset($_GET['mid']) ? $mid = $_GET['mid'] : die();

if($GLOBALS['memcache_on']) {
    //初始化memcache
    if (!$memcache && !($memcache = memcache_edwin_init()))
        exit;
}

if($GLOBALS['memcache_on']){
    //从memcache中获取数据
    $key = "peoplenum-$mid-$aid";
    if($peoplenum  = $memcache->get($key))
        echo $peoplenum;
    else
        getPeopleNumFromMysql();
}
else{
    getPeopleNumFromMysql();
}

function getPeopleNumFromMysql(){
    global $aid,$mid,$dsql,$useMemcached,$memcache;

    //要查询的数据库表名称
    $table = 'dede_addon'.$mid;

    $sql = "select people_num from $table where aid=$aid";

    $row = $dsql->GetOne($sql,MYSQLI_ASSOC);

    echo $row['people_num'];

    //修改memcache中数据
    if($GLOBALS['memcache_on']){
        $key = "peoplenum-$mid-$aid";
        $memcache->set($key,$row['people_num'],false,0);
    }
}
$memcache->close();
