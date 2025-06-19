<!DOCTYPE HTML>
<html>
<title>Reset password</title>
<head>
<link rel="icon" href="../favicon.png" type="image/ico" sizes="32x32">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<header>
</header>
<body>
<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

$connection = mysqli_connect("localhost", "c1uploading1", "#Stomornjak111", "c1zvizdoDB");
$email = $_POST["email"];

$sql = "SELECT * FROM tbl_users WHERE email = '$email'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result) > 0)
{
	$reset_token = time() . md5($email);

	$sql = "UPDATE tbl_users SET reset_token='$reset_token' WHERE email='$email'";
	mysqli_query($connection, $sql);

	$message = "<p>Please click the link below to reset your password</p>";
	$message .= "<a href='https://vip.translatesubtitles.co/pass/reset-password.php?email=$email&reset_token=$reset_token'>";
		$message .= "Reset password";
	$message .= "</a>";
        $message .= "<p>Best Regards,</p>";
        $message .= "<p>vip.translatesubtitles.co</p>";

	send_mail($email, "Reset password", $message);
}
else
{
	echo '<span style="background: red;border-radius: 5px;color: white;display:flex;justify-content:center;max-width:500px;line-height:5vh;margin:auto;margin-top:50px;font-weight:600;
">Email does not exists in our database!</span>';
}

function send_mail($to, $subject, $message)
{
	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = false;                                       // Enable verbose debug output
	    $mail->isSMTP();                                            // Set mailer to use SMTP
	    $mail->Host       = 'server.macanovic.net';  // Specify main and backup SMTP servers
		$mail->AuthType   = 'LOGIN';
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = 'no_reply@translatesubtitles.com';                     // SMTP username
	    $mail->Password   = '$Stomornjak111';                               // SMTP password
	    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
	    $mail->Port       = 587;    		// TCP port to connect to
		
		            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

	    $mail->setFrom('support@to.translatesubtitles.co', 'Translate Subtitles VIP');
	    //Recipients
	    $mail->addAddress($to);

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $subject;
	    $mail->Body    = $message;

	    $mail->send();
	    echo '<span style="background: green;border-radius: 5px;color: white;display:flex;justify-content:center;max-width:500px;line-height:5vh;margin:auto;margin-top:50px;font-weight:600;
">Link has been sent! Please check your email inbox.</span>';
	} catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
?>
<a href="https://vip.translatesubtitles.co" class="btn btn-dark sent-msg" role="button" aria-pressed="true">Back to Login</a>

</body>
</html>