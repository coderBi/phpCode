<?php

/**
	去掉一个字符串中的所有标签，然后截取一定的长度字符串。
	这里考虑到可能存在中文字符，所以使用的是mb_substr
*/
function mySubstr($str='', $len=0){
	//利用php提供的 strip_tags 移除一个字符串中的标签。 strip_tags会移除所有的额html xml 跟php标签。
	$str = strip_tags($str);
	return mb_substr($str, 0, $len);
}

$str = "<html><head></head><body>this is the content</body></html>";
echo mySubstr($str,10);