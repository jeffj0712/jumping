<?php
session_start();
//
if (!isset($_SESSION['userid'])) {
  die(header("Location: ../login.php"));
}
$idc = $_SESSION['userid'];
require '../connect/config.php';
$pdo = new mypdo();
?>
<!DOCTYPE html>
<html class=" " lang="en">
  <head>
    <title>Jumping Fitness Malaysia | Class Reservation</title>
    <link href="../assets2/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="../assets2/datepicker/bootstrap-datepicker.css" rel="stylesheet">
    <?php include "../template/header2.php";?>
    <div class="right_col" role="main" style="min-height: 1154px;">
      <div class="">
        <div class="">
          <h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-bicycl"></i> All Classes  ( <span class=" fa fa-th"> <a href="class_calender.php">View In Calendar </a></span> )</h4>
        </div>
        <br><br>
        <div id="messages" class="pv_mess"> <!----- message tab div  --->
        <div class=" container-fluid" style="width:100%; padding:0px">
          <div class="table-responsive">
            <table cellpadding="5" class="table table-bordered  table-striped table-hover" style="background-color:#FFF">
              <thead class="bg-light">
                <tr class="border-0">
                  <th class="border-0">Class Name</th>
                  <th  class="border-0">Start Date</th>
                  <th  class="border-0">Time</th>
                  <th  class="border-0">Available</th>
                  <!-- <th  class="border-0">Cost  </th> -->
                  <th  class="border-0">Status  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $pdo = new mypdo();
                $rowz = $pdo->get_class($idc);
                $iz = 0;
                for ($iz; $iz < count($rowz); $iz++) {
                  $row = $rowz[$iz];
                  $date3 = DateTime::createFromFormat("Y-m-d H:i", $row['begin_date'] . " " . $row['begin_time']);
                  $daten3 = new DateTime();
                  if ($date3 < $daten3) {
                    $re_state = 0;
                  } else {
                    $re_state = 1;
                  }
                ?>
                <tr id="row_<?php echo $row['id']; ?>" style="background-color:<?php echo ($iz % 2 == 0) ? '' : '#FDFFF4'; ?>">
                  <td><?php echo $row['cname']; ?></td>
                  <td><?php echo $row['begin_date']; ?></td>
                  <td><?php echo $row['begin_time']; ?></td>
                  <!-- <td><?php echo $row['cost']; ?></td> -->
                  <?php if ($re_state == 1)
                  {
                  if ($row['cur_limit'] < $row['nlimit'])
                  {?> <td><span class="text-primary">Available</span></td>
                  <td><button onClick="reserve_class(<?php echo $row['id']; ?>)" " class="btn btn-success">Reserve</button></td> <?php }
                  else
                  {
                  ?>
                  <td><span class="text-warning">No vacancy</span></td>
                  <td></td>
                  <?php
                  }
                  }
                  else
                  {
                  ?>
                  <td><span class="text-warning">Finished</span></td>
                  <td></td>
                  <?php
                  }
                  ?>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <br><br>
        </div> <!----- end of message div  --->
      </div>
      <br><br>
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
        public function get_class($id) {
          $qry = "SELECT b.id,a.member_id, b.cname, b.begin_date, b.begin_time, b.time, a.amount,b.cur_limit,b.nlimit FROM (SELECT * FROM reservation WHERE member_id = ?) a RIGHT JOIN class b ON a.class_id = b.id WHERE a.member_id is null ORDER By b.begin_date DESC LIMIT 100
      ";
          $stmt = $this->pdc->prepare($qry);
          $stmt->bindParam(1, $id, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetchAll();
        }
        public function get_value($table) {
          $qry = "SELECT id, value FROM $table ORDER BY id DESC";
          $stmt = $this->pdc->prepare($qry);
          $stmt->execute();
          return $stmt->fetchAll();
        }
      }