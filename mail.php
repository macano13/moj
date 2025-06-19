<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'server.macanovic.net';                    // Set the SMTP server to send through
        $mail->AuthType   = 'LOGIN';
        $mail->SMTPAuth   = True;                                   // Enable SMTP authentication
        $mail->Username   = 'no_reply@translatesubtitles.com';                     // SMTP username
        $mail->Password   = 'musica111';                               // SMTP password
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
        $mail->setFrom('no_reply@translatesubtitles.com', 'Mailer');
        $mail->addAddress('iotait.dev@gmail.com', 'IOATIT');     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Payment Invoice mail';
        $mail->Body    = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
                <title>Document</title>
                <style>
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
                        color: #3989c6
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
                        color: #3989c6;
                        font-size: 1.2em
                    }
            
                    .invoice table .qty,.invoice table .total,.invoice table .unit {
                        text-align: right;
                        font-size: 1.2em
                    }
            
                    .invoice table .no {
                        color: #fff;
                        font-size: 1.6em;
                        background: #3989c6
                    }
            
                    .invoice table .unit {
                        background: #ddd
                    }
            
                    .invoice table .total {
                        background: #3989c6;
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
                        color: #3989c6;
                        font-size: 1.4em;
                        border-top: 1px solid #3989c6
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
                <div id="invoice">
                    <div class="invoice overflow-auto">
                        <div style="min-width: 600px">
                            <main>
                                <div class="row contacts">
                                    <div class="col invoice-to">
                                        <div class="text-gray-light">INVOICE TO:</div>
                                        <h2 class="to">John Doe</h2>
                                        <div class="email"><a href="mailto:john@example.com">john@example.com</a></div>
                                    </div>
                                    <div class="col invoice-details">
                                        <h1 class="invoice-id">INVOICE</h1>
                                        <div class="date">Date of Invoice: 01/10/2018</div>
                                    </div>
                                </div>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">DESCRIPTION</th>
                                            <th class="text-right">Month PRICE</th>
                                            <th class="text-right">Month</th>
                                            <th class="text-right">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="no">04</td>
                                            <td class="text-left">
                                                <h3>Youtube channel</h3>
                                            to improve your Javascript skills. Subscribe and stay tuned :)
                                            </td>
                                            <td class="unit">$0.00</td>
                                            <td class="qty">100</td>
                                            <td class="total">$0.00</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">SUBTOTAL</td>
                                            <td>$5,200.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">GRAND TOTAL</td>
                                            <td>$6,500.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="thanks">Thank you!</div>
                            </main>
                        </div>
                        <div></div>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            </body>
            </html>
        ';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "here";
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>