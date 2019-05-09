<!DOCTYPE html>
<html class=" " lang="en">
  <head>
    <title>Jumping Fitness Malaysia | Login</title>
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
        <div class="card-header text-center"><h2>Admin Login</h2><span class="splash-description">Please enter your user information.</span></div>


        <button class="btn btn-primary" style="margin-top:40px; min-width:100px;" onClick="login_click()">Log in Here</button>


      </div>
    </div>
    <div id="logbox" style="width:100%; text-align:center; padding-top:10px; padding-bottom:20px;" class="white-popup mfp-hide">
      <div class="pop_up_mag">
        <a class="fa fa-times close_mag" style="color:#FFF"></a>

        <!-- head  -->
        <div id="loghead" style=" border-bottom:2px outset #CCC; color:#060; padding:6px; text-align:center; font-weight:bold; font-size:22px">Admin Login</div>
        <div style="margin-top:20px; margin-bottom:20px">
          <form onSubmit="loginnow(event)" method="post" action="">
            <div class="container-fluid">

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