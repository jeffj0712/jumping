<?php
session_start();
//
if(!isset($_SESSION['admina'])) die(header("Location: ../login.php"));
require '../connect/config.php';
$pdo =  new mypdo();
if(isset($_REQUEST['p'])) $min = $_REQUEST['p']; else $min = 0;
$min2 = $min * 20;
?>
<!DOCTYPE html>
<html class=" " lang="en">
  <head>
    <title>Jumping Fitness Malaysia | Add Credit</title>
    <link href="../assets2/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="../assets2/datepicker/bootstrap-datepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets2/datepicker/bootstrap-datetimepicker.min.css">
    <?php include("../template/header.php"); ?>
    <div class="right_col" role="main" style="min-height: 1154px;">
      <div class="">
        <div class="">
          
          <h4 style=" margin-bottom:10px;color:#21991E; font-weight:bold;"><i class=" fa"></i> Student Details </h4>
          
        </div>
        
        
        <div id="messages" class="pv_mess"> <!----- message tab div  --->
        
        
        
        <div class=" container-fluid" style="width:100%">
          
          <form method="post">
            
              <div class="col-xs-12 text-center" style="box-shadow: 2px 4px 6px #999; padding-bottom:30px;">
              <div class="form-group">
                <h2>Student Email Address:</h2>
                <div class=" input-group">
                  <input  class="form-control" type="email"  value="" required name="email">
                  <span class="input-group-addon" style="padding:0px"><button class="btn btn-primary">Load Details</button></span>
                </div></div>
              </div>
              
            </form>
            <div class="col-xs-12" style="margin-top:30px; box-shadow: 2px 4px 6px #999; padding-bottom:30px;">
              <?php $rown = 0;
              if(isset($_POST['email'])){
              $rown = 1;
              $row = $pdo->get_user(trim($_POST['email']));
              }
              if($rown == 0) echo '';
              elseif($row == null) echo '<span style="font-size:22px;">NO RECORD FOR THIS EMAIL ADDRESS</span>'; else{ ?>
              <div class="">
                <h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-"></i>Detail </h4>
              </div>
              <div class=" col-xs-12 col-sm-6">
                <h2><?php echo $row['fname']; ?><br><small> ( <?php echo $row['email']; ?> | <?php echo $row['phone']; ?> )</small> </h2>
                <div>Current Classes Left :  <span id="balance"><?php echo $row['balance']; ?></span></div>
                <?php
                $daten = new DateTime();
                $date2 = DateTime::createFromFormat("Y-m-d H:i:s", $row['cr_exp']);
                if($date2 > $daten){ $cr_msg = "Expires Date"; $cr_color = "#03F";}
                else{ $cr_msg = "Expired"; $cr_color = "#F00"; }
                ?>
                <div id="cr_status" style="color: <?php echo $cr_color; ?>; font-size:12px; font-family:'Times New Roman', Times, serif; background-color:#FFF; padding:2px;"><?php if($row['balance'] != 0){ echo $cr_msg; ?> :  &nbsp; &nbsp; <?php echo $date2->format("Y-m-d"); }?></div>
                
                
                
                <div style="margin-top:30px; border-bottom:#999 4px solid; padding:7px; font-weight:bold">Top Up Classes</div>
                <form onSubmit="add_credit(event, <?php echo $row['id']; ?>)">
                  <div class="form-group" style="width:200px">
                    <div class=" input-group">
                      <span class="input-group-addon" style="padding:3px">Amount</span>
                      <input  class="form-control" type="number"  value="" required id="amount">
                    </div></div>
                    
                    <div class="form-group" style="width:200px">
                      <label>Credit Expire Date:</label>
                      <!-- <div class=" input-group date" id="datetimepicker">
                        <input class="form-control" readonly type="text" id="cr_exp" required value="<?php echo $row['cr_exp']; ?>">
                        <span class="input-group-addon" style="padding:3px"><i class="fa fa-th"></i></span>
                      </div>  -->
                      <div class=" input-group">
                        <input class="form-control" readonly type="text" id="cr_exp" required value="<?php echo $date2->format("Y-m-d"); ?>">
                        <span class="input-group-addon"><span class="fa fa-th"></span></span>
                      </div>
                    </div>
                    <div class="form-group" style="width:200px">
                      <label>Note:</label>
                      <textarea class="form-control"  id="note" required minlength="5"></textarea>
                    </div>
                    
                    <div id="errmsg" class="text-danger" style="margin-top:30px"></div>
                    
                    <div id="sbutton" style="float:right"><button  class="btn btn-primary">Top Up</button></div>
                  </form>
                </div>
                <div class=" col-xs-12 col-sm-6">
                  <img src="../assets/profile/<?php echo $row['photo']; ?>.jpg" width="150px">
                </div>
              </div>
              <div class=" container-fluid" style="width:100%; padding:2px;">
                <div class="col-xs-12" style="margin-top:30px; box-shadow: 2px 4px 6px #999; padding-bottom:30px;">
                  <div class="">
                    <h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-"></i>Recent Transactions </h4>
                  </div>
                  <div class="table-responsive">
                    <table cellpadding="5" class="table  table-striped table-bordered table-hover" style="background-color:#FFF">
                      <thead class="bg-light">
                        <tr class="border-0">
                          <th class="border-0">S/N</th>
                          <th class="border-0">Date</th>
                          <th class="border-0">Amount</th>
                          <!-- <th  class="border-0">Status</th> -->
                          <th  class="border-0">Note</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                        <?php
                        $rowz = $pdo->get_transaction($row['id'], $min2);
                        $iz = 0;
                        for($iz; $iz < count($rowz); $iz++){  $row = $rowz[$iz];?>
                        <tr id="row_<?php echo $row['id']; ?>" style="background-color:<?php echo ($iz % 2 == 0)? '' : '#FDFFF4'; ?>">
                          <td><?php echo ($iz + 1) ?></td>
                          <td><?php echo date("Y-m-d h:i a", $row['date']); ?></td>
                          <td><?php echo $row['amount']; ?></td>
                          <!-- <td><span style="color:<?php echo ($row['status']== 0)? '#C00' : '#0C0'; ?>" class="fa fa-2x fa-circle"></span></td> -->
                          <td><?php echo $row['note']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <div class=" container-fluid text-center">
                    <?php if($min != 0){ ?>
                    <div class="col-xs-6 text-left">
                      <form method="get"> <button href="" class="btn btn-primary"> Previous</button>
                        <input type="hidden" value="" name="sort"><input  type="hidden" value="" name="order"><input  type="hidden" value="<?php echo ($min - 1); ?>" name="p">
                      </form>
                    </div>
                    <?php }
                    
                    if($iz > 20){ ?>
                    
                    <div class="col-xs-6 text-right">
                      <form method="get">
                        <button class="btn btn-primary"> Next</button>
                        <input type="hidden" value="" name="sort"><input  type="hidden" value="" name="order"><input  type="hidden" value="<?php echo ($min + 1); ?>" name="p">
                      </form>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <br><br>
          </div>
          
          <br><br>
          
          
          </div> <!----- end of message div  --->
          
          
          
        </div>
        <br><br>
        
        
        
        
        
        
        <script src="../assets2/js/admin-js.js"></script>
        <script src="../assets2/js/select2.min.js"></script>
        <script src="../assets2/clockpicker/bootstrap-clockpicker.min.js"></script>
        <script src="../assets2/datepicker/bootstrap-datepicker.js"></script>
        <script src="../assets2/datepicker/bootstrap-datetimepicker.min.js"></script>
        <!-- <script>
        $(document).ready(function(){
        'use strict';
        if ($("#datetimepicker input").length) {
        $('#datetimepicker input').datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        //daysOfWeekDisabled: '07',
        startDate: "+d",
        //startDate: "2018-12-24",
        //endDate :  "+7d",
        //showMeridian: true,
        //title:      "Select Transaction Date",
        //pickerPosition: "top-right",
        autoclose: true
        });
        }
        });
        
        </script> -->
        <script>
        $(document).ready(function(){
        $('.clockpicker').clockpicker({
        align: 'right',
        donetext: 'Done',
        autoclose : true
        });
        });
        
        $('#cr_exp').datepicker({
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
        
        public function get_transaction($uid, $lmt){
        try{
        $qry = "SELECT id, amount, date, status, note FROM transaction WHERE uid = ? ORDER BY ID DESC LIMIT ?,  20";
        $stmt = $this->pdc->prepare($qry);
        $stmt->bindParam(1, $uid, PDO::PARAM_INT);
        $stmt->bindParam(2, $lmt, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0) return $stmt->fetchAll(); else return [];
        
        }
        
        catch(Exception $e){
        return [];
        }
        
        }
        public function get_user($email){
        try{
        $qry = "SELECT id, fname, email, balance, phone, photo, cr_exp, reg FROM profile WHERE email = ?";
        $stmt = $this->pdc->prepare($qry);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0) return $stmt->fetch(); else return null;
        
        }
        
        catch(Exception $e){
        return null;
        }
        
        }
        
        }