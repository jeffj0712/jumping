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
/////      ADD CREDIT
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'add_credit') {
		$errMsg = '';

		$data = $dataz['data'];
		$uid = $data['uid'];
		$amount = $data['amount'];
		$cr_exp = $data['cr_exp'];
		$note = $data['note'];
		
		if($amount < 1)
		$tr_state = 0;
		else{
		$tr_state = 1;
		
		$date3 = DateTime::createFromFormat("Y-m-d", $cr_exp);
		$daten3 = new DateTime();
		if($date3 < $daten3)
		  $errMsg = 'Fatal Error. expire date can not be less than current date.<br>';
		}
		
		if($errMsg != ''){
		$err = array('status' => 'error', 'message' => $errMsg);
		die(json_encode($err));
		}
		
		 $pdo = new mypdo();
		 
		if($amount < 1)
		        $sreg = $pdo->add_credit_2($uid, $amount);
		else{
		        $cr_state = $pdo->get_credit_exp($uid);
		        
				$daten = new DateTime();
				$date2 = DateTime::createFromFormat("Y-m-d H:i:s", $cr_state);
				
				if($date2 > $daten)
				$sreg = $pdo->add_credit($uid, $amount, $cr_exp, 1);
				else
				$sreg = $pdo->add_credit($uid, $amount, $cr_exp, 0);
         
		     }
		 
		 if($sreg == 'PASS'){
			 $msg = array('status' => 'success', 'message' => $sreg);
			 $pdo->insert_transaction($uid, time(), $amount, $tr_state, $note);		 
		 die(json_encode($msg));
		 }
       else{
		 $msg = array('status' => 'error', 'message' => $sreg);		 
		 die(json_encode($msg));  
		   
		   }  
		 
}




///##################################################
/////      UPDATE ATTENDANCE
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'update_attendance') {
		$errMsg = '';
		$no_update = 0;

		$data = $dataz['data'];
		$cid = $data['cid'];
		
		$pdo = new mypdo();
		
		foreach($data['data'] as $key => $val){
			
			$sreg = $pdo->update_attendance($cid, $key, $val); 
			if($sreg == "PASS")
			$no_update++;
	     }

       $msg = array('status' => 'success', 'message' => $no_update);		 
	   die(json_encode($msg)); 
			
		}
		
		



///##################################################
/////      Change Password
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'change_password') {
		$errMsg = '';

		
		$data = $dataz['data'];
		$pwd = $data['pwd'];
		$pwd1 = $data['pwd1'];
		$pwd2 = $data['pwd2'];
		
	$pdo = new mypdo();
	  $profn = $pdo->get_profile_p($idc);
	   
	   $verify = password_verify($pwd, $profn['pwd']);
	   
	if($verify){    
	 
	  $sreg = $pdo->update_password($idc, password_hash($pwd1, PASSWORD_DEFAULT));
	  if($sreg == 'PASS'){
	     $msg = array('status' => 'success', 'message' => $sreg);		 
		 die(json_encode($msg)); 
	  }else{
		
		$msg = array('status' => 'error', 'message' => $sreg);		 
		 die(json_encode($msg));  
		  
		  }
		}
	else{
		$msg = array('status' => 'error', 'message' => 'Wrong password; Not verified');		 
		 die(json_encode($msg));
		
		}  
		 
}


  ///##################################################
/////      ADD ADMIN
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'add_admin') {
		
		if($_SESSION['adminb'] != '9'){
		 $msg = array('status' => 'error', 'message' => 'Authentication error');		 
		 die(json_encode($msg));  
		   
		   }
		
		$errMsg = '';

		$data = $dataz['data'];
		$email = $data['email'];
		$password = $data['password'];
		
		
		 $pdo = new mypdo();
         
		 $sreg = $pdo->add_admin($email, password_hash($password, PASSWORD_DEFAULT));
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
/////     DELETE ADMIN
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'delete_admin') {
		
		if($_SESSION['adminb'] != '9'){
		 $msg = array('status' => 'error', 'message' => 'Authentication error');		 
		 die(json_encode($msg));  
		   
		   }
		
		$errMsg = '';

		$data = $dataz['data'];
		$aid = $data['admin_id'];
		
		
		 $pdo = new mypdo();
         
		 $sreg = $pdo->delete_admin($aid);
		 if($sreg == 'PASS'){
	       $msg = array('status' => 'success', 'message' => 'PASS');		 
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
	 
	 public function add_credit($uid, $amount, $cr_exp, $state){
		 try{
			 if($state == 1)
		  $qry = "UPDATE profile SET balance = balance + ?, cr_exp = ? WHERE id = ?";
		     else
		  $qry = "UPDATE profile SET balance = ?, cr_exp = ? WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $amount, PDO::PARAM_INT);
		 $stmt->bindParam(2, $cr_exp, PDO::PARAM_STR);
		 $stmt->bindParam(3, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return "PASS"; else return "An error was encounter while processing request.";
		  
	 }
	 
	 catch(Exception $e){
		 return "An error was encounter while processing reguest. ";
		 }
     
	 }

   
   
   public function add_credit_2($uid, $amount){
		 try{
		  $qry = "UPDATE profile SET balance = balance + ? WHERE id = ?";
		    
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $amount, PDO::PARAM_INT);
		 $stmt->bindParam(2, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return "PASS"; else return "An error was encounter while processing request.";
		  
	 }
	 
	 catch(Exception $e){
		 return "An error was encounter while processing reguest. ";
		 }
     
	 }
 
   public function get_credit_exp($uid){
		 try{
		 $qry = "SELECT cr_exp FROM profile  WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return $stmt->fetch()['cr_exp']; else die("An error was encounter while processing request.");
		  
	 }
	 
	 catch(Exception $e){
		 die("An error was encounter while processing reguest. ");
		 }
     
	 }


  public function insert_transaction($idc, $date, $amount, $status, $note){
		 
		 try{
		  $qry = "INSERT INTO transaction(uid, date,  amount, status, note)VALUES(?, ?, ?, ?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $idc, PDO::PARAM_INT);
		 $stmt->bindParam(2, $date, PDO::PARAM_INT);
		 $stmt->bindParam(3, $amount, PDO::PARAM_INT);
		 $stmt->bindParam(4, $status, PDO::PARAM_INT);
		 $stmt->bindParam(5, $note, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
		 
		 }
	
	
	public function get_profile_p($id){
		 $qry = "SELECT id,  email,  pwd, level FROM admin WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $id, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() < 1)
		 die('password or username not match');
		 else{
		  $row = $stmt->fetch();
		  return $row;
		    }
		 }

  
   public function update_password($idc, $pwd){
	 try{
		  $qry = "UPDATE admin SET pwd = ? WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $pwd, PDO::PARAM_STR);
		 $stmt->bindParam(2, $idc, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
     
	 }	

 
 function add_admin($email, $password){
	 
	 $qry = "INSERT INTO admin(email,  pwd)VALUES(?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $email, PDO::PARAM_STR);
		 $stmt->bindParam(2, $password, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		    
	 
	 }


 function delete_admin($id){
	 
	 $qry = "DELETE FROM admin  WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $id, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		    
	 
	 }


  public function update_attendance($cid, $id, $value){
		 try{
		  $qry = "UPDATE reservation SET attendance = ? WHERE id = ? AND class_id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $value, PDO::PARAM_INT);
		 $stmt->bindParam(2, $id, PDO::PARAM_INT);
		 $stmt->bindParam(3, $cid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'FAIL';
		  
	 }
	 
	 catch(Exception $e){ print_r($e);
		 die("Database error occur while ....");
		 }
     
	 }	

}


