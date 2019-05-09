<?php
session_start();
require '../connect/config.php';
if(isset($_POST['fname'])){

			$email = $_POST["email"];
			
			$fname = $_POST["fname"];
			$email = $_POST["email"];
			$phone = $_POST["phone"];
			$pwd = $_POST["pwd"];
			$reg = time();
			if(strlen($pwd) < 6) die('wrong pasword');
			
			$pwd = password_hash($pwd, PASSWORD_DEFAULT);

if((strlen($fname) < 3) || (strlen($fname) > 100 ))die("name too small or too long");
	
	
		
		
		
		
		phoxixb:
	$letter = array( 1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e',6 => 'f', 7 => 'g', 8 => 'h', 9 => 'i', 10 => 'j', 11 => 'k', 12 => 'l', 13 => 'm', 14 => 'n', 15 => 'o', 16 => 'p', 17 => 'q', 18 => 'r', 19 => 's', 20 => 't', 21 => 'u', 22 => 'v', 23 => 'w', 24 => 'x', 25 => 'y', 26 => 'z', 27 => '0', 28 => '1', 29 => '2', 30 => '3', 31 => '4', 32 => '5', 33 => '6', 34 => '7', 35 => '8', 36 => '9');
		
		$token = "";
		$token .= $letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)].$letter[mt_rand(1,36)];
	
	
		$pford = "../assets/profile/".$token;
		$mime = pathinfo($_FILES["mfile"]["name"], PATHINFO_EXTENSION);
		$pford1 = $pford.".jpg";
		
		if($mime != "jpg" && $mime != "jpeg" && $mime != "png" && $mime != "gif")
die(">>Error! Wrong file type");

switch($_FILES["mfile"]["type"]){
	case 'image/jpeg':
	$imaged = imagecreatefromjpeg($_FILES["mfile"]["tmp_name"]);
	break;
	case 'image/png':
	$imaged = imagecreatefrompng($_FILES["mfile"]["tmp_name"]);
	break;
	case 'image/gif':
	$imaged = imagecreatefromgif($_FILES["mfile"]["tmp_name"]);
	break;
	default:
	die("File type not supported for passport. Passport should be a valid image");
		}
	
	
	
	$new_wz = imagesx($imaged)/200; $new_hz = imagesy($imaged)/200;
	if($new_wz > $new_hz){
		$new_w = floor(imagesx($imaged)/ $new_wz) ;  $new_h = floor(imagesy($imaged)/ $new_wz) ;
			}
	else{
		$new_w = floor(imagesx($imaged)/ $new_hz);  $new_h = floor(imagesy($imaged)/ $new_hz) ;
			}
			
	//create the image 300 by ..
	$imagen = imagecreatetruecolor($new_w, $new_h);
	
	//resize old image into new image
	
	imagecopyresampled($imagen, $imaged, 0, 0, 0, 0, $new_w, $new_h, imagesx($imaged), imagesy($imaged));
	
	if(file_exists($pford1)) goto phoxixb;
	
		
		
	$pdo = new mypdo();
$sreg = $pdo->reg_profile($fname, $email, $pwd, $phone, $token, $reg);
		if($sreg == 'PASS'){
		
		imagejpeg($imagen, $pford1);
		imagedestroy($imaged); imagedestroy($imagen);
		
		$_SESSION['username'] = $email;
		mailler($email, $fname);
		
		}
die($sreg);
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
	
	public function reg_profile($fname, $email, $pwd, $phone, $token, $reg){
		try{
		$qry = "INSERT INTO profile(fname, email, pwd, phone, photo, reg)VALUES(?, ?, ?, ?, ?, ?)";
		$stmt = $this->pdc->prepare($qry);
		$stmt->bindParam(1, $fname, PDO::PARAM_STR);
		$stmt->bindParam(2, $email, PDO::PARAM_STR);
		$stmt->bindParam(3, $pwd, PDO::PARAM_STR);
		$stmt->bindParam(4, $phone, PDO::PARAM_STR);
		$stmt->bindParam(5, $token, PDO::PARAM_STR);
		$stmt->bindParam(6, $reg, PDO::PARAM_INT);
		$stmt->execute();
		if($stmt->rowCount() > 0) return "PASS"; else return "An error was encounter while processing reguest. It seems you have registered with this email address before";
		
	}
	
	catch(Exception $e){
		return "An error was encounter while processing reguest. It seems you have registered with this email address before";
		}

	}
		
}
use PHPMailer\PHPMailer\PHPMailer;
function mailler($email, $name){
require '../mailer/src/PHPMailer.php';
require '../mailer/crypto.php';
require '../mailer/src/Exception.php';

$mssg = '<!doctype html><html> <head> <meta name="viewport" content="width=device-width"> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <title>Welcome to Jumping Fitness Malaysia</title> </head> <body style="text-align:center; background-color:#EEE;"> <div style="text-align:center; max-width:600px; display:inline-block;"><div style=" text-align:left; background-color:#FFF; padding:10px "> <h3 style=" text-align:center; color:#565; margin-bottom: 30px;">Hi! '. $name. ' Welcome to Jumping Fitness Malaysia</h3> <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; Margin-bottom: 15px;">Welcome to Jumping Fitness Malaysia. We are happy you are here.One of our representative will get back at you soon.</p>  <p style="font-family: sans-serif; font-style:italic; font-size: 12px; font-weight: normal; margin-bottom: 15px;">You received this mail because you  registered an account on jumpingfitness.com. Kindly ignore if you were not the person.</p> </div> <div style=" margin-top:40px; margin-bottom:10px; color: #999999; font-size: 12px; text-align: center;">Jumping Fitness Malaysia</span> <br>  </div> <div style="font-size: 12px; text-align: center;"> <a href="https://www.jumpingfitness.com/" style="color: #999999;text-decoration: none;">&copy; jumpingfitness.com</a>. </div> </div> </body></html>';
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom("support@jumpingfitness.com", 'Jumping Fitness Malaysia');
//Set an alternative reply-to address
$mail->addReplyTo("support@acetraning.com", 'Jumping Fitness Malaysia');
//Set who the message is to be sent to
$mail->addAddress($email, $name);
//Set the subject line
$mail->Subject = 'Welcome to Jumping Fitness Malaysia';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($mssg);
//Replace the plain text body with one created manually
$mail->AltBody = "Thank you registering a course at Jumping Fitness Malaysia Center. One of our representative will get back to you";
//Attach an image file
//$mail->addAttachment('1473787167.5497.JPEG');
if (!@$mail->send()) {
return "error";
} else {
return "good";
}
}