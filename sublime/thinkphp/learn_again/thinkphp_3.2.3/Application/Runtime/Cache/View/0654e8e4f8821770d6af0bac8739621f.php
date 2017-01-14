<?php if (!defined('THINK_PATH')) exit();?>$Think.server.script_name: <?php echo ($_SERVER['SCRIPT_NAME']); ?><br>
$Think.session.user_id: <?php echo (session('user_id')); ?><br>
$Think.get.id: <?php echo ($_GET['id']); ?><br>
$Think.post.id: <?php echo ($_POST['id']); ?><br>
$Think.cookie.name: <?php echo (cookie('name')); ?><br>
$Think.env.id: <?php echo ($_ENV['ID']); ?><br>
$think.request.id: <?php echo ($think["request"]["id"]); ?><br>
$Think.const.PHP_VERSION: <?php echo (PHP_VERSION); ?><br>
$Think.PHP_VERSION: <?php echo (PHP_VERSION); ?><br>
$Think.MODULE_NAME: <?php echo (MODULE_NAME); ?><br>
<hr>
<p style='color:red'>输出配置文件变量:</p>
$Think.config.db_charset: <?php echo (C("db_charset")); ?><br>
$Think.config.url_model: <?php echo (C("url_model")); ?><br>
$Think.config.db_host: <?php echo (C("db_host")); ?><br>
$Think.config.db_name: <?php echo (C("db_name")); ?><br>
$Think.config.url_router_on: <?php echo (C("url_router_on")); ?><br>