<?php
namespace View\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        echo 'hellow, 这个模块用作thinkphp的视图学习<br>';
		echo '主要包括；视图文件路径、视图文件后缀、不对应控制器与方法的视图引用、视图中的变量绑定与输出，以及视图中的循环与控制判断';
    }

	public function show1(){
		$content = $this->fetch('View@Index:show'); //View模块下的 Index/show.html
		$this->show($content,'utf-8','text/html');
	}

	///这个函数会调用失败，因为在当前View模块下面改变了模块的视图文件夹名称跟模块的后缀，以及控制器与方法的分隔符。
	public function show2(){
		$content = $this->fetch('Home@Index:index'); //引入其他模块的文件
		$content = "<span style='color:teal'>外面添加的内容</span>".$contnet;
		$this->show($content);
	}

	public function show3(){
		$result['id'] = 100;
		$result['data'] = '外部添加';
		$this->assign('result',$result);
		$this->display('./Application/Home/View/Index/find.html'); //引入相对index.php路劲的文件。需要带上自己的后缀
	}

	public function showSysVar(){
		echo "<p style='color:red'>利用\$Think输出环境变量：</p>";
		$this->display();
	}

	public function useFunc(){
		$result = array('id'=>2, 'name'=>'这是一个存在的名字哟');
		$this->assign('result',$result);
		$this->display();
	}

	public function volist(){
		$data = array(
			array(
				'name' => 'name1',
				'age' => 1,
			),
			array(
				'name' => 'name2',
				'age' => 2,
			),
		);
		$empty = "<span style='color:pink'>不存在任何的数据</span>";
		$this->assign('data', $data);
		$this->assign('empty', $empty);
		$this->display();
	}

	public function layout1(){
		//使用layout标签布局
		$this->display('layout1');
	}

	public function layout2(){
		//controller中使用layout函数布局
		layout('Layout/newLayout');
		$this->display('layout2');
	}

	public function layout3(){ //嵌套layout
		layout('Layout/embed');
		$this->display('layout2');
	}

	public function layout4(){ //使用include进行嵌套
		$this->display('layout3');
	}
}