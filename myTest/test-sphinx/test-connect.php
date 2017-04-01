<?php
header("Content-Type:text/html;charset=utf-8");

set_include_path(get_include_path().';D:\WebSever\coreseek-3.2.14-win32\api');
//包含php操作的api文件 这个文件的位置在 coreseek安装目录下面的api目录下
require_once('sphinxapi.php');

//连接
$sc = new SphinxClient();
$sc->SetServer('localhost',9312);

//查询  第二个参数指定的是sphinx里面的index  默认搜索模式是分词搜索(例如，这里的‘无间道’被分成了 '无间'和‘道’ 这两个词进行搜索。),分词的标准在语言包里面
$res = $sc->query('1942','dede_addon17');
if(!$res){
	die('查询sphinx失败');
}
var_dump($res);

//获取所有匹配到的id
$ids = array_keys($res['matches']);
$ids = implode(',',$ids);

//连接mysql
$mysqli = new mysqli('localhost','root','123','dedecmsv57utf8sp2');
$mysqli->query('set names utf8');

//通过返回的ids 查询mysql
$sql = "select a.id,a.title,b.introduce,b.score from dede_archives a join dede_addon17 b on a.id=b.aid where a.id in($ids)";

$result = $mysqli->query($sql);
$data = array();
while($row = $result->fetch_assoc()){
	$data[] = $row;
}

//释放mysql
$result->free();
$mysqli->close();

var_dump($data);

//关闭sphinx连接
$sc->close();
