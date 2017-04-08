<?php
/*********************************************************config 配置相关  START*******************************************************/
//全局配置数组
$config_ed = array(
    //默认环境配置
    'default' => array(
        //默认模块
        'default_module' => 'Index',
        //可识别的模块
        'modules' => array(
            'Index',
        ),
        //默认控制器
        'controller' => 'Index',
        //默认动作
        'action' => 'index',
    ),
    //配置memcache
    'memcache' =>array(
        //是否启用
        'on' =>  true,
        //主机
        'host' => 'localhost',
        //使用端口号
        'port' => 11211,
    ),
    //配置mysqli
    'mysqli' => array(
        //是否启用mysql
        'on' => true,
        //主机名
        'host' => 'localhost',
        'port' => 3306,
        'user' => 'root',
        'password' => '123',
        //默认连接后选择的数据库
        'dbname' => '',
        'charset' => 'utf8',
    ),
    //配置sphinx
    'sphinx' => array(
        //是否启用sphinx
        'on' => 'true',
        //配置sphinx api所在路径
        'sphinx_api_path' => 'D:\WebSever\coreseek-4.1-win32\coreseek-4.1-win32\api\sphinxapi.php',
        'host' => 'localhost',
        'port' => 9312,
        //设置默认使用的匹配模式 0表示SPH_MATCH_ALL
        'match_mode' => 0,
    ),
    //配置mongodb
    'mongodb' => array(
        //是否启用mongodb
        'on' => true,
        'host' => 'localhost',
        'port' => 27017,
        //连接之后默认使用的数据库
        'collection' => 'test',
        //连接时登录用户 如果为空就是不进行登录
        'username' => '',
        //登录密码
        'password' => '',
    ),
    //配置日志
    'log' => array(
        //是否开启日志系统
        'on' => true,
        //日志文件路径
        'path' => 'D:/phpCode/myTools/collect-web-site/log/log.txt',
        //写入日志超时时间 单位是微秒
        'timeout' => '5000000',
    )
);
/*********************************************************config 配置相关  END*******************************************************/