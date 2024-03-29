<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $cfg_webname; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo $cfg_baseurl; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?php echo $cfg_baseurl; ?>plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?php echo $cfg_baseurl; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="<?php echo $cfg_baseurl; ?>plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo $cfg_baseurl; ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo $cfg_baseurl; ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-green">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo $cfg_baseurl; ?>" class="logo"><b><?php echo $cfg_logo_txt; ?></b></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <?php
							if (isset($_SESSION[ 'user'])) {
							?>
							<li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Akun</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          <ul class="treeview-menu">
									<li><a href="<?php echo $cfg_baseurl; ?>settings.php">Pengaturan</a>
									</li>
									<li><a href="<?php echo $cfg_baseurl; ?>logout.php">Keluar</a>
									</li>
								</ul>
							</li>
				
							<?php
							if ($data_user[ 'level'] != "Member" ) {
							?>
								<li class="treeview">
          <a href="#">
            <i class="fa fa-star"></i>
            <span>Staff Fitur</span>
            <span class="pull-right-container">
            </span>
          </a>
          <ul class="treeview-menu">
											    <li><a href="<?php echo $cfg_baseurl; ?>staff/add_member.php">Tambah Member</a></li>
									<?php
									if ($data_user[ 'level'] != "Agen" ) {
									?>
									<li><a href="<?php echo $cfg_baseurl; ?>staff/add_agen.php">Tambah Agen</a></li>
									<?php
									if ($data_user[ 'level'] != "Reseller" ) {
									?>
									<li><a href="<?php echo $cfg_baseurl; ?>staff/add_reseller.php">Tambah Reseller</a></li>
									<?php
									if ($data_user[ 'level'] != "Admin" ) {
									?>
									<li><a href="<?php echo $cfg_baseurl; ?>staff/add_admin.php">Tambah Admin</a></li>
									<?php
									}
									}
									}
									?>
									<li><a href="<?php echo $cfg_baseurl; ?>staff/transfer_balance.php">Transfer Saldo</a></ul>
							</li>
						<?php
							}
							?>
							<?php
							if ($data_user[ 'level'] == "Developers") {
							?>
							<li class="treeview">
          <a href="#">
            <i class="fa fa-star"></i>
            <span>Developer Fitur</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          <ul class="treeview-menu">
											    <li><a href="<?php echo $cfg_baseurl; ?>admin/users.php">Kelola Pengguna</a></li>
									<li><a href="<?php echo $cfg_baseurl; ?>admin/services.php">Kelola Layanan</a></li>
									<li>
										<a href="admin/orders.php">Kelola Pesanan</a>
										
									</li>
						<li>
										<a href="admin/orders_pulsa.php">Kelola Pesanan Pulsa</a>
										
									</li>	
									
								 <li>
										<a href="admin/orders_line.php">Kelola Pesanan Line</a>
										
									</li>	
									
										<li>
										<a href="admin/orders_diamond.php">Kelola Pesanan Diamond</a>
										
									</li>	
									
									<li><a href="<?php echo $cfg_baseurl; ?>admin/news.php">Kelola Berita</a></li>
									<li><a href="<?php echo $cfg_baseurl; ?>admin/staff.php">Kelola Staff</a></li>
									<li><a href="<?php echo $cfg_baseurl; ?>admin/transfer_history.php">Riwayat Transfer Saldo</a></li>
								</ul>
							</li>
							<?php
							}
							?>
										<li>
											<a href="<?php echo $cfg_baseurl; ?>"> <i class="fa fa-home icon"> <b class="bg-success"></b> </i> <span>Dasbor</span> </a>
										</li>
										<li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Pemesanan Sosmed</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          <ul class="treeview-menu">
												<li><a href="<?php echo $cfg_baseurl; ?>order.php"> <i class="fa fa-angle-right"></i> <span>Pesanan Baru</span> </a></li>
												<li><a href="<?php echo $cfg_baseurl; ?>order_history.php"> <i class="fa fa-angle-right"></i> <span>Riwayat Pemesanan</span> </a></li>
											</ul>
										</li>
										
		<li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Pemesanan Pulsa</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          <ul class="treeview-menu">
												<li><a href="<?php echo $cfg_baseurl; ?>order_pulsa.php"> <i class="fa fa-angle-right"></i> <span>Pesan Pulsa</span> </a></li>
												<li><a href="<?php echo $cfg_baseurl; ?>order_history_pulsa.php"> <i class="fa fa-angle-right"></i> <span>Riwayat Pemesan Pulsa      </span> </a></li>
											</ul>
										</li>
          
               <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Download Apk</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          <ul class="treeview-menu">
												<li><a href="<?php echo $cfg_baseurl; ?>DreamSosmed.apk"> <i class="fa fa-angle-right"></i> <span>Pesanan Baru</span> </a></li>
											</ul>
										</li>	
										
										
	<li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Pemesanan Diamond</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          <ul class="treeview-menu">
												<li><a href="<?php echo $cfg_baseurl; ?>order_diamond.php"> <i class="fa fa-angle-right"></i> <span>Pesanan Baru</span> </a></li>
												<li><a href="<?php echo $cfg_baseurl; ?>order_history_diamond.php"> <i class="fa fa-angle-right"></i> <span>Riwayat Pemesanan</span> </a></li>
											</ul>
										</li>
										
	<li class="has-submenu">
                    <a href="#"><i class="fa fa-bank"></i> <span class="nav-label">Deposito</span><span class="fa arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $cfg_baseurl; ?>deposits/telkomsel">Deposito Automatis</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>deposits/tsel">Deposito Manual</a></li>
											</ul>
	<li class="has-submenu">
                  <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Deposito Bank</span><span class="fa arrow"></span></a>
                         <ul class="treeview-menu">
												<li><a href="<?php echo $cfg_baseurl; ?>deposit_bca.php"> <i class="fa fa-angle-right"></i> <span>Deposit Baru</span> </a></li>
												<li><a href="<?php echo $cfg_baseurl; ?>deposit_history_bca.php"> <i class="fa fa-angle-right"></i> <span>Riwayat Deposit</span> </a></li>
											</ul>
										</li>																	
										<?php
							} else {
							?>
							<li>
											<a href="<?php echo $cfg_baseurl; ?>index"> <i class="fa fa-sign-in icon"> <b class="bg-success"></b> </i> <span>Masuk</span> </a>
										</li>
										<?php
							}
							?>
										<li>
											<a href="<?php echo $cfg_baseurl; ?>staff_list.php"> <i class="fa fa-users icon"> <b class="bg-warning"></b> </i> <span>Daftar Staff</span> </a>
										</li>
<li class="treeview">
          <a href="#">
            <i class="fa fa-tags"></i>
            <span>Daftar Harga</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          <ul class="treeview-menu">
												<li><a href="<?php echo $cfg_baseurl; ?>price_list.php"> <i class="fa fa-angle-right"></i> <span>Sosial Media</span> </a></li>
												<li><a href="<?php echo $cfg_baseurl; ?>price_list_pulsa.php"> <i class="fa fa-angle-right"></i> <span>Pulsa</span> </a></li>
												<li><a href="<?php echo $cfg_baseurl; ?>price_list_diamond.php"> <i class="fa fa-angle-right"></i> <span>Diamond ML</span> </a></li>
											<li><a href="<?php echo $cfg_baseurl; ?>price_list_line"> <i class="fa fa-angle-right"></i> <span>Line</span> </a></li>
											</ul>
										</li>
										
											
										<li>
											<a href="<?php echo $cfg_baseurl; ?>terms.php"> <i class="fa fa-info icon"> <b class="bg-info"></b> </i> <span>Ketentuan Layanan</span> </a>
										</li>
										<li>
											<a href="<?php echo $cfg_baseurl; ?>api_doc.php"> <i class="fa fa-info icon"> <b class="bg-info"></b> </i> <span>Dokumentasi API</span> </a>
										</li>
									
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        </section>
        
        <!-- Main content -->
        <section class="content">