<?php
header("Content-Type:text/html;charset=utf-8");

set_include_path(get_include_path() . ';D:\WebSever\coreseek-4.1-win32\coreseek-4.1-win32\api');
//包含php操作的api文件 这个文件的位置在 coreseek安装目录下面的api目录下
require_once('sphinxapi.php');

//连接
$sc = new SphinxClient();
$sc->SetServer('localhost', 9312);

//连接mysql
$mysqli = new mysqli('localhost', 'root', '123', 'dedecmsv57utf8sp2');
$mysqli->query('set names utf8');


$res = $sc->query('倚天', 'dede_addon17');
var_dump($res);
if (!$res) {
    die('查询sphinx失败');
}
if (isset($res['matches'])) {
    $ids = array_keys($res['matches']);
    $ids = implode(',', $ids);
    var_dump($res['matches']);
    getFromMysql($ids);
} else {
    echo '没有符合的数据1<br>';
}


//只查询title
var_dump($res);
$sc->SetMatchMode(SPH_MATCH_EXTENDED);
$res = $sc->query('@title 倚天苏有朋', 'dede_addon17');
if (!$res) {
    die('查询sphinx失败');
}

if (isset($res['matches'])) {
    $ids = array_keys($res['matches']);
    $ids = implode(',', $ids);
    var_dump($res['matches']);
    getFromMysql($ids);
} else {
    echo '没有符合的数据2<br>';
}

//使用filter
$sc->SetMatchMode(SPH_MATCH_ALL);
$sc->SetFilter('years',array(crc32('2015')));
$res = $sc->query('倚天', 'dede_addon17');
var_dump($res);
if (!$res) {
    die('查询sphinx失败');
}
if (isset($res['matches'])) {
    $ids = array_keys($res['matches']);
    $ids = implode(',', $ids);
    var_dump($res['matches']);
    getFromMysql($ids);
} else {
    echo '没有符合的数据3<br>';
}


//关闭mysql
    $mysqli->close();

//关闭sphinx连接
    $sc->close();


    function getFromMysql($ids)
    {
        global $mysqli;
        $sql = "select a.id,a.title,b.introduce,b.score from dede_archives a join dede_addon17 b on a.id=b.aid where a.id in($ids)";

        $result = $mysqli->query($sql);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        var_dump($data);
        //释放mysql
        $result->free();
    }
