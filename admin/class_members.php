<?php
session_start();
//
if(!isset($_SESSION['adminb'])) die(header("Location: ../login.php"));
$idc = $_SESSION['admina'];
require '../connect/config.php';
$pdo =  new mypdo();
if(isset($_REQUEST['p'])) $min = $_REQUEST['p']; else $min = 0;
$min2 = $min * 50;
if(!isset($_REQUEST['id'])) die(header('Location: ./dashboard.php'));
$rowz = $pdo->get_reservation($min2, $_REQUEST['id']);
?>
<!DOCTYPE html>
<html class=" " lang="en">
	<head>
		<title>Jumping Fitness Malaysia | Class Members</title>
		<link href="../assets2/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
		<link href="../assets2/datepicker/bootstrap-datepicker.css" rel="stylesheet">
		<?php include("../template/header.php"); ?>
		<div class="right_col" role="main" style="min-height: 1154px;">
			<div class="">
				<div class="">
					
					<h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-"></i> <?php echo @$rowz[0]['cname']; ?> - Class Members <br><br>
					<div style="font-size:16px; margin-bottom:10px">Start Date:  <span  class="text-primary small"><?php echo @$rowz[0]['begin_date']; ?></span></div>
					<div style="font-size:16px">Start Time:  <span class="text-primary small"><?php echo @$rowz[0]['begin_time']; ?></span></div>
					
					</h4>
					
				</div>
				
				
				<div id="messages" class="pv_mess"> <!----- message tab div  --->
				
				
				
				<div class=" container-fluid" style="width:100%; padding:2px;">
					
					
					
					<div style="text-align:right"><a class="btn btn-primary fa fa-mail-reply" href="class.php"> Back to List View</a></div>
				<div class="">
					
					<div class="col-xs-12" style="margin-top:30px; box-shadow: 2px 4px 6px #999; padding-bottom:30px;">
						<div class="table-responsive">
							<table cellpadding="5" class="table  table-striped table-bordered table-hover" style="background-color:#FFF">
								<thead class="bg-light">
									<tr class="border-0">
										<th class="border-0">S/N</th>
										<th class="border-0">Photo</th>
										<th class="border-0">Student Name</th>
										<th class="border-0">Email</th>
										<th  class="border-0">Phone</th>
									</tr>
								</thead>
								<tbody>
									
									<?php
																	
								$iz = 0;
							for($iz; $iz < count($rowz); $iz++){  
								$row = $rowz[$iz];
								if($row['id']==null)
									continue;
								
																	
									?>
									<tr id="row_<?php echo $row['id']; ?>" style="background-color:<?php echo ($iz % 2 == 0)? '' : '#FDFFF4'; ?>">
										<td style="size:24px; background-color:#DBDBB7; font-weight:bolder" class="td_input" id="td_<?php echo $row['id']; ?>"><?php echo( $iz + 1); ?><br><input type="checkbox" data-id="<?php echo $row['id']; ?>" <?php echo ($row['attendance'] == 1)? 'checked' : ''; ?> ><br><span><?php echo ($row['attendance'] == 1)? '<strong style="color:#0C0">Yes</strong>' : '<strong style="color:#C00">No</strong>'; ?></span></td>
										<td><img src="../assets/profile/<?php echo $row['photo']; ?>.jpg" style="width:100px; height:100px;" class="img-thumbnail"/></td>
										<td><?php echo $row['fname']; ?></td>
										<td><?php echo $row['email']; ?></td>
										<td><?php echo $row['phone']; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div id="errmsg" style="color:#F00; padding:2px"></div>
						<div id="sbutton"><button onClick="update_attendance()" class="btn btn-success">Update Attendance</button></div>
						
						
						<div class=" container-fluid text-center">
							<?php if($min != 0){ ?>
							<div class="col-xs-6 text-left">
								<form method="get"> <button href="" class="btn btn-primary"> Previous</button>
									<input type="hidden" value="<?php echo $_REQUEST['id']; ?>" name="id"><input  type="hidden" value="" name="order"><input  type="hidden" value="<?php echo ($min - 1); ?>" name="p">
								</form>
							</div>
							<?php }
									
							if($iz > 50){ ?>
							
							<div class="col-xs-6 text-right">
								<form method="get">
									<button class="btn btn-primary"> Next</button>
									<input type="hidden" value="<?php echo $_REQUEST['id']; ?>" name="id"><input  type="hidden" value="" name="order"><input  type="hidden" value="<?php echo ($min + 1); ?>" name="p">
								</form>
							</div>
							<?php } ?>
						</div>
					</div>
					
					
					
				</div>
				
				
				<br><br>
				
				
				</div> <!----- end of message div  --->
				
				
				
			</div>
			<br><br>
			
			
			
			
			
			<script> var glob_cid2 = <?php echo $_REQUEST['id']; ?>; </script>
			<script src="../assets2/js/admin-js.js"></script>
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
			public function get_reservation($lmt, $class){
					try{
					$qry = "SELECT a.id, a.attendance, b.cname, b.begin_date, b.begin_time, b.time, a.amount, c.fname, c.email, c.phone, c.photo FROM reservation a RIGHT JOIN class b ON a.class_id = b.id LEFT join profile c ON a.member_id = c.id WHERE b.id = ? ORDER BY id DESC LIMIT ?, 50";
					$stmt = $this->pdc->prepare($qry);
					$stmt->bindParam(1, $class, PDO::PARAM_INT);
					$stmt->bindParam(2, $lmt, PDO::PARAM_INT);
					$stmt->execute();
					if($stmt->rowCount() > 0) return $stmt->fetchAll(); else return [];
					
				}
				
				catch(Exception $e){ print_r($e);
					return [];
					}
			
				}
			}