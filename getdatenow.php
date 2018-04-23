<?php
require 'connect.php';
$array = array();
/*
if($_SERVER['REQUEST_METHOD']=='POST'){*/
    $Login_Code= $_POST['Login_Code'];
    //$DocNo = 'L201802-00034';
    $Sql = "SELECT * FROM lose  INNER JOIN customer ON lose.Cus_Code= customer.Cus_Code WHERE  DocDate = DATE(NOW()) AND lose.IsCancel = 0 AND ChildOf = 
    '$Login_Code' ORDER BY lose.DocNo ";
//var_dump($Sql);
    $meQuery = mysql_query($Sql);
     while ($Result = mysql_fetch_assoc($meQuery)) {
        $DocNo =$Result["DocNo"];
        $Cus_Code =$Result["Cus_Code"];
        $NameTH =$Result["FName"];
        array_push($array,
          array(
            'DocNo'=>$DocNo,
            'Cus_Code'=>$Cus_Code,
            'NameTH'=>$NameTH
            
          )
        );
    } 
  /* var_dump($NameTH);
    print mysql_error(); 
   die;*/
//}
echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>

