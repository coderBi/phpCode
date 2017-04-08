<?php

/**
 * dao操作相关  其中包括mysql mongodb sphinx memcache，后续可能加入redis...
 * <p>版本2.0相比之前的1.0主要修改是用面向对象的思路进行重写</p>
 * <p>note:这个文件会读取全局的config文件，配置文件的引入在入口index.php文件中</p>
 * @auth edwin
 * @since 2017-4-8
 */

class Mysqli_Dao
{
    //内部使用的mysqli对象
    private $mysqli = false;

    /**
     * Mysqli_Dao constructor.
     * @param $mysqli 要使用的mysqli对象
     */
    private function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
     * 初始化一个数据库连接,返回一个Mysqli_Dao对象
     * @param string $host 连接主机
     * @param string $user 用户名
     * @param string $password 连接密码
     * @param string $dbname 默认使用的数据名
     * @param int port 连接端口
     * @param string $charset 连接编码默认utf8
     * @return bool|Mysqli_Dao  初始化失败返回false，初始化成功返回Mysqli_Dao对象
     */
    static function init($host = '', $user = '', $password = '', $dbname = '',$port=0, $charset = '')
    {
        //配置mysqli
        $host = !empty($host) ? $host : (!empty($config_ed['mysqli']['host']) ? $config_ed['mysqli']['host'] : 'localhost');
        $port = !empty($port) ? $port : (!empty($config_ed['mysqli']['port']) ? $config_ed['mysqli']['port'] : 3306);
        $user = !empty($user) ? $user : (!empty($config_ed['mysqli']['user']) ? $config_ed['mysqli']['user'] : 'root');
        $password = !empty($password) ? $password : (!empty($config_ed['mysqli']['password']) ? $config_ed['mysqli']['password'] : '');
        $charset = !empty($charset) ? $charset : (!empty($config_ed['mysqli']['charset']) ? $config_ed['mysqli']['charset'] : 'utf8');
        $dbname = !empty($dbname) ? $dbname : (!empty($config_ed['mysqli']['dbname']) ? $config_ed['mysqli']['dbname'] : 'test');

        //创建mysqli对象
        $mysqli = new mysqli($host, $user, $password, $dbname,$port);
        if ($mysqli->connect_error)
            return false;
        //设置连接字符集
        if (!$mysqli->query("set names $charset")) {
            $mysqli->close();
            return false;
        }
        return new self($mysqli);
    }

    /**
     * 执行一条有结果集的sql  返回一个二维数组
     * @param string $sql 待执行sql
     * @return array|bool sql执行成功返回array  失败返回false
     */
    function query_all($sql = '')
    {
        $mysqli = $this->mysqli;
        if(!($result =$mysqli->query($sql)))
            return false;
        $toReturn = array();
        while ($row = $result->fetch_assoc()) {
            $toReturn[] = $row;
        }
        $result->close();
        return $toReturn;
    }

    /**
     * @param string $sql 待执行的sql
     * @return bool|array  sql执行失败或者没有查询到任何数据返回false  成功获取一条记录返回一条记录数据的数组
     */
    function query_row($sql = '')
    {
        //如果是以 select开始的sql语句  因为是查询一条数据 这里进行优化在后面追加limit 0,1。
        if (preg_match('/^select.*/', ltrim($sql))) {
            //去掉结尾的 ; 和 ,
            $sql = preg_replace('/[,;]$/', '', trim($sql));
            //如果结尾没有limit  就加上limit 0,1
            if (!preg_match('/limit/i', $sql)) {
                $sql .= ' limit 0,1;';
            }
        }

        //查询返回二维数组
        $result = mysqli_query_all($sql);
        if (!is_array($result) || empty($result))
            return false;
        return $result[0];
    }

    /**
     * @param string $sql 待执行的sql
     * @return bool|string  sql执行失败或者没有数据 返回false  成功返回数据库中对应的string值
     */
    function query_one($sql = '')
    {
        //查询一行记录
        $result = mysqli_query_row($sql);
        if (!$result)
            return false;
        //这里由于可能返回的一行数据可能是一个关联数组，所以不能简单的使用$result[0]
        $item = each($result);
        return $item[1];
    }

    /**
     * 执行一条没有返回数据集的sql语句
     * @param string $sql 待执行的sql
     * @return bool sql执行成功返回true 失败返回false
     */
    function query_null($sql = '')
    {
        $result = $this->mysqli->query($sql);
        return $result;
    }
}


class Sphinx_Dao{
    //内部使用的sphinxClient对象
    private $sphinxClient = false;
    /**
     * 初始化一个sphinx连接 返回一个Sphinx_Dao对象
     * @param string $host 服务主机
     * @param int $port  端口
     * @param int $match_mode  匹配模式
     * @return false|SphinxClient 初始化成功返回Sphinx_Dao对象  失败返回false
     */
    static  function  init($host = '', $port = 0, $match_mode =0){
        //配置sphinx
        $sphinx_api_path = !empty($config_ed['sphinx']['sphinx_api_path']) ? $config_ed['sphinx']['sphinx_api_path'] : "sphinxapi.php";
        //引入sphinxapi.php
        require_once $sphinx_api_path;
        $host = !empty($host) ? $host : (!empty($config_ed['sphinx']['host']) ? $config_ed['sphinx']['host'] : 'localhost');
        $port = !empty($port) ? $port : (!empty($config_ed['sphinx']['port']) ? $config_ed['sphinx']['port'] : 9312);
        $match_mode = !empty($match_mode) ? $match_mode : (!empty($config_ed['sphinx']['match_mode']) ? $config_ed['sphinx']['match_mode'] : SPH_MATCH_ALL);

        //初始化连接
        $sc = new SphinxClient();
        $sc->setServer($host,$port);
        $sc->SetMatchMode($match_mode);
        if(!$sc->open())
            return false;
        return new self($sc);
    }

    /**
     * Sphinx_Dao constructor.
     * @param $sphinxClient  要使用的sphinxClient对象
     */
    private function __construct($sphinxClient)
    {
        $this->sphinxClient = $sphinxClient;
    }

    /**
     * 从sphinx查询一个关键词 返回查到的id列表
     * @param string $keywords 要查询的关键词
     * @param string $indexer  索引
     * @return string 处理过的id列表字符串,形式是 id1,di2,id3...
     */
    function sphinx_query_ids($keywords='',$indexer=''){
        $res = $this->sphinxClient->query($keywords,$indexer);
        //处理ids列表并返回
        $ids = array_keys($res['matches']);
        $ids = implode(',',$ids);
        return $ids;
    }
}

class Memecache_Dao{
    //内部使用的 Memecache 对象
    private  $memcache =false;
    /**
     * 初始化memcache连接 返回Memecache_Dao对象
     * @param string $host  主机 默认localhost
     * @param int $port  端口 默认是11211
     * @return bool|Memcache  初始化memcache成功返回Memecache_Dao对象  初始化失败返回false
     */
    static function init($host='',$port=0){
        //配置memcache
        $host = !empty($host) ? $host : (!empty($config_ed['memcache']['host']) ? $config_ed['memcache']['host'] : 'localhost');
        $port = !empty($port) ? $port : (!empty($config_ed['memcache']['port']) ? $config_ed['memcache']['port'] : 11211);
        $memcache = new Memcache();
        if(!$memcache->connect($host,$port))
            return false;
        return new self($memcache);
    }

    /**
     * Memecache_Dao constructor.
     * @param $memcache  内部要使用的memcache对象
     */
    function __construct($memcache)
    {
        $this->memcache = $memcache;
    }

    /**
     * 将memcache中某一个key对应的值加上一个数字，默认是加一自增
     * @param string $key  要处理的memcache中的key
     * @param int $incr  增量  默认为1  表示自增
     * @return bool  执行成功返回true  执行失败返回false
     */
    function memcache_incr($key='',$incr=1){
        if(empty($key))
            return false;

        //取出原来的值
        $value = $this->memcache->get($key);
        //如果取出的是空的  默认为0
        if(!$value)
            $value = 0;
        //新值
        $value = (int)$value + $incr;
        $this->memcache->set($key,$value);
        return true;
    }

    /**
     * 将memcache中某一个key对应的值减去一个数字，默认是减一自减
     * @param string $key  要处理的memcache中的key
     * @param int $decr  增量  默认为1  表示自减
     * @return bool  执行成功返回true  执行失败返回false
     */
    function memcache_decr($key='',$decr=1){
        if(empty($key))
            return false;

        //取出原来的值
        $value = $this->memcache->get($key);
        //如果取出的是空的  默认为0
        if(!$value)
            $value = 0;
        //新值
        $value = (int)$value - $decr;
        $this->memcache->set($key,$value);
        return true;
    }
}