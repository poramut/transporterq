<?php
require 'connect.php';
$array = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $Cus_Code= $_POST['Cus_Code'];
    $itemCode= $_POST['itemCode'];
    $Sql = "DELETE FROM buffer_lose
        WHERE 
        `Cus_Code` = '".$Cus_Code."' AND ItemCode = '".$itemCode."' ";

    $meQuery = mysql_query($Sql);
    if($meQuery) {
        array_push($array,
          array('flag'=>"true"
          )
        );
    }else {
      array_push($array,
        array('flag'=>"false"
        )
      );
    }

}else {
  array_push($array,
    array('flag'=>"false")
  );
}
echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>