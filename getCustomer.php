<?php
require 'connect.php';
$array = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
  if($_POST['flag']==true)
  {
    $Sql = "SELECT * FROM customer";
    $meQuery = mysql_query($Sql);
    while ($Result = mysql_fetch_assoc($meQuery)) {
        $Cus_Code = $Result["Cus_Code"];
        $FName = $Result["FName"];
        $Tel = $Result["Tel"];
        $Cus_image = $Result["Cus_image"];
        array_push($array,
          array('flag'=>"true",
          'Cus_Code'=>$Cus_Code,
          'FName'=>$FName,
          'Tel'=>$Tel,
          'Cus_image'=>$Cus_image
          )
        );
    }
  }
}else {
  array_push($array,
    array('flag'=>"false")
  );
}
echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>