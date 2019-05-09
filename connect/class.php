<?php
session_start(); 

$dataz = json_decode(file_get_contents('php://input'), true);

require '../connect/config.php';
if(isset($_SESSION['admina'])){
	$idc = 	$_SESSION['admina'];
 }
else{
	
	$msg = array('status' => 'error', 'message' => 'auttentication error. Please login');		 
    die(json_encode($msg));
	}



///##################################################
/////      ADD CLASS
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'add_class') {
		$errMsg = '';

		$data = $dataz['data'];
		$cname = $data['cname'];
		$begin_date =  $data['begin_date'];
		$begin_time = $data['begin_time'];
		$limit = $data['limit'];
		$cost = $data['cost'];
        $dtime = DateTime::createFromFormat("Y-m-d H:i", $begin_date. ' '. $begin_time);
		$time =  $dtime->getTimestamp(); 
		if(strlen($cname) < 2)
			$errMsg = 'Enter your Class Name<br>';
		
		if($errMsg != ''){
		$err = array('status' => 'error', 'message' => $rrMsg);
		die(json_encode($err));
		}
		
		 $pdo = new mypdo();
         
		 $sreg = $pdo->add_class($cname, $begin_date, $begin_time, $time, $limit, $cost);
		 if($sreg == 'PASS'){
		 $msg = array('status' => 'success', 'message' => 'PASS');		 
		 die(json_encode($msg));
		 }
       else{
		 $msg = array('status' => 'error', 'message' => $sreg);		 
		 die(json_encode($msg));  
		   
		   }  
		 
}





///##################################################
/////      UPDATE CLASS
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'update_class') {
		$errMsg = '';

		
		$data = $dataz['data'];
		$cid = $data['id'];
		$cname = $data['cname'];
		$begin_date =  $data['begin_date'];
		$begin_time = $data['begin_time'];
		$limit = $data['limit'];
		$cost = $data['cost'];
        $dtime = DateTime::createFromFormat("Y-m-d H:i", $begin_date. ' '. $begin_time);
		$time =  $dtime->getTimestamp(); 
		if(strlen($cname) < 2)
			$errMsg = 'Enter your Class Name<br>';
		
		if($errMsg != ''){
		$err = array('status' => 'error', 'message' => $rrMsg);
		die(json_encode($err));
		}
		
		 $pdo = new mypdo();
         
		 $sreg = $pdo->update_class($cname, $begin_date, $begin_time, $time, $limit, $cost, $cid);
		 if($sreg == 'PASS'){
		 $msg = array('status' => 'success', 'message' => 'PASS');		 
		 die(json_encode($msg));
		 }
       else{
		 $msg = array('status' => 'error', 'message' => $sreg);		 
		 die(json_encode($msg));  
		   
		   }  
		 
}






///##################################################
/////    DELETE CLASS
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'delete_class') {
		$errMsg = '';

		$data = $dataz['data'];
		$pid = $data['cid'];
		
		 $pdo = new mypdo();
         
		 $sreg = $pdo->delete_class($pid);
		 if($sreg == 'PASS'){
		 $msg = array('status' => 'success', 'data' => $sreg);		 
		 die(json_encode($msg));
		 }
       else{
		 $msg = array('status' => 'error', 'message' => $sreg);		 
		 die(json_encode($msg));  
		   
		   }  
		 
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
	 
	 public function add_class($cname, $begin_date, $begin_time, $time, $limit, $cost){
		 try{
		  $qry = "INSERT INTO class(cname, begin_date, begin_time, time, nlimit, cost)VALUES(?, ?, ?, ?, ?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $cname, PDO::PARAM_STR);
		 $stmt->bindParam(2, $begin_date, PDO::PARAM_STR);
		 $stmt->bindParam(3, $begin_time, PDO::PARAM_STR);
		 $stmt->bindParam(4, $time, PDO::PARAM_INT);
		 $stmt->bindParam(5, $limit, PDO::PARAM_INT);
		 $stmt->bindParam(6, $cost, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return "PASS"; else return "An error was encounter while processing reguest.";
		  
	 }
	 
	 catch(Exception $e){
		 return "An error was encounter while processing reguest. ";
		 }
     
	 }

 		
   	 public function update_class($cname, $begin_date, $begin_time, $time, $limit, $cost, $cid){
		 try{
		  $qry = "UPDATE class SET cname = ?, begin_date = ?, begin_time = ?, time = ?, nlimit = ?, cost = ? WHERE id = ? AND ? > cur_limit";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $cname, PDO::PARAM_STR);
		 $stmt->bindParam(2, $begin_date, PDO::PARAM_STR);
		 $stmt->bindParam(3, $begin_time, PDO::PARAM_STR);
		 $stmt->bindParam(4, $time, PDO::PARAM_INT);
		 $stmt->bindParam(5, $limit, PDO::PARAM_INT);
		 $stmt->bindParam(6, $cost, PDO::PARAM_INT);
		 $stmt->bindParam(7, $cid, PDO::PARAM_STR);
		 $stmt->bindParam(8, $limit, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return "PASS"; else return "No update was made.";
		  
	 }
	 
	 catch(Exception $e){
		 return "An error was encounter while processing reguest. ";
		 }
     
	 }



		
	public function get_admin($pid, $uid){
		 try{
		  $qry = "SELECT id, admin_name, password FROM admin WHERE id = ? AND uid = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $pid, PDO::PARAM_INT);
		 $stmt->bindParam(2, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return $stmt->fetch(); else return null;
		  
	 }
	 
	 catch(Exception $e){
		 return  null;
		 }
     
	 }	
	 
	 public function delete_class($pid){
		 try{
		  $qry = "DELETE  FROM class WHERE id = ? AND  cur_limit = 0";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $pid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'You can\'t delete this class at the moment.';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
     
	 }	
 


}


