<?php
//命名空间
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends Controller {
	//商品列表
	function showlist() {
		$goods = new \Model\GoodsModel();
		echo '<pre>';
		var_dump($goods);
		echo '</pre>';
		$this->display();
	}

	//添加
	function addGoods() {
		$this->display();
	}

	//修改
	function updateGoods() {
		$this->display();
	}
}