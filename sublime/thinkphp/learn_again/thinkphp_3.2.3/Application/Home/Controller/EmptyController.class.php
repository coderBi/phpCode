<?php
namespace Home\Controller;
use Think\Controller;

class EmptyController extends Controller{
	public function _empty(){
		echo "Home模块下没有找到相应的Controller";
		echo '<br>';
		echo "控制器".__CONTROLLER__.'不存在';
	}
}