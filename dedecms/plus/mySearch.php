<?php
require_once(dirname(__FILE__) . "/../include/common.inc.php");

//定义php文件内容编码  系统文件名称编码（这里是windows系统本地编码gbk）
$encode_in_file = 'utf-8';
$filename_encode = 'gbk';

//定义搜索页面的缓存目录  文件命名规则是  channelid-typeid-language-area-years-keywords-page.html  如果某一个参数没有传入对应位置为空
$searchCacheDir = './mySearch-cache/';

//定义模板存放的目录
$templetsDir = '../templets/a67/';

/***************************************************处理请求参数*****************************************************************/
$where = "";
$orderby = " order by id desc";
$requestParamArray = array();  //存储除了page以外的其他页面查询条件
$tableid = 17; //默认查询的addon17表

//指定channelid  也就是是否指定查那个模型
$mid = getParam('mid') ? getParam('mid') : $tableid;
if ($mid) {
    $tableid = $mid;
    $filename = $mid.'-';
    $requestParamArray['channelid'] = $mid;
}else{
    $filename = "$tableid-";
}

//typeid
$typeid = getParam('typeid');
if ($typeid) {
    $where .= " and a.typeid='$typeid' ";
    $filename .= $typeid.'-';
    $requestParamArray['typeid'] = $typeid;
}else{
    $filename .= "-";
}

//语言类型
$language = getParam('language');
if ($language) {
    $where .= " and b.language='$language' ";
    $requestParamArray['language'] = $language;
    $filename .= $language.'-';
}else{
    $filename .= "-";
}
//地区
$area = getParam('area');
if ($area) {
    $where .= " and b.area='$area' ";
    $filename .= $area.'-';
    $requestParamArray['area'] = $area;
}else{
    $filename .= "-";
}

//年代
$years = getParam('years');
if ($years) {
    $where .= " and b.years='$years' ";
    $filename .= $years.'-';
    $requestParamArray['years'] = $years;
}else{
    $filename .= "-";
}

//title
$title = getParam('title');
if ($title) {
    $requestParamArray['title'] = $title;
    $sphinx = init_sphinx();
    $sphinx->SetMatchMode(SPH_MATCH_EXTENDED); //这种扩展模式可以指定只查询某一字段
    $sphinx->SetLimits(0);
    //只匹配查询title是否包含关键词
    $ids = sphinx_query_ids("@title $title","dede_addon$tableid");

}else{
    $filename .= "-";
}

//当前页码 接受翻页变量
$page = getParam('page') ? max((int)getParam('page'), 1) : 1;
$filename .= $page;

/****************************检查是否缓存了相应的搜索文件，如果缓存并且在设定的时间范围内就直接取缓存*****************/
//计算文件路径
$filepath = $searchCacheDir.$filename.'.html';
//将文件名转换文本地编码
$filepath = mb_convert_encoding($filepath,$filename_encode,$encode_in_file);
//定义缓存时间
$cachetime = 1 * 6;
//如果上次修改时间到现在超过预定时间就直接拿换粗
if(file_exists($filepath) && filemtime($filepath) + $cachetime > time()){
    include $filepath;
    exit;
}


/***************************************************处理请求分页相关的参数  构造分页字符串********************************************/
//初始化mysqli
$mysqli = mysqli_edwin_init();
if(!$mysqli)
    exit;

//计算总的记录数
$sql = "select count(*) count from dede_archives a left join dede_addon$tableid b on a.id=b.aid where a.channel=$tableid $where";
$totalRecord = mysqli_query_one($sql,$mysqli);
//定义每一页显示条数
$perPage = 1;
//计算总的页数
$totalPage = ceil($totalRecord / $perPage);
//构造limit语句
$limit = " limit " . ($page - 1) * $perPage . ',' . $perPage;
//获取原来的请求字符串
$preParams = $_SERVER['QUERY_STRING'];
//去掉原来请求字符串中page值
$preParams = rmParamFromQueryString('page',$preParams);
if(!empty($preParams))
    $preParams .= '&';
//构造翻页字符串
$page_str = '<div class="pages" ><p > 共 ' . $totalRecord . ' 部手机电影，共 ' . $totalPage . ' 页，当前页为第 ' . $page . ' 页 </p ><div > <span ><a href = "?'.$preParams.'page=' . max($page - 1, 1) . '#page" > 上一页</a ></span >';
for ($i = 1; $i <= $totalPage; ++$i) {
    if ($i == $page)
        $page_str .= '<a href = "?'.$preParams.'page=' . $i . '#page" class="on" > ' . $i . '</a >';
    else
        $page_str .= '<a href = "?'.$preParams.'page=' . $i . '#page"> ' . $i . '</a >';
}
$page_str .= '<span ><a href = "?'.$preParams.'page=' . min($page + 1, $totalPage) . '#page"> 下一页</a ></span ></div ></div >';

/**************************************************构造页面中搜索条件部分******************************************************/
$so_str ='';
//已选筛选条件显示
$so_str .= '<div class="r_lis"><span>';
$sql = "select typename from dede_channeltype where id=$tableid";
$channelname = mysqli_query_one($sql,$mysqli);
if(!$channelname)
    $channelname = '未知模型';
$so_str .= "$channelname</span>  <i>|</i>  <b>检索条件：";
$index = 0;
foreach($requestParamArray as $k=>$v){
    if($index > 0){
        $so_str .= '&nbsp;+&nbsp;';
    }
    if($k == 'typeid'){
        $sql = "select typename from dede_arctype where id=$typeid";
        $typename = mysqli_query_one($sql,$mysqli);
        if($typename){
            $preParams = rmParamFromQueryString('typeid',$_SERVER['QUERY_STRING']);
            $preParams = rmParamFromQueryString('page',$preParams);
            $so_str .= "$typename<a href='?$preParams#page'><img src='".$GLOBALS['cfg_templets_skin']."/images/c_close.jpg' /></a>";
            $index++;
        }
    }
    else if($k == 'years' || $k == 'area'){
        $preParams = rmParamFromQueryString($k,$_SERVER['QUERY_STRING']);
        $preParams = rmParamFromQueryString('page',$preParams);
        $so_str .= "$v<a href='?$preParams#page'><img src='".$GLOBALS['cfg_templets_skin']."/images/c_close.jpg' /></a>";
        $index++;
    }
}
$so_str .= "</b></div>";

//检索条件选项列表
$so_str .= '<ul class="r_lis_con">';
$so_str .= '<li><b>按类型</b>';

//查询当前顶级栏目下面的所有子栏目
$sql = "select id,typename from dede_arctype where channeltype=$tableid and topid!=0";
$result = mysqli_query_all($sql,$mysqli);
//构造按类型搜索字符串
$preParams = rmParamFromQueryString('typeid',$_SERVER['QUERY_STRING']);
$preParams = rmParamFromQueryString('page',$preParams);
if(!isset($requestParamArray['typeid']))
    $so_str .= '<a href="?'.$preParams.'#page" class="all">全部</a>';
else
    $so_str .= '<a href="?'.$preParams.'#page">全部</a>';
if(!empty($preParams)) $preParams .= '&';
foreach($result as $row){
    if(isset($requestParamArray['typeid']) && $requestParamArray['typeid'] == $row['id'])
        $so_str .= ' | <a href="?'.$preParams.'typeid='.$row['id'].'#page" class="all">'.$row['typename'].'</a>';
    else
        $so_str .= ' | <a href="?'.$preParams.'typeid='.$row['id'].'#page">'.$row['typename'].'</a>';
}
$so_str .= "</li>";

$so_str .= '<li><b>按地区</b>';
//查询所有地区
if(!($area = getEnumFromMysql($tableid,'area',$mysqli)))
    exit;
//构造按地区搜索字符串
$preParams = rmParamFromQueryString('area',$_SERVER['QUERY_STRING']);
$preParams = rmParamFromQueryString('page',$preParams);
if(!isset($requestParamArray['area']))
    $so_str .= '<a href="?'.$preParams.'#page" class="all">全部</a>';
else
    $so_str .= '<a href="?'.$preParams.'#page">全部</a>';
if(!empty($preParams)) $preParams .= '&';
foreach($area as $item){
    if(isset($requestParamArray['area']) && $requestParamArray['area'] == $item)
        $so_str .= ' | <a href="?'.$preParams.'area='.$item.'#page" class="all">'.$item.'</a>';
    else
        $so_str .= ' | <a href="?'.$preParams.'area='.$item.'#page">'.$item.'</a>';
}
$so_str .= "</li>";

$so_str .= '<li><b>按时间</b>';
//查询所有地区
if(!($years = getEnumFromMysql($tableid,'years',$mysqli)))
    exit;
//构造按时间搜索字符串
$preParams = rmParamFromQueryString('years',$_SERVER['QUERY_STRING']);
$preParams = rmParamFromQueryString('page',$preParams);
if(!isset($requestParamArray['years']))
    $so_str .= '<a href="?'.$preParams.'#page" class="all">全部</a>';
else
    $so_str .= '<a href="?'.$preParams.'#page">全部</a>';
if(!empty($preParams)) $preParams .= '&';
foreach($years as $item){
    if(isset($requestParamArray['years']) && $requestParamArray['years'] == $item)
        $so_str .= ' | <a href="?'.$preParams.'years='.$item.'#page" class="all">'.$item.'</a>';
    else
        $so_str .= ' | <a href="?'.$preParams.'years='.$item.'#page">'.$item.'</a>';
}
$so_str .= "</li></ul>";

/****************************根据页面请求条件查询数据库  关联查询dede_arctype表取出一些字段用来计算url****************************************/
$sql = "select a.id, a.typeid, a.senddate, a.ismake, a.arcrank, a.money, a.title,a.litpic,b.score,b.language, tp.typedir,tp.typename,tp.corank, tp.namerule,
            tp.moresite,tp.siteurl,tp.sitepath from dede_archives a  left join `dede_arctype` tp on a.typeid=tp.id left join dede_addon17 b on a.id=b.aid  where a.channel=$tableid  $where $orderby $limit";
$dsql->Execute('me', $sql);
$data = array();
while ($row = $dsql->GetArray('me')) {
    //计算arcurl  注意这里的$row['filename'] 在源代码中也是提供的空
    $row['arcurl'] = GetFileUrl($row['id'], $row['typeid'], $row['senddate'], $row['title'], $row['ismake'],
        $row['arcrank'], $row['namerule'], $row['typedir'], $row['money'], $row['filename'], $row['moresite'], $row['siteurl'], $row['sitepath']);

    //添加记录到页面变量
    $data[] = $row;
}

/*************************************渲染模板文件 更新缓存文件 输出结果到浏览器*******************************************************/
//开启缓存
ob_start();

//引入查询页面模板
include $templetsDir . "mySearch.htm";

//将数据写入到缓存文件  刷新缓存文件
$html = ob_get_contents();
file_put_contents($filepath,$html);

//将缓存区数据发给浏览器  同时关闭缓冲区
ob_end_flush();