<?php
//表示大于2038年的日期  也就是2k38问题
//构造函数可以提供时间戳new DateTime('@1491434438')  也可以提供 new DateTime('2017-04-06 07:20:38');
$date = new DateTime('2017-04-01 07:20:38');
//设置为东八区
$date->setTimezone(new DateTimeZone('PRC'));
$str = $date->format('Y-m-d H:i:s');
echo $str.'<br>';

//获取时间戳
$timestamp = $date->format('U');
echo $timestamp.'<br>';