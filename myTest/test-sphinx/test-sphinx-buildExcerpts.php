<?php
header("Content-Type:text/html;charset=utf-8");

set_include_path(get_include_path().';D:\WebSever\coreseek-3.2.14-win32\api');
//包含php操作的api文件 这个文件的位置在 coreseek安装目录下面的api目录下
require_once('sphinxapi.php');

//连接
$sc = new SphinxClient();
$sc->SetServer('localhost',9312);

$res = $sc->query('1942','dede_addon17');

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

//输出查询到的数组
foreach($data as $k=>$v){
	$v = $sc->buildExcerpts($v, 'dede_addon17', '陈道明张国立',
	array(
		//在关键词前面加上的内容
		'before_match' => '<span style="color:red;font-weight:bold;font-size:16px;">',
		//在关键词后面加上的内容
		'after_match' => '</span>',
		//最大返回的摘要长度 默认256
		'limit' => 100,
	));
	echo $v[1].'<hr>'; //对应的是title
	echo $v[2].'<br><br>'; //对应introduce
}

//关闭sphinx连接
$sc->close();
