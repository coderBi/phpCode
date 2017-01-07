<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php数组部分练习题</title>
</head>
<body>
	<?php
	//得到一个数组的数字脚标个数跟所有数字之和
	function getArrSum($arr){
		$res = array(0,0);
		if(is_int($arr)){
			$res[0] += $arr;
			$res[1]++;
		} else {
			$temp = count($arr);
			for($i = 0; $i < $temp; ++$i){
				$res[0] += getArrSum($arr[$i])[0];
				$res[1] += getArrSum($arr[$i])[1];
			}
		}
		return $res;
	}
	//得到一个数字数组的平均值 
	function getArrAvr($arr){
		$sum = getArrSum($arr);
		return $sum[0] / $sum[1];
	}
	//求得一个整数数组中的最小奇数
	function getMinOdd($arr){
		$res = "";
		foreach ($arr as $value) {
			if($value % 2 == 0){
				continue;
			}
			if($res == "" || $res > $value){
				$res = $value;
			}
		}
		return $res;
	}
	 ?>
	<p>
		1,求解一个不整齐数字数组的平均值<br>
		<?php
		$arr1 = array(
			1,
			array(21,22,23,24,25),
			3,
			array(41,42,43,array(50,51,53)),
		);
		//数组不能用 . 拼接
		//echo("数组".$arr1."的平均值：".getArrAvr($arr1)."<br>");
		echo "<pre>数组";
		//不能直接echo 数组
		//echo $arr1;
		print_r($arr1);
		echo "</pre>的平均值：".getArrAvr($arr1)."<br>";
		 ?>
	</p>
	<p>
		2,确定一个整数数组中最小的奇数，如果没有奇数就输出“没有奇数”<br>
		<?php
		$arr2 = array(2,3,6,7,9,-51);
		if(($res = getMinOdd($arr2)) != ""){
			echo "<pre>数组";
			print_r($arr2);
			echo "</pre>中的最小奇数：".$res."<br>";
		} else{
			echo "没有奇数<br>";
		}
		
		 ?>
	</p>
	<p>
		3,调用系统提供的sort函数排序<br>
		<?php 
		//可以发现sort只会整理里面的标量，不会对要排序的数组
		//中array这样的复杂结构以及其里面的数据项进行排序
		$arr3 = array(
			array(42,41,40,array(50,51,53)),
			array(21,22,23,24,25),
			3,
			1,
		);
		echo "<pre>数组";
		print_r($arr3);
		sort($arr3);
		echo "</pre>调用系统sort后排序结果：<pre>";
		print_r($arr3);
		echo"</pre><br>";
		 ?>
	</p>
</body>
</html>