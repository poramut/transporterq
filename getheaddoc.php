<?php
require 'connect.php';
$array = array();

//if($_SERVER['REQUEST_METHOD']=='POST'){
    $DocNo= $_POST['DocNo'];
    //$Cus_Code = '1035';
    $Sql = "SELECT
CONCAT(customer.FName,customer.LName) AS FLName,
lose.Total,
lose.Cus_Code,
DATE_FORMAT(lose.DocDate,'%d-%m-%Y') AS DocDate5
FROM
    lose
INNER JOIN customer ON lose.Cus_Code = customer.Cus_Code
WHERE
    DocNo = '$DocNo'";

    $meQuery = mysql_query($Sql);
    while ($Result = mysql_fetch_assoc($meQuery)) {
        $FName =$Result["FLName"];
        $Total = $Result["Total"];
        $Cus_Code = $Result["Cus_Code"];
        $DocDate = $Result["DocDate5"];
       
    } 

    $Sql1 = "SELECT
        SUM(Qty*Price) AS Sumprice,
        SUM(Discount) AS Sumdiscount
        FROM
        lose_detail
        WHERE
        DocNo = '$DocNo'";
        $meQuery = mysql_query($Sql1);
        while ($Result = mysql_fetch_assoc($meQuery)) {
        $Sumprice =$Result["Sumprice"];
        $Sumdiscount = $Result["Sumdiscount"];
       
    } 
  /* var_dump($NameTH);
    print mysql_error(); 
   die;*/
        array_push($array,
          array(
            'FName'=>$FName,
            'Cus_Code'=>$Cus_Code,
            'Sumprice'=>$Sumprice,
            'Sumdiscount'=>$Sumdiscount,
            'DocDate'=>$DocDate,
            'Total'=>$Total
          )
        );
echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>