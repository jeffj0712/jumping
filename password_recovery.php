<?php

require './connect/config.php';

if(isset($_POST["token"]) and !isset($_POST["submitf"])){
	require'mailer/crypto.php';

    	 
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
              
			 require'mailer/crypto.php';
			 $raw_data = decrypt($_REQUEST["pl"]);
		     $data = explode("___", $raw_data); 
			 $username =	$data[2];	 
             html_out($_REQUEST["pl"], $username); }



function html_out($token, $username){?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Jumping Fitness Malaysia | Reset Password </title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
  <meta name="theme-color" content="#0FF"/>
<meta name="msapplication-TileColor" content="#0FF" />
  
  
  
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->

  <!-- Bootstrap CSS File -->
  <link href="assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/lib/animate/animate.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/magnific-popup.css" rel="stylesheet">


  <!-- =======================================================
    Theme Name: Regna
    Theme URL: https://bootstrapmade.com/regna-bootstrap-onepage-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body onLoad="loadref()">

  <!--==========================
  Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <h3><a href="#hero" style="color:#0F0; font-weight:bolder"><img src="assets/img/logo2.png" style="max-height:35px;"  /></a></h3>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="./">Home</a></li>
          
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Hero Section
  ============================-->
  <section id="hero" style="max-height:100px;">
    <div class="hero-container">
      </div>
  </section><!-- #hero -->


  <main id="main" style="margin-top:40px; margin-bottom:60px;">



<h4>Enter your new password details below</h4>

<div>  <!--:::::::::::      Beginning of form div  :::::::::::-->
<div style="color:#F00;" id="recovery_report"></div>
<form onsubmit="password_change_form(event)">
<div class="row" style="text-align:center">
<div class="col-12 col-md-6">
<div class=" form-group"><label>New Password </label><br /><input class="form-control" id="pword1" required placeholder="*******" type="password" /></div></div>
<div class="col-12 col-md-6">
<div class=" form-group"><label>Retype Password </label><br /><input class="form-control" id="pword2" required placeholder="*******" type="password"/></div></div>
<div class=" col-12"  style="width:100%; text-align:center"><input type="hidden" id="token" value="<?php echo $token; ?>" /><input type="hidden" id="username" value="<?php echo $username; ?>" /><button> Change</button></div>
</div>
</form>
</div>  <!--:::::::::::      End of form div  :::::::::::-->


  </main>




<!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">

      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Jumping Fitness Malaysia Pte</strong>. All Rights Reserved
     </div>
      <div class="credits">
        <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Regna
        -->
        Designed by <span class="small">theGeko</span>
      </div>
    </div>
  </footer><!-- #footer -->
  
  


  

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="assets/lib/jquery/jquery.min.js"></script>
  <script src="assets/lib/jquery/jquery-migrate.min.js"></script>
  <script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/lib/easing/easing.min.js"></script>
  <script src="assets/lib/wow/wow.min.js"></script>


  <script src="assets/lib/superfish/hoverIntent.js"></script>
  <script src="assets/lib/superfish/superfish.min.js"></script>
  <script src="assets/js/magnificent_popup.js"></script>
  <!-- Contact Form JavaScript File -->
 <!-- Template Main Javascript File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/home.js"></script>
  
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
		 $qry = "UPDATE profile SET pwd = ? WHERE email = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $pword, PDO::PARAM_STR);
		 $stmt->bindParam(2, $username, PDO::PARAM_STR); 
		 $stmt->execute();
		  }
	 }
















