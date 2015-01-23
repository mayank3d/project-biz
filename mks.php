<?php
require_once "Predis/Autoloader.php";
    Predis\Autoloader::register();
    $redis = new Predis\Client(array(
                "scheme" => "tcp",
                "host" => "127.0.0.1",
                "port" => 6379));
    /*$redis->hset('hash','field','value');
    $val = $redis->hget('hash','field');
    var_dump($val);die;*/
    $redis->zAdd('key', 1, 'val1');
    $redis->zAdd('key', 0, 'val0');
    $redis->zAdd('key', 5, 'val5');
    $redis->zAdd('key', 6, 'val5');
    $arr = $redis->zRange('key', 0, -1); // array(val0, val1, val5)
    echo "<pre>";
    print_r($arr);
    die;
    
?>