<?php

include('lib.php');

if(islogin()!== false){
    header('location:home.php');
    exit;
}

$name = P('username');
$password = P('password');
$password2 = P('repassword');

if(!$name || !$password || !$password2){
    error('please write your infomation');
}

$redis = connredis();
$res = $redis->get('user:username:' . $name . 'userid');

if($res){
    error('this name was used,please change');
}

if($password !== $password2){
    error('two password wasnt match');
}

$userid = $redis->incr('global:userid');

$redis->set('user:userid:' . $userid . ':username',$name);
$redis->set('user:userid:' . $userid . ':password',$password);
$redis->set('user:username:' . $name . ':userid',$userid);

$redis->lpush('newuserlink',$userid);
$redis->ltrim('newuserlink',0,49);

header('location:index.php');
