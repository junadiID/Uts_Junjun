<?php
session_start();
require("../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['level'] == "Admin" OR $data_user['level'] == "Reseller" OR $data_user['level'] == "Agen" OR $data_user['level'] == "Member") {
		header("Location: ".$cfg_baseurl);
	} else {
		$post_balance = $cfg_admin_bonus; // bonus Admin
		$post_price = $cfg_admin_price; // price Admin for registrant
		if (isset($_POST['add'])) {
			$post_fullname = $_POST['fullname'];			
			$post_username = trim($_POST['username']);
			$post_password = $_POST['password'];
			$post_email = $_POST['email'];

			$checkdb_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
			$datadb_user = mysqli_fetch_assoc($checkdb_user);
			if (empty($post_username) || empty($post_password)) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
			} else if (mysqli_num_rows($checkdb_user) > 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Username $post_username sudah terdaftar dalam database.";
			} else if ($data_user['balance'] < $post_price) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Saldo Anda tidak mencukupi untuk melakukan pendaftaran Admin.";
			} else {
				$post_api = random(20);
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$post_price WHERE username = '$sess_username'");
                $insert_user = mysqli_query($db, "INSERT INTO balance_history (username, action, quantity, msg, date, time) VALUES ('$sess_username', 'Cut Balance', 'Saldo dipotong untuk Penambahan user : $post_username', '$date', 'time')");				
				$insert_user = mysqli_query($db, "INSERT INTO users (fullname, username, password, balance, level, registered, status, api_key, email, uplink) VALUES ('$post_fullname', '$post_username', '$post_password', '$post_balance', 'Reseller', '$date', 'Active', '$post_api', '$post_email', '$sess_username')");
				if ($insert_user == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Admin telah ditambahkan.<br /><b>Username:</b> $post_username<br /><b>Password:</b> $post_password<br /><b>Level:</b> Admin <br /><b>Saldo:</b> Rp ".number_format($post_balance,0,',','.');
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system.";
				}
			}
		}

	include("../lib/header.php");
?>

            <div class="row">
                <div class="col-md-7">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-user-plus"></i> Tambah Admin</h3>
                                </div>
                		<div class="panel-body">
										<?php 
										if ($msg_type == "success") {
										?>
										<div class="alert alert-success">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
											<i class="fa fa-check-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										} else if ($msg_type == "error") {
										?>
										<div class="alert alert-danger">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
											<i class="fa fa-times-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										}
										?>
										<form class="form-horizontal" role="form" method="POST">
											<div class="form-group">
												<label class="col-md-2 control-label">Nama Lengkap</label>
												<div class="col-md-10">
													<input type="text" name="fullname" class="form-control" placeholder="Nama Lengkap">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">E-Mail</label>
												<div class="col-md-10">
													<input type="text" name="email" class="form-control" placeholder="E-Mail Aktif">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Username</label>
												<div class="col-md-10">
													<input type="text" name="username" class="form-control" placeholder="Username">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Password</label>
												<div class="col-md-10">
													<input type="text" name="password" class="form-control" placeholder="Password">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
												<button type="submit" class="btn btn-primary" name="add"><i class="fa fa-send"></i> Submit</button>
												<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>Ulangi</button>
											</div>
										</div>
										</form>
									</div>
								</div>
							</div>
                <div class="col-md-5">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-warning"></i> Perhatian</h3>
                                </div>
                		<div class="panel-body">
                                    	<ul>
                                    		<li>Pastikan saldo anda cukup untuk melakukan pendaftaran Admin.</li>
                                    		<li>Saldo Anda terpotong Rp <?php echo number_format($post_price,0,',','.'); ?> untuk 1x pendaftaran Admin.</li>
                                    		<li>Admin baru akan mendapat saldo Rp. <?php echo number_format($post_balance,0,',','.'); ?>.</li><hr>
                                    		<li><font color="red">*Admin tidak bertanggung jawab atas kesalahan pengguna</font></li>
                                    	</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>