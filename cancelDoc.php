<?php
require 'connect.php';
$array = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $DocNo= $_POST['DocNo'];
    //$Cus_Code= '1035';
   $Sql4 = "UPDATE lose SET IsCancel = 1 WHERE DocNo = '$DocNo' ";
          
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