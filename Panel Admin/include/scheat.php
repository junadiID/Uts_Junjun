<?php
require("../mainconfig.php");

 $category = $_POST['category'];
 
 $exe = mysqli_query($db,"SELECT * FROM service_cheat WHERE category = '$category' ORDER BY no");
 $cek = mysqli_num_rows($exe);
 $no = 1;
 while($row = mysqli_fetch_assoc($exe)){
  $id = $row['no'];
  $service = $row['service'];
?>
<option value="<?php echo $id; ?>"><?php echo $service; ?></option>
<?
$no++;
} ?>