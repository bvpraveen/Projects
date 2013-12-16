<html>
<head>
</head>
<body>

<?php

require_once("class.phpmailer.php");

$phpmailer= new PHPMailer();
$phpmailer->IsSMTP(); // telling the class to use SMTP
$phpmailer->SMTPSecure = 'ssl'; 
$phpmailer->Host       = 'ssl://smtp.gmail.com'; // SMTP server
$phpmailer->SMTPAuth   = true;                  // enable SMTP authentication
//$phpmailer->SMTPDebug = 2; 
$phpmailer->Port       = 465;          // set the SMTP port for the GMAIL server; 465 for ssl and 587 for tls
$phpmailer->Username   = 'irentfeedback@gmail.com'; // Gmail account username
$phpmailer->Password   = 'Password~1';        // Gmail account password
$phpmailer->SetFrom('irentfeedback@gmail.com', 'iRent');
$phpmailer->AddAddress('irentfeedback@gmail.com', 'iRent');
$phpmailer->Subject = '[Feedback]'.$_POST['emailid'].'('.$_POST['phone'].') '.$_POST['subject'];
$message = $_POST['message'];
$phpmailer->MsgHTML($message);
if(!$phpmailer->Send())
{
	echo 'Error while submitting feedback:'.$phpmailer->ErrorInfo;
}
else
{
	echo 'Feedback submitted successfully. <a href="home.php">Back to home page</a>';
}

?>

</body>
</html>