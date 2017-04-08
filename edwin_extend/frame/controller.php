<?php
/**
 * 基础Controller类，里面放置一些常用的Controller相关操作与配置
 * @auth edwin
 * @since 2017-4-8
 * @version 1.0
 */

class Controller{

    function __construct()
    {
        //设置连接连接编码
        header("Content-Type:text/html;charset=utf-8");
    }

    /*********************************************************与前台请求参数处理相关  START*******************************************************/
    /**
     * 从GET 或者 POST 里面获取指定参数名称的传入数据
     * @param string $key 要获取的参数名称
     * @param string $method get或者post方法  如果没有传入先从get中获取，如果没有再从post中获取
     * @return bool  成功返回对应的字符串  失败返回false
     */
    function getParam($key = '', $method = '')
    {
        if ($method == 'get' || $method == 'GET') {
            return isset($_GET[$key]) ? $_GET[$key] : false;
        } else if ($method == 'post' || $method == 'POST') {
            return isset($_POST[$key]) ? $_POST[$key] : false;
        } else if (empty($method)) {
            //如果method没有指定  就先查看get  再查看post里面是否有值
            return isset($_GET[$key]) ? $_GET[$key] : (isset($_POST[$key]) ? $_POST[$key] : false);
        }
    }

    /**
     * 移除请求字符串中的某一个项  这里的请求字符串的格式为  key1=value1&key2=value2&...
     * <p>note: 由于这里只能处理key1=value1&key2=value2&.格式的请求字符串，所以对于pathinfo风格不能处理 </p>
     * @param string $name 要移除的参数名称(key)
     * @return string  处理后的字符串
     */
    function rmParamFromQueryString($name = '')
    {
        $queryString = $_SERVER['QUERY_STRING'];
        //转换成数组
        $params = explode('&', $queryString);

        //查询数组  正则匹配  如果符合page=.*  就将相应数组中元素移除
        foreach ($params as $key => $param) {
            if (preg_match("/^$name=.*$/", $param))
                array_splice($params, $key, 1);
        }

        //重新构建并返回新的字符串
        $params = implode('&', $params);
        return $params;
    }
    /*********************************************************与前台请求参数处理相关  END*******************************************************/

    /*********************************************************页面跳转相关  START*******************************************************/
    /**
     * 立即重定向到某个页面  并且停止当前脚本的执行
     * @param $url  要跳转的url
     */
    function redirectToUrl($url){
        header("location:$url");
        exit;
    }

    /**
     * 延时页面跳转
     * @param $msg  等待页面跳转的时候提示的信息
     * @param $url 要跳转的url
     * @param $time  等待跳转的时间 单位是s
     */
    function refreshToUrl($msg,$url,$time){
        echo "<span style='color:red;'>{$msg}!</span>";
        echo "<br><a href='$url'>返回</a>";
        echo "<br>页面将于{$time}秒之后进行跳转。";
        header("refresh:$time,url=$url");
    }
    /*********************************************************页面跳转相关  END*******************************************************/
}