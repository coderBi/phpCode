<?php if (!defined('THINK_PATH')) exit();?><h2 style='color:red'>在模板文件中使用函数：</h1> 
$result.name|md5:<?php echo (md5($result["name"])); ?><br>
:md5($result.name):<?php echo md5($result.name);?><br>
:substr(md5($result.name),0,3):<?php echo substr(md5($result.name),0,3);?><br>
$result.name|md5|substr=0,3:<?php echo (substr(md5($result["name"]),0,3)); ?><br>
$result.address|default='address为空':<?php echo ((isset($result["address"]) && ($result["address"] !== ""))?($result["address"]):'address为空'); ?><br>
:($result['id']+10)*10:<?php echo ($result['id']+10)*10;?><br>
$result['id']?name=$result['name']:'id没有提供':<?php echo ($result['id']?$result['name']:'id没有提供'); ?><br>
<hr>
<p style='color:teal'>note: 使用二元运算符与三元运算符不能使用 . | 操作。</p>