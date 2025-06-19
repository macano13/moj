<?php
    require_once('config.php');
    require_once(ABSPATH . '/code/post/payment-request.php');
    require_once(ABSPATH . '/code/post/download-pdf.php');

    include_once("code/template/header.php");

    $user = getUserFromSession();
    $userId = $user->id;
    $invocieLists = db_getInvoiceByUser($userId);
?>
<style>
th {
    text-shadow: 5px 4px 8px grey!important;
}
.btn-primary {
  box-shadow: 5px 4px 8px grey!important;
}
</style>
<style>
        /* Stil za pozadinsku senku */
        #popupOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        /* Stil za pop-up prozor */
        #popupWindow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            width: 300px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

 /* Stil za "X" dugme */
        #closeButton {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }
        
        #closeButton:hover {
            color: #000;

        }
    </style>
    <section>
<div id="popupOverlay">
    <div id="popupWindow">
 <span id="closeButton">&times;</span> <!-- Dodato "X" dugme -->
        <p>There are small problems regarding payment, and if you make a payment and cannot access the VIP area, please contact us, we are working on a new payment system.</p><p> translatesubs@gmail.com</p>
    </div>
</div>

        <div class="jumbotron">
            <div class="container">
                <h5 class="text-center ml7">
				<span class="text-wrapper">
				<span class="letters">Please pay the invoice via Paypal to continue using our service.</span></span></h5>
                <div class="text-center" id="paypalBtn">
                    <form action="payment.php" method="post" style="max-width: max-content;display: inline-block;">
                        <input type="hidden" name="paymentSystem">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Pay with Paypal</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="invoiceList">
        <div class="container" style="overflow-x:auto;">
            <table  class="table table-responsive">
                <tr>
                    <th>Date</th>
                    <th>Invoice Id</th>
                    <th>Payment Status</th>
                    <th>Download</th>
                    <th>Payment Date</th>
                    <th>Transaction Id</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <?php if($invocieLists) { ?>
                        <?php foreach ($invocieLists as $key => $value) { ?>
                            <tr>
                                <td> <?php echo $key +1; ?> </td>
                                <td> <?php echo $value->invoice_id; ?> </td>
                                <td class="text-center alert <?php echo $value->last_trans_id != '' ? 'alert-success' : 'alert-danger'?>">
                                    <?php 
                                        echo $value->last_trans_id != '' ? 'Paid' : 'Unpaid';
                                    ?>
                                </td>
                                <td>
                                    <form action="payment.php" method="post" name="downloadPdfId">
                                        <input type="hidden" name="downloadPdfId" class="downloadPdfId" value="<?php echo $value->id; ?>">
                                        <button type="submit"><i class="fa fa-file-pdf-o"></i></button>
                                    </form>
                                </td>
                                <td> <?php echo $value->payment_date; ?> </td>
                                <td> <?php echo $value->last_trans_id; ?> </td>
                                <td> <?php echo $value->amount; ?> </td>
                            </tr>
                            <?php } ?>
                    <?php } ?>
                </tr>
            </table>
        </div>
    </section>
<script>
    // Funkcija za prikaz pop-up prozora
    function showPopup() {
        document.getElementById('popupOverlay').style.display = 'block';

        // Zatvara pop-up prozor nakon 10 sekundi
        setTimeout(function() {
            document.getElementById('popupOverlay').style.display = 'none';
        }, 20000); // 20000 ms = 20 sekundi
    }

    // Pozivanje funkcije pri učitavanju stranice
    window.onload = function() {
        showPopup();
    };

// Dodavanje događaja za "X" dugme da zatvori pop-up
    document.getElementById('closeButton').onclick = closePopup;
</script>
	<script>
// Wrap every letter in a span
var textWrapper = document.querySelector('.ml7 .letters');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({loop: true})
  .add({
    targets: '.ml7 .letter',
    translateY: ["1.1em", 0],
    translateX: ["0.55em", 0],
    translateZ: 0,
    rotateZ: [180, 0],
    duration: 850,
    easing: "easeOutExpo",
    delay: (el, i) => 50 * i
  }).add({
    targets: '.ml7',
    opacity: 0,
    duration: 2000,
    easing: "easeOutExpo",
    delay: 9000
  });
</script>

<?php include_once("code/template/footer.php");?>