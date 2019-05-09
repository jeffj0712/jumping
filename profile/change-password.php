<?php
session_start();
//
if(!isset($_SESSION['userid'])) die(header("Location: ../login.php"));
require '../connect/config.php';
$pdo =  new mypdo();
?>
<!DOCTYPE html>
<html class=" " lang="en">
  <head>
    <title>Change Password</title>
    <?php include("../template/header2.php"); ?>
    <div class="right_col" role="main" style="min-height: 1154px;">
      <div class="">
        <div class="">
          
          <h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-lock"></i> Change Password </h4>
          
        </div>
        
        
        
        <br><br>
        <div id="messages" class="pv_mess"> <!----- message tab div  --->
        
        
        
        <div class=" container-fluid" style="width:100%">
          
          <div class="card">
            <h5 class="card-header"> Kindly enter a secure password </h5>
            <div class="card-body p-0">
              <form onSubmit="change_password(event)">
                <div class="form-group">
                  <label for="inputText1" class="col-form-label">Current Password</label>
                  <input autocomplete="off" id="password" required type="password" class="form-control">
                </div>
                <div class="form-group">
                  <label for="inputText2"  class="col-form-label">New Password</label>
                  <input type="password" autocomplete="off" id="password1" required  class="form-control" placeholder="">
                </div>
                <div class="form-group">
                  <label for="inputText2"  class="col-form-label">Retype New Password</label>
                  <input type="password" autocomplete="off" id="password2" required  class="form-control" placeholder="">
                </div>
                
                
                <div id="errmsg" style="color:#F00; text-align:center"></div>
                <div class="form-group text-right" id="sbutton">
                  <button  class="btn btn-success"> Change Password</button>
                </div>
              </form>
            </div>
          </div>
          
        </div>
        
        
        <br><br>
        
        
        </div> <!----- end of message div  --->
        
        
        
      </div>
      <br><br>
      
      
      
      
      <script src="../assets2/js/main-js.js"></script>
      <script src="../assets2/js/select2.min.js"></script>
      
      <script>
      $(document).ready(function(){
      $("form").trigger('reset');
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