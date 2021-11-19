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
		if (isset($_GET['id'])) {
			$post_target = $_GET['id'];
			$check_ticket = mysqli_query($db, "SELECT * FROM tickets WHERE id = '$post_target'");
			$data_ticket = mysqli_fetch_array($check_ticket);
			if (mysqli_num_rows($check_ticket) == 0) {
				header("Location: ".$cfg_baseurl."admin/tickets.php");
			} else {
				include("../../lib/headeradmin.php");
?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-trash"></i> Hapus Tiket</h3>
                                </div>
                		<div class="panel-body">
										<form class="form-horizontal" role="form" method="POST" action="<?php echo $cfg_baseurl; ?>admin/tickets.php">
											<input type="hidden" name="id" value="<?php echo $data_ticket['id']; ?>">
											<div class="form-group">
												<label class="col-md-2 control-label">Subject</label>
												<div class="col-md-10">
													<input type="text" class="form-control" placeholder="Subject" value="<?php echo $data_ticket['subject']; ?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
												<button type="submit" class="btn btn-primary" name="delete"><i class="fa fa-trash"></i> Hapus</button>
											<a href="<?php echo $cfg_baseurl; ?>admin/tickets" class="btn btn-warning"><i class="fa fa-refresh"></i> Kembali</a>
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
			header("Location: ".$cfg_baseurl."admin/tickets.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>