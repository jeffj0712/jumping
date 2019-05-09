<?php 
session_start();
   //
      if(!isset($_SESSION['admina'])) die(header("Location: ../login.php"));


if($_SESSION['adminb'] == '9') $kzn =  1; else die(header("Location: ./dashboard.php")); 

require '../connect/config.php';
$pdo =  new mypdo();

 ?> 

<!DOCTYPE html>
<html class=" " lang="en">
<head>

<title>Add New Admin User</title>


<?php include("../template/header.php"); ?>

   <div class="right_col" role="main" style="min-height: 1154px;">
    <div class="">
        <div class="">
            
            	<h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-user-circle"></i> Add New Admin User </h4>
         
        </div>
        
    
        
    <br><br>
          <div id="messages" class="pv_mess"> <!----- message tab div  --->
          
          
          
                <div class=" container-fluid" style="width:100%">
            
          <div class="card">
                                    <h5 class="card-header">( Please take note of the password. Admin can change their password when they first login)</h5>
                                    <div class="card-body p-0">
                                         <form onSubmit="add_admin(event);">
                                          <div class="form-group">
                                              <label for="inputText1" class="col-form-label">Email Addrss</label>
                                              <input autocomplete="off" id="email" required type="email" class="form-control">
                                          </div>

                                          <div class="form-group">
                                              <label for="inputText2"  class="col-form-label">Password</label>
                                              <input autocomplete="off" id="password" required  class="form-control" placeholder="">
                                          </div>
                                <div id="errmsg" style="color:#F00; text-align:center"></div>
                                          <div class="form-group" id="sbutton">
                                            <button  class="btn btn-success">Add</button>
                                          </div>

                                      </form>
                                    </div>
                                </div>
             
                      </div> 
             
             
              <br><br>
           
          
           </div> <!----- end of message div  --->
    
    
    
       </div>
          <br><br>
          
          
          
          
<div id="cursebox" style="width:100%; text-align:center; padding-top:10px; padding-bottom:20px;" class="white-popup mfp-hide">

 <div class="pop_up_mag"> 
  <a class="fa fa-times close_mag" style="color:#FFF"></a>

 
 <!-- content  -->
<div>
<!-- head  -->
<div id="reghead" style=" border-bottom:2px outset #CCC; color:#060; padding:6px; text-align:center; font-weight:bold; font-size:22px">New Course Addition</div>
</div>
 <div style="margin-top:20px; margin-bottom:20px">
 <form id="cform" onSubmit="submit_form(event)" method="post" action="">
<div class="container-fluid" style="text-align:left">

<div class="col-xs-12">
 <div class="form-group">
 <label>PC  Model :</label>
 <input class="form-control inputncs" type="text" id="cname" required/>
 </div></div> 

 
 <div class="col-6">
 <button id="course_btn" style="margin-top:30px" class="btn btn-success"><span></span> Update</button>
 </div>
 </div>
 </div>
  </form>
 </div>
 </div>
 
      
          
          
          
          
     <script src="../assets2/js/admin.js"></script>
      <script src="../assets2/js/select2.min.js"></script>   
      
       <script>    



$(document).ready(function(){ 

//$('select').select2();

 });
 
</script>
  
          
      <?php include_once("../template/footer.php");
   
 
 
 
 
function option_group($arr){
	$option = '<option value="">Select an option</option>';
	for($iz = 0; $iz < count($arr); $iz++){
		$val = $arr[$iz]['value'];
		$option .= '<option value="'. $val .'">'. $val .'</option>';
		}
	
	return $option;
	}  

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
	 
	  public function get_admin(){
		 try{
		  $qry = "SELECT id, admin_name, password FROM admin ORDER BY id DESC";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->execute();
		  return $stmt->fetchAll();
	 }
	 
	 catch(Exception $e){
		 return [];
		 }
     
	 }

	 
	 }
 		

