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
		if (isset($_POST['add'])) {
			$post_name = $_POST['name'];
			$post_note = $_POST['note'];
			$post_rate = $_POST['rate'];

			if (empty($post_name) OR empty($post_note)) {
				$msg_type = "error";
				$msg_content = "×</span></button><b>Gagal:</b> Mohon mengisi semua input.";
			} else {
				$insert_news = mysqli_query($db, "INSERT INTO deposit_method (name, note, rate) VALUES ('$post_name', '$post_note', '$post_rate')");
				if ($insert_news == TRUE) {
					$msg_type = "success";
					$msg_content = "×</span></button><b>Berhasil:</b> Metode berhasil ditambah.";
				} else {
					$msg_type = "error";
					$msg_content = "×</span></button><b>Gagal:</b> Error system.";
				}
			}
		}

	include("../../lib/headeradmin.php");
?>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-plus"></i> Tambah Metode Deposit</h3>
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
										<form class="form-horizontal" role="form" method="POST">
											<div class="form-group">
												<label class="col-md-2 control-label">Type / Provider</label>
												<div class="col-md-10">
													<input type="text" name="name" class="form-control" placeholder="BANK BCA">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Catatan</label>
												<div class="col-md-10">
													<input type="text" name="note" class="form-control" placeholder="BCA 123456789 A/N Pemilik Rekening">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Rate / Kurs</label>
												<div class="col-md-10">
													<input type="text" name="rate" class="form-control" placeholder="0.8">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
												    <button type="submit" class="btn btn-primary" name="add"><i class="fa fa-send"></i> Tambah </button>		
											        <a href="<?php echo $cfg_baseurl; ?>admin/deposit_method.php" class="btn btn-warning btn-bordred waves-effect w-md waves-light"><i class="fa fa-refresh"></i> Kembali </a>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
<?php
	include("../../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>