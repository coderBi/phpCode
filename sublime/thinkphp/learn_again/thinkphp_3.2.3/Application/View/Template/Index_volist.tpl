<h2 style='color:red'>volist遍历：</h2>
<volist name='data' id='item' empty='$empty'>
	name={$item.name},age={$item.age}<br>
</volist>
<h2 style='color:red'>隔行换色：</h2>
<volist name='data' id='item' offset='0' length='10' mod='2'>
	<switch name='mod'>
	<case value='0' break='1'><span style='color:blue'>name={$item.name},age={$item.age}</span></case>
	<case value='1' break='1'><span style='color:teal'>name={$item.name},age={$item.age}</span></case>
	</switch>
	<br>
</volist>
<h2 style='color:red'>判断变量是否定义:</h2>
<present name='Think.get.id'>Think.get.id 已经定义<else/>Think.get.id没有定义</present><br>
<present name='Think.request.data'>Think.request.data 已经定义<else/>Think.request.data没有定义</present>
<h2 style='color:red'>php标签:</h2>
<php>echo '这一部分内容是php标签输出的，不推荐使用原生的&lt;?php标签。';</php>

