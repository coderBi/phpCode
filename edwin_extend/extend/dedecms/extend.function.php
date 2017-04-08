<?php
/**
 * dedecms中自定义过的一些扩展函数
 * <p>
 * note: 由于自己的框架进行了升级，目前这个文件中的以前使用在dede里面的自定义扩展，<br>
 * 因为使用的是老的面向过程的思路书写的，所以基本不再使用
 * </p>
 * @auth edwin
 * @since 2017-4-8
 * @version 2.0
 */

/*********************************************************自定义的mysqli相关操作  START*******************************************************/
/**
 * 初始化一个数据库连接
 * @param string $host 连接主机
 * @param string $user 用户名
 * @param string $password 连接密码
 * @param string $dbname 默认使用的数据名
 * @param string $charset 连接编码默认utf8
 * @return bool|mysqli  连接配置成功返回mysqli对象  失败返回false
 */
function mysqli_edwin_init($host = 'localhost', $user = 'root', $password = '123', $dbname = '', $charset = 'utf8')
{
    //默认配置
    $dbname = !empty($dbname) ? $dbname : 'dedecmsv57utf8sp2';
    //创建mysqli对象
    $mysqli = new mysqli($host, $user, $password, $dbname);
    if ($mysqli->connect_error)
        return false;
    //设置连接字符集
    if (!$mysqli->query("set names $charset")) {
        $mysqli->close();
        return false;
    }
    return $mysqli;
}

/**
 * @param $channelid  数据库表对应channelid  默认17
 * @param $field  字段名
 * @param $mysqli  mysqli对象，如果不提供本函数会创建，如果是本函数内部创建的连接，在函数执行完成会自动释放
 * @return array|bool 查询成功返回枚举字段处理过得到的数组  失败返回false
 */
function getEnumFromMysql($channelid = 17, $field = '', $mysqli = false)
{
    if (empty($field))
        return false;

    //实在被 dede用自己的dsql玩自己的一套给搞吐了  这里自己用新的数据库连接进行原生的sql操作
    if (!$mysqli) {
        $autoClose = true;
        if (!($mysqli = mysqli_edwin_init()))
            return false;
    }

    //查询数据库
    $sql = "show columns from dede_addon$channelid like '$field'";

    /// 之前的错误代码： $result = $dsql->GetOne($sql)  错误原因：查看GetOne函数可以发现会默认的在语句后面追加一个 limit 0,1 可是通过实践发现show columns 不能与 limit一起用。;

    if (!($result = $mysqli->query($sql))) {
        return false;
    }
    //从结果集获取一行记录
    $row = $result->fetch_array();

    //释放数据集和连接对象
    $result->close();
    if (!empty($autoClose))
        $mysqli->close();

    if (!is_array($row) || !isset($row['Type']))
        return false;

    //处理查询结果 将字符串 '(值1,值2)'类型的字符串处理返回 array(值1,值2)类型数组  值得注意的是数据库中返回的enum本身值上面带有 "~"
    $area = $row['Type'];
    $area = explode('(', $area);
    $area = $area[1];
    $area = explode(')', $area);
    $area = $area[0];
    //移除获取到内容中的单引号
    $area = preg_replace("/'/u", '', $area);
    return explode(',', $area);
}

/**
 * 执行一条有结果集的sql  返回一个二维数组
 * @param string $sql 待执行sql
 * @param bool|false $mysqli mysqli对象，如果不提供本函数会创建，如果是本函数内部创建的连接，在函数执行完成会自动释放。
 * @param string $charset 连接字符集，默认uft8
 * @return array|bool sql执行成功返回array  失败返回false
 */
function mysqli_query_all($sql = '', $mysqli = false, $charset = 'utf8')
{
    //如果mysqli对象不存在  就创建并且连接数据库
    if (!$mysqli) {
        //设置mysqli在函数执行后关闭标记为true
        $autoClose = true;
        //创建mysqli对象
        if (!($mysqli = mysqli_edwin_init()))
            return false;
    }

    if (!($result = $mysqli->query($sql))) {
        if (!empty($autoClose))
            $mysqli->close();
        return false;
    }
    $toReturn = array();
    while ($row = $result->fetch_assoc()) {
        $toReturn[] = $row;
    }
    $result->close();

    if ($autoClose)
        $mysqli->close();
    return $toReturn;
}

/**
 * @param string $sql 待执行的sql
 * @param bool|false $mysqli mysqli对象，如果没提供，函数执行过程中会连接数据库，函数执行完成会自动释放这个数据库连接
 * @param string $charset 数据库连接编码
 * @return bool|array  sql执行失败或者没有查询到任何数据返回false  成功获取一条记录返回一条记录数据的数组
 */
function mysqli_query_row($sql = '', $mysqli = false, $charset = 'utf8')
{
    //如果是以 select开始的sql语句  因为是查询一条数据 这里进行优化在后面追加limit 0,1。 值得注意的是因为在使用dede的GetOne的时候发现show columns这样的语句后面没有办法出现limit而产生一些问题，所以这里增加了语句以select开头的判断
    if (preg_match('/^select.*/', ltrim($sql))) {
        //去掉结尾的 ; 和 ,
        $sql = preg_replace('/[,;]$/', '', trim($sql));
        //如果结尾没有limit  就加上limit 0,1
        if (!preg_match('/limit/i', $sql)) {
            $sql .= ' limit 0,1;';
        }
    }

    //查询返回二维数组
    $result = mysqli_query_all($sql, $mysqli, $charset);
    if (!is_array($result) || empty($result))
        return false;
    return $result[0];
}

/**
 * @param string $sql 待执行的sql
 * @param bool|false $mysqli mysqli对象，如果没提供，函数执行过程中会连接数据库，函数执行完成会自动释放这个数据库连接
 * @param string $charset 数据库连接编码
 * @return bool|string  sql执行失败或者没有数据 返回false  成功返回数据库中对应的string值
 */
function mysqli_query_one($sql = '', $mysqli = false, $charset = 'utf8')
{
    //查询一行记录
    $result = mysqli_query_row($sql, $mysqli, $charset);
    if (!is_array($result) || empty($result))
        return false;
    //这里由于可能返回的一行数据可能是一个关联数组，所以不能简单的使用$result[0]
    $item = each($result);
    return $item[1];
}

/**
 * 执行一条没有返回数据集的sql语句
 * @param string $sql 待执行的sql
 * @param bool|false $mysqli mysqli对象，如果没提供，函数执行过程中会连接数据库，函数执行完成会自动释放这个数据库连接
 * @param string $charset 数据库连接编码
 * @return bool sql执行成功返回true 失败返回false
 */
function mysqli_query_null($sql = '', $mysqli = false, $charset = 'utf8')
{
    //如果mysqli对象不存在  就创建并且连接数据库
    if (!$mysqli) {
        //设置mysqli在函数执行后关闭标记为true
        $autoClose = true;
        //创建mysqli对象
        $dbname = 'dedecmsv57utf8sp2';
        $mysqli = new mysqli('localhost', 'root', '123', $dbname);
        if (!$mysqli)
            return false;
        //设置连接字符集
        if (!$mysqli->query("set names $charset")) {
            $mysqli->close();
            return false;
        }
    }

    $result = $mysqli->query($sql);

    if (!empty($autoClose))
        $mysqli->close();
    return $result;
}

/*********************************************************自定义的mysqli相关操作  END*******************************************************/


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
 * @param string $name 要移除的参数名称(key)
 * @param string $queryString 待处理的字符串
 * @return string  处理后的字符串
 */
function rmParamFromQueryString($name = '', $queryString = '')
{
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


/*********************************************************sphinx操作相关  START*******************************************************/
/**
 * 初始化一个sphinx连接并返回
 * @param string $host  服务主机
 * @param int $port  端口
 * @param int $match_mode  匹配模式
 * @return SphinxClient  初始化配置之后的sphinx连接对象
 */
function init_sphinx($host = 'localhost', $port = 9312, $match_mode =SPH_MATCH_ALL){
    $sphinx_api_path = "D:\WebSever\coreseek-4.1-win32\coreseek-4.1-win32\api";
    //包含php操作的api文件  实际使用发现 dede的include下面默认就包含了一个api文件，所以这里的require在当前环境下也可以不配置
    require_once("$sphinx_api_path\sphinxapi.php");

    //初始化sphinx连接配置
    $sc = new SphinxClient();
    $sc->setServer($host,$port);
    $sc->SetMatchMode($match_mode);
    return $sc;
}

/**
 * 从sphinx查询一个关键词 返回查到的id列表
 * @param string $keywords 要查询的关键词
 * @param string $indexer  索引
 * @param bool|false $sphinxClient  sphinx连接对象。如果没有提供sphinx连接对象，就内部实例化一个，但是内部实例化的这个对象在函数执行完成会自动释放
 * @return string 处理过的id列表字符串,形式是 id1,di2,id3...
 */
function sphinx_query_ids($keywords='',$indexer='',$sphinxClient=false){
    if(!$sphinxClient){
        $sphinxClient = init_sphinx();
        $autoClose = true;
    }
    //查询
    $res = $sphinxClient->query($keywords,$indexer);
    if (!empty($autoClose))
        $sphinxClient->Close();
    //处理ids列表并返回
    $ids = array_keys($res['matches']);
    $ids = implode(',',$ids);
    return $ids;
}
/*********************************************************sphinx操作相关  END*******************************************************/

/*********************************************************memcache操作相关  START*******************************************************/
//设置memcache是否启用  为true表示启用memcache
$GLOBALS['memcache_on'] = true;

/**
 * 初始化memcache连接
 * @param string $host  主机 默认localhost
 * @param int $port  端口 默认是11211
 * @return bool|Memcache  初始化memcache成功返回memcache对象  初始化失败返回false
 */
function memcache_edwin_init($host='localhost',$port=11211){
    $memcache = new Memcache();
    if(!$memcache->connect($host,$port))
        return false;
    return $memcache;
}

/**
 * 将memcache中某一个key对应的值加上一个数字，默认是加一自增
 * @param string $key  要处理的memcache中的key
 * @param int $incr  增量  默认为1  表示自增
 * @param bool|false $memcache  memcache对象，如果提供的false，函数内部会自动进行memcache连接，函数执行完成之后会自动释放这个连接
 * @return bool  执行成功返回true  执行失败返回false
 */
function memcache_incr($key='',$incr=1,$memcache=false){
    if(empty($key))
        return false;
    if(!$memcache){
        $autoClose = true;
        $memcache = memcache_edwin_init();
        if(!$memcache)
            return false;
    }
    //取出原来的值
    $value = $memcache->get($key);
    //如果取出的是空的  默认为0
    if(!$value)
        $value = 0;
    //新值
    $value = (int)$value + $incr;
    $memcache->set($key,$value);

    if (!empty($autoClose))
        $memcache->close();
    return true;
}

/**
 * 将memcache中某一个key对应的值减去一个数字，默认是减一自减
 * @param string $key  要处理的memcache中的key
 * @param int $decr  增量  默认为1  表示自减
 * @param bool|false $memcache  memcache对象，如果提供的false，函数内部会自动进行memcache连接，函数执行完成之后会自动释放这个连接
 * @return bool  执行成功返回true  执行失败返回false
 */
function memcache_decr($key='',$decr=1,$memcache=false){
    if(empty($key))
        return false;
    if(!$memcache){
        $autoClose = true;
        $memcache = memcache_edwin_init();
        if(!$memcache)
            return false;
    }
    //取出原来的值
    $value = $memcache->get($key);
    //如果取出的是空的  默认为0
    if(!$value)
        $value = 0;
    //新值
    $value = (int)$value - $decr;
    $memcache->set($key,$value);

    if (!empty($autoClose))
        $memcache->close();
    return true;
}
/*********************************************************memcache操作相关  END*******************************************************/


/*********************************************************其他自定义扩展函数  START*******************************************************/
/**
 * 根据评分获取页面小星星
 * @param $score  评分
 * @return string  根据评分生成的页面小星星字符串
 */
function getSmallStars($score)
{
    //申明要使用全局的php变量 $cfg_templets_skin是dede定义的一个php变量，在模板中使用的是 {dede:global.cfg_templets_skin/}
    global $cfg_templets_skin;

    //约定页面上星星的显示个数
    $stars = 5;

    //获取金色星星数量
    $goldCount = round($score / 2);

    //获取灰色星星数量  这里约定页面上
    $gridCount = $stars - $goldCount;

    $toReturn = '';

    //输出两个种星星
    for ($i = 0; $i < $goldCount; ++$i) {
        $toReturn .= "<img src='$cfg_templets_skin/images/star.jpg'/>";
    }
    for ($i = 0; $i < $gridCount; ++$i) {
        $toReturn .= "<img src='$cfg_templets_skin/images/star_grid.jpg'/>";
    }

    return $toReturn;
}
/*********************************************************其他自定义扩展函数  END*******************************************************/