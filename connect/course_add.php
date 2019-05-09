<?php

require '../connect/config.php';

session_start(); 
if(!isset($_SESSION['admine']))
	 die('Please refresh page');
	
 $pdo = new mypdo();	

if(isset($_POST['flag'])){ 

 if($_POST['flag'] == 0)  		
 
 die($pdo->insert_course($_POST['price'], $_POST['duration'], $_POST['seat'], $_POST['cname'], $_POST['desc'], $_POST['uid']));
 
 else
 
 die($pdo->update_course($_POST['price'], $_POST['duration'], $_POST['seat'], $_POST['cname'], $_POST['desc'], $_POST['uid']));

}

elseif(isset($_POST['dataf'])){
	$dataf = ($_POST['dataf'] == 0)? 1 : 0;
	 die($pdo->update_course_flg($dataf, $_POST['uid']));
	}

elseif(isset($_POST['deletef'])){
	 die($pdo->delete_course($_POST['deletef']));
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
	 
	 public function insert_course($price, $duration, $seat, $cname, $descc, $uid){
		 
		  $qry = "INSERT INTO courses(cname, descc, price, duration, seat)VALUES(?, ?, ?, ?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $cname, PDO::PARAM_STR);
		 $stmt->bindParam(2, $descc, PDO::PARAM_STR);
		 $stmt->bindParam(3, $price, PDO::PARAM_STR);
		 $stmt->bindParam(4, $duration, PDO::PARAM_INT);
		 $stmt->bindParam(5, $seat, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return "PASS"; else return "An error was encounter while adding details";
		 
		 }
	 
    
	 public function update_course($price, $duration, $seat, $cname, $descc, $uid){
		 
		  $qry = "UPDATE  courses SET cname = ?, descc = ?, price = ?, duration = ?, seat = ? WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $cname, PDO::PARAM_STR);
		 $stmt->bindParam(2, $descc, PDO::PARAM_STR);
		 $stmt->bindParam(3, $price, PDO::PARAM_STR);
		 $stmt->bindParam(4, $duration, PDO::PARAM_INT);
		 $stmt->bindParam(5, $seat, PDO::PARAM_INT);
		 $stmt->bindParam(6, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return "PASS"; else return "An error was encounter while updating course details";
		 
		 }
		 
	public function update_course_flg($flag, $uid){
		 
		  $qry = "UPDATE  courses SET flag = ? WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $flag, PDO::PARAM_INT);
		 $stmt->bindParam(2, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return "PASS"; else return "An error was encounter while updating course status";
		 
		 }
   
    public function delete_course($uid){
		 
		  $qry = "DELETE FROM   courses  WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return "PASS"; else return "An error was encounter while deleting course ";
		 
		 }
	 
	 }
 		

