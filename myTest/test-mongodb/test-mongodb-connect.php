<?php
$host = 'localhost';
$port = 27017;
//实际使用发现php不建议直接使用Mongo类，而是使用Mongo的父类 MongoClient
$client = new  MongoClient("mongodb://localhost:27017");  

//选择数据库
$db = $client->selectDB('user');

//查询user集合的所有数据
$users = $db->user->find();
var_dump($users);  //一个MongoCursor 对象
foreach($users as $user){
	//$user是一个array 而不是对象
	var_dump($user);
}