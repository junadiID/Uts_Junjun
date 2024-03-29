<?php

session_start();
require("../../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['level'] != "Developers") {
		header("Location: ".$cfg_baseurl);
	} else {
		if (isset($_GET['code'])) {
			$post_code = $_GET['code'];
			$checkdb_order = mysqli_query($db, "SELECT * FROM deposits WHERE code = '$post_code' AND status NOT IN ('Success','Error')");
			$datadb_order = mysqli_fetch_assoc($checkdb_order);
			if (mysqli_num_rows($checkdb_order) == 0) {
				header("Location: ".$cfg_baseurl."admin/deposits");
			} else {
				include("../../lib/headeradmin.php");
?>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-times-circle"></i> Tolak Permintaan Deposit</h3>
                                </div>
                		<div class="panel-body">
										<?php 
										if ($msg_type == "success") {
										?>
										<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><?php echo $msg_content; ?></div>
										<?php
										} else if ($msg_type == "error") {
										?>
										<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><?php echo $msg_content; ?></div>
										<?php
										}
										?>
										<form class="form-horizontal" role="form" method="POST" action="<?php echo $cfg_baseurl; ?>admin/deposits">
											<div class="form-group">
												<label class="col-md-2 control-label">Faktur</label>
												<div class="col-md-10">
													<input type="text" class="form-control" value="<?php echo $datadb_order['code']; ?>" name="code" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Tujuan</label>
												<div class="col-md-10">
													<input type="text" class="form-control" value="<?php echo $datadb_order['user']; ?>" name="user" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Saldo Didapat</label>
												<div class="col-md-10">
													<input type="text" class="form-control" value="<?php echo $datadb_order['balance']; ?>" name="balance" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
												    <button type="submit" class="btn btn-primary" name="cancel"><i class="fa fa-times-circle"></i> Tolak </button>		
											        <a href="<?php echo $cfg_baseurl; ?>admin/deposits" class="btn btn-warning"><i class="fa fa-refresh"></i> Kembali </a>
												</div>
											</div>											
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
				include("../../lib/footer.php");
			}
		} else {
			header("Location: ".$cfg_baseurl."admin/deposits.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>