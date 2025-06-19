<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
    require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

    use PayPal\Rest\ApiContext;
    use PayPal\Auth\OAuthTokenCredential;
    use PayPal\Api\Payer;
    use PayPal\Api\Item;
    use PayPal\Api\ItemList;
    use PayPal\Api\Amount;
    use PayPal\Api\Transaction;
    use PayPal\Api\RedirectUrls;
    use PayPal\Api\Payment;
    use PayPal\Exception\PayPalConnectionException;

    $baseUrl = 'http://vip.translatesubtitles.co/';
    if (IS_POST() && isset($_POST['paymentSystem'])) {

        \PayPal\Core\PayPalConfigManager::getInstance()->addConfigs(['mode' => 'live' /*or "sandbox" */]) ;
        
        $month = 1;

        $paymentInfo = db_payAmount();

        $currency = $paymentInfo->currency_name;
        $monhtlyAmount = $paymentInfo->pay_amount;
      
        $totalAmount = $monhtlyAmount * $month;

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AZQRVZJODpUcv88zYC0RXZZJurJX5mIsOg3z-g9ev5RfR3s3xbK33ZehxEl-zJNqkjlYubVjujmx08cw',     // ClientID
                'EJ8IS9Xi_e3YavVcH_SdfFPVejbETAghfSwgSlhw-0XhVFlIEzL4b7ydr7Q1gM1PgnW4QXKHG4DHl-cc'      // ClientSecret
            )
        );

        // sandbox configuration
        
        // $apiContext = new ApiContext(
        //     new OAuthTokenCredential(
        //         'AbEIuM-3NRh0ZHAisZWBqibWhPS4QxYaptjbAIMskonUDwg0WmSbO7nGY2zxSmQkdrVmMaryDx8ZhB4j',     // ClientID
        //         'ED5bYt7mgkSxV-RCCpVYUOfXIhi9yeNO5Bgq6pQoWquo1jAzK_fS3S6VmYEkdVRGxbjKDyRzqYv3CCZs'      // ClientSecret
        //     )
        // );

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $item1->setName('Payment')
            ->setCurrency($currency)
            ->setQuantity($month)
            ->setPrice($monhtlyAmount);
        
        $itemList = new ItemList();
        $itemList->setItems(array($item1));

       
        $amount = new Amount();
        $amount->setCurrency($currency)
            ->setTotal($totalAmount);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($baseUrl."code/post/payment-process.php")
            ->setCancelUrl($baseUrl."code/post/payment-failed.php");
        

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($apiContext);

        // echo "<pre>";
        // print_r($payment);
        // die('here');

        header('Location:'. $payment->getApprovalLink()); 
    }
?>