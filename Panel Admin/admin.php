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
							<div class="col-md-12">
								<div class="alert alert-info">
									<i class="fa fa-info-circle"></i> Silahkan Chat Admin Melalui Kontak Berikut Ini
								</div>
							</div>
							
							<div class="col-md-4">
									
									<div class="white-box text-center bg-info" style="padding: 20px 0;">
										<img src='https://s8.postimg.cc/ifwtnx7j5/devloper.png' border='0' alt='devloper'/></a>
										<h3 class="text-white text-uppercase">Junjun Junaedi</h3>
										<h4 <p class="text-white text-uppercase">(Junadi)</h4></p>
										<p class="text-white">WhatsApp : 085722176451</p>
										<p class="text-white">Facebook : <a href="#"> Arul AxelVix</a> </p>
										<p class="text-white">Instagram : <a href="https://www.instagram.com/junadi_id"> Arul AxelVix</a> </p>
									</div>
								</div>.
							
						</div>
						
						<div class="col-md-4">
									
									<div class="white-box text-center bg-info" style="padding: 20px 0;">
										<img src='https://s8.postimg.cc/ifwtnx7j5/devloper.png' border='0' alt='devloper'/></a>
										<h3 class="text-white text-uppercase">Akmal Mufid</h3>
										<h4 <p class="text-white text-uppercase">(Akmal)</h4></p>
										<p class="text-white">WhatsApp : 081319169507</p>
										<p class="text-white">Facebook : <a href="https://m.facebook.com/akmal.axelvix.1?ref=bookmarks"> Akmal AxelVix</a> </p>
										<p class="text-white">Instagram : <a href="https://www.instagram.com/Akmalm_727"> Akmal</a> </p>
										<p class="text-white">Line : <a href="http://line.me/ti/p/~"> -_– </a> </p>
									</div>
								</div> <!-- end col -->
							
						</div>
						<!-- end row -->
								

                               
             

                              
                                </div>
                            </div>
                        </div>
                    </div>
						<!-- end row -->
<?php
include("lib/footer.php");
?>