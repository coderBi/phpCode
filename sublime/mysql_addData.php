<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户信息管理</title>
	<style>
		#res {
			border-collapse: collapse;
		}
		#res td {
			border: 1px solid silver;
		}
	</style>
</head>
<body>
	<?php 
	function printResult($result){
		if(!$result)
			return false;
		echo "<table id='res'>";
		//打印表头
		$cols = mysql_num_fields($result);
		echo "<tr>";
		for($i = 1; $i < $cols; ++$i){
			echo "<td>";
			$colName = mysql_field_name($result,$i);
			echo $colName;
			echo "</td>";
		}
		echo "</tr>";
		//打印内容
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
			for($i = 1; $i < $cols -1; ++$i){
				echo "<td>";
				echo $row[$i];
				echo "</td>";
			}
			echo "<td>";
			//row[0]存放是id
			echo "<a href = '?action=del&id=".$row[0]."'>".$row[$cols -1]."</a>";
			echo "</td>";	
			echo "</tr>";	
		}
		echo "</table>";
		return true;
	}
	function connectMySql($dbName){
		$link = @mysql_connect("localhost","root","");
		if(!$link){
			return false;
		}
		$sql = "use ".$dbName.";";
		if(!mysql_query($sql))
			return false;
		return true;
	}
	function addData($dbName,$tbName,$arr,$keyNames){
		if(!connectMySql($dbName))
			return false;
		foreach ($keyNames as $value) {
			if(!array_key_exists($value, $arr))
				return false;
		}
		$sql = "insert into ".$tbName.' set ';
		$cols = count($keyNames);
		for($i = 0; $i < $cols -1; ++$i){
			$value = $keyNames[$i];
			if(is_int($arr[$value])){
				$sql .= $value." = ".$arr[$value].", ";
			} else {
				$sql .= $value." = "."'".$arr[$value]."'".", ";
			}
		}
		$value = $keyNames[$cols-1];
		$sql .= $value." = ".$arr[$value].";";
		if(!mysql_query($sql))
			return false;
		return true;
	}
	 ?>
	<form action="" method='post'>
		<table>
			<tr><td colspan='2'>添加数据：</td></tr>
			<tr>
				<td>用户名</td>
				<td>
					<input type="text" name='name' <?php 
					$keyNames = array('name','password','age',
						'xueli','fav','aspect');
					$arr = array();
					if(isset($_POST['name'])){
						$arr['name'] = $_POST['name'];
						echo "value = ".'\''.$arr['name'].'\'';
					}
					 ?>>
				</td>
			</tr>
			<tr>
				<td>密码</td>
				<td>
					<input type="password" name='password' <?php 
					if(isset($_POST['password'])){
						$arr['password'] = $_POST['password'];
						echo "value = ".'\''.$arr['password'].'\'';
					}
					 ?>>
				</td>
			</tr>
			<tr>
				<td>年龄</td>
				<td>
					<input type="text" name='age' <?php 
					if(isset($_POST['age'])){
						$arr['age'] = $_POST['age'];
						echo "value = ".'\''.$arr['age'].'\'';
					}
					 ?>>
				</td>
			</tr>
			<tr>
				<td>学历</td>
				<td>
					<select name="xueli">
						<option value="0" <?php 
						if(!isset($_POST['xueli']) ||
						 $_POST['xueli'] == 0){
							echo  "selected";
						}
						 ?>>请选择学历</option>
						<option value="1" <?php 
						if(isset($_POST['xueli']) &&
						 $_POST['xueli'] == 1){
						 	$arr['xueli'] = '中学';
							echo  "selected";
						}
						 ?>>中学</option>
						<option value="2" <?php 
						if(isset($_POST['xueli']) &&
						 $_POST['xueli'] == 2){
						 	$arr['xueli'] = '大学';
							echo  "selected";
						}
						 ?>>大学</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>兴趣</td>
				<td>
					<label><input type="checkbox" name='fav[]' value='0' <?php 
					if(isset($_POST['fav'])){
						$fav = $_POST['fav'];
						foreach ($fav as $value) {
							if($value == 0){
								echo 'checked';
								if(!isset($arr['fav'])){
									$arr['fav'] = 0;
								}
								$arr['fav'] += 1;
								break;
							}
						}
					}
					 ?>>排球</label>
					<label><input type="checkbox" name='fav[]' value='1' <?php 
					if(isset($_POST['fav'])){
						$fav = $_POST['fav'];
						foreach ($fav as $value) {
							if($value == 1){
								echo 'checked';
								if(!isset($arr['fav'])){
									$arr['fav'] = 0;
								}
								$arr['fav'] += 2;
								break;
							}
						}
					}
					 ?>>篮球</label>
					<label><input type="checkbox" name='fav[]' value='2' <?php 
					if(isset($_POST['fav'])){
						$fav = $_POST['fav'];
						foreach ($fav as $value) {
							if($value == 2){
								echo 'checked';
								if(!isset($arr['fav'])){
									$arr['fav'] = 0;
								}
								$arr['fav'] += 4;
								break;
							}
						}
					}
					 ?>>地球</label>
				</td>
			</tr>
			<tr>
				<td>来自</td>
				<td>
					<label><input type="radio" name="aspect" value='0' <?php 
					if(isset($_POST['aspect'])){
						$aspect = $_POST['aspect'];
						if($aspect == 0){
							echo 'checked = checked';
							$arr['aspect'] = 1;
						}
					}
					 ?>>东北</label>
					<label><input type="radio" name="aspect" value='1' <?php 
					if(isset($_POST['aspect'])){
						$aspect = $_POST['aspect'];
						if($aspect == 1){
							echo 'checked = checked';
							$arr['aspect'] = 2;
						}
					}
					 ?>>华北</label>
					<label><input type="radio" name="aspect" value='2' <?php 
					if(isset($_POST['aspect'])){
						$aspect = $_POST['aspect'];
						if($aspect == 2){
							echo 'checked = checked';
							$arr['aspect'] = 3;
						}
					}
					 ?>>西北</label>
					<label><input type="radio" name="aspect" value='3' <?php 
					if(isset($_POST['aspect'])){
						$aspect = $_POST['aspect'];
						if($aspect == 3){
							echo 'checked = checked';
							$arr['aspect'] = 4;
						}
					}
					 ?>>华东</label>
					<label><input type="radio" name="aspect" value='4' <?php 
					if(isset($_POST['aspect'])){
						$aspect = $_POST['aspect'];
						if($aspect == 4){
							echo 'checked = checked';
							$arr['aspect'] = 5;
						}
					}
					 ?>>华南</label>
					<label><input type="radio" name="aspect" value='5' <?php 
					if(isset($_POST['aspect'])){
						$aspect = $_POST['aspect'];
						if($aspect == 5){
							echo 'checked = checked';
							$arr['aspect'] = 6;
						}
					}
					 ?>>华西</label>
				</td>
			</tr>
			<tr>
				<td colspan='2'><input type="submit" value='ok'></td>
			</tr>
		</table>
	</form>
	<?php
	if(!empty($arr) && !addData('learn_mysql','user',$arr,$keyNames)){
		echo '数据添加失败！';
	}
	function delData(){
		if(!isset($_GET['action']) || !isset($_GET['id']))
			return true;
		$id = $_GET['id'];
		if(!connectMySql('learn_mysql'))
			return false;
		$sql = "delete from user where id = ".$id.";";
		if(!mysql_query($sql))
			return false;
		return true;
	}
	function showData(){
		if(!connectMySql('learn_mysql')){
			echo "数据库连接失败！";
			return;
		}
		$sql = "set @var = '删除'";
		if(!mysql_query($sql)){
			echo "数据库操作失败，请重试！";
			return;
		}
		$sql = "select id, name as 姓名,age as 年龄,xueli as 学历, fav as 兴趣,
		aspect as 来自,zhuceTime as 注册时间, @var as 操作 from user;";
		$result = mysql_query($sql);
		if(!$result){
			echo "数据库查询失败！";
			return;
		}
		printResult($result);
	}
	if(!delData()){
		echo "数据删除操作失败!";
	}
	echo '<h3>显示数据：</h3>'; 
	showData();
	 ?>
</body>
</html>