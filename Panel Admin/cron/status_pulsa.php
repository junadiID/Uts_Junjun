 <?php
require("../mainconfig.php");

$check_order = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE status IN ('Pending','Processing')");

if (mysqli_num_rows($check_order) == 0) {
  die("Order Pending not found.");
} else {
  while($data_order = mysqli_fetch_assoc($check_order)) {
    $o_oid = $data_order['oid'];
     $o_provider = $data_order['provider'];
  if ($o_provider == "MANUAL") {
    echo "Order manual<br />";
  } else {
    
    $check_provider = mysqli_query($db, "SELECT * FROM provider WHERE code = 'SPETRMEDIA-PULSA'");
    $data_provider = mysqli_fetch_assoc($check_provider);
    
    $p_apikey = $data_provider['api_key'];
    $p_link = $data_provider['link'];
    $api_postdata = "key=DSwOESlJpxJq8lR9zcdp&action=status&id=$o_oid";
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://spetr-media.com/api/pulsa/status');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $chresult = curl_exec($ch);
    curl_close($ch);
    $json_result = json_decode($chresult);

      
          $u_status = $json_result->data->status;
             if ($u_status == "Pending") {
            $un_status = "Pending";
         } else if ($u_status == "Error") {
            $un_status = "Error";
         } else if ($u_status == "Success") {
            $un_status = "Success";
         } else {
             $un_status = "Pending";
         }
        
    $update_order = mysqli_query($db, "UPDATE orders_pulsa SET status = '$un_status' WHERE oid = '$o_oid'");
    if ($update_order == TRUE) {
      echo "ID Pusat: $o_oid<br /> Status: $un_status<br />";
    } else {
      echo "Error database.";
    }
  }
  }
