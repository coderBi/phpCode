<?php
namespace Home\Controller;
class InitializeController extends FatherController{
	public function _initialize(){ //如果子类或者父类存在 __contruct会导致 _initialize失效。如果都不存在。这个时候如果子类有_initialize就用子类的，如果没有就用父类的_initialize，这个时候子类如果要用父类的_initialize需要显示的调用。
		echo '_initialize<br>';
	}
	public function index(){
		echo 'index<br>';
		$this->anotherFunc();
	}
	public function _before_index(){
		echo '_before_index<br>';
	}
	public function _after_index(){
		echo '_after_index<br>';
	}
	public function anotherFunc(){
		echo 'anotherFunc<br>';
	}
}