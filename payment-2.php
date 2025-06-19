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
    <section>
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