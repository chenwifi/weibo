<?php
include('lib.php');

$redis = connredis();
$pdo = new PDO('mysql:dbname=test;host=localhost','root','123456');


$i=0;
while($redis->llen('global:store') && $i<1000){
    $stmt = $pdo->prepare('insert into post (postid,userid,username,time,content) values (?,?,?,?,?)');
    $i++;
    $postid = $redis->rpop('global:store');
    //print_r($postid);
    $arr = $redis->hmget('post:postid:'.$postid,array('userid','username','time','content'));
    print_r($arr);
    $stmt->bindValue(1,$postid,PDO::PARAM_INT);
    $stmt->bindValue(2,$arr['userid'],PDO::PARAM_INT);
    $stmt->bindValue(3,$arr['username'],PDO::PARAM_STR);
    $stmt->bindValue(4,$arr['time'],PDO::PARAM_INT);
    $stmt->bindValue(5,$arr['content'],PDO::PARAM_STR);
    $stmt->execute();
}

echo 'ok';






