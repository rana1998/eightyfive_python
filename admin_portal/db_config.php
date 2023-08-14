<?php
ob_start();

 
$mysql_host = 'localhost';
// $mysql_username = 'arialkhk_python';
// $mysql_password = 'gtron@12g';
// $mysql_database = 'arialkhk_python';
$mysql_username = 'root';
$mysql_password = '';
$mysql_database = 'arialkhk_python';
  
  

$con =$conn= new mysqli($mysql_host, $mysql_username, $mysql_password);
    
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

$con->select_db($mysql_database) or die( "Unable to select database.");

// Swiftmailer Initialized
function send_email($param = array())
{

    require_once 'swiftmailer/lib/swift_required.php';
    $transport = new Swift_SmtpTransport('GTRON.com', 465, 'ssl');
    $mailer = Swift_Mailer::newInstance($transport);


    $receiver_name  =  $param['receiver_name'];
    $receiver_email =  $param['receiver_email'];
    $subject        =  $param['subject'];
    $email_template =  $param['email_template'];

    // $subject : String
	// $email_template : String
	// $receiver : Array

    $message = Swift_Message::newInstance();
    $message->setTo(array($receiver_email =>  $receiver_name) );
    $message->setSubject($subject);
    $message->setBody($email_template,"text/html");
    $message->setReplyTo('noreply@GTRON.com');
    $message->setFrom('noreply@mazicoin.com', 'mazicoin.com');
    // Send the email
    if($mailer->send($message)){
    	return TRUE;
    }

}



    
    
?>