<?php
require 'connect.php';
$array = array();
/*
if($_SERVER['REQUEST_METHOD']=='POST'){*/
    $DocNo= $_POST['DocNo'];
    //$DocNo = 'L201803-00071';
    $Sql = "SELECT
lose_detail.Item_Code,
lose_detail.Qty,
lose_detail.Discount,
lose_detail.Price,
lose_detail.Total,
item.Barcode,
item.NameTH
FROM
lose
INNER JOIN lose_detail ON lose.DocNo = lose_detail.DocNo
LEFT JOIN item ON lose_detail.Item_Code = item.Item_Code
WHERE
lose.DocNo='".$DocNo."'";
//var_dump($Sql);
    $meQuery = mysql_query($Sql);
     while ($Result = mysql_fetch_assoc($meQuery)) {
        $NameTH =$Result["NameTH"];
        $Qty = $Result["Qty"];
        $SalePrice = $Result["Price"];
        $Barcode = $Result["Barcode"];
        $ItemCode = $Result["Item_Code"];
        $Discount = $Result["Discount"];
        $Total = $Result["Total"];
        array_push($array,
          array(
            'Qty'=>$Qty,
            'ItemCode'=>$ItemCode,
            'Barcode'=>$Barcode,
            'NameTH'=>$NameTH,
            'SalePrice'=>$SalePrice,
            'Discount'=>$Discount,
            'Total'=>$Total
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