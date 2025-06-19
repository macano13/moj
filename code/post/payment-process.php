<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
    require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

    use PayPal\Rest\ApiContext;
    use PayPal\Auth\OAuthTokenCredential;
    use PayPal\Api\Payment;
    use PayPal\Api\PaymentExecution;
    use PayPal\Exception\PayPalConnectionException;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    if (isset($_GET['PayerID']) && isset($_GET['paymentId'])) {
        $PayerID = $_GET['PayerID'];
        $paymentId = $_GET['paymentId'];

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AZQRVZJODpUcv88zYC0RXZZJurJX5mIsOg3z-g9ev5RfR3s3xbK33ZehxEl-zJNqkjlYubVjujmx08cw',     // ClientID
                'EJ8IS9Xi_e3YavVcH_SdfFPVejbETAghfSwgSlhw-0XhVFlIEzL4b7ydr7Q1gM1PgnW4QXKHG4DHl-cc'      // ClientSecret
            )
        );


       // $apiContext = new ApiContext(
        //    new OAuthTokenCredential(
        //        'AbEIuM-3NRh0ZHAisZWBqibWhPS4QxYaptjbAIMskonUDwg0WmSbO7nGY2zxSmQkdrVmMaryDx8ZhB4j',     // ClientID
        //        'ED5bYt7mgkSxV-RCCpVYUOfXIhi9yeNO5Bgq6pQoWquo1jAzK_fS3S6VmYEkdVRGxbjKDyRzqYv3CCZs'      // ClientSecret
       //     )
       // );
    
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $apiContext);
    
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
    
        $response = $payment->execute($execution, $apiContext);
    
        $error_message = "";
        $success_message = "";

        if ($response->state == 'approved') {
            $transactions = $payment->getTransactions();
            $relatedResources = $transactions[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            $lastTransId = $sale->getId();
            $amount = $sale->getAmount();
           
            $user = $_SESSION["USER_INFO"];
            $userId = $user->id;

            $paymentInfo    = db_payAmount();

            $monhtlyAmount  = $paymentInfo->pay_amount;

            $perMonthPrice = $monhtlyAmount;

            $amount = $amount->total;
            $month = $amount / $perMonthPrice;

            $dt1 = new DateTime();
            $paymentDate = $dt1->format("Y-m-d");
        
            $dt2 = new DateTime("+".$month ."month");
            $expireDate = $dt2->format("Y-m-d");

            $randomString = substr(sha1(rand()), 0, 8);
            $inVoiceId = "UBF".$userId.$randomString;

            $count = db_checkInvoiceExistStatus($userId);

            if ($count == '') {
                $resUser = db_updateUser($userId,1,$expireDate);
                $checkTransIdExists = db_checkTransIdExists($lastTransId);
                if (count($checkTransIdExists) == 0) {
                    $res = db_insertInvoicesDetails($userId,$inVoiceId,$amount,$lastTransId,$paymentDate);
                }else{
                    $_SESSION['paymentMessage'] = 'Already Paid!.';
                    echo "<script>window.location.href ='/index.php?message=payment';</script>";
                    return;
                }
            }else{
                $resUser = db_updateUser($userId,1,$expireDate);
                foreach ($count as $value) {
                    $res = db_updateInvoicesDetails($value->id,$amount,$lastTransId,$paymentDate);
                }
            }

            if ($res) {
                sendingMail($user->name, $user->email,$user->password,$paymentDate,$perMonthPrice,$month,$amount);
                $_SESSION['paymentMessage'] = 'Success! Your activation will expire in '.$expireDate;
                echo "<script>window.location.href ='/index.php?message=payment';</script>";
            }else{
                $_SESSION['paymentMessage'] = 'Something went wrong! Please contact with admin with your transaction id '.$lastTransId;
                echo "<script>window.location.href ='/index.php?message=payment';</script>";
            }
        }else{
            $_SESSION['paymentMessage'] = 'Something went wrong! Payment can not be completed.';
            echo "<script>window.location.href ='/index.php?message=payment';</script>";
        }
    }else {
        $result = array("status" => 400, "Message" => "Data missing");
        echo json_encode($result);
    }


    function sendingMail($name,$email,$password,$paymentDate,$perMonthPrice,$totalMonth,$amount)
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
            $mail->setFrom('no_reply@translatesubtitles.com', 'VIP Payment Invoice mail');
            $mail->addAddress($email, $name);     // Add a recipient
    
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Payment Invoice mail';
            $mail->Body    = "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
                    <title>Document</title>
                    <style>
                        .congraz_msg h4{
                            color: #4D4F5B;
                        }
                        #invoice{
                            padding: 30px;
                        }
                
                        .invoice {
                            position: relative;
                            background-color: #FFF;
                            min-height: 680px;
                            padding: 15px
                        }
                
                        .invoice .contacts {
                            margin-bottom: 20px
                        }
                
                        .invoice .invoice-to {
                            text-align: left
                        }
                
                        .invoice .invoice-to .to {
                            margin-top: 0;
                            margin-bottom: 0
                        }
                
                        .invoice .invoice-details {
                            text-align: right
                        }
                
                        .invoice .invoice-details .invoice-id {
                            margin-top: 0;
                            color: #39c647
                        }
                
                        .invoice main {
                            padding-bottom: 50px
                        }
                
                        .invoice main .thanks {
                            margin-top: -100px;
                            font-size: 2em;
                            margin-bottom: 50px
                        }
                
                        .invoice table {
                            width: 100%;
                            border-collapse: collapse;
                            border-spacing: 0;
                            margin-bottom: 20px
                        }
                
                        .invoice table td,.invoice table th {
                            padding: 15px;
                            background: #eee;
                            border-bottom: 1px solid #fff
                        }
                
                        .invoice table th {
                            white-space: nowrap;
                            font-weight: 400;
                            font-size: 16px
                        }
                
                        .invoice table td h3 {
                            margin: 0;
                            font-weight: 400;
                            color: #39c647;
                            font-size: 1.2em
                        }
                
                        .invoice table .qty,.invoice table .total,.invoice table .unit {
                            text-align: right;
                            font-size: 1.2em
                        }
                
                        .invoice table .no {
                            color: #fff;
                            font-size: 1.6em;
                            background: #39c647
                        }
                
                        .invoice table .unit {
                            background: #ddd
                        }
                
                        .invoice table .total {
                            background: #39c647;
                            color: #fff
                        }
                
                        .invoice table tbody tr:last-child td {
                            border: none
                        }
                
                        .invoice table tfoot td {
                            background: 0 0;
                            border-bottom: none;
                            white-space: nowrap;
                            text-align: right;
                            padding: 10px 20px;
                            font-size: 1.2em;
                            border-top: 1px solid #aaa
                        }
                
                        .invoice table tfoot tr:first-child td {
                            border-top: none
                        }
                
                        .invoice table tfoot tr:last-child td {
                            color: #39c647;
                            font-size: 1.4em;
                            border-top: 1px solid #39c647
                        }
                
                        .invoice table tfoot tr td:first-child {
                            border: none
                        }
                        @media print {
                            .invoice {
                                font-size: 11px!important;
                                overflow: hidden!important
                            }
                
                            .invoice footer {
                                position: absolute;
                                bottom: 10px;
                                page-break-after: always
                            }
                
                            .invoice>div:last-child {
                                page-break-before: always
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='congraz_msg'>
                            <h4 class='text-center'>Congratulation! You have successfully completed your payment process</h4>
                            <div class='text-center'>
                                <a href=$baseUrl.'login.php' class='btn btn-info'>Login</a>
                            </div>
                        <hr>
                        <div class='text-center'>
                            <p>Email - $email</p>
                            <p>Password - $password</p>
                        </div>
                
                        </div>
                    </div>
                    <div id='invoice'>
                        <div class='invoice overflow-auto'>
                            <div style='min-width: 300px'>
                                <main>
                                    <div class='row contacts'>
                                        <div class='col invoice-to'>
                                            <div class='text-gray-light'>INVOICE TO:</div>
                                            <h2 class='to'>$name</h2>
                                            <div class='email'><a href='mailto:$email'>$email</a></div>
                                        </div>
                                        <div class='col invoice-details'>
                                            <h1 class='invoice-id'>INVOICE</h1>
                                            <div class='date'>Date of Invoice: $paymentDate</div>
                                        </div>
                                    </div>
                                    <table border='0' cellspacing='0' cellpadding='0'>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class='text-left'>DESCRIPTION</th>
                                                <th class='text-right'>Month PRICE</th>
                                                <th class='text-right'>Month</th>
                                                <th class='text-right'>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class='no'>01</td>
                                                <td class='text-left'>
                                                    <h3>Single Month Payment</h3>
                                                </td>
                                                <td class='unit'>$perMonthPrice</td>
                                                <td class='qty'>$totalMonth</td>
                                                <td class='total'>$amount</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan='2'></td>
                                                <td colspan='2'>SUBTOTAL</td>
                                                <td>$amount</td>
                                            </tr>
                                            <tr>
                                                <td colspan='2'></td>
                                                <td colspan='2'>GRAND TOTAL</td>
                                                <td>$amount</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class='thanks'>Thank you!<br/>
                                    <p>vip.translatesubtitles.co</p>
                                 </div>
                                </main>
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <script src='https://code.jquery.com/jquery-3.3.1.js' integrity='sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=' crossorigin='anonymous'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                </body>
                </html>
            ";
    
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
?>