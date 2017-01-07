<?php

$arr = array(1 => 1,
	3 => 3,
	5 => 5,
	7 => 7,);

array_splice($arr, 3, 1); //删除key位 3的元素

echo "<pre>";
print_r($arr);  //打印结果是脚标是 0 1 2。array_splice会从0 开始重置脚标。
echo "</pre>";