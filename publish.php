<?php

include('lib.php');

$content = P('content');

if(!$content){
    error('please write down you thought');
}

if(($user = islogin()) === false){
    header('location:index.php');
    exit;
}

$redis = connredis();

$pid = $redis->incr('global:postid');

/*
$redis->set('post:postid:' . $pid . ':userid',$user['userid']);
$redis->set('post:postid:' . $pid . ':time',time());
$redis->set('post:postid:' . $pid . ':content',$content);
*/

$redis->hmset('post:postid:'.$pid,array('userid'=>$user['userid'],'username'=>$user['username'],'time'=>time(),'content'=>$content));

$redis->zadd('user:userid:'.$user['userid'].':post',$pid,$pid);

if($redis->zcard('user:userid:'.$user['userid'].':post')>20){
    $redis->zremrangebyrank('user:userid:'.$user['userid'].':post',0,0);
}

//mypost:

$redis->lpush('mypost:userid:'.$user['userid'],$pid);
if($redis->llen('mypost:userid:'.$user['userid'])>10){
    $redis->rpoplpush('mypost:userid:'.$user['userid'],'global:store');
}





//$fans = $redis->smembers('follower:'.$user['userid']);
//$fans[] = $user['userid'];
//print_r($fans);exit;
//foreach($fans as $fansid){
//    $redis->lpush('recivepost:'.$fansid,$pid);
//}

header('location:home.php');
