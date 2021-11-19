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
		$post_phone = $_POST['phone'];
		$post_nometer = $_POST['nometer'];
		

		$check_service = mysqli_query($db, "SELECT * FROM services_pulsa WHERE id = '$post_service' AND status = 'Active'");
		$data_service = mysqli_fetch_assoc($check_service);

		$price = $data_service['price'];
		$service = $data_service['name'];
		$service_code = $data_service['pid'];
		$provider = $data_service['provider'];
		
		$check_provider = mysqli_query($db, "SELECT * FROM provider WHERE code = '$provider'");
		$data_provider = mysqli_fetch_assoc($check_provider);
		

		if (empty($post_service) || empty($post_phone)) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Mohon mengisi input.";
		} else if (mysqli_num_rows($check_service) == 0) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Layanan tidak ditemukan.";
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
            } else if ($provider == "SPETRMEDIA-PULSA") {
                $postdata = "key=$key&action=order&service=$service_code&phone=$post_phone&nometer=$post_nometer";
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
 
            if ($provider == "SPETRMEDIA-PULSA" AND $json_result->error == TRUE) {
                $msg_type = "error";
                $msg_content = "<b>Gagal:</b> ".$json_result->error;
            } else {
                if ($provider == "SPETRMEDIA-PULSA") {
                    $oid = $json_result->id;
                    
                } else if ($provider == "MANUAL") {
                    $poid = $oid;
                }
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
				if ($update_user == TRUE) {
					$insert_order = mysqli_query($db, "INSERT INTO orders_pulsa (oid, user, service, phone, nometer, price, status, date) VALUES ('$oid', '$sess_username', '$service', '$post_phone', '$post_nometer', '$price', 'Pending', '$date')");
					
					if ($insert_order == TRUE) {
						$msg_type = "success";
						$msg_content = "<b>Pesanan telah diterima.</b><br /><b>Layanan:</b> $service<br /><b>NO. Telp:</b> $post_phone<br /><b>Biaya:</b> Rp ".number_format($price,0,',','.');
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
						<div class="row">
                             <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h3 class="panel-title"><i class="fa fa-tag"></i> Pesan Pulsa</h3>
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
												<label class="col-md-2 control-label">Oprator</label>
												<div class="col-md-10">
													<select class="form-control" id="category">
														<option value="0">Select one...</option>
														<option value="TELKOMSEL">TELKOMSEL</option>
														<option value="AXIS">AXIS</option>
														<option value="INDOSAT">INDOSAT</option>
														<option value="THREE">THREE</option>
														<option value="XL">XL</option>
														<option value="BOLT">BOLT</option>
														<option value="SMARTFREN">SMARTFREN</option>
														<option value="PLN">TOKEN PLN</option>
														<option value="GARENA">V.GARENA</option>
														<option value="GEMSCOOL">V.GEMSCOOL</option>
														<option value="GOJEK">SALDO GOJEK / GRAB</option>
														<option value="GOOGLEPLAY">GOOGLEPLAY GIFT CARD</option>
														<option value="WIFIID">WIFI.Id</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Layanan</label>
												<div class="col-md-10">
													<select class="form-control" id="service" name="service">
														<option value="0">Select one...</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Nomor Telepon</label>
												<div class="col-md-10">
													<input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxx">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Total Harga</label>
												<div class="col-md-10">
													<input type="text" class="form-control" name="price" id="price" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Nomor Meter</label>
												<div class="col-md-10">
													<input type="text" name="nometer" class="form-control" placeholder="Hanya diisi untuk pembelian Token PLN">
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
                   <h3 class="panel-title"><i class="fa fa-info-circle"></i> Informasi</h3>
									</div>
									<div class="card-body">
										<ul>
										
											<li>NOMER METER HANYA DIISI UNTUK PEMBELIAN TOKEN PLN</li>
											<li>ORDER PULSA/KUOTA/VOUCHER GAME. MASUKKAN NOMOR TELEPON DENGAN BENAR.</li>
											<li>ORDER TOKEN, HARAP MEMASUKKAN NOMER ID PELANGGAN DENGAN  BENAR.</li>
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
			url: '<?php echo $cfg_baseurl; ?>inc/order_service_pulsa.php',
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
			url: '<?php echo $cfg_baseurl; ?>inc/order_pulsa.php',
			data: 'service=' + service,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#price").val(msg);
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
