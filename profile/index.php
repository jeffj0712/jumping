<?php
session_start();
//
if (!isset($_SESSION['userid'])) {
die(header("Location: ../login.php"));
}
require '../connect/config.php';
$idc = $_SESSION['userid'];
$pdo = new mypdo();
$row = $pdo->get_user(trim($idc));
$_SESSION['user_name'] = $row['fname'];
if (isset($_POST['usid'])) {
$usid = substr($_POST['usid'], 10);
$month = (int) $_POST['month_n'] + 1; //jascrip month is 0 - 11
$year = (int) $_POST['year_n'];
if ($month == 13) {
$month = 1;
$year = $year + 1;
}
if ($month == 0) {
$month = 12;
$year = $year - 1;
}
$month_jv = $month - 1; //javascrip month
$time_stamp_start = mktime(0, 0, 0, $month, 1, $year);
$lastday = (int) date('t', $time_stamp_start);
$time_stamp_end = mktime(23, 59, 59, $month, $lastday, $year);
$pdo = new mypdo;
$event_m = $pdo->get_events($usid, $time_stamp_start, $time_stamp_end, time());
$dataz = [$year, $month_jv, $event_m];
die(json_encode($dataz));
} else {
$time_now = time();
$st_month = (int) date("m", $time_now) - 1; //jascrip month is 0 - 11
$st_year = (int) date("Y", $time_now);
?>
<!DOCTYPE html>
<html class=" " lang="en">
  <head>
    <title>Jumping Fitness Malaysia | Class Reservation</title>
    <link href="../assets2/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="../assets2/datepicker/bootstrap-datepicker.css" rel="stylesheet">
    <style>
    body{ margin:0px;}
    .calender_container{ display:inline-block; width:100%;  padding: 10px; text-align:left}
    @media (max-width: 760px) {
    .calender_container{width:760px; min-width:760px;}
    }
    .eknero_calender{ width:100%}
    .eknero_calender .title_hd{text-align:center; font-weight:bold; margin-bottom:30px;}
    .eknero_calender .title_hd a{ font-size:24px; font-weight:bolder; cursor:pointer}
    .eknero_calender .title_hd .a_next{ margin-left:40px}
    .eknero_calender .title_hd .a_prev{ margin-right:40px}
    .calender_hd{ font-weight:bold}
    .calender_hd > div{ display:inline-block; width: 14%;  text-align:center}
    .calender_bd{}
    .calender_bd > div{position:relative; display:inline-block; width: 14%; margin: 2px 1px 2px 1px; padding:5px 2px 5px 2px;  text-align:left;  border-radius:3px; background-color:#CCC; height:100px; overflow-y:auto}
    .number_day{position:absolute; right:2px; top:0px; font-weight:bold}
    .div_show{ font-size:9px; font-weight:bold; color:#050; border-bottom:thin #009 solid; padding:1px; margin-bottom:2px;}
    @media (max-width: 760px) {
    .calender_bd > div, .calender_hd > div{ width:12%;}
    }
    .eventday{width:100%; text-align:center; position:relative}
    .eventday .day_heading{ padding:10px; color:#036; font-weight:bolder; text-align:center}
    .eventday .color_1, .eventday .color_2, .eventday .color_3{text-align:left; padding-bottom:10px; padding-top:10px; border-bottom:thin #666 solid}
    .eventday .color_1{ color:#090}
    .eventday .color_2{ color: #FC0}
    .eventday .color_3{ color:#F00}
    .eventday .color_1 > span, .eventday .color_2 > span, .eventday .color_3 > span{ display:inline-block; width:80px; vertical-align:middle}
    .eventday .color_1 > div, .eventday .color_2 > div, .eventday .color_3 > div{ display:inline-block; width:calc(100% - 80px); vertical-align:middle}
    @media (max-width: 500px) {
    .calender_container{ width:100%;}
    }
    .pop_up_magc{width:auto; max-width:900px; width:900px; display:inline-block; background-color:#EFEFEF; padding:20px; border-radius:5px; color: #222;}
    @media (max-width: 900px) {
    .pop_up_magc{width:100%; padding:10px;}
    }
    .close_magc{position:absolute; right: 15px; top: 12px; font-size:20px; cursor:pointer; text-decoration:none; color:#FFF;  z-index:200}
    </style>
    <?php include "../template/header2.php";?>
    <div class="right_col" role="main" style="min-height: 1154px;">
      <div class="">
        <div id="messages" class="pv_mess">
          <div class=" container-fluid" style="width:100%; padding:2px;">
            <div class="col-xs-12" style=" padding-bottom:20px; box-shadow: 2px 4px 6px #999; border-bottom:3px #8daf6d solid">
              <div class=" col-xs-12 col-sm-6">
                <h3><?php echo $row['fname']; ?></h3>
                <div>Classes Left :  <span id="balance"><?php echo $row['balance']; ?></span></div>
                <?php
                $daten = new DateTime();
                $date2 = DateTime::createFromFormat("Y-m-d H:i:s", $row['cr_exp']);
                if ($date2 > $daten) {
                $cr_msg = "Expire date";
                $cr_color = "#090a08";} else {
                $cr_msg = "Expired at";
                $cr_color = "#F00";}
                ?>
                <div id="cr_status" style="color: <?php echo $cr_color; ?>; font-size:12px; font-family:'Times New Roman', Times, serif; padding:2px;"><?php if ($row['balance'] != 0) {echo $cr_msg;?> :  &nbsp; &nbsp; <?php echo $date2->format("Y-m-d"); ;} ?></div>
              </div>
              <div class=" col-xs-12 col-sm-6">
                <img src="../assets/profile/<?php echo $row['photo']; ?>.jpg" width="150px">
              </div>
            </div>
            <div class="col-xs-12" style="margin-top:30px; box-shadow: 2px 4px 6px #999; padding-bottom:30px;">
              <div style="width:100%; overflow-x:auto; border-bottom:3px #8daf6d solid">
                <div class="calender_container">
                </div>
              </div>
            </div>
            <br><br>
            <script>
            var st_month =  <?php echo "" . $st_month; ?>;
            var st_year =  <?php echo "" . $st_year; ?>;
            var sid_ek =  <?php echo '9'; ?>;
            </script>
            <script src="../assets2/js/main-js.js"></script>
            <script src="../assets2/js/select2.min.js"></script>
            <script src="../assets2/clockpicker/bootstrap-clockpicker.min.js"></script>
            <script src="../assets2/datepicker/bootstrap-datepicker.js"></script>
            <script src="../assets2/js/eknero_calender2.js"></script>
            <script>
            $(document).ready(function(){
            get_calender_datas(st_month, st_year)
            });
            </script>
            <?php include_once "../template/footer.php";
            }
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
            public function get_class() {
            $qry = "SELECT id, cname, begin_date, begin_time, time, nlimit, cost FROM class ORDER BY id DESC LIMIT 100";
            $stmt = $this->pdc->prepare($qry);
            //$stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
            }
            public function get_events($uid, $time_st, $time_end, $curtime) {
            $qry = "SELECT id, cname, begin_date, begin_time, time, nlimit, cur_limit, cost, (time > ?) AS ctime  FROM class WHERE (time >= ? AND time <= ?) ORDER BY time DESC";
            $stmt = $this->pdc->prepare($qry);
            $stmt->bindParam(1, $curtime, PDO::PARAM_INT);
            $stmt->bindParam(2, $time_st, PDO::PARAM_INT);
            $stmt->bindParam(3, $time_end, PDO::PARAM_INT);
            $stmt->execute();
            $event_r = [];
            while ($row = $stmt->fetch()) {
            $event_r[] = $row;
            }
            return $event_r;
            }
            }