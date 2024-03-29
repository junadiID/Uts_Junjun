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
	if (isset($_GET['oid'])) {
		$post_oid = $_GET['oid'];
		$checkdb_order = mysqli_query($db, "SELECT * FROM orderss WHERE oid = '$post_oid'");
		$datadb_order = mysqli_fetch_assoc($checkdb_order);
	if (mysqli_num_rows($checkdb_order) == 0) {
		header("Location: ".$cfg_baseurl."admin/orderss");
	} else {
	include("../../lib/headeradmin.php");
	}
}
?>

            <div class="row">
                <div class="col-md-offset-2 col-md-8"><a href="<?php echo $cfg_baseurl; ?>admin/orderss.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali Ke Daftar</a><br /><br />
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-eye"></i> Detail Pembelian : <?php echo $datadb_order['oid']; ?></h3>
                                </div>
                		<div class="panel-body">
                               <div class="table-responsive">
				                    <table class="table table-bordered table-striped">
												<tr>
													<td><b>Kode</b></td>
													<td><?php echo $datadb_order['oid']; ?></td>
												</tr>
												<tr>
													<td><b>Kode Provider</b></td>
													<td><?php echo $datadb_order['poid']; ?></td>
												</tr>
												<tr>
													<td><b>Pengguna</b></td>
													<td><?php echo $datadb_order['user']; ?></td>
												</tr>
												<tr>
													<td><b>Produk</b></td>
													<td><?php echo $datadb_order['service']; ?></td>
												</tr>
												<tr>
													<td><b>Data</b></td>
													<td><?php echo $datadb_order['link']; ?></td>
												</tr>
												<tr>
													<td><b>Jumlah</b></td>
													<td><?php echo number_format($datadb_order['quantity'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td><b>Jumlah Kurang</b></td>
													<td><?php echo number_format($datadb_order['remains'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td><b>Jumlah Awal</b></td>
													<td><?php echo number_format($datadb_order['start_count'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td><b>Harga</b></td>
													<td>Rp <?php echo number_format($datadb_order['price'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td><b>Status</b></td>
													<td><?php echo $datadb_order['status']; ?></td>
												</tr>
												<tr>
													<td><b>Tanggal & Waktu</b></td>
													<td><?php echo $datadb_order['date']; ?> (<?php echo $datadb_order['time']; ?>) </td>
												</tr>
												<tr>
													<td><b>Provider</b></td>
													<td><?php echo $datadb_order['provider']; ?></td>
												</tr>
												<tr>
													<td><b>Order Melalui</b></td>
													<td><?php echo $datadb_order['place_from']; ?></td>
												</tr>
												<tr>
													<td><b>Pengembalian Dana</b></td>
													<td><label class="label label-<?php if($data_show['refund'] == 1) { echo "danger"; } else { echo "success"; } ?>"><?php if($data_show['refund'] == 0) { ?>Tidak<?php } else { ?>Tidak<?php } ?></label></td>
												</tr>												

						            </table>
					            </div>
                            </div>
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