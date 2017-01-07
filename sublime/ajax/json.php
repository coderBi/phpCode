<?php
//索引数组
$color = array('red','blue','green');
echo json_encode($color),'<br>';  //js数组 ['red','blue','green']

//关联数组
$city = array('xx'=>'xx',);
echo json_encode($city),'<br>'; //js对象  {"xx": "xx"}

//索引关联数组
$city = array('xx'=>'xx','another');
echo json_encode($city),'<br>'; //js对象  {"xx": "xx",'0':'another'}

//对象
class Person {
	public $name = 'xx';
	var $age = 12;
	public function run(){}
}
$p = new Person();
echo json_encode($p),'<br>';  //json对象 {'name':'xx','age':12} 方法不会生成属性

//json_decode，第二个参数为true表示返回的非Object而是array
$x = json_decode(json_encode($p),true);
var_dump($x);
echo "<br>";
echo gettype( json_encode($p) ),"<br>";  // json_encode得到的类型是string，也就是称为的“json字符串”

//自定义json字符串。自定的外面的引号必须是单引号。而且属性名称也得用双引号括起来
//$json_str = "{'name':'xx'}"; 这样写js_decode得到的是null
$json_str = '{"name":"xx"}';
var_dump(json_decode($json_str));
echo "<br>";