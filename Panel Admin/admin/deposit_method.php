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
		if (isset($_POST['delete'])) {
			$post_id = $_POST['id'];
			$checkdb_news = mysqli_query($db, "SELECT * FROM deposit_method WHERE id = '$post_id'");
			if (mysqli_num_rows($checkdb_news) == 0) {
				$msg_type = "error";
				$msg_content = "×</span></button><b>Gagal:</b> Metode tidak ditemukan.";
			} else {
				$delete_news = mysqli_query($db, "DELETE FROM deposit_method WHERE id = '$post_id'");
				if ($delete_news == TRUE) {
					$msg_type = "success";
					$msg_content = "×</span></button><b>Berhasil:</b> Metode deleted.";
				}
			}
		}

				include("../lib/headeradmin.php");
?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-bank"></i> Data Metode Deposit</h3>
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
										<div class="row">
										<div class="col-md-6">
											<a href="<?php echo $cfg_baseurl; ?>admin/deposit_method/add.php" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Metode</a>
										</div></div>
										<div class="clearfix"></div>
										<br />
										<div class="table-responsive">
											<table class="table table-bordered issue-tracker">
												<thead>
													<tr>
														<th>Nama</th>
														<th>Catatan</th>
														<th>Rate</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
$query_list = "SELECT * FROM deposit_method ORDER BY id DESC"; // edit
$records_per_page = 10; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_show = mysqli_fetch_assoc($new_query)) {
												?>
													<tr>
														<td><?php echo $data_show['name']; ?></td>
														<td><?php echo $data_show['note']; ?></td>
														<td><?php echo $data_show['rate']; ?></td>
														<td align="center">
														<a href="<?php echo $cfg_baseurl; ?>admin/deposit_method/delete.php?id=<?php echo $data_show['id']; ?>" class="btn btn-xs btn-primary btn-bordred"><i class="fa fa-trash"></i></a>
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
						</div>
						<!-- end row -->
<?php
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>