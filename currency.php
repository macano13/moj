<?php
require_once('config.php');

require_once(ABSPATH . '/code/post/currency_set.php');

include_once("code/template/header.php");

if ($user->user_role != 1) {
    echo "<script>window.location.href ='/upload-file.php';</script>";
}

$payamentcurrencyLists = db_payamountList();
// echo "<pre>";
// print_r($payamentcurrencyLists);
// die;
?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Set Currency</h3>
				</div>
               
				<?php if ($payamentcurrencyLists) { ?>
					<div class="box-body table-responsive no-padding" style="min-height:80vh">
						<table class="table table-hover">
							<tr>
								<th>ID</th>
								<th>Currency Name</th>
								<th>Value</th>
								<th>Default</th>
								<th>Set Default</th>
							</tr>
                            <?php foreach ($payamentcurrencyLists as $key => $value) { ?>
                                <tr>
									<form action="currency.php" method="post">
										<td> <?php echo $key +1; ?> </td>
										<td><?php echo $value->currency_name; ?></td>
										<td>
											<input type="text" value="<?php echo $value->pay_amount; ?>" name="currencyAmount"/>
										</td>
										<td> <?php echo $value->default_status == 0 ? 'Not default' : 'Default'; ?> </td>
										<td>
											<input type="hidden" name="currencyId" value="<?php echo $value->id; ?>">
											<button type="submit" <?php echo $value->default_status == 0 ? '' : 'disabled'; ?>>
												Set Default
											</button>
										</td>
									</form>
                                   
                                </tr>
                            <?php } ?>
						</table>
					</div>
				<?php } ?>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>



<?php
include_once("code/template/footer.php");
?>