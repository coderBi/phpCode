<?php
/**
 * 自己实现的一个抓取网页程序，这里抓取了优酷的电影列表页面
 * @auth edwin
 * @since 2017-4-5
 */
//因为采集比较耗时间，而php默认最多执行30s，所以这里设置没有时间限制
set_time_limit(0);

$date1 = new DateTime();

require_once("extend.edwin.php");

//要查询的url
$url_s = 'http://list.youku.com/category/show/c_96_s_1_d_1_p_';
$url_e = '.html?spm=a2h1n.8251845.0.0';
//curl属性配置
$curl_opts = array(
    CURLOPT_RETURNTRANSFER => 1,
);
$curl = curl_init();

//获取url页面
for($i = 1; $i <= 30; ++$i){
    $url = "$url_s$i$url_e";
    getOnePage($url,$curl,$curl_opts);
}


$date2 = new DateTime();
$ms = $date2->getTimestamp() - $date1->getTimestamp();  //时间戳单位是秒
echo '一共使用了:'.$ms.'秒';

function getOnePage($url,$curl,$curl_opts){
    $str = Edwin\curl_getURLContent($url,$curl,$curl_opts);
    //获取要抓取的列表
    $font = '<div class="box-series"><ul class="panel">';
    $tail = '</ul></div><div class="yk-pager">';
    $str = Edwin\getContentBetween($font,$tail, $str);
    //uniqid 第一个参数是添加的前缀，第二个参数为true表示后面会追加一个熵，没有熵的时候如果不算前缀返回13位，有熵返回23位
    $html_page = uniqid('youku_',true);
    file_put_contents("./$html_page".'.html',$str);
    //抓取列表字符串

    global $config_ed;
    if($config_ed['log']['on']){
        Edwin\log('info','write one','采集的url：'.$url);
    }
}