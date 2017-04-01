<?php
namespace Bind\Controller\Bind;
use Think\Controller;
class index extends Controller{
	public function _before_run(){
		echo '这里是Bind\Bind\index的前置方法<br>';
	}
	public function run(){ //index操作实际执行代码
		echo '这里是Bind\Bind\index实际执行的run方法<br>';
	}
	public function _after_run(){
		echo '这里是Bind\Bind\index的后置方法<br>';
	}
}