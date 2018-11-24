<?php

include('lib.php');

$username = P('username');
$password = P('password');

$redis = connredis();

$userid = $redis->get('user:username:' . $username . ':userid');

if($userid===false){
    error('this name wasnt assign');
}
//echo $userid;exit;
$realpass = $redis->get('user:userid:' . $userid . ':password');
//print_r($realpass);exit;

if($realpass !== $password){
    error('password isnt right');
}

$autonum = autonum();
$redis->set('user:userid:' . $userid . ':auth',$autonum);

setcookie('username',$username);
setcookie('userid',$userid);
setcookie('auth',$autonum);

header('location:home.php');
