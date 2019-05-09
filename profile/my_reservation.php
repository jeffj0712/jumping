<?php
session_start();
//
if (!isset($_SESSION['userid'])) {
die(header("Location: ../login.php"));
}
$idc = $_SESSION['userid'];
require '../connect/config.php';
$pdo = new mypdo();
//if(!isset($_REQUEST['refid'])) die(header("Location: ../add_hostname.php"));
$row = $pdo->get_user(trim($idc));
$_SESSION['user_name'] = $row['fname'];
?>
<!DOCTYPE html>
<html class=" " lang="en">
  <head>
    <title>Jumping Fitness Malaysia | Dashboard</title>
    <link href="../assets2/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="../assets2/datepicker/bootstrap-datepicker.css" rel="stylesheet">
    <?php include "../template/header2.php";?>
    <div class="right_col" role="main" style="min-height: 1154px;">
      <div class="">
        <div class="">
          <h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-dashboard"></i> My Records </h4>
        </div>
        <div class="col-xs-12" style="margin-top:30px; box-shadow: 2px 4px 6px #999; padding-bottom:30px;">
          <h3>Recent Reservation</h3>
          <div class="table-responsive">
            <table cellpadding="5" class="table  table-striped table-bordered table-hover" style="background-color:#FFF">
              <thead class="bg-light">
                <tr class="border-0">
                  <th class="border-0">S/N</th>
                  <th class="border-0">Class Name</th>
                  <th class="border-0">Start Date</th>
                  <th class="border-0">Time</th>
                  <!-- <th class="border-0">Cost</th> -->
                  <th class="border-0">Attendance</th>
                  <th  class="border-0"> Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $rowz = $pdo->get_reservation($idc);
                $iz = 0;
                for ($iz; $iz < count($rowz); $iz++) {
                $row = $rowz[$iz];
                $timdf = 2;
                $week = date('N', time());
                if ($week == 7 || $week == 6 || $week == 5) {
                $timdf = 12;
                }
                if (($row['time'] - time()) < $timdf * 60 * 60) {
                $rstatus = 0;
                } else {
                $rstatus = 1;
                }
                ?>
                <tr id="row_<?php echo $row['id']; ?>" style="background-color:<?php echo ($iz % 2 == 0) ? '' : '#FDFFF4'; ?>">
                  <td><?php echo ($iz + 1); ?></td>
                  <td><?php echo $row['cname']; ?></td>
                  <td><?php echo $row['begin_date']; ?></td>
                  <td><?php echo $row['begin_time']; ?></td>
                  <!-- <td><?php echo $row['amount']; ?></td> -->
                  <td><?php echo ($row['attendance'] == 1) ? '<span class="fa fa-check text-primary"></span> Attended' : 'Not Attended'; ?></td>
                  <td><?php if ($rstatus == 1) {?>  <button class="btn btn-warning fa fa-times" onClick="cancel_reservation(<?php echo $row['id']; ?>)"> Cancel</button> <?php }else{echo 'Finished ';}?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
          <?php if ($iz >= 5) {?> <div class="text-center"><a href="./my_reservation.php" target="_blank" class="btn btn-primary">View More</a></div> <?php }?>
        </div>
        <div class="col-xs-12" style="margin-top:30px; box-shadow: 2px 4px 6px #999; padding-bottom:30px;">
          <h3>Cancelled Reservation</h3>
          <div class="table-responsive">
            <table cellpadding="5" class="table  table-striped table-bordered table-hover" style="background-color:#FFF">
              <thead class="bg-light">
                <tr class="border-0">
                  <th class="border-0">S/N</th>
                  <th class="border-0">Class Name</th>
                  <th class="border-0">Start Date</th>
                  <th class="border-0">Time</th>
                  <!-- <th class="border-0">Cost</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                $rowz = $pdo->get_reservation_log($idc);
                $iz = 0;
                for ($iz; $iz < count($rowz); $iz++) {
                $row = $rowz[$iz];
                ?>
                <tr id="row_<?php echo $row['id']; ?>" style="background-color:<?php echo ($iz % 2 == 0) ? '' : '#FDFFF4'; ?>">
                  <td><?php echo ($iz + 1); ?></td>
                  <td><?php echo $row['cname']; ?></td>
                  <td><?php echo $row['begin_date']; ?></td>
                  <td><?php echo $row['begin_time']; ?></td>
                  <!-- <td><?php echo $row['amount']; ?></td> -->
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
          <?php if ($iz >= 3) {?> <div class="text-center"><a href="./cancelled_reservation.php" target="_blank" class="btn btn-primary">View More</a></div> <?php }?>
        </div>
      </div>
      <br><br>
      </div> <!----- end of message div  --->
    </div>
    <script src="../assets2/js/main-js.js"></script>
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
    <?php include_once "../template/footer.php";
    function option_group($arr) {
    $option = '<option value="">Select an option</option>';
    for ($iz = 0; $iz < count($arr); $iz++) {
    $val = $arr[$iz]['value'];
    $option .= '<option value="' . $val . '">' . $val . '</option>';
    }
    return $option;
    }
    class mypdo {
    public $pdc = null;
    public function __construct() {
    $host = dbhost;
    $db = dbname;
    $user = dbuser;
    $pass = dbpass;
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false];
    $this->pdc = new PDO($dsn, $user, $pass, $opt);
    }
    
    public function get_user($id) {
    try {
    $qry = "SELECT id, fname, email, balance, phone, photo, cr_exp, reg FROM profile WHERE id = ?";
    $stmt = $this->pdc->prepare($qry);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
    return $stmt->fetch();
    } else {
    return null;
    }
    } catch (Exception $e) {
    return null;
    }
    }
    public function get_transaction($uid) {
    try {
    $qry = "SELECT id, amount, date, status, note FROM transaction WHERE uid = ? ORDER BY ID DESC LIMIT 5";
    $stmt = $this->pdc->prepare($qry);
    $stmt->bindParam(1, $uid, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
    return $stmt->fetchAll();
    } else {
    return [];
    }
    } catch (Exception $e) {
    return [];
    }
    }
    public function get_reservation($uid) {
    try {
    $qry = "SELECT a.id, a.attendance, b.cname, b.begin_date, b.begin_time, b.time, a.amount FROM reservation a INNER JOIN class b ON a.class_id = b.id WHERE a.member_id = ?  ORDER BY id DESC LIMIT 5";
    $stmt = $this->pdc->prepare($qry);
    $stmt->bindParam(1, $uid, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
    return $stmt->fetchAll();
    } else {
    return [];
    }
    } catch (Exception $e) {
    return [];
    }
    }
    public function get_reservation_log($uid) {
    try {
    $qry = "SELECT a.id, b.cname, b.begin_date, b.begin_time, b.time, a.amount FROM reservation_log a INNER JOIN class b ON a.class_id = b.id WHERE a.member_id = ?  ORDER BY id DESC LIMIT 4";
    $stmt = $this->pdc->prepare($qry);
    $stmt->bindParam(1, $uid, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
    return $stmt->fetchAll();
    } else {
    return [];
    }
    } catch (Exception $e) {
    return [];
    }
    }
    }