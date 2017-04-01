<?php

/**
将一个带有标签的字符串截取一个子串，前提是不能截断标签并且截取的长度只计算真正的文字内容，标签属性等内容不计算到截取的长度计算中。
@note： 这里处理没有考虑中文字符编码的问题。
*/
function mySubstr($str='', $len=0){
	$tags = array();
	$tagsCount = 0;

	//从头开始读入字符串 
	for($i = 0, $j = 0; $j < $len && $i < strlen($str); ++$i){
		//如果读入的是标签开始标记
		if($str[$i] == '<' && $i+1 < strlen($str) && $str[$i+1] != '/'){
			$tag = '';

			//获取标签名称
			for($k = $i + 1; $k < strlen($str) && $str[$k] != '>' && $str[$k] != ' ' && $str[$k] != '/' && $str[$k] != '\n'; ++$k){
				$tag .= $str[$k];
			}
			
			//保存标签名称到数组  修改数组元素个数计数
			if(!empty($tag))
				$tags[$tagsCount++] = $tag;

			//寻找闭合箭头 '>'
			for(;$k < strlen($str) && $str[$k] != '>'; ++$k){
			}

			//读到了结束标记 '/>'  
			if($k < strlen($str) && $str[$k -1] == '/'){
				//移除最靠后面的tags数组中的元素
				if($tagsCount > 0)
					unset($tags[--$tagsCount]);
			}
			$i = $k;
			continue;
		}

		//读入结束标签
		if($str[$i] == '<' && $i+1 < strlen($str) && $str[$i+1] == '/'){
			for($k = $i+1; $k < strlen($str) && $str[$k] != '>'; ++$k){}

			//读入标签正常闭合
			if($k < strlen($str)){
				if($tagsCount > 0)
					unset($tags[--$tagsCount]);
			}
			$i = $k;
			continue;
		}

		//读入的是正常的文字
		$j++;
	}

	$strToReturn = substr($str,0,$i);

	if($i < strlen($str)){
		for($k = $tagsCount - 1; $k >= 0; --$k){
			$strToReturn .= "</".$tags[$k].'>';
		}
	}

	return $strToReturn;
}

$testStr = "<p><a><img src=''/>this is the real content，over</a></p>";
echo mySubstr($testStr,20);