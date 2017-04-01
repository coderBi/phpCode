<?php
//测试正则表达式
$string = "大陆','欧美','港台'";
echo preg_match("/'/",$string).'<br>';
echo preg_replace("/'/u",'',$string).'<br>';

//查看mb  encoding
echo mbregex_encoding().'<br>';

//这里不能匹配的原因是 mb_ereg_match函数默认在表达式前面又 ^ 也就是只可以匹配开头的部分   在php手册里面介绍如果要匹配所有位置可以使用 .*开头
echo mb_ereg_match("'",$string).'<br>';
echo  mb_ereg_replace("'",'',$string).'<br>';


//设置 mb encoding
mbregex_encoding('utf-8');

//使用 .*开头  优化mb_ereg_match 的匹配
echo mb_ereg_match(".*'",$string).'<br>';

//这个语句不对  因为会将匹配到的 .*'都删除掉，最后字符串为空
echo  mb_ereg_replace(".*'",'',$string).'<br>';
