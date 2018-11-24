<?php
include('lib.php');
if(islogin() === false){
    header('location:index.php');
}

$redis = connredis();
$newuserlist = array();

$newuserlist = $redis->sort('newuserlink',array('sort'=>'desc','get'=>'user:userid:*:username'));

//print_r($newuserlist);exit;

?>
<h1>hot</h1>

<p>
<h2>welcome the lasted user</h2>
</p>
<div>
<?php foreach($newuserlist as $v) {?>
<a href='profile.php?u=<?php echo $v ?>'><?php echo $v ?></a>
<?php }?>
</div>
<p>
<h2>let us see the lasted thought</h2>
</p>
