<?php
session_start();
require("../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
    $sess_username = $_SESSION['user']['username'];
    $check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
    $data_user = mysqli_fetch_assoc($check_user);
    if (mysqli_num_rows($check_user) !== 0) {
        header("Location: ".$cfg_baseurl);
    }
}
    if (isset($_POST['daftar'])) {
        $post_email = mysqli_real_escape_string($db, trim($_POST['email']));
        $post_fullname = mysqli_real_escape_string($db, trim($_POST['fullname']));
        $post_username = mysqli_real_escape_string($db, trim($_POST['username']));
        $post_password = mysqli_real_escape_string($db, trim($_POST['password']));
        $post_repeat_password = mysqli_real_escape_string($db, trim($_POST['repassword']));
        // $post_code = $_POST['code'];
        
        $check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
        // $check_code = mysqli_query($db, "SELECT * FROM code_verification WHERE code = '$post_code'");
// empty($post_code)

        if (empty($post_username) || empty($post_password) || empty($post_fullname) || empty($post_repeat_password) || empty($post_email)) {
            $msg_type = "error";
            $msg_content = "<b>Gagal:</b> Lengkapi semua input. <script>swal('Oh Snap!', 'Lengkapi semua input.', 'error');</script>";
        } else if (mysqli_num_rows($check_user) > 0) {
            $msg_type = "error";
            $msg_content = "<b>Gagal:</b> Username telah digunakan. <script>swal('Oh Snap!', 'Username telah digunakan.', 'error');</script>";
        } else if (mysqli_num_rows($check_code) == 0) {
            $msg_type = "error";
            $msg_content = "<b>Gagal:</b> Kode undangan tidak ditemukan. <script>swal('Oh Snap!', 'Kode undangan tidak ditemukan.', 'error');</script>";
        } else if (strlen($post_username) > 15) {
            $msg_type = "error";
            $msg_content = "<b>Gagal:</b> Username maksimal 15 karakter . <script>swal('Oh Snap!', 'Username maksimal 15 karakter.', 'error');</script>";
        } else if (strlen($post_password) > 15) {
            $msg_type = "error";
            $msg_content = "<b>Gagal:</b> Password maksimal 15 karakter. <script>swal('Oh Snap!', 'Password maksimal 15 karakter.', 'error');</script>";
        } else if (strlen($post_username) < 5) {
            $msg_type = "error";
            $msg_content = "<b>Gagal:</b> Username minimal 5 karakter. <script>swal('Oh Snap!', 'Username minimal 5 karakter.', 'error');</script>";
        } else if (strlen($post_password) < 5) {
            $msg_type = "error";
            $msg_content = "<b>Gagal:</b> Password minimal 5 karakter. <script>swal('Oh Snap!', 'Password minimal 5 karakter.', 'error');</script>";
        } else if ($post_password <> $post_repeat_password) {
            $msg_type = "error";
            $msg_content = "<b>Gagal:</b> Konfirmasi password tidak sesuai. <script>swal('Oh Snap!', 'Konfirmasi password tidak sesuai.', 'error');</script>";
        } else {
                $insert_user = mysqli_query($db, "INSERT INTO users (username, password, level, balance, api_key, status, registered, uplink, email) VALUES ('$post_username', '$post_password', 'Member', '0', '$post_api', 'Active', '$date', 'Free Member', '$post_email')");
                // $insert_user = mysqli_query($db, "UPDATE code_verification SET status = 'Already Used' WHERE code = '$post_code'");
                if ($insert_user == TRUE) {
                    $msg_type = "success";
                    $msg_content = "<b>Berhasil:</b> Pendaftaran berhasil. Anda akan dialihkan ke halaman masuk.<META HTTP-EQUIV=Refresh CONTENT=\"2; URL=auth\"> <script>swal('Yeay!', 'Pendaftaran berhasil. Anda akan dialihkan ke halaman masuk.', 'success');</script>";
                } else {
                    $msg_type = "error";
                    $msg_content = "<script>swal('Error!', 'Error system (1).', 'error');</script>";
                }
            }
        }
include_once("../lib/header.php");
?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default animated fadeInDown">
                <div class="panel-heading">
                   <h3 class="panel-title"><i class="fa fa-user-plus"></i> Daftar </h3>
                </div>
                <div class="panel-body">
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
                                                <label class="col-md-2 control-label">Email</label>
                                                <div class="col-md-10">
                                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Nama Lengkap</label>
                                                <div class="col-md-10">
                                                    <input type="text" name="fullname" class="form-control" placeholder="Nama Lengkap">
                                                </div>
                                            </div>
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
                                                <label class="col-md-2 control-label">Ulangi Password</label>
                                                <div class="col-md-10">
                                                    <input type="password" name="repassword" class="form-control" placeholder="Ulangi Password">
                                                </div>
                                            </div>
                                            <!--<div class="form-group">-->
                                            <!--    <label class="col-md-2 control-label">Kode Undangan</label>-->
                                            <!--    <div class="col-md-10">-->
                                            <!--        <input type="text" name="code" class="form-control" placeholder="Kode Undangan">-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                              
                                            <div class="form-group">
                                                <div class="col-md-offset-2 col-md-10">
                                                    <button type="submit" class="btn btn-primary" name="daftar"><i class="fa fa-send"></i> Submit </button>
                                                    <button type="reset" class="btn btn-warning"><i class="fa fa-refresh"></i> Ulangi</button>                                                  
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
include("../lib/footer.php");
?>
                      