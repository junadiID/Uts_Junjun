<?php
session_start();
require("mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."account/logout");        
    }
    
	$check_order = mysqli_query($db, "SELECT SUM(price) AS total FROM orders WHERE user = '$sess_username'");
	$data_order = mysqli_fetch_assoc($check_order);    
    $check_orderp = mysqli_query($db, "SELECT SUM(price) AS total FROM orders_pulsa WHERE user = '$sess_username'");
    $data_orderp = mysqli_fetch_assoc($check_orderp);        
    $check_deposit = mysqli_query($db, "SELECT SUM(quantity) AS total FROM deposits WHERE user = '$sess_username' AND status = 'Success'");
    $data_deposit = mysqli_fetch_assoc($check_deposit);

    $check_order_today = mysqli_query($db, "SELECT * FROM orders WHERE date ='$date' AND user = '$sess_username'");
    $check_orderp_today = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$date' AND user = '$sess_username'");
    $check_depo_today = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$date' AND user = '$sess_username'");
    $today = date("Y-m-d");
    
    $oneday_ago = date('Y-m-d', strtotime("-1 day"));
    $check_order_oneday_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$oneday_ago' AND user = '$sess_username'");
    $check_orderp_oneday_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$oneday_ago' AND user = '$sess_username'");
    $check_depo_oneday_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$oneday_ago' AND user = '$sess_username'");
    
    $twodays_ago = date('Y-m-d', strtotime("-2 day"));
    $check_order_twodays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$twodays_ago' AND user = '$sess_username'");
    $check_orderp_twodays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$twodays_ago' AND user = '$sess_username'");
    $check_depo_twodays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$twodays_ago' AND user = '$sess_username'");
    
    $threedays_ago = date('Y-m-d', strtotime("-3 day"));
    $check_order_threedays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$threedays_ago' AND user = '$sess_username'");
    $check_orderp_threedays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$threedays_ago' AND user = '$sess_username'");
    $check_depo_threedays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$threedays_ago' AND user = '$sess_username'");
    
    $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
    $check_order_fourdays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$fourdays_ago' AND user = '$sess_username'");
    $check_orderp_fourdays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$fourdays_ago' AND user = '$sess_username'");
    $check_depo_fourdays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$fourdays_ago' AND user = '$sess_username'");
    
    $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
    $check_order_fivedays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$fivedays_ago' AND user = '$sess_username'");
    $check_orderp_fivedays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$fivedays_ago' AND user = '$sess_username'");
    $check_depo_fivedays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$fivedays_ago' AND user = '$sess_username'");
    
    $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
    $check_order_sixdays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$sixdays_ago' AND user = '$sess_username'");
    $check_orderp_sixdays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$sixdays_ago' AND user = '$sess_username'");
    $check_depo_sixdays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$sixdays_ago' AND user = '$sess_username'");
    
    $sevendays_ago = date('Y-m-d', strtotime("-7 day"));
    $check_order_sevendays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$sevendays_ago' AND user = '$sess_username'");    
    $check_orderp_sevendays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$sevendays_ago' AND user = '$sess_username'");    
    $check_depo_sevendays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$sevendays_ago' AND user = '$sess_username'");     
} else {
    $_SESSION['user'] = $data_user;
    header("Location: ".$cfg_baseurl."account/auth.php");
    }

include("lib/header.php");
if (isset($_SESSION['user'])) {
?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info animated fadeInDown">
                    <p>Selamat Datang <b><?php echo $data_user['fullname']; ?></b>! Silahkan Melakukan Transaksi</p>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                        <div class="portlet animated fadeInDown"><!-- /primary heading -->
                            <div class="portlet-heading">
                                <h3 class="portlet-title text-dark">
                                  <i class="fa fa-line-chart"></i> Pembelian & Deposit 7 hari terakhir
                                </h3>
                                <div class="portlet-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                    <span class="divider"></span>
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#portlet1"><i class="ion-minus-round"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="portlet1" class="panel-collapse collapse in">
                                <div class="portlet-body">
                        <div id="line-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                    <i class="fa fa-shopping-cart"></i>
                            <h2 class="m-0">Rp <?php echo number_format($data_order['total'],0,',','.'); ?></h2>
                            <div> Total Pembelian Sosial Media</div>
                        </div>
                    </div>
            <div class="col-md-4 col-sm-6">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                    <i class="fa fa-shopping-cart"></i>
                            <h2 class="m-0">Rp <?php echo number_format($data_orderp['total'],0,',','.'); ?></h2>
                            <div> Total Pembelian Pulsa & VOC</div>
                        </div>
                    </div>
            <div class="col-md-4 col-sm-6">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                    <i class="fa fa-bank"></i>
                            <h2 class="m-0">Rp <?php echo number_format($data_deposit['total'],0,',','.'); ?></h2>
                            <div> Total Deposit Sukses </div>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet animated fadeInDown"><!-- /primary heading -->
                        <div class="portlet-heading">
                        <h3 class="portlet-title text-dark">
                            <i class="fa fa-warning"></i> Informasi Terkini
                        </h3>
                                <div class="portlet-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                    <span class="divider"></span>
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#portlet2"><i class="ion-minus-round"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="portlet2" class="panel-collapse collapse in">
                                <div class="portlet-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Type</th>
                                                        <th>Tanggal</th>
                                                        <th>Konten</th>
                                                        <th>Dibuat Oleh</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $check_news = mysqli_query($db, "SELECT * FROM news ORDER BY id DESC LIMIT 5");
                                                    $no = 1;
                                                    while ($data_news = mysqli_fetch_assoc($check_news)) {
                                                    if($data_news['section'] == "Informasi") {
                                                        $label = "primary";
                                                    } else if($data_news['section'] == "Update") {
                                                        $label = "info";
                                                    } else if($data_news['section'] == "Penting") {
                                                        $label = "danger";
                                                    } else if($data_news['section'] == "Event") {
                                                        $label = "success";
                                                    }
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $no; ?></th>
                                                        <td align="center"><label class="label label-<?php echo $label; ?>"><?php echo $data_news['section']; ?></label></td>
                                                        <td><?php echo $data_news['date']; ?></td>
                                                        <td><?php echo $data_news['content']; ?></td>
                                                        <td><?php echo $data_news['created_by']; ?></td>
                                                    </tr>
                                                    <?php
                                                    $no++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?php
}
include("lib/footer.php");
?>