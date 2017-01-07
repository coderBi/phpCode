<?php

$arr = 
Array
(
    0 => Array
        (
            "id" => 14,
            "name" => "Admin/Model",
        ),

    1 => Array
        (
            "id" => 2,
            "name" => "Admin/Config",
        ),

    2 => Array
        (
            "id" => 3,
            "name" => "Admin/Admin",
        ),

);

echo "<pre>";
print_r($arr);
$index = 0;
foreach($arr as $key => $value){ //这里是$value，所以循环实际上是在一个$arr的备份上面进行
	echo "<br><br>key: ".$key."<br><br>";
	echo ($index++), "<br>";
	if($value['id'] == 14)
		$value['name'] = 'xx';
	else{
		array_splice($arr, $key, 1); //删除的是原来$arr的元素，而且array_splice会改变原来的脚标（） 
	}
}

print_r($arr);
echo "</pre>";