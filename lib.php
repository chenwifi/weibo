<?php
error_reporting(E_ALL &~ E_NOTICE);

function P($key){
    return $_POST[$key];	
}

function G($key){
    return $_GET[$key];	
}

function error($msg){
    echo $msg;
    exit;
}

function connredis(){
    static $redis = null;

    if($redis === null){
	$redis = new Redis();
	$redis->connect('127.0.0.1',6379);
    }

    return $redis;
}

function islogin(){
    if(!$_COOKIE['username'] || !$_COOKIE['userid'] || !$_COOKIE['auth']){
	return false;
    }

    $r = connredis();
    $realnum = $r->get('user:userid:' . $_COOKIE['userid'].':auth');

    if($realnum !== $_COOKIE['auth']){
	return false;
    }    

    return array('username'=>$_COOKIE['username'],'userid'=>$_COOKIE['userid']);
}

function autonum(){
    $str = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
    $str = substr(str_shuffle($str),0,16);	
    return $str;
}

function timeformat($time){
    $sec = time()-$time;
    if($sec>=86400){
	return floor($sec/86400).'days';
    }elseif($sec>=3600){
	return floor($sec/3600).'hours';
    }elseif($sec>=60){
	return floor($sec/60) . 'minutes';
    }else{
	return $sec . 'seconds';
    }
}
