<?php
$arr = array(1,2,3);
foreach($arr as $k => &$v) {
    $v = $v * 2;
}
// now $arr is array(2, 4, 6)
//$v��Ϊ���Ǳ�������һ��ѭ���������ã���������ÿһ��ѭ�����Ƕ����һ������޸�
foreach($arr as $k => $v) {
    echo "$k", " => ", "$v", "\n";
}