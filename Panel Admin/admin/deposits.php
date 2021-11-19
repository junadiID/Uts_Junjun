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
	} else if ($data_user['level'] != "Developers") {
		header("Location: ".$cfg_baseurl);
	} else {
		if (isset($_POST['accept'])) {
			$post_code = $_POST['code'];
			$checkdb = mysqli_query($db, "SELECT * FROM deposits WHERE code = '$post_code'");
			$datadb = mysqli_fetch_assoc($checkdb);
			if (mysqli_num_rows($checkdb) == 0) {
				$msg_type = "error";
				$msg_content = "×</span></button><b>Gagal:</b> Deposito tidak ditemukan.";
			} elseif ($datadb['status'] != "Pending") {
				$msg_type = "error";
				$msg_content = "×</span></button><b>Gagal:</b> Deposito berstatus ".$datadb['status'].".";
			} else {
				$post_user = $datadb['user'];
				$post_balance = $datadb['balance'];
				$send_balance = mysqli_query($db, "UPDATE users SET balance = balance+$post_balance WHERE username = '$post_user'");
				$update_depo = mysqli_query($db, "UPDATE deposits SET status = 'Success' WHERE code = '$post_code'");
				if ($send_balance == TRUE) {
					$msg_type = "success";
					$msg_content = "×</span></button><b>Berhasil:</b> Permintaan deposito diterima.<br />Kode: $post_code<br />Penerima: $post_user<br />Jumlah Saldo: Rp $post_balance";
				} else {
					$msg_type = "error";
					$msg_content = "×</span></button><b>Gagal:</b> Kesalahan sistem";
				}
			}
		} elseif (isset($_POST['cancel'])) {
			$post_code = $_POST['code'];
			$checkdb = mysqli_query($db, "SELECT * FROM deposits WHERE code = '$post_code'");
			$datadb = mysqli_fetch_assoc($checkdb);
			if (mysqli_num_rows($checkdb) == 0) {
				$msg_type = "error";
				$msg_content = "×</span></button><b>Gagal:</b> Deposito tidak ditemukan.";
			} elseif ($datadb['status'] != "Pending") {
				$msg_type = "error";
				$msg_content = "×</span></button><b>Gagal:</b> Deposito berstatus ".$datadb['status'].".";
			} else {
				$post_user = $datadb['user'];
				$update_depo = mysqli_query($db, "UPDATE deposits SET status = 'Error' WHERE code = '$post_code'");
				if ($update_depo == TRUE) {
					$msg_type = "success";
					$msg_content = "×</span></button><b>Berhasil:</b> Permintaan deposito dibatalkan.<br />Kode: $post_code";
				} else {
					$msg_type = "error";
					$msg_content = "×</span></button><b>Gagal:</b> Kesalahan sistem";
				}
			}
		}

				include("../lib/headeradmin.php");

	// widget
	$check_worder = mysqli_query($db, "SELECT SUM(balance) AS total FROM deposits WHERE status = 'Success'");
	$data_worder = mysqli_fetch_assoc($check_worder);
	$check_worder = mysqli_query($db, "SELECT * FROM deposits WHERE status = 'Success'");
	$count_worder = mysqli_num_rows($check_worder);
?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-bank"></i> Data Deposit</h3>
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
										<div class="table-responsive">
											<table class="table table-bordered issue-tracker table-condense">
												<thead>
													<tr>
														<th>Tanggal</th>
														<th>Kode</th>
														<th>Pengguna</th>
														<th>Metode</th>
														<th>Catatan</th>
														<th>Jumlah</th>
														<th>Saldo didapat</th>
														<th>Status</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$query_list = "SELECT * FROM deposits WHERE code LIKE '%$search%' ORDER BY id DESC"; // edit
} else {
	$query_list = "SELECT * FROM deposits ORDER BY id DESC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_show = mysqli_fetch_assoc($new_query)) {
													if($data_show['status'] == "Pending") {
														$label = "warning";
													} else if($data_show['status'] == "Error") {
														$label = "danger";
													} else if($data_show['status'] == "Success") {
														$label = "success";
													}
												?>
													<tr>
														<td><?php echo $data_show['date']; ?></td>
														<td><?php echo $data_show['code']; ?></td>
														<td><?php echo $data_show['user']; ?></td>
														<td><?php echo $data_show['method']; ?></td>
														<td><?php echo $data_show['note']; ?></td>
														<td>Rp <?php echo number_format($data_show['quantity'],0,',','.'); ?></td>
														<td>Rp <?php echo number_format($data_show['balance'],0,',','.'); ?></td>
														<td><label class="label label-<?php echo $label; ?>"><?php echo $data_show['status']; ?></label></td>
														<td align="center">
														<a href="<?php echo $cfg_baseurl; ?>admin/deposit/accept?code=<?php echo $data_show['code']; ?>" class="btn btn-xs btn-primary"><i class="fa fa-check"></i></a>
														<a href="<?php echo $cfg_baseurl; ?>admin/deposit/cancel.php?code=<?php echo $data_show['code']; ?>" class="btn btn-xs btn-danger btn-bordred"><i class="fa fa-times"></i></a>
														</td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
										</div>											
											<nav aria-label="...">
											  <ul class="pagination">

<?php
// start paging link
$self = $_SERVER['PHP_SELF'];
$query_list = mysqli_query($db, $query_list);
$total_no_of_records = mysqli_num_rows($query_list);
echo "<li class='page-item disabled'><a class='page-link' href='#'>Total: ".$total_no_of_records."</a></li>";
if($total_no_of_records > 0) {
	$total_no_of_pages = ceil($total_no_of_records/$records_per_page);
	$current_page = 1;
	if(isset($_GET["page_no"])) {
		$current_page = $_GET["page_no"];
	}
	if($current_page != 1) {
		$previous = $current_page-1;
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=1'>← First</a></li>";
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$previous."'>Previous</a></li>";
	}
	for($i=1; $i<=$total_no_of_pages; $i++) {
		if($i==$current_page) {
			echo "<li class='page-item active'><a class='page-link' href='".$self."?page_no=".$i."'>".$i." <span class='sr-only'>(current)</span></a></li>";
			} else {
			echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$i."'>".$i."</a></li>";
		}
		}
	if($current_page!=$total_no_of_pages) {
		$next = $current_page+1;
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$next."'>Next</a></li>";
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$total_no_of_pages."'>Last →</a></li>";
			}
}
// end paging link
											?>
											  </ul>
											</nav>
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