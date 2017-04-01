<?php
//引入dede的数据库操作类  通过实际应用发现这个require必须写在前面  如果是中途插入可能将这个语句之前执行的结果变量进行了一些意想不到的处理(例如之前因为将require的这个语句放到unserialize后面，发现之后这个反序列化的变量又成了字符串。内部的源码暂时没看，但是这个文件看来必须得先引入)
require_once(dirname(__FILE__)."/../include/common.inc.php");

if($GLOBALS['memcache_on']) {
    //初始化memcache
    if (!$memcache && !($memcache = memcache_edwin_init()))
        exit;
}

//处理传入数据
isset($_GET['score']) ? $score = $_GET['score'] : die();
isset($_GET['aid']) ? $aid = $_GET['aid'] : die();
isset($_GET['mid']) ? $mid = $_GET['mid'] : die();

//获取已经评分的aids列表
isset($_COOKIE['score_aids']) ?  $score_aids = unserialize($_COOKIE['score_aids']) : $score_aids = array();

//判断当前这个aid 是否存在于已经评分过的aids列表中
if(in_array($aid, $score_aids)){
    //已经评论过  直接返回
    echo '-1';
    exit;
}

//利用dede中操作数据库对行啊 $dsql
$table = "dede_addon$mid";
$sql = 'select score, people_num from '.$table.' where aid='.$aid;

//执行一条sql， 其中 me 指定的是数据集的名称
$dsql->Execute('me', $sql);

//从数据集中取出一条结果
$row = $dsql->GetArray('me');

//更新评分  更新评分人数
$newScore = ($row['score']*$row['people_num'] + $score) / ($row['people_num'] +1);
$dsql->ExecNoneQuery("update  $table set score=$newScore,people_num=people_num+1 where aid=$aid");

//评分写入数据库成功后  将这个aid加入到score_aids列表中
$score_aids[] = $aid;

//重置cookie  设置cookie访问目录 /  一级域名跟子域名可以访问到
setcookie('score_aids',serialize($score_aids),mktime(23,59,59,date('m'),date('d'),date('Y')),'/','testphp.com');

//返回新的平均值
echo $newScore;

//更新memcache
if($GLOBALS['memcache_on']){
    $score_key = "score-$mid-$aid";
    $people_key = "peoplenum-$mid-$aid";
    $memcache->set($score_key,$newScore);
    $memcache->set($people_key,$row['people_num']+1);
}
$memcache->close();