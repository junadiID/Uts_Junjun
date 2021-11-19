<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $cfg_desc; ?>">
        <meta name="google-site-verification" content="googleedc6eba0cc38e4d0" />
        <meta name="author" content="<?php echo $cfg_author; ?>">

        <link rel="shortcut icon" href="">

        <title><?php echo $cfg_webname; ?></title>

        <!-- Google-Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo $cfg_baseurl; ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $cfg_baseurl; ?>css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="<?php echo $cfg_baseurl; ?>css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="<?php echo $cfg_baseurl; ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $cfg_baseurl; ?>assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="<?php echo $cfg_baseurl; ?>assets/morris/morris.css">

        <!-- sweet alerts -->
        <link href="<?php echo $cfg_baseurl; ?>assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo $cfg_baseurl; ?>css/style.css" rel="stylesheet">
        <link href="<?php echo $cfg_baseurl; ?>css/helper.css" rel="stylesheet">
        <link href="<?php echo $cfg_baseurl; ?>css/style-responsive.css" rel="stylesheet" />
        <script src="//cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>  

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62751496-1', 'auto');
  ga('send', 'pageview');

</script>

    </head>

    <body>

        <!-- Aside Start-->
        <aside class="left-panel">

            <!-- brand -->
            <div class="logo">
                <a href="<?php echo $cfg_baseurl; ?>" class="logo-expanded">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="nav-label"><?php echo $cfg_logo_txt; ?></span>
                </a>
            </div>
            <!-- / brand -->

            <!-- Navbar Start -->
            <nav class="navigation">
                <ul class="list-unstyled">
            <?php
            if (isset($_SESSION[ 'user'])) {
            ?>
            <?php
            if ($data_user[ 'level'] != "Member" ) {
            ?>
                <li class="has-submenu">
                    <a href="#"><i class="fa fa-plus"></i> <span class="nav-label">Fitur Tambahan</span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $cfg_baseurl; ?>staff/add_member.php">Tambah Member</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>staff/add_agen.php">Tambah Agen</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>staff/add_reseller.php">Tambah Reseller</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>staff/add_admin.php">Tambah Admin</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>staff/transfer_balance.php">Transfer Saldo</a></li>
                    </ul>
                </li>
            <?php 
            }
            ?>
            <?php
            if ($data_user[ 'level'] == "Developers") {
            ?>                 
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin"><i class="fa fa-user-secret"></i> <span class="nav-label">Admin Panel</span></a>
                </li>
            <?php
            }
            ?>   
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>"><i class="fa fa-home"></i> <span class="nav-label">Halaman Utama</span></a>
                </li>    
                <li class="has-submenu">
                    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Sosial Media S1</span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $cfg_baseurl; ?>orders/sosmed.php">Pembelian Tunggal</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>orders/history/sosmed.php">Riwayat Pembelian</a></li>
                       
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Sosial Media S2</span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $cfg_baseurl; ?>orders/sosmed2.php">Pembelian Tunggal</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>orders/history/sosmed2.php">Riwayat Pembelian</a></li>
                       
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Pulsa & Voucher</span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $cfg_baseurl; ?>orders/pulsa.php">Pembelian Tunggal</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>orders/history/pulsa.php">Riwayat Pembelian</a></li>
                    </ul>
                </li>
                
               
                
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>tickets/new.php"><i class="fa fa-ticket"></i> <span class="nav-label">Tiket Bantuan</span></a>
                </li>                                                
            <?php
            } else {
            ?>    
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>account/auth.php"><i class="fa fa-sign-in"></i> <span class="nav-label">Masuk</span></a>
                </li>

                <li>
                    <a href="<?php echo $cfg_baseurl; ?>account/register.php"><i class="fa fa-user-plus"></i> <span class="nav-label">Pendaftaran Akun</span></a>
                </li>

                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin.php"><i class="fa fa-users" aria-hidden="true"></i> <span class="nav-label">Daftar Admin</span></a>
                </li>
            <?php
            }
            ?>                 
                    
                <li class="has-submenu">
                    <a href="#"><i class="fa fa-tags"></i> <span class="nav-label">Daftar Layanan</span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $cfg_baseurl; ?>price_list.php">Sosial Media S1</a></a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>price_list2.php">Sosial Media S2</a></a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>price_list_pulsa.php">Pulsa & Voucher</a></li>
                        
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="fa fa-question-circle"></i> <span class="nav-label">Bantuan</span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $cfg_baseurl; ?>contact.php">Kontak Admin</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>faq.php">Pertanyaan Umum</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>terms.php">Ketentuan Layanan</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>

        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <!-- Right navbar -->
                <ul class="list-inline navbar-right top-menu top-right-menu"> 
            <?php
            if (isset($_SESSION[ 'user'])) {
            ?>
            <li class="dropdown text-center">
                <a href="<?php echo $cfg_baseurl; ?>deposits"> <span>Saldo : Rp <?php echo number_format($data_user['balance'],0,',','.'); ?></span></a>
            </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown text-center">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-user"></i>
                            <span class="username"><?php echo $sess_username; ?> </span> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                            <li><a href="<?php echo $cfg_baseurl; ?>account/profile.php"><i class="fa fa-cog"></i> Pengaturan Akun</a></li>
                            <li><a href="<?php echo $cfg_baseurl; ?>account/logout.php"><i class="fa fa-sign-out"></i> Keluar</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end --> 
                    <?php
                    }
                    ?>     
                </ul>
                <!-- End right navbar -->

            </header>
            <!-- Header Ends -->

            <!-- Page Content Start -->
            <!-- ================== -->

            <div class="wraper container-fluid">
