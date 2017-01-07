<html>
<!-- 当表单中存在文件数据时，必须加上enctype='multipart/form-data'属性，否则浏览器会将文件当做字符串处理 -->
<form action="#" enctype='multipart/form-data' method='post'>
	选择要上传的文件：<input type="file" name='upload'><br>
	<input type="submit" value='ok'>
</form>
<?php
// 服务器接受到文件数据存储在$_FILES里面
if (isset($_FILES['upload'])) {
	var_dump(uploadfile($_FILES['upload']));
 } 
/**
 * 上传单个文件
 * @param  array  $file_info 某个上传文件的临时信息，5个元素数组
 * @return [type]           失败返回false，成功返回文件名
 */
function uploadfile($file_info=array()) {
	//判断是否有错误
	if($file_info['error'] != 0){
		$error_info = '上传出现错误';
		return false;
	}
	//判断类型是否合适
	//后缀名的判断
	$ext_list =  array('.jpeg', '.png','.gif','.jpg'); //允许的后缀名列表
	$ext = strrchr($file_info['name'],'.'); //最后出现 . 及其之后的内容
	if (! in_array(strtolower($ext), $ext_list)) {
		$error_info = '文件【后缀名】类型错误';
		return false;
	}
	$mime_list = ext2mime($ext_list); //允许的mime列表
	//mime类型判断
	if (! in_array($file_info['type'], $mime_list)) {
		$error_info = '文件【MIME】类型错误';
		return false;
	}
	//判断从文件内容里面获取的mime
	$finfo = new Finfo(FILEINFO_MIME_TYPE);
	$real_mime = $finfo->file($file_info['tmp_name']);
	if (! in_array($real_mime, $mime_list)) {
		$error_info = '文件【真实MIME】类型错误';
		return false;
	}
	//大小是否在限制范围之内
	$max_size = 1024 * 1024;
	if ($file_info['size'] > $max_size) {
		$error_info = '文件太大';
		return false;
	}
	//生成目标文件
	$prefix = ' '; //前缀名
	$upload_filename = uniqid($prefix,true).$ext;
	//指定上传目录
	$upload_path = './';
	//依据天，划分目录存储
	$sub_dir = date('Ym').'/';
	//判断子目录是否存在
	if(! is_dir($upload_path.$sub_dir)){
		//子目录不存在
		mkdir($upload_path.$sub_dir);
	}
	//检测文件是否为上传文件
	if (! is_uploaded_file($file_info['tmp_name'])) {
		$error_info = '文件被损坏';
		return false;
	}
	//移动到项目指定目录
	$result = move_uploaded_file($file_info['tmp_name'],$upload_path.$sub_dir.$upload_filename);
	//判断移动结果
	if($result){
		//移动成功，返回上传的文件名，供后续操作
		return $sub_dir.$upload_filename;
	} else {
		$error_info = '移动文件失败';
		return false;
	}
}
/**
 * 将后缀转成mime
 * @param  array  $ext_list 后缀列表
 * @return array           mime列表
 */
function ext2mime($ext_list=array()){
	//获取列表映射
	$ext2mime_list = require './ext2mime.php';
	foreach ($ext_list as $ext) {
		$mime_list[] = $ext2mime_list[$ext];
	}
	//返回mime列表
	return $mime_list;
}
?>
</html>