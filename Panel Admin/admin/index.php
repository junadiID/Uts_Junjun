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
	}

	$check_worder = mysqli_query($db, "SELECT * FROM orders");
	$count_worder = mysqli_num_rows($check_worder);
	$check_wuser = mysqli_query($db, "SELECT * FROM users");
	$count_wuser = mysqli_num_rows($check_wuser);	
	$check_service = mysqli_query($db, "SELECT * FROM services");
	$count_service = mysqli_num_rows($check_service);
	$check_wdepo = mysqli_query($db, "SELECT * FROM deposits");
	$count_wdepo = mysqli_num_rows($check_wdepo);
	$check_wticket = mysqli_query($db, "SELECT * FROM tickets");
	$count_ticket = mysqli_num_rows($check_wticket);

	    // Data Order with Line Chart
    $check_order_today = mysqli_query($db, "SELECT * FROM orders WHERE date ='$date'");
    $check_orderp_today = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$date'");
    $check_depo_today = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$date'");
    $today = date("Y-m-d");
    
    $oneday_ago = date('Y-m-d', strtotime("-1 day"));
    $check_order_oneday_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$oneday_ago'");
    $check_orderp_oneday_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$oneday_ago'");
    $check_depo_oneday_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$oneday_ago'");
    
    $twodays_ago = date('Y-m-d', strtotime("-2 day"));
    $check_order_twodays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$twodays_ago'");
    $check_orderp_twodays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$twodays_ago'");
    $check_depo_twodays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$twodays_ago'");
    
    $threedays_ago = date('Y-m-d', strtotime("-3 day"));
    $check_order_threedays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$threedays_ago'");
    $check_orderp_threedays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$threedays_ago'");
    $check_depo_threedays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$threedays_ago'");
    
    $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
    $check_order_fourdays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$fourdays_ago'");
    $check_orderp_fourdays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$fourdays_ago'");
    $check_depo_fourdays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$fourdays_ago'");
    
    $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
    $check_order_fivedays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$fivedays_ago'");
    $check_orderp_fivedays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$fivedays_ago'");
    $check_depo_fivedays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$fivedays_ago'");
    
    $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
    $check_order_sixdays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$sixdays_ago'");
    $check_orderp_sixdays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$sixdays_ago'");
    $check_depo_sixdays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$sixdays_ago'");
    
    $sevendays_ago = date('Y-m-d', strtotime("-7 day"));
    $check_order_sevendays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$sevendays_ago'");    
    $check_orderp_sevendays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$sevendays_ago'");    
    $check_depo_sevendays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$sevendays_ago'");    
    
    // End Data

	include("../lib/headeradmin.php");
?>
        <div class="row">
            <div class="col-lg-6">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-shopping-cart"></i>
                            <h2 class="m-0"><?php echo number_format($count_worder,0,',','.'); ?> Pembelian</h2>
                            <div> Total Pembelian </div>
                        </div>
                    </div>
            <div class="col-lg-6">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-bank"></i>
                            <h2 class="m-0"><?php echo number_format($count_wdepo,0,',','.'); ?> Deposit</h2>
                            <div> Total Deposit </div>
                        </div>
                    </div>
            <div class="col-lg-4">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-ticket"></i>
                            <div> Total Tiket </div>
                            <h2 class="m-0"><?php echo number_format($count_ticket,0,',','.'); ?> Tiket</h2>
                        </div>
                    </div>
            <div class="col-lg-4">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-users"></i>
                            <h2 class="m-0"><?php echo number_format($count_wuser,0,',','.'); ?> Pengguna</h2>
                            <div> Total Pengguna </div>
                        </div>
                    </div>
            <div class="col-lg-4">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-tags"></i>
                            <h2 class="m-0"><?php echo number_format($count_service,0,',','.'); ?> Layanan</h2>
                            <div> Total Layanan Aktif </div>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet animated fadeInDown"><!-- /primary heading -->
                        <div class="portlet-heading">
                            <h3 class="portlet-title text-dark"><i class="fa fa-line-chart"></i> Grafik Pembelian & Deposit Pengguna 7 Hari Terakhir</h3>
                                <div class="portlet-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                    <span class="divider"></span>
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#portlet3"><i class="ion-minus-round"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="portlet3" class="panel-collapse collapse in">
                                <div class="portlet-body">
                        <div id="line-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include("../lib/footer.php");
	} else {
header("Location: ".$cfg_baseurl);
}
?><?php
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
	}

	$check_worder = mysqli_query($db, "SELECT * FROM orders");
	$count_worder = mysqli_num_rows($check_worder);
	$check_wuser = mysqli_query($db, "SELECT * FROM users");
	$count_wuser = mysqli_num_rows($check_wuser);	
	$check_service = mysqli_query($db, "SELECT * FROM services");
	$count_service = mysqli_num_rows($check_service);
	$check_wdepo = mysqli_query($db, "SELECT * FROM deposits");
	$count_wdepo = mysqli_num_rows($check_wdepo);
	$check_wticket = mysqli_query($db, "SELECT * FROM tickets");
	$count_ticket = mysqli_num_rows($check_wticket);

	    // Data Order with Line Chart
    $check_order_today = mysqli_query($db, "SELECT * FROM orders WHERE date ='$date'");
    $check_orderp_today = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$date'");
    $check_depo_today = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$date'");
    $today = date("Y-m-d");
    
    $oneday_ago = date('Y-m-d', strtotime("-1 day"));
    $check_order_oneday_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$oneday_ago'");
    $check_orderp_oneday_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$oneday_ago'");
    $check_depo_oneday_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$oneday_ago'");
    
    $twodays_ago = date('Y-m-d', strtotime("-2 day"));
    $check_order_twodays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$twodays_ago'");
    $check_orderp_twodays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$twodays_ago'");
    $check_depo_twodays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$twodays_ago'");
    
    $threedays_ago = date('Y-m-d', strtotime("-3 day"));
    $check_order_threedays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$threedays_ago'");
    $check_orderp_threedays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$threedays_ago'");
    $check_depo_threedays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$threedays_ago'");
    
    $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
    $check_order_fourdays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$fourdays_ago'");
    $check_orderp_fourdays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$fourdays_ago'");
    $check_depo_fourdays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$fourdays_ago'");
    
    $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
    $check_order_fivedays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$fivedays_ago'");
    $check_orderp_fivedays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$fivedays_ago'");
    $check_depo_fivedays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$fivedays_ago'");
    
    $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
    $check_order_sixdays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$sixdays_ago'");
    $check_orderp_sixdays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$sixdays_ago'");
    $check_depo_sixdays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$sixdays_ago'");
    
    $sevendays_ago = date('Y-m-d', strtotime("-7 day"));
    $check_order_sevendays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$sevendays_ago'");    
    $check_orderp_sevendays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$sevendays_ago'");    
    $check_depo_sevendays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$sevendays_ago'");    
    
    // End Data

	include("../lib/headeradmin.php");
?>
        <div class="row">
            <div class="col-lg-6">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-shopping-cart"></i>
                            <h2 class="m-0"><?php echo number_format($count_worder,0,',','.'); ?> Pembelian</h2>
                            <div> Total Pembelian </div>
                        </div>
                    </div>
            <div class="col-lg-6">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-bank"></i>
                            <h2 class="m-0"><?php echo number_format($count_wdepo,0,',','.'); ?> Deposit</h2>
                            <div> Total Deposit </div>
                        </div>
                    </div>
            <div class="col-lg-4">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-ticket"></i>
                            <div> Total Tiket </div>
                            <h2 class="m-0"><?php echo number_format($count_ticket,0,',','.'); ?> Tiket</h2>
                        </div>
                    </div>
            <div class="col-lg-4">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-users"></i>
                            <h2 class="m-0"><?php echo number_format($count_wuser,0,',','.'); ?> Pengguna</h2>
                            <div> Total Pengguna </div>
                        </div>
                    </div>
            <div class="col-lg-4">
                <div class="widget-panel widget-style-1 bg-info animated fadeInDown">
                            <i class="fa fa-tags"></i>
                            <h2 class="m-0"><?php echo number_format($count_service,0,',','.'); ?> Layanan</h2>
                            <div> Total Layanan Aktif </div>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet animated fadeInDown"><!-- /primary heading -->
                        <div class="portlet-heading">
                            <h3 class="portlet-title text-dark"><i class="fa fa-line-chart"></i> Grafik Pembelian & Deposit Pengguna 7 Hari Terakhir</h3>
                                <div class="portlet-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                    <span class="divider"></span>
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#portlet3"><i class="ion-minus-round"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="portlet3" class="panel-collapse collapse in">
                                <div class="portlet-body">
                        <div id="line-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include("../lib/footer.php");
	} else {
header("Location: ".$cfg_baseurl);
}
?>