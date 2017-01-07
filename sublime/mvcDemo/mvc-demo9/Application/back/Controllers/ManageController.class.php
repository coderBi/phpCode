<?php 
/**
 * 后台管理中心控制器
 */
class ManageController extends ModuleController {
	/**
	 * 首页动作
	 */
	public function indexAction(){
		//载入后台模板
		include VIEW_PATH.'index.html';
	}
}
 ?>