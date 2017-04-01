<?php if (!defined('THINK_PATH')) exit();?><form action='<?php echo ($action); ?>' method='post'>
	name: <input type='text' name='name'/><br>
	password: <input type='password' name='password'/><br>
	repassword: <input type='password' name='repassword'><br>
	<input type='submit' value='提交'>
</form>