<?php
   
   require '../connect/config.php';
   
   //###############################################
    //##     Admin LOGIN SECTION
   //############################################
   if(isset($_POST['login'])){
	  
	   if(trim($_POST['username']) == '') die(); 
	   $pdo = new mypdo();
	   $profn = $pdo->get_profile($_POST['username']);
	   
	   $verify = password_verify($_POST['password'], $profn['pwd']);
	   
	if($verify){    
	session_start();
	$_SESSION['admin'] = $profn['email'];
	$_SESSION['admina'] = $profn['id'];
	$_SESSION['adminb'] = $profn['level'];
	die('PASS');
	}
	else{
		
		die('username password not match');
		
		}
   }
   
  
  
   //###############################################
    //##     LOGOUT
   //############################################
 elseif(isset($_REQUEST['logout'])){
	 
	 session_start();
	session_unset(); session_destroy();
	die(header('Location: ./'));
	 
	 }
      
else die(header('Location: ./'));



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
	 
	  
	  public function get_profile($email){
		 $qry = "SELECT id,  email,  pwd, level FROM admin WHERE email = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $email, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() < 1)
		 die('password or username not match');
		 else{
		  $row = $stmt->fetch();
		  return $row;
		    }
		 }
	 
	 }
 


