<?php
namespace Home\Controller;
use Think\Controller;
class FormController extends Controller{
	public function insert(){
		$Form = D('Form'); //D方法需要创建对应的模型类
		if($Form->create()){ //使用create方法会进行自动表单验证跟自动完成
			$result = $Form->add(); //如果是自增主键返回主键，如果不是并且插入成功返回插入的条数，如果执行失败返回false
			if($result){
				$this->success('数据添加成功');
			} else{
				$this->error('数据添加失败');
			}
		} else{
			$this->error($Form->getError()); //如果create执行失败，可以通过getError得到错误信息
		}
	}

	public function read($id=0){
		$Form = M('Form'); //使用M方法，不是使用D方法，如果下面使用的方法是在基础Model类中。这样没必须多余的开销
		$data = $Form->find($id); //find返回一个键值对数组，key是数据库中的列名。value是相应的值。如果没有找到内容返回false
		if($data){
			$this->assign('data', $data);
		} else{
			$this->error('数据错误');
		}
		$this->display();
	}

	public function edit($id=0){
		$Form = M('form');
		$this->assign('vo', $Form->find($id));
		$this->display();
	}

	public function update(){
		$form = D('form');
		if($form->create()){
			$result = $form->save(); //save保存，默认自动识别主键进行保存
			if($result){
				$this->success('更新成功');
			} else{
				$this->error('更新失败');
			}
		} else{
			$this->error($form->getError());
		}
	}
}