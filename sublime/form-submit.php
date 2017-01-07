<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>制作一个提交表单，提交后页面显示提交信息</title>
	<style>
		table {
			border: 1px solid silver;
		}
	</style>
</head>
<body>
	<form action="" method="post">
		<input type="hidden" name="explain" value="register">
		<table>
			<tr>
				<td>用户名</td>
				<td>
					<input type="text" name="name" <?php  
						if(isset($_POST['name'])){
							$name = $_POST['name'];
							echo("value='$name'");
						}
					?>>
				</td>
			</tr>
			<tr>
				<td>密码</td>
				<td>
					<input type="password" name="password" <?php  
						if(isset($_POST['password'])){
							$password = $_POST['password'];
							echo("value='$password'");
						}
					?>>
				</td>
			</tr>
			<tr>
				<td>性别</td>
				<td>
					<label><input type="radio" name="gender" value="man" <?php  
						if(array_key_exists('gender', $_POST) && $_POST['gender'] == "man"){
							echo "checked='checked'";
						}
					?>>男</label>
					<label><input type="radio" name="gender" value="female" <?php  
						if(array_key_exists('gender', $_POST) && $_POST['gender'] == "female"){
							echo "checked='checked'";
						}
					?>>女</label>
				</td>
			</tr>
			<tr>
				<td>兴趣爱好</td>
				<td>
					<label>足球<input type="checkbox" name="fav[]" value="football" <?php
						// 这里的fav设置的是数组。之前有问题是错误写成$_POST['fav[]']
						if(isset($_POST['fav'])) {
							foreach ($_POST['fav'] as $key => $value) {
								if($value == "football"){
									echo "checked";
									break;
								}
							}
						} 
					?>></label>
					<label>篮球<input type="checkbox" name="fav[]" value="basketball" <?php  
						if(isset($_POST['fav'])) {
							foreach ($_POST['fav'] as $key => $value) {
								if($value == "basketball"){
									echo "checked";
									break;
								}
							}
						} 
					?>></label>
				</td>
			</tr>
			<tr>
				<td>省份</td>
				<td>
					<select name="provence" id="">
						<?php  
							if(isset($_POST['provence'])){
								$provence = $_POST['provence'];
							} else {
								$provence = "";
							}
						?>
						<option value="henan" <?php if($provence == "henan") echo "selected" ?>>河南</option>
						<option value="shandong" <?php if($provence == "shandong") echo "selected" ?>>山东</option>
						<option value="jiangxi" <?php if($provence == "jiangxi") echo "selected" ?>>江西</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>个人描述</td>
				<td>
					<!-- 经过查找 发现textarea没有value -->
					<textarea name="self_introduce" cols="50" rows="10"><?php  
							if(isset($_POST['self_introduce'])){
								$self_introduce = $_POST['self_introduce'];
								echo($self_introduce);
							}
						?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="提交" colspan="2">
				</td>
			</tr>
			<tfoot>注册页面php实现</tfoot>
		</table>

	</form>
	
</body>
</html>