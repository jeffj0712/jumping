<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../assets2/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets2/css/font-awesome.css" rel="stylesheet">
<link href="../assets2/css/custom.min.css" rel="stylesheet">
<link href="../assets2/css/style3.css" rel="stylesheet">
<link href="../assets2/css/magnific-popup.css" rel="stylesheet">
<link href="../assets2/css/select2.min.css" rel="stylesheet">
<style type="text/css">
.cf-hidden {
display: none;
}
.cf-invisible {
visibility: hidden;
}
#comodoTL {
display:block;
font-size:8px;
padding-left:18px;
}
.container-space {
margin-bottom: 50px;
}
input{padding-left:0px;}
.pv_messageright{background-color:#E8E8E8;}
.pv_messageleft{background-color:;}
.pv_master{background-color:#066; color:#FFF; padding-right: 3px; padding-left:3px; border-radius:3px;}
.table_div{ overflow-x:auto; background-color:#FFF; width:100%; padding-bottom:30px}
.table_div table { background-color:#F9FFEA}
.table_div table thead{background-color:#CCC}
.table_div table td, th{ white-space:nowrap}
.table_div table tbody tr td{ font-size:15px; font-weight:normal; padding-bottom:10px; padding-top: 10px;}
.table_div table tbody tr td a{font-weight:bold; cursor:pointer; color:#0C0; text-decoration:none;}
#sing_c td{text-align:left}
.pop_up_mag{width:auto; max-width:500px; width:500px; display:inline-block; background-color:#EFEFEF; padding:20px; border-radius:5px; color: #222}
@media (max-width: 500px) {
.pop_up_mag{width:100%; padding:10px;}
}
.pop_up_mag2{width:auto; max-width:900px; width:900px; display:inline-block; background-color:#EFEFEF; padding:20px; border-radius:5px; color: #222}
@media (max-width: 500px) {
.pop_up_mag2{width:100%; padding:10px;}
}
</style>
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border-bottom:medium #CCC solid">
                    <a href="#" class="site_title"><img src="../assets2/images/avatar.jpg" style="max-width:40px;" alt="..." class="img-circle"> <span id="namzut0">Jumping Fitness Malaysia</span></a>
                </div>
                <div class="clearfix"></div>
                <div class="profile">
                    <div class="profile_pic">
                        <img src="../assets2/images/avatar.jpg" style="max-width:30px;" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <h2>Welcome! Manager</h2>
                    </div>
                </div>
                <br>
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu ">
                    <div class="menu_section">
                        <h3>&nbsp;  </h3>
                        <ul class="nav side-menu">
                            <li><a href="dashboard.php" style="font-weight:bold"><i class="fa fa-dashboard"></i> Dashboard</a>
                            
                            <li style="background-color:#333"><a style="text-align: center;">Class</a>
                        </li>
                        <li><a href="./class.php"><i class="fa fa-pl"></i>View Classes</a>
                    </li>
                    <li><a href="./add-class.php"><i class="fa fa-plu"></i>New Class</a>
                </li>
                
                <li style="background-color:#333"><a style="text-align: center;">Students</a>
                </li><li><a href="./add-credit.php"><i class="fa fa-plu"></i>Student Details</a>
            </li>
            <li><a href="./reservation.php"><i class="fa fa-pl"></i>Reservations</a>
        </li>
        <li><a href="./cancelled_reservation.php"><i class="fa fa-pl"></i>Cancelled Reservations</a>
    </li>
    <li style="background-color:#333"><a style="text-align: center;">Account</a>
</li>
<li><a href="./change-password.php"><i class="fa fa-plu"></i>Change Password</a>
</li>
<?php if ($_SESSION['adminb'] == '9') {?>
<li><a href="./admin.php"><i class="fa fa-use"></i>New Manager</a>
</li>
<?php }?>
<li style="margin-top:200px"><a class="" href="login.php?logout"><i class="fa fa-sign-out"></i><span class="text">Logout</span></a></li>
</ul>
</div>
</div>
</div>
</div>
<div class="top_nav">
<div class="nav_menu">
<nav>
<div class="nav toggle">
<a id="menu_toggle"><i class="fa fa-bars"></i></a>
</div>
<ul class="nav navbar-nav navbar-right">
<li class="">
<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
<img src="../assets2/images/avatar.jpg"  alt=""><?php echo $_SESSION['admin']; ?>  <span class=" fa fa-angle-down"></span>
</a>
<ul class="dropdown-menu dropdown-usermenu pull-right">
<li><a href="login.php?logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
</ul>
</li>
</ul>
</nav>
</div>
</div>
<script src="../assets2/js/jquery.min.js"></script>
<script src="../assets2/js/tether.min.js"></script>
<script src="../assets2/js/bootstrap.min.js"></script>
<div class="dommie" id="sending" ><span><i class="fa fa-spinner fa-spin"></i>  Please wait...</span></div>