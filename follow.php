<?php

include('lib.php');

if(($user = islogin())===false){
    header('location:index.php');
}
//print_r($user);exit;
$f = G('f');
$otherid = G('uid');

$redis = connredis();

if($f){
    $redis->sadd('following:' . $user['userid'],$otherid);
    $redis->sadd('follower:' . $otherid,$user['userid']);    
}else{
    $redis->srem('following:' . $user['userid'],$otherid);
    $redis->srem('follower:' . $otherid,$user['userid']);
}

$othername = $redis->get('user:userid:' . $otherid . ':username');
header('location:profile.php?u=' . $othername);
