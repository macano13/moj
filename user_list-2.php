<?php
require_once('config.php');
require_once(ABSPATH . '/code/post/user-delete.php');
require_once(ABSPATH . '/code/post/user-suspend.php');

include_once("code/template/header.php");

if ($user->user_role != 1) {
    echo "<script>window.location.href ='/upload-file.php';</script>";
}

$userList = db_getUsersList($user->user_role);
?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Users Lists</h3>
				</div>
                <?php if ($success_message  != "") { ?>
					<div class="callout callout-success"><?php echo $success_message; ?></div>
				<?php } ?>
				<?php if ($error_message != "") { ?>
					<div class="callout callout-danger"><?php echo $error_message; ?></div>
				<?php } ?>
				<?php if ($userList) { ?>
					<div class="box-body table-responsive no-padding" style="min-height:80vh">
						<table class="table table-hover">
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Active Status</th>
								<th>Payment Expire Date</th>
								<th>Suspend</th>
								<th>Delete</th>
							</tr>
                            <?php foreach ($userList as $key => $value) { ?>
                                <tr>
                                    <td> <?php echo $key +1; ?> </td>
                                    <td> <?php echo $value->name; ?> </td>
                                    <td> <?php echo $value->email; ?> </td>
                                    <td> <?php echo $value->is_active != 1 ? 'Not Active' : 'active'; ?> </td>
                                    <td> <?php echo $value->expire_date; ?> </td>
                                    <td> 
                                        <form action="user_list.php" method="post" name="userSuspendForm">
											<input type="hidden" name="suspendId" class="suspendId" value="<?php echo $value->id; ?>">
											<button type="submit">
											<?php echo $value->is_active == 2 ? 'UnSuspend' : 'suspend'; ?>
											
											</button>
										</form> 
                                    </td>
									<td> 
                                        <form action="user_list.php" method="post" name="userDeleteForm">
											<input type="hidden" name="deleteid" class="deleteid" value="<?php echo $value->id; ?>">
											<button type="submit"><i class="fa fa-trash"></i></button>
										</form> 
                                    </td>
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