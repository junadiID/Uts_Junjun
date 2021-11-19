<?php
//*Script by THCoder //*Mohon Untuk Tidak Mengubah Copyright*//

require_once("mainconfig.php");//koneksi kepada database
$key = "d7KuWjesrGcXFSEMvt04q1lfDHJok5"; // your api key
$postdata = "api_key=$key&action=services";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://medanpedia.co.id/pulsa/json.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$chresult = curl_exec($ch);
//echo $chresult;
curl_close($ch);
$json_result = json_decode($chresult, true);
$indeks=0; 
$i = 1;
// get data service
while($indeks < count($json_result['data'])){ 
    
$id =$json_result['data'][$indeks]['id'];
$name = $json_result['data'][$indeks]['layanan'];
$code =$json_result['data'][$indeks]['layanan'];
$indeks++; 
$i++;
 
 $check_services = mysqli_query($db, "SELECT * FROM servicepulsa_cat WHERE code = '$code'");
            $data_services = mysqli_fetch_assoc($check_orders);
        if(mysqli_num_rows($check_services) > 0) {
            echo "Service Sudah Ada Di database => $code \n <br />";
        } else {
            
$insert=mysqli_query($db, "INSERT INTO servicepulsa_cat (name,code) VALUES ('$name','$code')");//Memasukan Kepada Database (OPTIONAL)
if($insert == TRUE){
echo"SUKSES INSERT -> Name : $name || Code : $code <br />";
}else{
    echo "GAGAL MEMASUKAN DATA";
    
}
}
}
?>