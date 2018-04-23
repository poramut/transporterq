<?php
require 'connect.php';
$array = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $Cus_Code= $_POST['Cus_Code'];
    //$Cus_Code= '1035';
   $Sql4 = "DELETE FROM buffer_lose WHERE Cus_Code = '$Cus_Code' ";
          
           $meQuery = mysql_query($Sql4);
           /*var_dump($Sql4);*/
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