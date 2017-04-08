<?php
/**
 * 入口文件  index.php
 * @auth edwin
 * @since 2017-4-7
 * @version 1.0
 */

//检查php版本
if(version_compare(PHP_VERSION,'5.6.0','<'))
    die('require PHP >= 5.6.0');

/*******************************************************添加include_path START*******************************************************/
$include = get_include_path();
//最后一个 ;
$quote_p = strrpos($include,";");
if($quote_p === false)
    $quote_p = -1;
if(strlen($include) != $quote_p + 1)
    $include .= ';';
$include .= "./frame;./extend;";
set_include_path($include);
/*******************************************************添加include_path END*******************************************************/

//引入sphinxapi.php
require_once('sphinxapi.php');

//引入配置文件
require_once "./config/config.php";

//引入extend.ed 核心扩展文件
require_once "main.php";

//保存运行时变量
$runtime_var = array();

/***********************************************************解析 m c a  START***********************************************************/
$query = $_SERVER['QUERY_STRING'];
$query = explode('/',$query);
//删除空元素  这里不用array_filter($query) 的原因是如果传入了 "0" 也会被筛选掉
foreach($query as $k=>$v){
    if('' == $v)
        array_splice($query,$k,1);
}
//解析 m
if(isset($query[0]) && in_array($query[0],$config_ed['default']['modules'])){
    $m = $query[0];
    array_splice($query,0,1);
}
else
    $m = isset($config_ed['default']['default_module']) ? $config_ed['default']['default_module'] : "Index";
$runtime_var['module'] = $m;
$runtime_var['module_path'] = $m_path = './module/'.$m;
if(!is_dir($m_path))
    die("module [$m] not found");
//解析 c
if(isset($query[0])){
    $c = $query[0];
    array_splice($query,0,1);
}
else
    $c = "Index";
$c .= "Controller";
$runtime_var['controller'] = $c;
$runtime_var['controller_path'] = $c_path = $m_path."/$c.php";
if(!file_exists($c_path))
    die("controller [$c] under module [$m] not found");
//引入请求文件
require_once $c_path;
if(!class_exists($c))
    die("class [$c] not found in file $c_path");
//创建Controller对象
$controller = new $c();
//解析 a
if(isset($query[0])){
    $a = $query[0];
    array_splice($query,0,1);
}
else
    $a = "index";
$runtime_var['action'] = $a;
if(!method_exists($controller,$a))
    die("method [$a] under $c@$m not found");
/***********************************************************解析 m c a  END***********************************************************/

/***********************************************************处理页面其他请求参数  START***********************************************************/
$params = array();
for($i = 0; $i < count($query); $i += 2){
    $k = $query[$i];
    $v = isset($query[$i+1]) ? $query[$i+1] : "";
    //如果有多个传递的参数名相同 就用数组保存值
    if(array_key_exists($k,$params)){
        if(!is_array($params[$k])){
            $tmp = $params[$k];
            $params[$k] = array();
            $params[$k][] = $tmp;
        }
        $params[$k][] = $v;
    }
    else
        $params[$k] = $v;
}
$runtime_var['params'] = $params;
/***********************************************************处理页面其他请求参数  END***********************************************************/

//其他初始化工作
require_once "init.php";

/**************************************************反射执行相关方法  START************************************************************************/
$rf = new ReflectionMethod($c,$a);
//判断访问权限
if(!(ReflectionMethod::IS_PUBLIC & $rf->getModifiers()))
    die("method [$a] under $c@$m is not a public method");
//构造执行语句
$ps = $rf->getParameters();
$eval_str = "\$rf->invoke(\$controller";
foreach ($ps as $p) {
    $name = $p->getName();
    if(array_key_exists($name,$params))
        $tmp = $params[$name];
    else if($p->isDefaultValueAvailable())
        $tmp = $p->getDefaultValue();
    else
        die("the paramter [$name] required in method #/$m/$c/$a#");
    $eval_str .= ",\$tmp";
}
$eval_str .= ");";
//执行执行生成的执行语句
eval($eval_str);
/**************************************************反射执行相关方法  END************************************************************************/