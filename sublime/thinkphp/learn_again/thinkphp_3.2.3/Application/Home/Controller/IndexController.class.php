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

	public function _empty(){ //访问函数名不存在会自动访问这个函数
		echo '不存在相应操作';
	}

	private function pvt(){ //私有方法，如果外部进行请求，也会转到_empty
		echo "pvt";
	}

	public function _before_funcIn(){ //前置
		echo '_before_funcIn<br>';
	}
	public function _after_funcIn(){ //后置
		echo '_after_funcIn<br>';
	}
	public function funcIn(){
		echo 'funcIn<br>';
	}

	public function gotoSuccess(){
		$this->success('操作成功，即将跳转',$_SERVER['SCRIPT_NAME'].'/Home/Index/index',3);
	}

	public function gotoError(){
		$this->error('操作失败，即将跳转','https://baidu.com',3);
	}

	public function redirect1(){
		//redirect('/Index/index',3); //解析有问题，redirect函数第一个提供的是url如果给的是/Index/index会请求localhost/Index/index。如果给的是Index/index会解析成当前Controller下面的Index/index后面一个index解析成了参数，第一个Index解析成方法。所以使用redirect第一个参数指定的是url，如果值站点内部，可以通过U方法生成url

		//redirect(U('Home/Index/index'),3,'正在跳转中...'); //站点内部url.

		//redirect('http:/baidu.com', '5', '页面跳转中...'); //外部url

		redirect('http://baidu.com',3);  //默认的提示信息是：系统即将3秒后跳转到http://baidu.com
	}

	public function redirect2(){ //$this->redirect
		$this->redirect('View/Index/index','id=1',3,'正在跳转中..');
	}

	public function ajaxJson(){
		$data['id'] = 1;
		$data['name'] = '搞笑';
		$this->ajaxReturn($data, 'json'); //返回json
	}

	public function ajaxXml(){
		$data['id'] = 1;
		$data['name'] = 'bww';
		$data['age'] = 18;
		$this->ajaxReturn($data, 'xml'); //会返回一个根节点是think的xml文档。id name age 都被解析成根节点下面的子节点。
	}

	public function suffix(){
		$toEcho = '请求的后缀是：'.__EXT__;
		echo $toEcho;
	}

	public function callMenuWidget1(){ //调用Widget\MenuWidget控制器
		$menu = A('Menu','Widget'); //实例化Widget/MenuWidget对象
		$menu->index();
	}

	public function callMenuWidget2(){
		$this->display();
	}

	public function callMenuWidget3(){
		R('Menu/func1',array(2,'哈哈'),'Widget'); //R方法（'控制器/方法','参数','分层控制器名'）
	}

	public function showAddForm(){
		$action = U('Home/Index/add2ValidateAndAutoTable');
		$this->assign('action',$action);
		$this->display('ValidateAndAuto/form');
	}

	public function showUpdateForm(){
		$action = U('Home/Index/update2ValidateAndAutoTable');
		$this->assign('action',$action);
		$this->display('ValidateAndAuto/form');
	}

	public function add2ValidateAndAutoTable(){
		$validateAndAutoModel = D('validateAndAuto');
		if($validateAndAutoModel->create()){
			$validateAndAutoModel->add();
		} else{
			die($validateAndAutoModel->getError());
		}
	}

	public function update2ValidateAndAutoTable(){
		
	}
}