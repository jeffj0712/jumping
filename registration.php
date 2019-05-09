<?php
require './connect/config.php';

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Member Registration</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
  <meta name="theme-color" content="#0FF"/>
 <meta name="msapplication-TileColor" content="#0FF" />



	<meta name="description" content="Jumping Fitness Malaysia - Course Registration"/>
	<meta property="og:url" content="https://www.jumpingfitness.com/registration.php"/>
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="Jumping Fitness Malaysia - Professional Training Center"/>
	<meta property="og:description" content="Jumping Fitness Malaysia. We are the professionals. Jumping Fitness Malaysia is the best avenue to succeed in your fitness . ."/>
	<meta property="og:image" content="https://www.jumpingfitness.com/assets/img/jumping_fitness_malaysia.jpg"/>
  
  
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  
  
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

<style>

.course_details{position:relative; background-color:#676; padding:10px; overflow: hidden; white-space: nowrap; text-overflow:ellipsis; width:100%; color:#FFF; font-weight:bold; font-size:18px; border:#00C 2px solid;}
.more_details{position:absolute; top:-20px; right:10px; padding:6px; border:2px #CCC solid; background-color:#FFF;" class="email; cursor:pointer}
.hiden_details{ display: none;}

</style>

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
          <li><a style="border-bottom:2px solid #0C0; color:#FFF">Member Registration</a></li>
           </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Hero Section
  ============================-->
  <section id="hero" style="height:200px;">
    <!-- <div class="hero-container" style="padding-top:150px;">
      <a class="btn-get-started" style="border-radius:4px; border:dotted; font-weight:bold; background-color:#00F">Member Registration</a>
    </div> -->;
  </section><!-- #hero -->

  <main id="main">
 <div class="container">
<div class="row">


  
<div id="cur_form" style="width:100%; text-align:center; padding-top:10px; padding-bottom:20px; background-color:#CCC">

 <div class="pop_up_mag2">  
 <!-- content  -->
<div>
<!-- head  -->
<div id="reghead" style=" border-bottom:2px outset #CCC; color:#060; padding:6px; text-align:center; font-weight:bold; font-size:22px">Member Registration</div>
</div>
 <div style="margin-top:20px; margin-bottom:20px">
 <form id="cform" onSubmit="submit_reg_form(event)" method="post" action="">
<div class="row" style="text-align:left">


<div class="col-xs-12 col-sm-6">
 <div class="form-group">
<img src="assets/img/common.jpg" id="photo" style="width:200px; max-width:200px">
<input onChange="load_img()" class="form-control inputncs" type="file" name="mfile" id="mfile" required style="width:210px"/>
 </div></div> 





<div class="col-xs-12 col-sm-6">
 <div class="form-group">
 <label><span class="fa fa-user-circle-o"></span> Full Name :</label>
 <input class="form-control inputncs" type="text" name="fname" id="fname" required/>
 </div></div> 


<div class="col-xs-12 col-sm-6">
 <div class="form-group">
 <label><span class="fa fa-envelope-o"></span> Email Address :</label>
 <input class="form-control inputncs" type="email" name="email" id="email" required/>
 </div></div>
 
 <div class="col-xs-12 col-sm-6">
 <div class="form-group">
 <label><span class="fa fa-phone"></span> Contact Number :</label>
 <input class="form-control inputncs" type="phone" name="phone" id="phone" required />
 </div></div>


<div class="col-xs-12 col-sm-6">
 <div class="form-group">
 <label><span class="fa fa-password"></span> Password(min length : 6) :</label>
 <input class="form-control inputncs" type="password" name="pwd" id="pwd" min-length="6" required/>
 </div></div>
 
 <div class="col-xs-12 col-sm-6">
 <div class="form-group">
 <label><span class="fa fa-password"></span> Retype Password :</label>
 <input class="form-control inputncs" type="password" id="pwd2" required />
 </div></div>
 


<div id="errmsg" style="margin-top:30px; color:#F00; size:13px"></div>
 
 <div class="col-12 text-center" id="sbutton" style="margin-top:30px;">
 <button id="course_btn" style="min-width:150px" class="btn btn-success"><span></span> Register</button>
 </div>
 </div>
  </form>
 </div>
 </div>
 </div>
  





    
    </div>
    </div>
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
  
  
    




  
<div id="logbox" style="width:100%; text-align:center; padding-top:10px; padding-bottom:20px;" class="white-popup mfp-hide">

 <div class="pop_up_mag"> 
 <a class="fa fa-times close_mag" style="color:#FFF"></a>
 
 <!-- content  -->
<div>
<!-- head  -->
<div id="loghead" style=" border-bottom:2px outset #CCC; color:#060; padding:6px; text-align:center; font-weight:bold; font-size:22px"> Login</div>
</div>
 <div style="margin-top:20px; margin-bottom:20px">
 <form onSubmit="loginnow(event)" method="post" action="">
 <div class="container-fluid ">
 
 <div class="col-xs-12 " style="color:#F00; font-size:12px;" id="login_err"></div>
 <div class="col-xs-12 " style="color:#F00; font-size:12px;" id="rec_err"></div>
 
 <div class="col-xs-12 " >
 <div class="form-group has-feedback"> 
 <input type="email" id="lusername"  required class="form-control inputncs" placeholder="email address" />
 <input type="email" id="rusername"  required class="form-control inputncs" placeholder="email address" /></div></div>
 
 <div class="col-xs-12">
 <div class="form-group has-feedback">
 <input type="password" id="lpassword" required  class="form-control inputncs" placeholder="enter password" /></div>
  </div></div>
 <div> 
 <button onClick="recovernow()" type="button" id="recover_bxn"  class="btn btn-primary"> Recover <span class="fa fa-recycle"></span></button>
 <button onClick="loginnow()" type="button" id="login_bxn"  class="btn btn-primary"> Login <span class="fa fa-sign-in"></span></button> <a style="margin-left:20px; color:#090; text-decoration:none" id="recover_link" href="#" onClick="recover_click()"> Forgot Password?</a>
 </div>
 </form>
 
 </div>
 </div>
  

<div id="log_admin" style="width:100%; text-align:center; padding-top:10px; padding-bottom:20px;" class="white-popup mfp-hide">

 <div class="pop_up_mag"> 
 <a class="fa fa-times close_mag" style="color:#FFF"></a>
 
 <!-- content  -->
<div>
<!-- head  -->
<div id="loghead" style=" border-bottom:2px outset #CCC; color:#060; padding:6px; text-align:center; font-weight:bold; font-size:22px"> Login As Admin</div>
</div>
 <div style="margin-top:20px; margin-bottom:20px">
 <form onSubmit="login_anow(event)" method="post" action="">
 <div class="container-fluid ">
 
 <div class="col-xs-12 " style="color:#F00; font-size:12px;" id="login_aerr"></div>
 
 <div class="col-xs-12 " >
 <div class="form-group has-feedback"> 
 <input type="text" id="ausername"  required class="form-control inputncs" placeholder="username" />

 <div class="col-xs-12">
 <div class="form-group has-feedback">
 <input type="password" id="apassword" required  class="form-control inputncs" placeholder="enter password" /></div>
  </div></div>
 <div> 
 <button onClick="login_anow()" type="button" id="login_abxn"  class="btn btn-primary"> Login <span class="fa fa-sign-in"></span></button> 
 </div>
 </form>
 
 </div>
 </div>





  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="assets/lib/jquery/jquery.min.js"></script>
  <script src="assets/lib/jquery/jquery-migrate.min.js"></script>
  <script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/lib/wow/wow.min.js"></script>
   

  <script src="assets/lib/waypoints/waypoints.min.js"></script>
  <script src="assets/lib/superfish/superfish.min.js"></script>
  <script src="assets/js/magnificent_popup.js"></script>
  <!-- Contact Form JavaScript File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/home.js"></script>
  
</body>
</html>

<?php


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
	 
	 
    
	 
	 }
 		