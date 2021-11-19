 <?php
session_start();
require("../mainconfig.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['level'] == "Server") {
		header("Location: ".$cfg_baseurl."wrong");	
	}

	include("../lib/header.php");
	$msg_type = "nothing";

	if (isset($_POST['order'])) {
		$post_service = $_POST['service'];
		$post_quantity = $_POST['quantity'];
		$post_link = trim($_POST['link']);
		$post_category = $_POST['category'];
		$check_service = mysqli_query($db, "SELECT * FROM servicess WHERE sid = '$post_service' AND status = 'Active'");
		$data_service = mysqli_fetch_assoc($check_service);

        $check_orders = mysqli_query($db, "SELECT * FROM orderss WHERE link = '$post_link' AND status IN ('Pending','Processing')");
        $data_orders = mysqli_fetch_assoc($check_orders);
		$rate = $data_service['price'] / 1000;
		$price = $rate*$post_quantity;
		$oid = S2.-random_number(3).random_number(3);
		$service = $data_service['service'];
		$provider = $data_service['provider'];
		$pid = $data_service['pid'];

		$check_provider = mysqli_query($db, "SELECT * FROM provider WHERE code = '$provider'");
		$data_provider = mysqli_fetch_assoc($check_provider);
		
		if (empty($post_service) || empty($post_link) || empty($post_quantity)) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Mohon mengisi input.";
		
		} else if (mysqli_num_rows($check_orders) == 1) {
		    $msg_type = "error";
		    $msg_content = "<b>Gagal:</b> Terdapat Orderan Username Yang Sama Dan berstatus Pending/Processing.";
		} else if (mysqli_num_rows($check_service) == 0) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Layanan tidak ditemukan.";
		} else if (mysqli_num_rows($check_provider) == 0) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Server Maintenance.";
		} else if ($post_quantity < $data_service['min']) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Jumlah minimal adalah ".$data_service['min'].".";
		} else if ($post_quantity > $data_service['max']) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Jumlah maksimal adalah ".$data_service['max'].".";
		} else if ($data_user['balance'] < $price) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Saldo Anda tidak mencukupi untuk melakukan pembelian ini.";
		} else {

			
					// api data
			$link = $data_provider['link'];
			$key = $data_provider['api_key'];
			// end api data

			if ($provider == "MANUAL") {
                $api_postdata = "";
            } else if ($provider == "SPETRMEDIA-S2") {
                $postdata = "key=$key&action=order&service=$pid&link=$post_link&quantity=$post_quantity";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $link);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $chresult = curl_exec($ch);
                curl_close($ch);
                $json_result = json_decode($chresult);
            } else {
                die("System Error!");
            }
 
            if ($provider == "SPETRMEDIA-S2" AND $json_result->error == TRUE) {
                $msg_type = "error";
                $msg_content = "<b>Gagal:</b> ".$json_result->error;
            } else {
                if ($provider == "SPETRMEDIA-S2") {
                    $poid = $json_result->id;
                    
                } else if ($provider == "MANUAL") {
                    $poid = $oid;
                }
				
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
				if ($update_user == TRUE) {
					$insert_order = mysqli_query($db, "INSERT INTO orderss (oid, poid, user, service, link, quantity, price, status, date, provider, place_from) VALUES ('$oid', '$poid', '$sess_username', '$service', '$post_link', '$post_quantity', '$price', 'Pending', '$date', '$provider', 'WEB')");
					
					if ($insert_order == TRUE) {
						$msg_type = "success";
						$msg_content = "<b>Pesanan telah diterima.</b><br /><b>Layanan:</b> $service<br /><b>Link:</b> $post_link<br /><b>Jumlah:</b> ".number_format($post_quantity,0,',','.')."<br /><b>Biaya:</b> Rp ".number_format($price,0,',','.');
					} else {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Error system (2).";
					}
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system (1).";
				}
			}
		}
	}
	
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
?>
<?php
$hariini = date("d-m-Y");
?>
						<div class="row">
                            <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h3 class="panel-title"> Pemesanan Baru</h3>
				                  </div>
									<div class="card-body">
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
												<label class="col-md-12 control-label">Kategori</label>
												<div class="col-md-12">
													<select class="form-control" id="category" name="category">
														<option value="0">Pilih salah satu...</option>
														<?php
														$check_cat = mysqli_query($db, "SELECT * FROM service_catt ORDER BY name ASC");
														while ($data_cat = mysqli_fetch_assoc($check_cat)) {
														?>
														<option value="<?php echo $data_cat['code']; ?>"><?php echo $data_cat['name']; ?></option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-12 control-label">Layanan</label>
												<div class="col-md-12">
													<select class="form-control" name="service" id="service">
														<option value="0">Pilih kategori...</option>
													</select>
												</div>
											</div>
											<div id="note">
											</div>
											<div class="form-group">
												<label class="col-md-12 control-label">Link/Target</label>
												<div class="col-md-12">
													<input type="text" name="link" class="form-control" placeholder="Link/Username Target">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-12 control-label">Jumlah</label>
												<div class="col-md-12">
													<input type="number" name="quantity" class="form-control" placeholder="Jumlah" onkeyup="get_total(this.value).value;">
												</div>
											</div>
											
											<input type="hidden" id="rate" value="0">
											<div class="form-group">
												<label class="col-md-12 control-label">Total Harga</label>
												<div class="col-md-12">
													<input type="number" class="form-control" id="total" readonly>
												</div>
											</div>
											<button type="submit" class="pull-right btn btn-success btn-bordered waves-effect w-md waves-light" name="order">Buat Pesanan</button>
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h3 class="panel-title"> Informasi <span class="label label-danger pull-central">WAJIB BACA!!</span></h3>
				                  </div>
									<div class="card-block">
										<ul>
											<li><b>MASUKKAN LINK/TARGET YANG BENAR.</b></li>
											<li><b><span class="label label-warning pull-central">PERHATIAN!</span> YANG PERLU DIMASUKKAN DI TARGET CUKUP LINK ATAU USERNAME!! JANGAN MASUKKAN NAMA/EMAIL/NOMER/DLL.</b></li>
											<li><b>AKUN TARGET HARUS BERSIFAT PUBLIK/TIDAK PRIVATE.</b></li>
											<li><b>JIKA MEMASUKKAN USERNAME INSTAGRAM, TIDAK PERLU MEMAKAI @ CONTOH : _SPETRMEDIA</b></li>
											<li><b>JANGAN MENGGUNAKAN LEBIH SATU LAYANAN SEKALIGUS UNTUK USERNAME/LINK YANG SAMA. HARAP TUNGGU STATUS  <span class="label label-success pull-central">Success</span></b></li>								
											<li><b>JIKA ORDERAN STATUS  <span class="label label-danger pull-central">Error</span> dan  <span class="label label-danger pull-central">Partial</span> SALDO ANDA TELAH DIREFUND OTOMATIS OLEH SERVER!</b></li>			
											<li><b>JIKA PESANAN BELUM <span class="label label-success pull-central">Success</span>, DALAM WAKTU 1x48 JAM SILAKAN HUBUNGI ADMIN!</b></li>
											<li><b>KESALAHAN PENGGUNA BUKANLAH TANGGUNG JAWAB KAMI. BERHATI-HATILAH SEBELUM ORDER KARENA ORDERAN TIDAK DAPAT DIBATALKAN!!</b></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
						<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript">
$(document).ready(function() {
	$("#category").change(function() {
		var category = $("#category").val();
		$.ajax({
			url: '<?php echo $cfg_baseurl; ?>inc/order_service2.php',
			data: 'category=' + category,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#service").html(msg);
			}
		});
	});
	$("#service").change(function() {
		var service = $("#service").val();
		$.ajax({
			url: '<?php echo $cfg_baseurl; ?>inc/order_note2.php',
			data: 'service=' + service,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#note").html(msg);
			}
		});
		$.ajax({
			url: '<?php echo $cfg_baseurl; ?>inc/order_rate2.php',
			data: 'service=' + service,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#rate").val(msg);
			}
		});
	});
});

function get_total(quantity) {
	var rate = $("#rate").val();
	var result = eval(quantity) * rate;
	$('#total').val(result);
}
	</script>
<?php
	include("../lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>
<?php
