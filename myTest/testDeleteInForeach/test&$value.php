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
foreach($arr as $key => &$value){
	echo "<br><br>key: ".$key."<br><br>";
	echo ($index++), "<br>";
	if($value['id'] == 14)
		$value['name'] = 'xx';
	else{
		array_splice($arr, $key, 1); //删除
	}
}

unset($value);
print_r($arr);
echo "</pre>";