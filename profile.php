<?php
include('lib.php');

if(($user=islogin()) === false){
    header('location:index.php');
    exit;
}

$redis = connredis();

$other = G('u');
$otherid = $redis->get('user:username:' . $other . ':userid');

if(!$otherid){
    error('illegal user');
}

$fsta = $redis->sismember('following:' . $user['userid'],$otherid);
$fop = $fsta?0:1;
$finfo = $fsta?'stop follow':'follow';


?>

<html>
<style>
div{
width:120px;
height:100px;
border:3px solid black;
}
</style>
<body>
<h1>this is other people profile</h1>
<a href='index.php'>firstpage</a>
<a href='timeline.php'>hot</a>
<a href='logout.php'>logout</a>

<div>
<p><a href='follow.php?uid=<?php echo $otherid ?>&f=<?php echo $fop; ?> '><?php echo $finfo; ?></a></p>
</div>
</body>
</html>


