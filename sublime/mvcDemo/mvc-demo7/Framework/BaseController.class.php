<?php 
class BaseController{
	//构造方法，所有的都需要的设定
	function __construct(){
		header("content-type:text/html;charset=utf-8");
	}
	//显示一定的提示文字，然后自动跳转（一定时间后）
	function GotoUrl($msg,$url,$time){
		echo "<font color='red'>{$msg}!</font>";
		echo "<br><a href='$url'>返回</a>";
		echo "<br>页面将于{$time}秒之后进行跳转。";
		header("refresh:$time;url=$url");//location是立即跳转，这里是一定时间自动跳转
	}
}
 ?>