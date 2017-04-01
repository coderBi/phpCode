<?php if (!defined('THINK_PATH')) exit();?><h2 style='color:red'>succes跳转中间页面</h2>
<?php echo ($message); ?><br>
<p style='color:teal'>页面在<b id='wait' style='color:red'><?php echo ($waitSecond); ?></b>>秒之后，跳转到<?php echo ($jumpUrl); ?></p>
<p><a href='<?php echo ($jumpUrl); ?>'>点击立即跳转</a></p>
<script>
(function(){
	var wait = document.getElementById('wait');
	var interval = setInterval(function(){
		var time = --wait.innerHTML;
		if(time <= 0){
			location.href = '<?php echo ($jumpUrl); ?>';
			clearInterval(interval);
		}
	},1000);
})();
</script>