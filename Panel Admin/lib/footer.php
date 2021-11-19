            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            <footer class="footer">
                <?php echo date("Y"); ?> © <?php echo $cfg_webname; ?>.
            </footer>
            <!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
        


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo $cfg_baseurl; ?>js/jquery.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>js/bootstrap.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>js/modernizr.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>js/pace.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>js/wow.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/chat/moment-2.2.1.js"></script>

        <!-- Counter-up -->
        <script src="<?php echo $cfg_baseurl; ?>js/waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo $cfg_baseurl; ?>js/jquery.counterup.min.js" type="text/javascript"></script>

        <!--Morris Chart-->
        <script src="<?php echo $cfg_baseurl; ?>assets/morris/morris.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/morris/raphael.min.js"></script>

        <!-- sparkline --> 
        <script src="<?php echo $cfg_baseurl; ?>assets/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/sparkline-chart/chart-sparkline.js" type="text/javascript"></script> 

        <!-- sweet alerts -->
        <script src="<?php echo $cfg_baseurl; ?>assets/sweet-alert/sweet-alert.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/sweet-alert/sweet-alert.init.js"></script>

        <script src="<?php echo $cfg_baseurl; ?>js/jquery.app.js"></script>
        <!-- Chat -->
        <script src="<?php echo $cfg_baseurl; ?>js/jquery.chat.js"></script>
        <!-- Dashboard -->
        <script src="<?php echo $cfg_baseurl; ?>js/jquery.dashboard.js"></script>

        <!-- Todo -->
        <script src="<?php echo $cfg_baseurl; ?>js/jquery.todo.js"></script>


        <script type="text/javascript">
        /* ==============================================
             Counter Up
             =============================================== */
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
            });
        </script>
        <script>
  $(function () {
    "use strict";

    // LINE CHART
    var line = new Morris.Line({
      element: 'line-chart',
      resize: true,
      data: [
        {y: '<?php echo $today; ?>', x: <?php echo mysqli_num_rows($check_order_today); ?>, b:<?php echo mysqli_num_rows($check_depo_today); ?>, m:<?php echo mysqli_num_rows($check_orderp_today); ?>},
        {y: '<?php echo $oneday_ago; ?>', x: <?php echo mysqli_num_rows($check_order_oneday_ago); ?>, b:<?php echo mysqli_num_rows($check_depo_oneday_ago); ?>, m:<?php echo mysqli_num_rows($check_orderp_oneday_ago); ?>},
        {y: '<?php echo $twodays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_twodays_ago); ?>, b:<?php echo mysqli_num_rows($check_depo_twodays_ago); ?>, m:<?php echo mysqli_num_rows($check_orderp_twodays_ago); ?>},
        {y: '<?php echo $threedays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_threedays_ago); ?>, b:<?php echo mysqli_num_rows($check_depo_threedays_ago); ?>, m: <?php echo mysqli_num_rows($check_orderp_threedays_ago); ?>},
        {y: '<?php echo $fourdays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_fourdays_ago); ?>, b:<?php echo mysqli_num_rows($check_depo_fourdays_ago); ?>, m: <?php echo mysqli_num_rows($check_orderp_fourdays_ago); ?>},
        {y: '<?php echo $fivedays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_fivedays_ago); ?>, b:<?php echo mysqli_num_rows($check_depo_fivedays_ago); ?>,  m: <?php echo mysqli_num_rows($check_orderp_fivedays_ago); ?>},
        {y: '<?php echo $sixdays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_sixdays_ago); ?>, b:<?php echo mysqli_num_rows($check_depo_sixdays_ago); ?>, m: <?php echo mysqli_num_rows($check_orderp_sixdays_ago); ?>,},
        {y: '<?php echo $sevendays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_sevendays_ago); ?>, b:<?php echo mysqli_num_rows($check_depo_sevendays_ago); ?>, m: <?php echo mysqli_num_rows($check_orderp_sevendays_ago); ?>}        
      ],
      xkey: 'y',
      ykeys: ['x', 'b', 'm'],
      labels: ['Total Pembelian SosMed', 'Total Deposit Sukses', 'Total Pembelian Pulsa'],
      lineColors: ['#f8ac59','#1ab394','#1c84c6'],
      hideHover: 'auto'
    });
  });
</script>
</body>
</html>
