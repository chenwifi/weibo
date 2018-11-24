<?php
include('lib.php');

setcookie('userid','',-1);
setcookie('username','',-1);
setcookie('auth','',-1);

$redis = connredis();
$redis->set('user:userid:' . $_COOKIE['userid'] . ':auth','');

header('location:index.php');
