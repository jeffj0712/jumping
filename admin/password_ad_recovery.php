<?php

require '../connect/config.php';

if(isset($_POST["token"]) and !isset($_POST["submitf"])){
	
	
	require'../mailer/crypto.php';

    	 
	$pword = password_hash($_POST['pword'], PASSWORD_DEFAULT); 
    $token =  $_POST['token'];
	
	    if($token == "") die("This link has already been used");
		  $raw_data = decrypt($token);
		  $data = explode("___", $raw_data); 
		  //$timec."___".$email."___".$username."___".$timec
		  $timec = $data[0]; 
		  if($data[0] != $data[3]) die("");
		  if((time() - $timec) > 7200) die("Sorry! This link has expired");
		  
		  
		   $pdo = new mypdo();
		  $pdo->get_recover($timec, $data[1]);
		     
		  $pdo->delete_recover($timec, $data[1]);
		  
		  $pdo->update_password($pword, $data[1]);
          
		   die("PASS");  

 
			  }
             

     
elseif(isset($_REQUEST["pl"]) and !isset($_POST["submitf"])){
              
			 require'../mailer/crypto.php';
			 $raw_data = decrypt($_REQUEST["pl"]);
		     $data = explode("___", $raw_data); 
			 $username =	$data[2];	 
             html_out($_REQUEST["pl"], $username); }

else  html_out('bhhjj', 'uvvv');

function html_out($token, $username){?>



<!DOCTYPE html>
<html class=" " lang="en">
<head>

<title>Jumping Fitness Malaysia | Password Reset</title>

<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
 
<link href="../assets2/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets2/css/font-awesome.css" rel="stylesheet">
<link href="../assets2/css/magnific-popup.css" rel="stylesheet">


<style type="text/css">
body{margin:0px; padding:0px; padding-bottom:20px; text-align:center; background-color: #E6E6E6; color:#404040;}
.header{ padding:10px; height: 50px; }
.segment_a{display:none; min-height:300px;; background-color:#EEE; width:600px; text-align:center; margin-top:20px; padding-bottom:20px;}
.segment_b{display: block; color:#FFF; min-height:300px;; background-color:#0C0; width:600px; text-align:center; padding-bottom:20px; margin-top:30px}
@media (max-width:768px){
	
	.segment_a{ min-height: 250px; width:100%}
.segment_b{ width: 100%}



.close_mag{position:absolute; right: 15px; top: 12px; font-size:20px; cursor:pointer; text-decoration:none; color:#FFF;  z-index:200}


.pop_up_mag{width:auto; max-width:500px; width:500px; display:inline-block; background-color:#EFEFEF; padding:20px; border-radius:5px; color: #222}
@media (max-width: 500px) {
.pop_up_mag{width:100%; padding:10px;}
}

.pop_up_mag2{width:auto; max-width:900px; width:900px; display:inline-block; background-color:#EFEFEF; padding:20px; border-radius:5px; color: #222}
@media (max-width: 500px) {
.pop_up_mag2{width:100%; padding:10px;}
}
	
}

</style>

</head>
<body>

<div class="segment_b" id="seg_0" style="display:inline-block; padding:30px;">

<div class="card ">
            <div class="card-header text-center"><h2>Reset Password</h2></div>
            
            

 <div style="margin-top:20px; margin-bottom:20px">
 
<h4>Enter your new password details below</h4>

<div>  <!--:::::::::::      Beginning of form div  :::::::::::-->
<div style="color:#F00;" id="recovery_report"></div>
<form onsubmit="password_change_form(event)">
<div class="row" style="text-align:center">
<div class="col-12 col-md-6">
<div class=" form-group"><label>New Password </label><br /><input class="form-control" id="pword1" required placeholder="*******" type="password" /></div></div>
<div class="col-12 col-md-6">
<div class=" form-group"><label>Retype Password </label><br /><input class="form-control" id="pword2" required placeholder="*******" type="password"/></div></div>
<div class=" col-12"  style="width:100%; text-align:center"><input type="hidden" id="token" value="<?php echo $token; ?>" /><input type="hidden" id="username" value="<?php echo $username; ?>" /><button class="btn btn-primary"> Reset  </button></div>
</div>
</form>
</div>  <!--:::::::::::      End of form div  :::::::::::-->



              
            
                 </div>
</div>



<style>

.close_mag{position:absolute; right: 15px; top: 12px; font-size:20px; cursor:pointer; text-decoration:none; color:#FFF;  z-index:200}


.pop_up_mag{width:auto; max-width:500px; width:500px; display:inline-block; background-color:#EFEFEF; padding:20px; border-radius:5px; color: #222}
@media (max-width: 500px) {
.pop_up_mag{width:100%; padding:10px;}
}
</style>






 <script src="../assets2/js/jquery.min.js"></script>
<script src="../assets2/js/bootstrap.min.js"></script>
         
     <script src="../assets2/js/admin_signing.js"></script>
      <script src="../assets2/js/select2.min.js"></script>   
      
     <script src="../assets2/js/magnificent_popup.js"></script>

</body>
</html>



<?php }



class mypdo{
	 public $pdc = null;
	 public function __construct(){
		 $host = dbhost;
		 $db   =  dbname;
		 $user  =  dbuser;
		 $pass  =   dbpass;
		 $charset = 'utf8mb4';
		 $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		 $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false,];
		 $this->pdc = new PDO($dsn, $user, $pass, $opt);
		 }
	 
	 
	 
	 public function get_recover($timec, $username){
		 $qry = "SELECT username FROM recovertb WHERE id = ? AND username = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $timec, PDO::PARAM_INT);
		 $stmt->bindParam(2, $username, PDO::PARAM_STR); 
		 $stmt->execute();
		 if($stmt->rowCount() < 1)
		 die('link has expired');
		 else{
		  return $stmt->fetch();
		    }
		    
		 }
	  
	  public function delete_recover($timec, $username){
		 $qry = "DELETE FROM recovertb WHERE id = ? AND username = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $timec, PDO::PARAM_INT);
		 $stmt->bindParam(2, $username, PDO::PARAM_STR); 
		 $stmt->execute();
		 }
	   
	   
	   public function update_password($pword, $username){
		 $qry = "UPDATE admin SET pwd = ? WHERE email = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $pword, PDO::PARAM_STR);
		 $stmt->bindParam(2, $username, PDO::PARAM_STR); 
		 $stmt->execute();
		  }
	 }
















