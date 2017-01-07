<?php
include('../thinkphp/ThinkPHP.php');

function confirm( $name, $password ) {
	$name = isset( $name ) ? $name : '';
	$password = isset( $password ) ? $password : '';

	echo "<form action='' method='post' >";
	echo '姓名：<input type="text" value= '.$name.' ><br>';
	echo '姓名：<input type="password" value= "'.$password.'" ><br>';
	echo '<input type="submit" value="提交" >';
	echo '</form>';
}

confirm('hah','12322');