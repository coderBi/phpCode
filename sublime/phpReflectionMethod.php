<?php
//php里面的反射
//通过反射，可以感知这个类里面有哪些属性，哪些方法，这些方法是私有还是public的。

class Person {
	function say() {
		echo "xiaoming says";
	}
	function sing($addr,$name) {
		echo 'xiaoming is at'.$addr.',he is singing,name is '.$name;
	}
}

$per = new Person();

//无参数调用
$method1 = new ReflectionMethod($per, 'say');
$method1->invoke($per);

//有参数调用
echo '<br>';
$method2 = new ReflectionMethod( $per, 'sing' );
$method2 -> invokeArgs( $per, array( '北京', '小小鸟' ) );
