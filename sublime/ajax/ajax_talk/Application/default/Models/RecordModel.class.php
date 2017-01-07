<?php
class RecordModel extends BaseModel {
	function __construct() {
		parent::__construct();
	}

	/**
	 * 从数据库获取最新记录
	 * @param  int $id 页面传过来的已经传送的最大id
	 * @return 二维数组     最新记录的数组
	 */
	function get($id){
		$sql = "select * from ajax_talk where id > ".$id.";";
		$result = $this->db->fetchAll($sql);
		return $result;
	}

	/**
	 * 向ajax_talk添加一天记录
	 * @param string $content  聊天内容
	 * @param string $sender   发送人
	 * @param string $receiver 接收人
	 * @return  成功返回受影响的记录数、失败返回false
	 */
	function add($content,$sender,$receiver){
		$sql = "insert into ajax_talk value(null,'".$sender."','".$receiver."','".$content."',null);";
		return $this->db->query($sql);
	}
}