<?php

function getMemcacheKeys() {

    $memcache = new Memcache;
    $memcache->connect('localhost', 11211) or die ("Could not connect to memcache server");

    $list = array();
    $allSlabs = $memcache->getExtendedStats('slabs');
    //$items = $memcache->getExtendedStats('items');
    foreach($allSlabs as $server => $slabs) {
        foreach($slabs AS $slabId => $slabMeta) {
           $cdump = $memcache->getExtendedStats('cachedump',(int)$slabId);
            foreach($cdump AS $keys => $arrVal) {
                if (!is_array($arrVal)) continue;
                foreach($arrVal AS $k => $v) {                  
                    echo $k .'=>';
                    //上面获取的$v 对一个的并不是所有的值 要获取值还得用get  其实也很容易理解，如果这几行代码就将整个服务器的数据都获取到也没法实用
                    var_dump($memcache->get($k));
                }
           }
        }
    }
    $memcache->close();
}

getMemcacheKeys();
