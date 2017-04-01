<?php
namespace Home\Model;
use Think\Model;

class ValidateAndAutoModel extends Model{
	protected $_validate = array(
		array('name','require','name不能为空',self::EXISTS_VALIDATE,'regex',3),
		array('password','6,12','密码长度必须是6~12',self::EXISTS_VALIDATE,'length',3),
		array('repassword','password','两次密码不一致',0,'confirm',3),
	);
	protected $_atuo = array(
		array('password','md5',3,'function'),
		array('descripe','getDescripe',1,'callback'), //插入的时候进行填充
		array('update_time','time',2,'function'), //更新的时候进行填充
	);
	public function getDescripe(){
		return '没有任何介绍信息';
	}
}