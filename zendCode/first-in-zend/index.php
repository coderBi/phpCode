<?php
$arr = array(1,2,3);
foreach($arr as $k => &$v) {
    $v = $v * 2;
}
// now $arr is array(2, 4, 6)
//$v因为还是保存着上一个循环最后的引用，所以下面每一次循环都是对最后一个项的修改
foreach($arr as $k => $v) {
    echo "$k", " => ", "$v", "\n";
}