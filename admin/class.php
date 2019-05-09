<?php 
session_start();
   //
      if(!isset($_SESSION['admina'])) die(header("Location: ../login.php"));

require '../connect/config.php';
$pdo =  new mypdo();


 ?> 

<!DOCTYPE html>
<html class=" " lang="en">
<head>

<title>Jumping Fitness Malaysia | Classes</title>
<link href="../assets2/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
<link href="../assets2/datepicker/bootstrap-datepicker.css" rel="stylesheet">


<?php include("../template/header.php"); ?>

   <div class="right_col" role="main" style="min-height: 1154px;">
    <div class="">
        <div class="">
            
            	<h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-bicycl"></i>All Classes  ( <span class=" fa fa-th"><a href="class_calender.php">View In Calendar </a></span> )</h4>
         
        </div>
        
    
        
    <br><br>
          <div id="messages" class="pv_mess"> <!----- message tab div  --->
          
          
          
                <div class=" container-fluid" style="width:100%; padding:0px">
            
            <div style="text-align:right"><a class="btn btn-primary fa fa-plus" href="add-class.php"> New Class</a></div>
            <div class="table-responsive">
                                            <table class="table  table-striped table-hover" style="background-color:#FFF">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        
                                                        <th class="border-0">Class Name</th>
                                                        <th class="border-0">Members</th>
                                                        <th  class="border-0">Start Date</th>
                                                        <th  class="border-0">Time</th>
                                                        <th  class="border-0">Limit</th>
                                                        <!-- <th  class="border-0">Cost </th> -->
                                                        <th class="border-0"> Action </th>
      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                
                                 <?php
								 $pdo = new mypdo();               
                                  $rowz = $pdo->get_class();
								  $iz = 0;
								  for($iz; $iz < count($rowz); $iz++){  $row = $rowz[$iz];?>
								                   <tr id="row_<?php echo $row['id']; ?>" style="background-color:<?php echo ($iz % 2 == 0)? '' : '#FDFFF4'; ?>">
                                                        
                                                        <td><?php echo $row['cname']; ?></td>
                                                        <td><?php echo $row['cur_limit']; ?> (<a href="./class_members.php?id=<?php echo $row['id']; ?>&ng=">View Members</a>)</td>
                                                        <td><?php echo $row['begin_date']; ?></td>
                                                        <td><?php echo $row['begin_time']; ?></td>
                                                        <td><?php echo $row['nlimit']; ?></td>
                                                        <!-- <td><?php echo $row['cost']; ?></td> -->

                                                        <td>
                                                          <a margin-right:5px;" href="edit-class.php?pid=<?php echo $row['id']; ?>&ref=" class="btn btn-warning">Edit</a>
                                                          <button onClick="delete_class(<?php echo $row['id']; ?>)"  class="btn btn-danger">Delete</button>
                                                        </td>
                                                    </tr>
                                        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
             
             
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
	 
	 public function get_class(){
		 
		 $qry = "SELECT id, cname, begin_date, begin_time, time, nlimit, cur_limit, cost FROM class ORDER BY begin_date DESC LIMIT 100";
		 $stmt = $this->pdc->prepare($qry);
		 //$stmt->bindParam(1, $id, PDO::PARAM_INT);
		 $stmt->execute();
		 return $stmt->fetchAll();
		 }
	 
    public function get_value($table){
		 
		  $qry = "SELECT id, value FROM $table ORDER BY id DESC";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->execute();
		 return $stmt->fetchAll();
		 }

	 
	 }
 		

