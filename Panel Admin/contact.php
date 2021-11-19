<?php
session_start();
require("mainconfig.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."account/logout");
	}
}

include("lib/header.php");
?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-phone"></i> Kontak Admin</h3>
                                </div>
                                    <div class="panel-body">

                <h1 class="text-center">Silahkan kontak admin melalui kontak berikut ini</h1><hr>                    	
        <div class="row">
            <div class="col-lg-6">
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-envelope-o fa-5x"></i>
                            <h2> Email Support </h2><br />
                            <h3 class="font-bold">support@Thinkspedia.xyz</h3>
                        </div>
                    </div>
            <div class="col-lg-6">
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-whatsapp fa-5x"></i>
                            <h2> Whatsapp </h2><br />
                            <h3 class="font-bold">081285390961</h3>
                        </div>
                    </div>
            <div class="col-lg-6">
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-facebook fa-5x"></i>
                            <h2> Facebook Develover </h2><br />
                            <h3 class="font-bold">https://www.facebook.com/thinkspedia</h3>
                        </div>
                    </div>
            <div class="col-lg-6">
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-instagram fa-5x"></i>
                            <h2> Instagram </h2><br />
                            <h3 class="font-bold">Thinks_Pedia</h3>
                        </div>
                    </div>
                </div>
            </div>                                    
        </div>
                                
                                    </div>
                                </div>

<?php
include("lib/footer.php");
?>