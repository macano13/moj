<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';



if (!empty($_POST['email'])) {


    print ("Sending email with PHP\n");



try {
            //Server settings
            $mail = new PHPMailer();
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com'; 			// Set the SMTP server to send through
			$mail->AuthType   = 'LOGIN';
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'vip.translatesubtitles@gmail.com';                     // SMTP username
            $mail->Password   = 'musica111';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

//Recipients
            $mail->setFrom('vip.translatesubtitles@gmail.com', 'VIP Contact');
            $mail->addAddress('vip.translatesubtitles@gmail.com', 'VIP Contact');     // Add a recipient



// Content
            $report_mail = $_POST['email'];
           
            $report_description = $_POST['description'];
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
                <th>Description:</th><td>'.$report_description.'</td> 
            </tr> 
        </table> 
    </body> 
    </html>';

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            
            $_SESSION['mail_success'] = "Report is successfully sent!";

            header("location: formpage.php" . $id);

    header("location: formpage.php" . $id);;
        } catch (Exception $e) {
                    $id = $_POST['subtitle_id'];
                    $_SESSION['report_error'] = "There are some error while sending report.";

                    header("location: formpage.php" . $id);
        }


}

else {
    $id = $_POST['subtitle_id'];
    $_SESSION['report_error'] = "Email is invalid/empty.";

    header("location: formpage.php" . $id);
}