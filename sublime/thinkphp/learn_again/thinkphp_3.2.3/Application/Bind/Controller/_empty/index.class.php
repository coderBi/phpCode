<?php
namespace Bind\Controller\_empty;
use Think\Controller;
class index extends Controller{
	public function run(){ //index操作实际执行代码
		echo '这里是Bind\_empty\index实际执行的run方法。如果没有找到一个控制器会执行到_empty控制器';
	}
}