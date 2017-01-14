<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        echo 'hellow thinkphp!';
    }

	public function find($id=0){
		$Data = M('data');
		$result = $Data->find($id);
		$this->assign('result', $result);
		$this->display();
	}
}