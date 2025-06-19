<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';



if (!empty($_POST['email'])) {


    print ("Sending email with PHP\n");



try {
            //Server settings
            $mail = new PHPMailer();
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'server.macanovic.net'; 			// Set the SMTP server to send through
			$mail->AuthType   = 'LOGIN';
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'no_reply@translatesubtitles.com';                     // SMTP username
            $mail->Password   = 'musica111';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

//Recipients
            $mail->setFrom('demo.translatesubtitles@gmail.com', 'Demo');
            $mail->addAddress('demo.translatesubtitles@gmail.com', 'Demo');     // Add a recipient



// Content
            $report_mail = $_POST['email'];
           
            $report_ip = $_POST['user_ip'];
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Subtitle Report';
            //$mail->Body    = 'Report information details: <br> User Email: '.$report_mail.'<br> User IP: '.$report_ip.'<br>;
            $mail->Body    = ' 
    <html> 
    <head> 
      
    </head> 
    <body> 
        <h1>Report Details</h1> 
        <table cellspacing="0" style="border: 2px dashed #000000  ; width: 100%;"> 
            <tr> 
                <th>Email:</th><td>'.$report_mail.'</td> 
            </tr> 

            <tr> 
                <th>IP Address:</th><td>'.$report_ip.'</td> 
            </tr> 
        </table> 
    </body> 
    </html>';

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            
            $_SESSION['mail_success'] = "Report is successfully sent!";

            header("location: login.php" . $id);

    header("location: login.php" . $id);;
        } catch (Exception $e) {
                    $id = $_POST['subtitle_id'];
                    $_SESSION['report_error'] = "There are some error while sending report.";

                    header("location: login.php" . $id);
        }


}

else {
    $id = $_POST['subtitle_id'];
    $_SESSION['report_error'] = "Email is invalid/empty.";

    header("location: login.php" . $id);
}