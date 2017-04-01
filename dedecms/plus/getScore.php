<?php
require_once(dirname(__FILE__) . "/../include/common.inc.php");


//获取传入的模型mid  文档aid
isset($_GET['aid']) ? $aid = $_GET['aid'] : die();
isset($_GET['mid']) ? $mid = $_GET['mid'] : die();

if($GLOBALS['memcache_on']) {
    //初始化memcache
    if (!$memcache && !($memcache = memcache_edwin_init()))
        exit;
}

if($GLOBALS['memcache_on']){
    // 从memcache中获取数据
    echo getScoreFromMemcache();
    exit;
}
else{
    echo getScoreFromMysql();
    exit;
}

function getScoreFromMemcache(){
    //申明全局变量
    global $aid,$mid,$memcache;

    $key = "score-$mid-$aid";

    if(!($score = $memcache->get($key)))
        return getScoreFromMysql();
    return $score;
}

function getScoreFromMysql()
{


    //申明全局变量
    global $aid, $mid,$useMemcached, $memcache, $dsql;

    //要查询的数据库表名称
    $table = 'dede_addon' . $mid;

    $sql = "select score from $table where aid=$aid";

    //执行一条sql， 其中 me 指定的是数据集的名称
    $dsql->Execute('me', $sql);

    //从数据集中取出一条结果
    $row = $dsql->GetArray('me');

    $score = $row['score'];

    //如果设置使用memcache 就存入memcache
    if($GLOBALS['memcache_on']){
        $key = "score-$mid-$aid";
        $memcache->set($key,$score,false,0);
    }
    return $score;
}