<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php里面的overloading</title>
</head>
<body>
	<?php 
	//利用魔术方法实现其他语言里面的重载
	class A{
		//如果是调用的求平方和函数：如果参数都是标量就返回计算结果，否则返回调用信息
		function __call($method,$arguments){
			$count = count($arguments);
			if($method == 'getPingfangSum'){
				$sum = 0;
				$flag = 0;
				for($i = 0; $i < $count; ++$i){
					//只有所有参数都是标量的时候才进行计算
					if(!is_numeric($arguments[$i])){
						$flag = 1;
					}
				}
				if($flag == 0){
					for($i = 0; $i < $count; ++$i){
						$sum += $arguments[$i]*$arguments[$i];
					}
					return $sum;
				} else {
					$str = "函数名:".$method.' 参数是：';
					for($i = 0; $i < $count - 1; ++$i){
						$str .= $arguments[$i].',';
					}
					$str .= $arguments[$count -1].';';
					return $str;
				}
			} else {
				return '没有这个函数';
			}
		}	
	}
	$a1 = new A();
	echo "\$a1->getPingfangSum(1,2): ".$a1->getPingfangSum(1,2).'<br>';
	echo "\$a1->getPingfangSum(1,2,3): ".$a1->getPingfangSum(1,2,3).'<br>';
	echo "\$a1->getPingfangSum(1,2,'qw'): ".$a1->getPingfangSum(1,2,'qw').'<br>';
	echo "\$a1->getPingfang(1): ".$a1->getPingfang(1).'<br>';
	 ?>
</body>
</html>