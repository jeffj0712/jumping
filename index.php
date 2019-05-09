<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Jumping Fitness Malaysia | Professional Training Center</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
  <meta name="theme-color" content="#0FF"/>
<meta name="msapplication-TileColor" content="#0FF" />


    <meta name="keywords" content="Jobs, usa jobs, canda jobs, dubai, employment, cleaner, welder,">

	<meta name="description" content="Jumping Fitness Malaysia - The best fitness trainning center in Malaysia "/>
	<meta property="og:url" content="https://www.jumpingfitness.com"/>
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="Jumping Fitness Malaysia - Professional Training Center"/>
	<meta property="og:description" content="Jumping Fitness Malaysia. We are the professionals. Jumping Fitness Malaysia is the best avenue to succeed in your fitness . ."/>
	<meta property="og:image" content="https://www.jumpingfitness.com/assets/img/jumping_fitness_malaysia.jpg"/>
   
  
  
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
        <h3><a href="#hero" style="color:#0F0; font-weight:bolder"><img src="assets/img/logo2.png" style="max-height:35px;"  /></h3>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#hero">Home</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="registration.php">Registration</a></li>
          <li><a href="#contact">Contact Us</a></li>
          <?php if(isset($_SESSION['admina'])){ ?>
      <a  href="./admin"> admin Area </a>
      <?php }?>
          
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Hero Section
  ============================-->
  <section id="hero">
    <div class="hero-container">
      <h1>Jumping Fitness Malaysia</h1>
      <h2>Professional Fitness Center </h2>
      <a href="./registration.php" class="btn-get-started">Register for a class</a>
      <?php if(isset($_SESSION['userid'])){ ?>
      <a  href="./profile" class="btn-get-started"> view Profile </a>
      <?php }else{ ?>
      <a id="loginlink" href="#" class="btn-get-started" onClick="login_click()">Login</a>
      <?php } ?>
    </div>
  </section><!-- #hero -->

  <main id="main">

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
      <div class="container">
        <div class="row about-container">

          <div class="col-lg-6 content order-lg-1 order-2">
            <h2 class="title">About Us</h2>
            <p>
             Jumping Fitness Malaysia is a new generation  training center that focus on Fitness. Our courses are well elaborated to yield effective learning outcome</p><p>
             For the pass few years, there have been increase in the level of fitness concern, thus the need to propagate the knowledge in this trend. Jumping Fitness Malaysia is the guiding light in the world of fitness training. We lead, while others follow. It does not matter your backgroud or your body physic, Our trainning systems are designed to suite your demand. </p><p>
. 
            </p>

            
          </div>
       <div class="col-lg-6 background order-lg-2 order-1 wow fadeInRight"></div>
        </div>

      </div>
    </section><!-- #about -->


   
   
    <!--==========================
    Call To Action Section
    ============================-->
    <section id="call-to-action">
      <div class="container wow fadeIn">
        <div class="row">
          <div class="col-lg-9 text-center text-lg-left">
            <h3 class="cta-title">Register a course today!</h3>
            <p class="cta-text"> Become a fitness expert. It doesn't matter your current background. Follow the guiding light. Our team are experience and practically oriented. </p>
          </div>
           </div>

      </div>
    </section><!-- #call-to-action -->



    <!--==========================
      Contact Section
    ============================-->
    <section id="contact">
      <div class="container wow fadeInUp">
        <div class="section-header">
          <h3 class="section-title">Contact</h3>
          <p class="section-description">You can always get in touch with us using any of the following channels</p>
        </div>
      </div>

      <div class="container wow fadeInUp">
        <div class="row justify-content-center">

          <div class="col-lg-3 col-md-4">

            <div class="info">
              <div>
                <i class="fa fa-map-marker"></i>
                <p>Malaysia </p>
              </div>

              <div>
                <i class="fa fa-envelope"></i>
                <p>info@jumpingfitness.com</p>
              </div>

                </div>

   
          </div>

          <div class="col-lg-5 col-md-8">
            <div class="form">
              <div id="sendmessage">Your message has been sent. Thank you!</div>
              <div id="message_report"></div>
              <form action="" method="post" role="form" class="contactForm" onSubmit="submit_contact_form(event)" id="form_n">
                <div class="form-group">
                  <input type="text" name="name" class="form-control" id="name_n" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="email" id="email_n" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject_n" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="query" id="message_n" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                  <div class="validation"></div>
                </div>
                <div class="text-center"><button type="submit">Send Message</button></div>
              </form>
            </div>
          </div>

        </div>

      </div>
    </section><!-- #contact -->

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
        Designed by <span class="small"><a href="admin/">Joyway</a></span>
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
  

   
     
     <!--/ Modal box-->

  
  <div class="dommie" id="sending" ><span><i class="fa fa-spinner fa-spin"></i>  Please wait...</span></div>

  
  
  
  
  
  
  

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
