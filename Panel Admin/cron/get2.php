<?php
   require_once("../mainconfig.php");
       
$api_postdata = "key=DSwOESlJpxJq8lR9zcdp&action=service";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://spetr-media.com/api/sosmed2/service");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $chresult = curl_exec($ch);
    curl_close($ch);
    $json_result = json_decode($chresult, true);
    print_r($json_result);

$indeks=0; 
$i = 1;
// get data service
while($indeks < count($json_result['result'])){ 
    
$category=$json_result['result'][$indeks]['category'];
$sid =$json_result['result'][$indeks]['sid'];
$service = $json_result['result'][$indeks]['service'];
$min_order =$json_result['result'][$indeks]['min'];
$max_order = $json_result['result'][$indeks]['max'];
$price = $json_result['result'][$indeks]['price'];
$note = $json_result['result'][$indeks]['note'];
$indeks++; 
$i++;
// end get data service 
// setting price 
$rate = $price; 
$rate_asli = $rate + 1000; //setting penambahan harga
// setting price 
 $check_services = mysqli_query($db, "SELECT * FROM servicess WHERE pid = '$sid' AND provider='SPETRMEDIA-S2'");
            $data_services = mysqli_fetch_assoc($check_orders);
        if(mysqli_num_rows($check_services) > 0) {
            echo "Service Sudah Ada Di database => $service | $sid \n <br />";
        } else {
            
$insert=mysqli_query($db, "INSERT INTO servicess (sid,category,service,note, min, max, price, status, pid, provider) VALUES ('$sid','$category','$service','$note','$min_order','$max_order','$rate_asli','Active','$sid','SPETRMEDIA-S2')");//Memasukan Kepada Database (OPTIONAL)
if($insert == TRUE){
echo"SUKSES INSERT -> Kategori : $category || SID : $sid || Service :$service || Min :$min_order || Max : $max_order ||Price : $rate_asli || Note : $note <br />";
}else{
    echo "GAGAL MEMASUKAN DATA";
    
}
}
}
?>