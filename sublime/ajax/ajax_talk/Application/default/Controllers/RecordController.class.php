<?php
class RecordController extends ModuleController {
	function __construct() {
		parent::__construct();
	}

	/**
	 * 获取最新的聊天记录
	 * @return  输出最新记录集的json字符串
	 */
	function getAction(){
		$maxId = !empty($_GET['maxId']) ? $_GET['maxId'] : 0; //获取页面提交的maxId，默认是 0
		$recordModel = new RecordModel();
		echo json_encode($recordModel->get($maxId));
	}

	function addAction(){
		if(!isset($_SESSION['name'])) {echo false; return;}
		$content = !empty($_POST['content_say']) ? $_POST['content_say'] : ""; //聊天内容
		$receiver = !empty($_POST['receiver']) ? $_POST['receiver'] : "所有人"; //接受者
		$sender = $_SESSION['name'];

		//利用RecodModel写入数据库
		$recordModel = new RecordModel();
		echo $recordModel->add($content,$sender,$receiver);
	}
}