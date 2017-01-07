<?php
$arr =  Array('name'=>'xx',
				'age'=> 12,
				'province'=>'province');
foreach($arr as &$value){
	$value .='a';
}

//unset($value); //这里将value释放掉，可以解决引用问题

/*由于上一个foreach里面也是用的value，而php里面value的作用域会超出foreach。第一个foreach循环之后，value 是指向最后一个元素的，这导致第二个循环里面，效果是每次将最后一个元素修改为前面的元素，然后将其打印、*/
foreach($arr as $value){
	echo $value."<br>";
}
