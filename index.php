<?php

include('lib.php');

if(islogin()!==false){
    header('location:home.php');
    exit;
}

?>

<html>
<body>
<h1>weibo</h1>
<div>
<h2>register</h2>
<form action='register.php' method='post'>
name:<input type='text' name='username' /><br />
password:<input type='password' name='password' /><br />
cmpass:<input type='password' name='repassword' /><br />
<input type='submit' value='register' />
</form>
</div>
<div>
<h2>login</h2>
<form action='login.php' method='post'>
name:<input type='text' name='username' /><br />
password:<input type='password' name='password' /><br />
<input type='submit' value='login' />
</form>
</div>
</body>
</html>



