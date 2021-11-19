<?php
session_start();
require("../../mainconfig.php");
$page_type = "sosmed";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	}

	include("../../lib/header.php");
?>

			<div class="row">
			    <div class="col-md-12">
             <div class="card">
	          <div class="card-body">
	          
                <h3 class="card-title">
                                    <h5><i class="fa fa-history"></i> Riwayat Pemesanan Media Sosial</h5>
                                </div>
                                    <div class="card-body">
										<div class="alert alert-success">
											<i class="fa fa-check"></i> : Ya.<br />
											<i class="fa fa-times"></i> : Tidak.<hr>
							                Klik <i class="fa fa-eye"></i> atau <b>Detail</b> untuk melihat detail pesanan.
										</div>
										<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									    <div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<div class="input-group">
													<select class="form-control" name="status">
														<option value="">Semua</option>
														<option value="Pending">Pending</option>
														<option value="Processing">Processing</option>
														<option value="Partial">Partial</option>
														<option value="Error">Error</option>
														<option value="Success">Success</option>
																				    </select>
													<span class="input-group-btn">
														<button class="btn btn-default" title="Sortir" type="submit"><i class="fa fa-sort"></i></button>
													</span>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<div class="input-group">
													<input type="text" class="form-control" id="filter" name="search" placeholder="Cari id pesanan atau data target...">
													<span class="input-group-btn">
														<button class="btn btn-default" title="Cari" type="submit"><i class="fa fa-search"></i></button>
													</span>
												</div>
											</div>
										</div>
									</div>
								</form>
										<div class="table-responsive">
                                            <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
										        <thead>
											        <tr>
														<th></th>
														<th>ID Pesanan</th>
														<th>Layanan</th>
														<th>Data</th>
														<th>Jumlah</th>
														<th>Harga</th>
														<th>Status</th>
														<th>API</th>
														<th>Refund</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
if (isset($_GET['search']) AND isset($_GET['status'])) {
	$search = $_GET['search'];
	$status = $_GET['status'];
	if (!empty($_GET['search']) AND !empty($_GET['status'])) {
	   $query_list = "SELECT * FROM orderss WHERE link LIKE '%$search%' OR oid LIKE '%$search%' AND status LIKE '%$status%' AND user = '$sess_username' ORDER BY id DESC"; // edit
	} else if (empty($_GET['search'])) {
	   $query_list = "SELECT * FROM orderss WHERE status LIKE '%$status%' AND user = '$sess_username' ORDER BY id DESC"; // edit 
	} else if (empty($_GET['status'])) {
	   $query_list = "SELECT * FROM orderss WHERE link LIKE '%$search%' OR oid LIKE '%$search%' AND user = '$sess_username' ORDER BY id DESC"; // edit 
	} else {
	    $query_list = "SELECT * FROM orderss WHERE user = '$sess_username' ORDER BY id DESC"; // edit
	}
} else {
    $query_list = "SELECT * FROM orderss WHERE user = '$sess_username' ORDER BY id DESC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_order = mysqli_fetch_assoc($new_query)) {
													if($data_order['status'] == "Pending") {
														$label = "warning";
													} else if($data_order['status'] == "Processing") {
														$label = "info";
													} else if($data_order['status'] == "Error") {
														$label = "danger";
													} else if($data_order['status'] == "Partial") {
														$label = "danger";
													} else if($data_order['status'] == "Success") {
														$label = "primary";
													}
												?>
													<tr class="odd gradeX">
														<td><a href="<?php echo $cfg_baseurl; ?>orders/detail/sosmed2?oid=<?php echo $data_order['oid']; ?>" class="btn btn-primary btn-xs dim" title="Detail"><i class="fa fa-eye"></i></a></td>	
														<td><?php echo $data_order['oid']; ?></td>
														<td><?php echo $data_order['service']; ?></td>
														<td><?php echo $data_order['link']; ?></td>
														<td><?php echo number_format($data_order['quantity'],0,',','.'); ?></td>
														<td>Rp <?php echo number_format($data_order['price'],0,',','.'); ?></td>
														<td align="center"><label class="label label-<?php echo $label; ?>"><?php echo $data_order['status']; ?></label></td>					<td><?php if($data_order['place_from'] == "API") { ?><label class="label label-primary"><i class="fa fa-check"></i></label><?php } else { ?><label class="label label-danger"><i class="fa fa-times"></i></label><?php } ?></td>
														<td><?php if($data_order['refund'] == 1) { ?><label class="label label-primary"><i class="fa fa-check"></i></label><?php } else { ?><label class="label label-danger"><i class="fa fa-times"></i></label><?php } ?></td>
													</tr>
												<?php
												}
												?>
										</tbody>
										
											</table>
											
					            </div>
											<div class="table-responsive">
										<nav class="m-t-20">
											<ul class="pagination">
											<?php
// start paging link
$self = $_SERVER['PHP_SELF'];
$query_list = mysqli_query($db, $query_list);
$total_records = mysqli_num_rows($query_list);
echo "<li class='page-item disabled'><a href='#' class='page-link'>Total: ".$total_records."</a></li>";
if($total_records > 0) {
	$total_pages = ceil($total_records/$records_per_page);
	$current_page = 1;
	if(isset($_GET["page_no"])) {
		$current_page = $_GET["page_no"];
		if ($current_page < 1) {
			$current_page = 1;
		}
	}
	if($current_page > 1) {
		$previous = $current_page-1;
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=1'>← First</a></li>";
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$previous."'><i class='fa fa-angle-left'></i> Previous</a></li>";
	}
	// limit page
	$limit_page = $current_page+3;
	$limit_show_link = $total_pages-$limit_page;
	if ($limit_show_link < 0) {
		$limit_show_link2 = $limit_show_link*2;
		$limit_link = $limit_show_link - $limit_show_link2;
		$limit_link = 3 - $limit_link;
	} else {
		$limit_link = 3;
	}
	$limit_page = $current_page+$limit_link;
	// end limit page
	// start page
	if ($current_page == 1) {
		$start_page = 1;
	} else if ($current_page > 1) {
		if ($current_page < 4) {
			$min_page  = $current_page-1;
		} else {
			$min_page  = 3;
		}
		$start_page = $current_page-$min_page;
	} else {
		$start_page = $current_page;
	}
	// end start page
	for($i=$start_page; $i<=$limit_page; $i++) {
		if($i==$current_page) {
			echo "<li class='page-item active'><a class='page-link' href='".$self."?page_no=".$i."'>".$i."</a></li>";
		} else {
			echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$i."'>".$i."</a></li>";
		}
	}
	if($current_page!=$total_pages) {
		$next = $current_page+1;
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$next."'>Next <i class='fa fa-angle-right'></i></a></li>";
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$total_pages."'>Last →</a></li>";
	}
}
// end paging link
											?>
										
										
                            </div>
                            </div>
					            </div>
				            </div>
			            </div>
			            	</ul>
										</nav>
						<!-- end row -->
<?php
	include("../../lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>