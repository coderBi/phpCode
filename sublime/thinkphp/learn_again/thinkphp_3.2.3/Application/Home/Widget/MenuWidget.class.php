<?php
namespace Home\Widget;
class MenuWidget extends \Think\Controller{
	public function index(){
		echo 'Home\Widget\MenuWidget 控制器 index 方法<br>';
	}

	public function func1($id=0,$name=''){
		echo 'id:'.$id.'<br>';
		echo 'name:'.$name.'<br>';
	}
}