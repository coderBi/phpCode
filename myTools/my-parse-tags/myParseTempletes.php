<?php
/******************************************************模拟得dede标签解析****************************************************/
//引入扩展函数所在文件
require_once('./extend.edwin.php');

//设置模板所在目录
$cfg_templets_skin = '/dedecms/templets/a67';

//初始化mysql
if(!($mysqli = mysqli_edwin_init()))
    die('mysql 初始化失败');

//读入模板文件
$str = file_get_contents('./test.tpl');

// 正则匹配dede:arclist标签   /s作用可以匹配到换行  /U 非贪婪匹配
$regex = "/{dede:arclist(.*)}(.*){\/dede:arclist}/sU";

$count = preg_match_all($regex,$str,$matches);

//对匹配结果数组去重  这里可以去重 是因为对一个匹配到的dede:arclist标签解析后会替换原来文本中所有相应的符合规则的子串(str_replace函数的原理)
$matches[0] = array_unique($matches[0]);

foreach($matches[0] as $k=>$v){
    /****************解析dede:arclist 标签的属性 start **/
    //去前后空格
    $attrs = trim($matches[1][$k]);
    //去单引号 双引号
    $attrs = str_replace("'","",$attrs);
    $attrs = str_replace('"',"",$attrs);
    //用空格切开
    $attrs = preg_split('/\s+/',$attrs);
    $_attrs = array();
    //处理每一个属性，构成键值对数组
    foreach($attrs as $attr){
        $attr = explode('=',$attr);
        $_attrs[strtolower($attr[0])] = $attr[1];
    }
    //设置默认查表使用到的属性
    $channelid = isset($_attrs['channelid']) ? $_attrs['channelid'] : 17;
    $row = isset($_attrs['row']) ? $_attrs['row'] : 10;
    $addfiles = '';
    if(isset($_attrs['addfields'])){
        $addfiles = explode(',',$_attrs['addfields']);
        foreach($addfiles as $_k=>$addfile){
            $addfiles[$_k] = "b.$addfile";
        }
        $addfiles = implode(',',$addfiles);
        $addfiles = ",$addfiles";
    }
    $orderby = isset($_attrs['orderby']) ? $_attrs['orderby'] : 'aid';
    $orderway = isset($_attrs['orderway']) ? $_attrs['orderway'] : 'desc';
    //获取channelid对应的主表与附加表
    $sql = "select maintable,addtable from dede_channeltype where id=$channelid";
    $table = mysqli_query_row($sql,$mysqli);
    //通过属性拼接sql
    $sql = "select a.* $addfiles from {$table['maintable']} a join {$table['addtable']} b on a.id=b.aid  order by $orderby $orderway limit $row";
    //执行sql 获取数据
    $data = mysqli_query_all($sql,$mysqli);
    /****************解析dede:arclist 标签的属性 end **/

    /****************解析dede:arclist 子标签  并将sql查询到的数据填充进来 start **/
    $regex = '/\[field:(\w+)(\s+function=("|\')(\w+\(.*\))\3)?\/\]/sU';
    preg_match_all($regex,$matches[2][$k],$fields);

    $html = "";
    foreach ($data as $item) {
        $newstr = $matches[2][$k];
        //一条记录的填充
        foreach ($fields[0] as $_k=>$field) {
            $fieldname = $fields[1][$_k];
            $replace = isset($item[$fieldname]) ? $item[$fieldname] : '';
            //如果需要运行php代码
            if(!empty($fields[4][$_k])){
                $replace = str_replace('@me',$replace,$fields[4][$_k]);
                eval("\$replace = $replace;");
            }
            $newstr = str_replace($field,$replace,$newstr);
        }
        $html .= $newstr;
    }
    /****************解析dede:arclist 子标签  并将sql查询到的数据填充进来 end **/

    $str = str_replace($v,$html,$str);
}

//释放mysqli
$mysqli->close();

//生成html页面
$html_page = './a/test.html';
file_put_contents($html_page,$str);

//跳转到生成页面
redirectToUrl('a/test.html');