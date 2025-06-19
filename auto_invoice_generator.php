<?php

    // ** MySQL settings - You can get this info from your web host ** //
    /** The name of the database for WordPress */
    define('DB_NAME', 'c1zvizdoDB');

    /** MySQL database username */
    define('DB_USER', 'c1uploading1');

    /** MySQL database password */
    define('DB_PASSWORD', '#Stomornjak111');

    /** MySQL hostname */
    define('DB_HOST', 'localhost');

    define('APP_DEBUG', FALSE);

    if (!defined('ABSPATH'))
        define('ABSPATH', dirname(__FILE__));


    // require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
    require '/mnt/volume-fsn1-1/web/vendor/autoload.php';
    require_once(ABSPATH . '/code/system/db_helper/shared/ez_sql_core.php');
    require_once(ABSPATH . '/code/system/db_helper/mysqli/ez_sql_mysqli.php');
    require_once(ABSPATH . '/code/system/web-helper.php');
    
    require_once('code/db/db-helper.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $todaysDate =  Date("Y-m-d");
    $userLists = getDuePaymentUser($todaysDate);

    $payAmount = db_payAmount();
    $perMonthPrice = $payAmount->pay_amount;

   
    foreach ($userLists as $key => $value) {
        
        $randomString = substr(sha1(rand()), 0, 8);
        $inVoiceId = "UBF".$value->id.$randomString;

        $count = db_checkInvoiceExistStatus($value->id);

        if ($count == '') {
            echo $value->id;
            $resUser = db_updateUser($value->id,0,$value->expire_date);
          
            $res = db_insertInvoicesDetails($value->id,$inVoiceId,$perMonthPrice,null,null);
          
            if ($res) {
                sendingMail($value->name,$value->email,'',$perMonthPrice,1,$perMonthPrice);
                echo json_encode(array('success' => 'Operation successfully completed!'));
            }else{
                echo json_encode(array('success' => 'Operation failed!'));
            }
        }
    }

    function sendingMail($name,$email,$paymentDate,$perMonthPrice,$totalMonth,$amount)
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
            $mail->setFrom('no_reply@translatesubtitles.com', 'VIP New Invoice');
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
                            <h4 class='text-center'>Please pay your monthly invoice</h4>
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