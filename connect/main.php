<?php
session_start(); 

$dataz = json_decode(file_get_contents('php://input'), true);

require '../connect/config.php';
if(isset($_SESSION['userid'])){
	$idc = 	$_SESSION['userid'];
 }
else{
	
	$msg = array('status' => 'error', 'message' => 'auttentication error. Please login');		 
    die(json_encode($msg));
	}



///##################################################
/////      RESERVE CLASS
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'reserve_class') {
		$errMsg = '';
        $pdo = new mypdo();
		$data = $dataz['data'];
		$cid = $data['cid'];
		
		$class_g = $pdo->get_classn($cid);
		$prof_g  = $pdo->get_profile($idc);
		
		///Check if the credit has expired
		
		        $daten = new DateTime();
				$date2 = DateTime::createFromFormat("Y-m-d H:i:s", $prof_g['cr_exp']);
				
		if($date2 < $daten && $prof_g['balance'] != 0)
		$errMsg = 'Your credit has expired<br>';
		
		//check if balance is enough 
		elseif($prof_g['balance'] < $class_g['cost'])
			$errMsg = 'Balance is low. Please credit your account<br>';
		elseif($class_g['cur_limit'] >= $class_g['nlimit'])
			$errMsg = 'Class already filled up<br>';
			
		if($errMsg != ''){
		$err = array('status' => 'error', 'message' => $errMsg);
		die(json_encode($err));
		}
		
		
		 $sreg = $pdo->ch_reserve_class($cid, $idc);
		 if($sreg != 'PASS'){
		  $msg = array('status' => 'error', 'message' => 'You have already Reserve this class');		 
		  die(json_encode($msg));
		 }
		 
		 $sreg = $pdo->update_class($cid);
		 if($sreg != 'PASS'){
		  $msg = array('status' => 'error', 'message' => $sreg);		 
		  die(json_encode($msg));
		 }	 
		 
		 $sreg = $pdo->reserve_class($cid, $idc, $class_g['cost'], time());	 
		 if($sreg != 'PASS'){
			$sreg = $pdo->update_class2($cid);
		  $msg = array('status' => 'error', 'message' => $sreg);		 
		  die(json_encode($msg));
		 } 
			 
		 $sreg = $pdo->update_balance($idc, $class_g['cost']);
		 $sreg = $pdo->insert_transaction($idc, time(), $class_g['cost'], 0, 'class reservation ('.$class_g['cname']. ')');
		 
		 $msg = array('status' => 'success', 'message' => $sreg);		 
		 die(json_encode($msg));  
		 
}











///##################################################
/////     CANCEL  RESERVE CLASS
///####################################################	
if(isset($dataz['ch']) && $dataz['ch'] == 'cancel_reserve') {
		$errMsg = '';
        $pdo = new mypdo();
		$data = $dataz['data'];
		$rid = $data['rid'];
		
		$rsv_g = $pdo->get_reservation($rid, $idc);
		$prof_g  = $pdo->get_profile($idc);
		
		                          $timdf = 2;
								  $week  =  date('N', time());
								  if($week == 7 || $week == 6 || $week == 5) $timdf = 12;
								  if(($rsv_g['time'] - time()) < $timdf * 60 * 60)
								  $errMsg = 'We are Sorry. You can cancel this reservation. Starting Date is very close<br>';
								  
		
		if($errMsg != ''){
		$err = array('status' => 'error', 'message' => $errMsg);
		die(json_encode($err));
		}
		
		///move reservation to log
		 $sreg = $pdo->reserve_class_log($rsv_g['class_id'], $idc, $rsv_g['amount'], time());	 
		 if($sreg != 'PASS'){
			 $msg = array('status' => 'error', 'message' => $sreg);		 
		  die(json_encode($msg));
		 } 
		 //delete fro the reservation table
		 $pdo->delete_reservation($rid, $idc);
		 
		 ///Update class count
		 $sreg = $pdo->update_class2($rsv_g['class_id']);
		
		 $sreg = $pdo->update_balance2($idc, $rsv_g['amount']);
		 
		  $sreg = $pdo->insert_transaction($idc, time(), $rsv_g['amount'], 1, 'cancelled reservation ('.$rsv_g['cname']. ')');
		 
		 $msg = array('status' => 'success', 'message' => $sreg);		 
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
	 
	 
	 public function get_profile($id){
		 try{
		  $qry = "SELECT id, fname, email, balance, phone, photo, cr_exp, reg FROM profile WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $id, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return $stmt->fetch(); else return null;
		  
	 }
	 
	 catch(Exception $e){
		 return null;
		 }
     
	 }	
	 
	 
	public function get_classn($cid){
		 
		 $qry = "SELECT id, cname, begin_date, begin_time, time, nlimit, cur_limit, cost FROM class WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $cid, PDO::PARAM_INT);
		 $stmt->execute();
		 return $stmt->fetch();
		 }
	
	 public function update_class($cid){
	 try{
		  $qry = "UPDATE class SET cur_limit = cur_limit + 1 WHERE id = ? AND  cur_limit < nlimit";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $cid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
     
	 }	
	 
	 public function update_class2($cid){
	 try{
		  $qry = "UPDATE class SET cur_limit = cur_limit - 1 WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $cid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
     
	 }	
	 
	 
	 
	 public function update_balance($idc, $amount){
	 try{
		  $qry = "UPDATE profile SET balance = balance - ? WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $amount, PDO::PARAM_INT);
		 $stmt->bindParam(2, $idc, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
     
	 }	
	 
	 
	 public function update_balance2($idc, $amount){
	 try{
		  $qry = "UPDATE profile SET balance = balance + ? WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $amount, PDO::PARAM_INT);
		 $stmt->bindParam(2, $idc, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
     
	 }	
	 
	 
	 
	 public function reserve_class($cid, $idc, $amount, $time){
		 
		 try{
		  $qry = "INSERT INTO reservation(member_id, class_id, amount, time)VALUES(?, ?, ?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $idc, PDO::PARAM_INT);
		 $stmt->bindParam(2, $cid, PDO::PARAM_INT);
		 $stmt->bindParam(3, $amount, PDO::PARAM_INT);
		 $stmt->bindParam(4, $time, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
		 
		 }
	
	
	public function reserve_class_log($cid, $idc, $amount, $time){
		 
		 try{
		  $qry = "INSERT INTO reservation_log(member_id, class_id, amount, time)VALUES(?, ?, ?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $idc, PDO::PARAM_INT);
		 $stmt->bindParam(2, $cid, PDO::PARAM_INT);
		 $stmt->bindParam(3, $amount, PDO::PARAM_INT);
		 $stmt->bindParam(4, $time, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'error';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
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
	
	
	
	public function  ch_reserve_class($cid, $idc){
		 
			 try{
		  $qry = "SELECT COUNT(member_id) AS cnt FROM reservation WHERE member_id = ? AND class_id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $idc, PDO::PARAM_INT);
		 $stmt->bindParam(2, $cid, PDO::PARAM_INT);
		 $stmt->execute();  //die($stmt->fetch()['cnt'].'nnn'.$idc."nnn".$cid);
		 if($stmt->fetch()['cnt'] <= 0)return 'PASS'; else return 'You have already reserve this class';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
		 
		 
		 
		 }
	 
	 
	 public function delete_class($pid){
		 try{
		  $qry = "DELETE  FROM class WHERE id = ? AND  cur_limit = 0";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $pid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'Class Already filled up';
		  
	 }
	 
	 catch(Exception $e){
		 return  'Database error occured';
		 }
     
	 }	
 
 
 public function get_reservation($rid, $uid){
		 try{
		 $qry = "SELECT a.id, a.class_id, b.cname, b.begin_date, b.begin_time, b.time, a.amount FROM reservation a INNER JOIN class b ON a.class_id = b.id WHERE a.id = ? AND a.member_id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $rid, PDO::PARAM_INT);
		 $stmt->bindParam(2, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return $stmt->fetch(); else return [];
		  
	 }
	 
	 catch(Exception $e){
		 return [];
		 }
     
	 }


  public function delete_reservation($rid, $uid){
		 try{
		 $qry = "DELETE FROM reservation WHERE id = ? AND member_id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $rid, PDO::PARAM_INT);
		 $stmt->bindParam(2, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return $stmt->fetch(); else return [];
		  
	 }
	 
	 catch(Exception $e){
		 return [];
		 }
     
	 }

  
  public function get_profile_p($id){
		 $qry = "SELECT id,  pwd FROM profile WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $id, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() < 1)
		 die('pa');
		 else{
		  $row = $stmt->fetch();
		  return $row;
		    }
		 }

  public function update_password($idc, $pwd){
	 try{
		  $qry = "UPDATE profile SET pwd = ? WHERE id = ?";
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
	 

}


