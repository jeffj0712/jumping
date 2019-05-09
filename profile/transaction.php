<?php
session_start();
//
if(!isset($_SESSION['userid'])) die(header("Location: ../login.php"));
$idc = $_SESSION['userid'];
require '../connect/config.php';
$pdo =  new mypdo();
if(isset($_REQUEST['p'])) $min = $_REQUEST['p']; else $min = 0;
$min2 = $min * 20;
?>
<!DOCTYPE html>
<html class=" " lang="en">
	<head>
		<title>Jumping Fitness Malaysia | Transaction</title>
		<link href="../assets2/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
		<link href="../assets2/datepicker/bootstrap-datepicker.css" rel="stylesheet">
		<?php include("../template/header2.php"); ?>
		<div class="right_col" role="main" style="min-height: 1154px;">
			<div class="">
				<div class="">
					<h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-"></i> Transactions </h4>
				</div>
				<div id="messages" class="pv_mess"> <!----- message tab div  --->
				<div class=" container-fluid" style="width:100%; padding:2px;">
					<div class="col-xs-12" style="margin-top:30px; box-shadow: 2px 4px 6px #999; padding-bottom:30px;">
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
																	$rowz = $pdo->get_transaction($idc, $min2);
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
				
				public function get_user($id){
					try{
					$qry = "SELECT id, fname, email, balance, phone, photo, reg FROM profile WHERE id = ?";
					$stmt = $this->pdc->prepare($qry);
					$stmt->bindParam(1, $id, PDO::PARAM_INT);
					$stmt->execute();
					if($stmt->rowCount() > 0) return $stmt->fetch(); else return null;
					
				}
				
				catch(Exception $e){
					return null;
					}
			
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
			public function get_reservation($uid){
					try{
					$qry = "SELECT a.id, b.cname, b.begin_date, b.begin_time, b.time, a.amount FROM reservation a INNER JOIN class b ON a.class_id = b.id WHERE a.member_id = ?  ORDER BY id DESC LIMIT 5";
					$stmt = $this->pdc->prepare($qry);
					$stmt->bindParam(1, $uid, PDO::PARAM_INT);
					$stmt->execute();
					if($stmt->rowCount() > 0) return $stmt->fetchAll(); else return [];
					
				}
				
				catch(Exception $e){
					return [];
					}
			
				}
			}