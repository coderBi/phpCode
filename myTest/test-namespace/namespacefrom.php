<?php
namespace TestOne;

//存放一个类  可以在引用文件中通过 use test\MyCls; 使用这个类
class MyCls{
    function output(){
        echo "hello test";
    }
}

//外部函数
function output(){
    echo "hello out";
}
