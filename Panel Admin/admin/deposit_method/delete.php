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
			$post_id = $_GET['id'];
			$checkdb_news = mysqli_query($db, "SELECT * FROM deposit_method WHERE id = '$post_id'");
			$datadb_news = mysqli_fetch_assoc($checkdb_news);
			if (mysqli_num_rows($checkdb_news) == 0) {
				header("Location: ".$cfg_baseurl."admin/deposit_method.php");
			} else {
				include("../../lib/headeradmin.php");
?>
 

             <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-trash"></i> Hapus Metode Deposit</h3>
                                </div>
                		<div class="panel-body">
										<form class="form-horizontal" role="form" method="POST" action="<?php echo $cfg_baseurl; ?>admin/deposit_method.php">
											<input type="hidden" name="id" value="<?php echo $datadb_news['id']; ?>">
											<div class="form-group">
												<label class="col-md-2 control-label">Type / Provider</label>
												<div class="col-md-10">
													<input type="text" class="form-control" value="<?php echo $datadb_news['name']; ?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
												    <button type="submit" class="btn btn-primary" name="delete"><i class="fa fa-trash"></i> Hapus </button>		
											        <a href="<?php echo $cfg_baseurl; ?>admin/deposit_method.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
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
			header("Location: ".$cfg_baseurl."admin/deposit_method.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>