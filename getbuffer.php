<?php
require 'connect.php';
$array = array();

//if($_SERVER['REQUEST_METHOD']=='POST'){
    $Cus_Code= $_POST['Cus_Code'];
    //$Cus_Code = '1035';
    $Sql = "SELECT
buffer_lose.ItemCode,
item.NameTH,
item.SalePrice,
buffer_lose.Qty,
buffer_lose.Discount,
buffer_lose.Total
FROM
buffer_lose
INNER JOIN item ON item.Item_Code = buffer_lose.ItemCode
INNER JOIN customer ON customer.Cus_Code = buffer_lose.Cus_Code
WHERE
buffer_lose.Cus_Code = '$Cus_Code' ";

    $meQuery = mysql_query($Sql);
    while ($Result = mysql_fetch_assoc($meQuery)) {
        $NameTH =$Result["NameTH"];
        $Qty = $Result["Qty"];
        $SalePrice = $Result["SalePrice"];
        $ItemCode = $Result["ItemCode"];
        $Discount = $Result["Discount"];
        $Total = $Result["Total"];
        array_push($array,
          array(
            'Qty'=>$Qty,
            'ItemCode'=>$ItemCode,
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

echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>