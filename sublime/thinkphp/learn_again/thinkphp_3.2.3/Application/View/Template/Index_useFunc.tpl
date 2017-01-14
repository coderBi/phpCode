<h2 style='color:red'>在模板文件中使用函数：</h1> 
$result.name|md5:{$result.name|md5}<br>
:md5($result.name):{:md5($result.name)}<br>
:substr(md5($result.name),0,3):{:substr(md5($result.name),0,3)}<br>
$result.name|md5|substr=0,3:{$result.name|md5|substr=0,3}<br>
$result.address|default='address为空':{$result.address|default='address为空'}<br>
:($result['id']+10)*10:{:($result['id']+10)*10}<br>
$result['id']?name=$result['name']:'id没有提供':{$result['id']?$result['name']:'id没有提供'}<br>
<hr>
<p style='color:teal'>note: 使用二元运算符与三元运算符不能使用 . | 操作。</p>
