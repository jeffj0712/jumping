<?php
	 
if(isset($_REQUEST['logout'])){
  session_start();	   
	session_unset();
	session_destroy();
	die(header("Location: ../"));
	
	die();
}
else{



?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title></head>
<body style="text-align:center; ">

<div style="max-width:500px; display:inline-block; margin-top:100px">

<form method="post">
  <div style="color:red"> <?php if(isset($_GET['err'])) echo $_GET['err']; ?></div>
<div style="margin:10px 0px 20px 0px"><label>Username</label><input name="username" type="text" /></div>

<div style="margin:10px 0px 20px 0px"><label>Password</label><input name="password" type="password" /></div>

<div style="margin:10px 0px 20px 0px"><input style="padding:6px; width:100px" name="login" value="Login" type="submit" /></div>

</form>


</div>



</body>

</html>




<?php   }  ?>
