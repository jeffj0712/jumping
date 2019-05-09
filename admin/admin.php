<?php 
session_start();
   //
      if(!isset($_SESSION['admina'])) die(header("Location: ../login.php"));


if($_SESSION['adminb'] == '9') $kzn =  1; else die(header("Location: ./recent_machines.php")); 

require '../connect/config.php';
$pdo =  new mypdo();

 ?> 

<!DOCTYPE html>
<html class=" " lang="en">
<head>

<title>Manage Admin Users</title>


<?php include("../template/header.php"); ?>

   <div class="right_col" role="main" style="min-height: 1154px;">
    <div class="">
        <div class="">
            
            	<h4 style="size:40px; color:#21991E; font-weight:bold"><i class=" fa fa-users"></i> Manage Admin Users </h4>
         
        </div>
        
    
        
    <br><br>
          <div id="messages" class="pv_mess"> <!----- message tab div  --->
          
          
          
                <div class=" container-fluid" style="width:100%">
            
          <div class="card">
                                    <h5 class="card-header">Manage Admin Users <a style="float:right;" href="add-user.php" class="btn btn-success">Add New Admin </a></h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Email Address</th>
                                                        <th class="border-0">Password</th>

                                                        <th style="float:right;" class="border-0">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                
                                 <?php
								 $pdo = new mypdo();               
                                  $rowz = $pdo->get_admin();
								  $iz = 0;
								  for($iz; $iz < count($rowz); $iz++){  $row = $rowz[$iz];?>
								                   <tr id="row_<?php echo $row['id']; ?>">
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td>**********</td>

                                                        <td>
                                                        <?php if($_SESSION['adminb'] != $row['level']){?>
                                                          <button onClick="delete_admin(<?php echo $row['id']; ?>)" style="float:right;" class="btn btn-danger">Delete</button>
                                                          <?php } ?>
                                                                </td>
                                                    </tr>
                                        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
             
                      </div> 
             
             
              <br><br>
           
          
           </div> <!----- end of message div  --->
    
    
    
       </div>
          <br><br>
          
          
          
          
          
          
          
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
		  $qry = "SELECT id, email, level FROM admin ORDER BY id DESC";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->execute();
		  return $stmt->fetchAll();
	 }
	 
	 catch(Exception $e){
		 return [];
		 }
     
	 }

	 
	 }
 		

