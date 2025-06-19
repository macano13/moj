<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
    require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email     = $_POST['email'];
        $mailBody     = $_POST['mailBody'];
        
        $sendStatus = sendingDownloadMail($email,$mailBody);
        // var_dump($sendStatus);
        // die();
        // return ['status'=>1];
        $response = [
            'status' => "success",
            'message' => 1,
        ];
        print_r(json_encode($response));
    }


    function sendingDownloadMail($email,$mailBody)
    {
        $mail = new PHPMailer(true);
        $baseUrl = 'https://vip.translatesubtitles.co/';

        try {
            //Server settings
            $mail->SMTPDebug = false;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'server.macanovic.net';                    // Set the SMTP server to send through
            $mail->AuthType   = 'LOGIN';
            $mail->SMTPAuth   = True;                                   // Enable SMTP authentication
            $mail->Username   = 'no_reply@translatesubtitles.com';                     // SMTP username
            $mail->Password   = '$Stomornjak111';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            
            //Recipients
            $mail->setFrom('no_reply@translatesubtitles.com', 'VIP Subtitle Download Link');
            $mail->addAddress($email);     // Add a recipient
    
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Subtitle file download link';
            $mail->Body    = $mailBody;
    
            $mail->send();
            if($mail)
            {
             return "true";
            }
            
        } catch (Exception $e) {
            return "false";
        }
    }
    
?>