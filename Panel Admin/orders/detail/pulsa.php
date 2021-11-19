<?php
session_start();
require("../../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	} else {
		if (isset($_GET['oid'])) {
			$post_oid = $_GET['oid'];
			$checkdb_order = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE oid = '$post_oid'");
			$datadb_order = mysqli_fetch_assoc($checkdb_order);
			if ($datadb_order['refund'] == 1) {
			    $count_refund = $datadb_order['price'];
		    $total_refund = $count_refund;
			} 
			if($datadb_order['status'] == "Pending") {
				$label = "warning";
			} else if($datadb_order['status'] == "Processing") {
				$label = "info";
			} else if($datadb_order['status'] == "Error") {
				$label = "danger";
			} else if($datadb_order['status'] == "Partial") {
				$label = "danger";
			} else if($datadb_order['status'] == "Success") {
				$label = "primary";
			}
			if (mysqli_num_rows($checkdb_order) == 0) {
				header("Location: ".$cfg_baseurl."orders/history/pulsa");
			} else {
				include("../../lib/header.php");
?>
										
		    <div class="row">
		    	<div class="col-md-12">
             <div class="card">
	          <div class="card-body">
	          
                <h3 class="card-title">
                                    <h5><i class="fa fa-eye"></i> Detail Pemesanan | <?php echo $datadb_order['oid']; ?></h5>
                                </div>
                                    <div class="card-body">
                	                    <div class="table-responsive">
                                            <table class="table table-stripped" data-page-size="8" data-filter=#filter>
                                                
                                                <tr>
													<td><b>ID Pesanan</b></td>
													<td><code><?php echo $datadb_order['oid']; ?></code></td>
												</tr>
												<tr>
													<td><b>Pembelian</b></td>
													<td><?php echo $datadb_order['service']; ?></td>
												</tr>
												<tr>
													<td><b>Nomer HP</b></td>
													<td><?php echo $datadb_order['phone']; ?></td>
												</tr>
												<tr>
													<td><b>Nomer Meter</b></td>
													<td><?php echo $datadb_order['nometer']; ?></td>
												</tr>
												<tr>
													<td><b>Harga</b></td>
													<td>Rp <?php echo number_format($datadb_order['price'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td><b>Status</b></td>
													<td><label class="label label-<?php echo $label; ?>"><?php echo $datadb_order['status']; ?></label></td>
												</tr>
												<tr>
													<td><b>Refund</b></td>
													<td><label class="label label-<?php if($datadb_order['refund'] == 0) { echo "danger"; } else { echo "primary"; } ?>"><?php if($datadb_order['refund'] == 0) { ?>Tidak<?php } else { ?> Ya (Refunded Rp <?php echo number_format($total_refund); ?>)<?php } ?></label> </td>
												</tr>
												<tr>
													<td><b>IP Statis</b></td>
													<td><?php echo $datadb_order['ip']; ?></td>
						 						</tr>
												<tr>
													<td><b>Tanggal Pembelian</b></td>
													<td><?php echo $datadb_order['date']; ?></td>
						 						</tr>
						                    </table>
						                    <a href="<?php echo $cfg_baseurl; ?>orders/history/pulsa" class="btn btn-success m-b-10"><i class="fa fa-arrow-left"></i> Kembali</a>
					                    </div>
                                    </div>
                    </div>
                </div>
            </div>
<?php
				include("../../lib/footer.php");
			}
		} else {
			header("Location: ".$cfg_baseurl."orders/history/pulsa");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>