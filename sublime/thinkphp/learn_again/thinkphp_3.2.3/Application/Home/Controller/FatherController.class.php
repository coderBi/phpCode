<?php
/*
	父类，用于测试查看 _initialize函数的执行效果
*/

namespace Home\Controller;
use Think\Controller;
class FatherController extends Controller{
	public function _initialize(){ //如果子类没有_initalize会自动调用父类的，如果子类有，还要调用父类的，需要显示调用。
		echo "FatherController::_initialize()<br>";
	}
	public function __construct(){ //如果子类有__contruct，这个construct内部需要显示调用父类的__construct。如果子类没有 __construct会继承父类的，调用父类的。无论是子类还是父类，只有存在__construct，就会是得_initialize失效。也就是说php原生的__construct优先级高于thinkphp的_initialize的优先级。
		echo "FatherController::__construct()<br>";
	}
	public function index(){
		echo 'FatherController::index()<br>';
	}
}