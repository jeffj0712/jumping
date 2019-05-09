<?php
session_start();
//
if(!isset($_SESSION['admina'])) die(header("Location: ../login.php"));
require '../connect/config.php';
$pdo =  new mypdo();
//if(!isset($_REQUEST['refid'])) die(header("Location: ../add_hostname.php"));
//$row = $pdo->get_hostname($_REQUEST['refid']);
?>
<!DOCTYPE html>
<html class=" " lang="en">
  <head>
    <title>Jumping Fitness Malaysia | Add Class</title>
    <link href="../assets2/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="../assets2/datepicker/bootstrap-datepicker.css" rel="stylesheet">
    <?php include("../template/header.php"); ?>
    <div class="right_col" role="main" style="min-height: 1154px;">
      <div class="">
        <div class="">
          
          <h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-book"></i> Add Class </h4>
          
        </div>
        
        
        
        <br><br>
        <div id="messages" class="pv_mess"> <!----- message tab div  --->
        
        
        
        <div class=" container-fluid" style="width:100%">
          
          
          
          
          <form onSubmit="add_class(event)">
            
            <div class=" col-xs-12 col-sm-6">
              <div class="form-group">
                <label>Class Name :</label>
                <input class="form-control" type="text" value="" required id="cname">
              </div>
            </div>
            
            <div class=" col-xs-12 col-sm-6">
              <div class="form-group">
                <label>Start Date :</label>
                <div class=" input-group">
                  <input readonly class="form-control" type="text" value="" required id="date">
                  <span class="input-group-addon"><span class="fa fa-th"></span></span>
                </div>
              </div>
            </div>
            
            <div class=" col-xs-12 col-sm-6">
              <div class=" form-group">
                <label>Time Begin :</label>
                <div class="input-group clockpicker">
                  <input readonly class="form-control" type="text" value="" required id="begin_time">
                  <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                </div></div>
              </div>
              
              <div class=" col-xs-12 col-sm-6">
                <div class="form-group">
                  <label>No. Available :</label>
                  <input class="form-control" type="number" value="" required id="limit">
                </div>
              </div>
              
              <!-- <div class=" col-xs-12 col-sm-6" hidden="">
                <div class="form-group">
                  <label>Cost :</label>
                  <input class="form-control" type="number" min="1" value="" required id="cost">
                </div>
              </div> -->
              
              <div class=" text-danger col-xs-12 text-center " id="errmsg">
              </div>
              <div class=" col-xs-12 text-center " id="sbutton">
                <div class="form-group" style="margin-top:20px">
                  <button class="btn btn-primary"> Add Class </button>
                </div>
              </div>
            </form>
            
          </div>
          
          
          <br><br>
          
          
          </div> <!----- end of message div  --->
          
          
          
        </div>
        <br><br>
        
        
        
        
        
        
        <script src="../assets2/js/class.js"></script>
        <script src="../assets2/js/select2.min.js"></script>
        <script src="../assets2/clockpicker/bootstrap-clockpicker.min.js"></script>
        <script src="../assets2/datepicker/bootstrap-datepicker.js"></script>
        <script>
        $(document).ready(function(){
        $('.clockpicker').clockpicker({
          align: 'right',
        donetext: 'Done',
          autoclose : true
          });
        });
        
        $('#date').datepicker({
        format: "yyyy-mm-dd",
        startDate: "1d",
          startView: 0 ,
        autoclose: true
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
          
          public function get_hostname($id){
            
            $qry = "SELECT id, hostname, ip, location, scanner_md, screen_md, camera_md, pc_md, scanner_sn, screen_sn, camera_sn, pc_sn, cabinet_sn, b_cvl_fm, b_cvl_to, b_cr_fm, b_cr_to, b_mil_fm, b_mil_to, b_emp_fm, b_emp_to, b_qa_fm, b_qa_to FROM hostname WHERE id = ? ORDER BY id DESC";
            $stmt = $this->pdc->prepare($qry);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            }
          
        public function get_value($table){
            
            $qry = "SELECT id, value FROM $table ORDER BY id DESC";
            $stmt = $this->pdc->prepare($qry);
            $stmt->execute();
            return $stmt->fetchAll();
            }
          
          }