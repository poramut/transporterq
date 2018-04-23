<?php
require 'connect.php';
$array = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $sreach= $_POST['sreach'];
    $Cus_Code= $_POST['Cus_Code'];
 /*   $sreach= "ปังกรอบ";
    $Cus_Code= "1035";*/
    $Sql = "SELECT
  sale_pack_detail.DocNo,
  sale_pack.Cus_Code,
  sale_pack_detail.Item_Code,
  item.Barcode,
  item.NameTH,
  item.SalePrice
  FROM
  sale_pack
  INNER JOIN sale_pack_detail ON sale_pack.DocNo = sale_pack_detail.DocNo
  INNER JOIN item ON sale_pack_detail.Item_Code = item.Item_Code
    WHERE sale_pack.Cus_Code='".$Cus_Code."' AND (item.NameTH like '%".$sreach."%'  OR item.Barcode LIKE '%".$sreach."%' ) GROUP BY sale_pack_detail.Item_Code  ";

    $meQuery = mysql_query($Sql);
    while ($Result = mysql_fetch_assoc($meQuery)) {
        $NameTH =$Result["NameTH"];
        $DocNo = $Result["DocNo"];
        $SalePrice = $Result["SalePrice"];
        $Item_Code = $Result["Item_Code"];
        $Barcode = $Result["Barcode"];
        array_push($array,
          array('flag'=>"true",
            'DocNo'=>$DocNo,
            'ItemCode'=>$Item_Code,
            'NameTH'=>$NameTH,
            'Barcode'=>$Barcode,
            'SalePrice'=>$SalePrice
          )
        );
    } 
   /*var_dump($NameTH);
    print mysql_error(); 
   die;*/

}else {
  array_push($array,
    array('flag'=>"false")
  );
}
echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>