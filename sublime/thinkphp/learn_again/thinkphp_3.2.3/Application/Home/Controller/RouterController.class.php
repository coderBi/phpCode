<?php
namespace Home\Controller;
use Think\Controller;

class RouterController extends Controller{
	public function router1(){
		echo $_GET['year'].'<br>';
		echo $_GET['month'].'<br>';
		echo $_GET['day'].'<br>';
		$year = I('param.year','1997');
		$month = I('month','1');
		$day = I('day','1');
		echo 'hellow,welecome to router1. Time: '.$year.'-'.$month.'-'.$day;
	}
}