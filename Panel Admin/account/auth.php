<?php
session_start();
require("../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	header("Location: ".$cfg_baseurl);
} else {
	if (isset($_POST['login'])) {
		$post_username = mysqli_real_escape_string($db, trim($_POST['username']));
		$post_password = mysqli_real_escape_string($db, trim($_POST['password']));
		if (empty($post_username) || empty($post_password)) {
			$msg_type = "error";
            $msg_content = "<b>Gagal:</b> Lengkapi semua input. <script>swal('Oh Snap!', 'Lengkapi semua input.', 'error');</script>";
		} else {
			$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
			if (mysqli_num_rows($check_user) == 0) {
				$msg_type = "error";
                $msg_content = "<b>Gagal:</b> Kombinasi username dan password tidak ditemukan. <script>swal('Oh Snap!', 'Kombinasi username dan password tidak ditemukan.', 'error');</script>";
			} else {
				$data_user = mysqli_fetch_assoc($check_user);
				if ($post_password <> $data_user['password']) {
					$msg_type = "error";
                    $msg_content = "<b>Gagal:</b> Kombinasi username dan password tidak ditemukan. <script>swal('Oh Snap!', 'Kombinasi username dan password tidak ditemukan.', 'error');</script>";
				} else if ($data_user['status'] == "Suspended") {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Akun nonaktif. <script>swal('Oh Snap!', 'Akun Suspended.', 'error');</script>";
				} else {
					$_SESSION['user'] = $data_user;
					header("Location: ".$cfg_baseurl);
				}
			}
		}
	}
include("../lib/header.php");
if (isset($_SESSION['user'])) {
    } else {
?>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default animated fadeInDown">
                <div class="panel-heading">
                   <h3 class="panel-title"><i class="fa fa-sign-in"></i> Masuk </h3>
                </div>
                <div class="panel-body">
                                        <?php 
                                        if ($msg_type == "error") {
                                        ?>
                                        <div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <i class="fa fa-times-circle"></i>
                                            <?php echo $msg_content; ?>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <form class="form-horizontal" role="form" method="POST">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Username</label>
                                                <div class="col-md-10">
                                                    <input type="text" name="username" class="form-control" placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Password</label>
                                                <div class="col-md-10">
                                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-offset-2 col-md-10">
                                                    <button type="submit" class="btn btn-primary" name="login"><i class="fa fa-send"></i> Submit</button>
                                                    <button type="reset" class="btn btn-warning"><i class="fa fa-refresh"></i> Ulangi</button>
                                                    <head><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-7046158971641310",
    enable_page_level_ads: true
  });
</script></head>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <div class="col-md-6">
                        <div class="panel panel-default animated fadeInDown">
                            <div class="panel-heading"> 
                           <h3 class="panel-title"><i class="fa fa-question-circle"></i> Mengapa Memilih Kami?</h3>
                       </div>
                       <div class="panel-body">
                                        <p><b><?php echo $cfg_webname; ?></b> Merupakan Sebuah Website Penyedia Layanan Sosial Media Marketing Seperti, Followers, Like, Views, Pulsa , Voucher Game Termurah, Cepat & Berkualitas.</p>
                                    <ul>
                                        <li>Instant & Auto Processing.</li>
                                        <li>Automatis Refund Orderan Gagal.</li>
                                        <li>Harga Sangat Murah Dan Berkualitas.</li>
                                        <li>Data Order Di Proses Secepat JET.</li>
                                        <li>Cheapest Price.</li>
                                        <li>Layanan Lengkap.</li>
                                        <li>24 Jam Kami Membantu Anda.</li>
                                    </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php
}
}
include("../lib/footer.php");
?>