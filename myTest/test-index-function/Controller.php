<?php
class Index{
    function  index(){
        echo "it works";
    }
}

class Index1{
    function  index(){
        echo "it works";
    }
}

class Index2{
    function  index2(){
        echo "it works";
    }
}

//打印了两个it works， 通过断点测试发现在new Index() 会执行index方法
$controller = new Index();
$controller->index();

echo '<hr>';

//打印一个it workd
$controller = new Index1();
$controller->index();

echo '<hr>';

//打印两个it works。 到此可以证实猜想，php为了满足其他语言使用者的习惯，这里与类名相同的函数名也是“构造方法”
$controller = new Index2();
$controller->index2();