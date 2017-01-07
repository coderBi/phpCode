<?php 
/**
 * 后台模块基础控制器类
 */
class ModuleController extends BaseController {
	public function __construct(){
		//强制调用父类构造方法
		parent::__construct();
		//开启session
		$this->_startSession();
		//校验是否具有登录凭证
		$this->_isLogin();
	}
	/**
	 * 配置ini数据项
	 */
	protected function _configIni(){
		//配置当前session文件存放位置，需要在开启session之前配置
		ini_set('session.save_path','D:/phpCode/temp/');
	}
	/**
	 * 开启session,项目中不仅仅是登录校验需要开启
	 */
	protected function _startSession(){
		//配置php.ini数据项
		$this->_configIni();
		//开启session
		session_start();
	}

	/**
	 * 检测当前是否有登录凭证
	 */
	protected function _isLogin() {
		//特例列表，不需要进行校验
		//哪个控制器的哪个动作不需要进行校验
		$no_check = array(
			'Admin' => array('Login','Check'),
			);
		//判断是否处于特例列表
		if(isset($no_check[CONTROLLER]) &&
			in_array(ACTION,$no_check[CONTROLLER])) {
			//在特例列表里面
			return;
		}
		//判断是否具有登录凭证
		if(!isset($_SESSION['username'])){
			//登录标志不存在
			//判断是否采用cookie记录了登录状态 && 可以校验成功
			$m_admin = ModelFactory::M('AdminModel');
			if(isset($_COOKIE['username']) && isset($_COOKIE['password']) &&
				$m_admin->checkRemember($_COOKIE['username'],$_COOKIE['password'])){
				//记录了登录状态并且通过了验证
				return;
			} else {
				//没有记录登录状态或者登录状态验证不过通过
				$this->_jumpNow('?p=back&c=Admin&a=Login');
			}
		}
	}
}
 ?>