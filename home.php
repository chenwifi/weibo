<?php
include('lib.php');

if(($user=islogin()) === false){
    header('location:index.php');
    exit;
}

$redis = connredis();

//$redis->ltrim('recivepost'.$user['userid'],0,49);
//$content = $redis->sort('recivepost:'.$user['userid'],array('sort'=>'desc','get'=>'post:postid:*:content'));
//var_dump($content);exit;

//$postids = $redis->sort('recivepost:'.$user['userid'],array('sort'=>'desc'));

//var_dump($postids);exit;


$lastpullpid = $redis->get('lastpullpid:userid:'.$user['userid']);
if(!$lastpullpid){
    $lastpullpid = 0;
}

$idol = $redis->smembers('following:'.$user['userid']);
$idol[] = $user['userid'];
//print_r($idol);
$lastpid = $redis->get('global:postid');
$plist = array();
foreach($idol as $v){
    $plist = array_merge($plist,$redis->zrangebyscore('user:userid:'.$v.':post',$lastpullpid+1,$lastpid));
}
//sort($plist);
rsort($plist);
if(!empty($plist)){
    $redis->set('lastpullpid:userid:'.$user['userid'],end($plist));
}
print_r($plist);
foreach($plist as $v){
    $redis->lpush('recivepost:'.$user['userid'],$v);
}

$redis->ltrim('recivepost:'.$user['userid'],0,999);
//$postids = $redis->lrange('recivepost:'.$user['userid'],0,-1);
$list = array();
foreach($plist as $v){
    $list[] = $redis->hmget('post:postid:'.$v,array('userid','username','time','content'));
}

//var_dump($list);exit;

$fansnum = $redis->scard('follower:'.$user['userid']);
$idotnum = $redis->scard('following:'.$user['userid']);
?>


<html>
<body>
<style type='text/css'>
textarea{
width:500px;
height:200px;
}
</style>
<p><a href='index.php'>firstpage</a></p>
<p><a href='timeline.php'>hot</a></p>
<p><a href='logout.php'>logout</a></p>
<h3>following:<?php echo $idotnum ?></h3><h3>follower:<?php echo $fansnum ?></h3>
<p><?php echo $user['username'] ?>,dont miss your thought</p>
<p>
<form action='publish.php' method='post'>
<textarea name='content'></textarea>
<input type='submit' value='publish' />
</form>
</p>
<?php foreach($list as $v){ ?>
<div>
<p><a href="profile.php?u=<?php echo $v['username'] ?>"><?php echo $v['username']; ?></a></p>
<p><?php echo $v['content']; ?></p>
<p>wased published before <?php echo timeformat($v['time']); ?></p>
</div>
<?php } ?>
</body>
</html>


