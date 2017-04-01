<?php if (!defined('THINK_PATH')) exit();?><h2 style='color:red'>volist遍历：</h2>
<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>name=<?php echo ($item["name"]); ?>,age=<?php echo ($item["age"]); ?><br><?php endforeach; endif; else: echo "$empty" ;endif; ?>
<h2 style='color:red'>隔行换色：</h2>
<?php if(is_array($data)): $i = 0; $__LIST__ = array_slice($data,0,10,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; switch($mod): case "0": ?><span style='color:blue'>name=<?php echo ($item["name"]); ?>,age=<?php echo ($item["age"]); ?></span><?php break;?>
	<?php case "1": ?><span style='color:teal'>name=<?php echo ($item["name"]); ?>,age=<?php echo ($item["age"]); ?></span><?php break; endswitch;?>
	<br><?php endforeach; endif; else: echo "" ;endif; ?>
<h2 style='color:red'>判断变量是否定义:</h2>
<?php if(isset($_GET['id'])): ?>Think.get.id 已经定义<?php else: ?>Think.get.id没有定义<?php endif; ?><br>
<?php if(isset($_REQUEST['data'])): ?>Think.request.data 已经定义<?php else: ?>Think.request.data没有定义<?php endif; ?>
<h2 style='color:red'>php标签:</h2>
<?php echo '这一部分内容是php标签输出的，不推荐使用原生的&lt;?php标签。'; ?>