<?php

require '../connect/config.php';

if(isset($_POST['username'])){

        $pdo = new mypdo();
		
		$timec = time();
			
		$data = $_POST['username'];
		if(preg_match("/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/", $data)) //if the data is an email address
		$pfile =  $pdo->get_profile(1, $data);
		else { //The data is a unername
		die('Please enter an email address');
		$pfile =  $pdo->get_profile(0, $data);  
		}
	 		  $username = $pfile['fname'];  $email = $pfile['email'];
		   
		   $stg =  $pdo->insert_recover($timec, $email); 
		 
		  mailler($username,$email, $timec);  //Send recover password link to the user
	      die("PASS");

}

use PHPMailer\PHPMailer\PHPMailer;
function mailler($username,$email,$timec){

/****  Required all necessary PHPMail library and a custom encrypt library to encrypt our data */

require '../mailer/src/PHPMailer.php';
require '../mailer/crypto.php';
require '../mailer/src/Exception.php';
 
$ref2 = encrypt($username.">>".time().">>".$username.">>8");

$ref = encrypt($timec."___".$email."___".$username."___".$timec);

$recover_link = "https://www.jumpingfitness.com/admin/password_ad_recovery.php?pl=$ref&n=0";


$mssg = '<!doctype html><html> <head> <meta name="viewport" content="width=device-width"> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <title>JUMPING FITNESS | PASSWORD RECOVERY</title> </head> <body style="text-align:center; background-color:#EEE;"> <div style="text-align:center; max-width:600px; display:inline-block;"> <div style=" text-align:left; background-color:#FFF; padding:10px "> <h3 style=" text-align:center; color:#565; margin-bottom: 30px;">Recover Password   </h3> <p style="margin-bottom: 15px; text-align:center; font-weight:normal"><span style="color:#090; font-weight:bolder; font-size:16px; margin-right:20px">Hello! '. $username. '</span> Please click on the link below to recover your password</p> <p style="text-align:center"><a style="color:#ffffff; margin:20px; padding:10px; border-radius:10px; display:inline-block; text-decoration:none; background-color: #00F; border: solid 2px #0F0;  font-size: 18px; font-weight: bold;" href="'. $recover_link.'"> Recover Password </a></p><p style="font-size: 12px">Or copy the link below and paste it in a browser address bar</p><p style="font-size:12px"><a href="'. $recover_link.'">'. $recover_link.'</a></p> <p style="font-style:italic; font-size: 12px; font-weight: normal; margin-bottom: 15px;">You received this mail because you were about recovery a password at jumpingfitness.com. Kindly ignore if you were not the one.</p> </div> <div style=" margin-top:40px; margin-bottom:10px; color: #999999; font-size: 12px; text-align: center;">The best in Fitness Trainning. </div> <div style="font-size: 12px; text-align: center;"> <a href="https://www.jumpingfitness.com/" style="color: #999999;text-decoration: none;">&copy; jumpingfitness.com</a>. </div> </div> </body></html>';


//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom("support@jumpingfitness.com", 'Jumping Fitness Malaysia');
//Set an alternative reply-to address
$mail->addReplyTo("support@jumpingfitness.com", 'Jumping Fitness Malaysia');
//Set who the message is to be sent to
$mail->addAddress($email, '');
//Set the subject line
$mail->Subject = "Reset Your Password";
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($mssg);
//Replace the plain text body with one created manually
$mail->AltBody = "Please click on the link below to reset your password /n/n $recover_link";

//Attach an image file
//$mail->addAttachment('1473787167.5497.JPEG');

if (!@$mail->send()) {
    return "error";
} else {
    return "good";
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
	 
	  
	  public function get_profile($ch, $data){
		  if($ch == 0)
		 $qry = "SELECT email, email AS fname FROM admin WHERE email = ?";
		 else
		$qry = "SELECT email, email AS fname FROM admin WHERE email = ?"; 
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $data, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() < 1)
		 die('No record for this detail');
		 else{
		  $row = $stmt->fetch();
		  return $row;
		    }
		 }
	   
	   
	   public function insert_recover($timec, $username){
		 $qry = "INSERT INTO recovertb (id, username) VALUES (?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $timec, PDO::PARAM_INT);
		 $stmt->bindParam(2, $username, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() < 1)
		 die('A database error occured');
		  }
	 }
 