<?php
namespace Home\Controller;
use Think\Controller;

class WhereController extends Controller{

	//字符串作为查询条件
	public function where1(){
		$where = 'id>0 and id<100';
		$form = M('form');
		if(!$form){
			$this->error('创建form 模型类失败');
		}
		$this->assign('result', $form->where($where)->select());
		$this->display('where');
	}

	//数组作为查询条件
	public function where2(){
		$where['id'] = 2;
		$where['content'] = '你好';
		//调整数组中各项的逻辑关系
		$where['_logic'] = 'or';
		$form = M('form');
		if(!$form){
			$this->error('创建form 模型类失败');
		}
		$this->assign('result', $form->where($where)->select());
		$this->display('where');
	}

	//对象作为查询条件
	public function where3(){
		$form = M('form');
		if(!$form){
			$this->error('创建form 模型类失败');
		}
		$where = new \stdClass(); //stdClass是php5添加的，相当于所有的类的基类。注意这里的创建用的命名空间是 \ 。因为stdClass 是php的内置对象。
		$where->id = 2;
		$where->content = '你好';
		$where->_logic = 'or';
		$this->assign('result', $form->where($where)->select());
		$this->display('where');
	}

	//不同字段不同值的快捷查询
	public function where4(){
		$form = M('form');
		if(!$form){
			$this->error('创建form 模型类失败');
		}
		$map['id|content'] = array(array('eq',1),array('notlike', '%你好%'),'_multi'=>true); //多条件,id|content 表示逻辑关系是or
		$this->assign('result',$form->where($map)->select());
		$this->display('where');
	}

	//区间查询
	public function where5(){
		$form = M('form');
		if(!$form){
			$this->error('创建form 模型失败');
		}
		$map['id'] = array(array('egt',1), array('elt',5), 'and');
		$this->assign('result',$form->where($map)->select());
		$this->display('where');
	}

	//组合查询
	public function where6(){
		$form = M('form');
		if(!$form){
			$this->error('创建form 模型失败');
		}
		//通过测试 如果后面设置了 $where['_query']  这里的$where['_string']就必须注释掉，否则会在where条件中多出来一个空的 (),也就是$where['_query']将$where['_string']解析成普通的属性了，然后又由于某种原因解析成了空。 
		//$where['_stirng'] = 'id=1';//组合查询之字符串模式查询
		//$where['_logic'] = 'or';

		$where['_query'] = 'id=2&content=你好&_logic=or'; //组合查询之请求字符串查询,类似于url
		
		$map['_complex'] = $where; //组合查询之复合查询
		$map['id'] = array('lt', 100);
		$this->assign('result',$form->where($map)->select());
		$this->display('where');
	}

	//统计查询
	public function where7(){
		$form = M('form');
		if(!$form){
			$this->error('创建form model类对象失败');
		}
		$where = $form->where('id<100');
		echo 'count(): '.$where->count().'<br>';
		echo 'count(id): '.$where->count('id').'<br>';
		echo 'avg(id): '.$where->avg('id').'<br>';
		echo 'max(id): '.$where->max('id').'<br>';
	}

	//动态查询 + 子查询
	public function where8(){
		$form = M('form');
		if(!$form){
			$this->error('创建form model类对象失败');
		}
		$subQuery = $form->where('id<100')->buildSql(); //buildSql不返回结果而是创建一个子查询供后续使用
		echo 'count: '.$form->table($subQuery.' a')->count().'<br>'; //注意子查询用作table必须要取别名
		echo "content: ".$form->table($subQuery.' a')->getFieldByTitle('什么鬼','content'); //动态查询getFieldBy
	}

	//连贯操作 field data page limit distinct table
	public function chain1(){
		$form = M('data'); //这里创建的模型内部默认操作的是data表
		if(!$form){
			$this->error('创建form model类对象失败');
		}
		$data = new \stdClass();
		$data->title = 'chain1';
		$data->content = 'chain1';
		//field('create_time',true) 表示除了create_time其他的字段都取出来
		$this->assign('result',$form->table('think_form')->data($data)->field('create_time',true)->order('id desc')->page('1,10')->limit('0,5')->distinct(true)->select());
		$this->display('where');
	}

	//连贯操作 validate create. 注意这两个函数是进行表单验证相配合的。create数据源默认是POST数组。另一点要注意的是如果一个变量isset为false，那么就不会对它进行相应的验证，即使设置了与它相关的require之类的验证条件。由于这种跳过不验证，会导致结果create的结果返回成功
	public function chain2(){
		$form = M('form');
		if(!$form){
			$this->error('创建form model类对象失败');
		}
		$data = new \stdClass();
		$data->title = ''; //这一行，如果被注释掉，就不会产生任何的验证，即使下面定义了针对title的验证。create也会返回成功
		$data->content = 'chain2';
		$data->create_time = 0;
		$create = $form->validate(array(array('title','require','title必须')))->create($data); //create方法，填充$form的data属性。这里没有表单，所以给create传参数。
		if($create){ //验证通过， create函数内部会将验证通过后的内容填充到当前model对象的data属性。
			echo '验证通过,data:<br>';
			print_r($form->data());
		} else{
			echo '验证失败,'.$form->getError();
			echo '<br>最后的sql：'.$form->getLastSql();
			echo '<br>data: ';print_r($form->data()); //如果create验证失败，内部的data内容还是空，$form->data()会返回当前的$form对象。
		}
	}

	//data函数是向model类中的data属性进行填充。create方法也是填充data属性。r如果自己用data函数填充，就没有系统的验证，需要自己处理。
	public function data(){
		$form = M('form');
		if(!$form){
			$this->error('创建form model类对象失败');
		}
		$data['id'] = 1;
		$data['title'] = 'chain2';
		$data['content'] = 'chain2';
		$data['create_time'] = time();
		$result = $form->data($data)->data();
		$this->assign('result',array($result));
		$this->display('where');
	}
}