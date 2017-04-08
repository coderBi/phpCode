<?php
require_once("namespacefrom.php");
use TestOne\MyCls;

//使用test下面的一个类
$cls = new MyCls();
$cls->output();

//使用test里面的一个不放到类里面的函数  注意这里没有办法使用 use test;直接使用
TestOne\output();