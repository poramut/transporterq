<?php
require 'connect.php';
//require 'class.php';
$array = array();

//$dateobj = new DatetimeTH();


/*if($_SERVER['REQUEST_METHOD']=='POST')
{*/
   $Cus_Code = $_POST["Cus_Code"];
    $lose_status = $_POST["lose_status"];
    $lose_txt = $_POST["lose_txt"];
    $Login_Code = $_POST["Login_Code"];
  /* $Cus_Code = '1035';
    $lose_status = '0';
    $lose_txt = 'askljadfasdf';
    $Login_Code ='9876';*/
 /*   $Cus_Code = "1035";
    $lose_detail = "sdfdfgfdsffgdssdfdsss";*/
  /*  $date = $_POST["date"];
    $time = $_POST["time"];
    $place = $_POST["place"];
    $detail_txt = $_POST["detail_txt"];
    $Isnormal = $_POST["Isnormal"];
    $Objective = $_POST["objective"];*/

    $Sql = "SELECT
        SUM(Total) AS Sumtotal,
        SUM(Qty*Price) AS Sumprice,
        SUM(Discount) AS Sumdiscount
        FROM
        buffer_lose
        WHERE
        Cus_Code = '$Cus_Code'";
    $meQuery = mysql_query($Sql);
    while($Result = mysql_fetch_assoc($meQuery)){
        $Total = $Result["Sumtotal"];
        $Sumprice = $Result["Sumprice"];
        $Sumdiscount = $Result["Sumdiscount"];
      }

    $Sql8 = "SELECT
    customer.FName
    FROM
    lose
    INNER JOIN customer ON customer.Cus_Code = lose.Cus_Code
    WHERE
    lose.Cus_Code= '$Cus_Code'
    GROUP BY lose.Cus_Code ";
      $meQuery = mysql_query($Sql8);
      while($Result = mysql_fetch_assoc($meQuery)){
        $NameCus= $Result["FName"];
      }
/*var_dump($Total);
echo "<br>";*/

    $Sql = "SELECT  COUNT(*)+1 AS dcount
            , MONTH(NOW()) AS dmonth
            , YEAR(NOW()) AS dyear
            , DocDate
            FROM
             lose
            WHERE MONTH(DocDate) = MONTH(NOW())
            AND  YEAR(DocDate) = YEAR(NOW())";
    $meQuery = mysql_query($Sql);
    while($Result = mysql_fetch_assoc($meQuery)){
        $dcount = $Result["dcount"];
        $dmonth = $Result["dmonth"];
        $dyear = $Result["dyear"];
        $DocDate = $Result["DocDate"];
      }

      //count
      if($dcount<10){
        $dautorun = '0000'.$dcount;
      }elseif ($dcount<100) {
        $dautorun = '000'.$dcount;
      }elseif ($dcount<1000) {
        $dautorun = '00'.$dcount;
      }elseif ($dcount<10000) {
        $dautorun = '0'.$dcount;
      }else {
        $dautorun = ''.$dcount;
      }

      //MONTH
      if(strlen($dmonth)==1){
        $dmonth = '0'.$dmonth;
      }

      //YEAR
      //$dyear = substr($dyear,2,2);

      //DOCNO
      $dDocNo = 'L'.$dyear.$dmonth.'-'.$dautorun;
/*var_dump($dDocNo);
echo "<br>";*/
      //Saleorder
      $Sql1 = "INSERT INTO lose(
          DocNo,
          DocDate,
          Cus_Code,
          Total,
          Detail,
          Login_Code,
          Lose_Status,
          Modify_Date,
          Modify_Code,
          Branch_Code,
          IsCancel,
          IsBillz,
          Status,
          IsClrBill,
          IsPasteBill,
          RefDocNo
        )
        VALUES(
          '$dDocNo',
          NOW(),
          '$Cus_Code',
          '$Total',
          '$lose_txt',
          '$Login_Code',
          0,
          NOW(),
          0,
          2,
          0,
          0,
          '$lose_status',
          0,
          0,
          null
        ) ";

        $meQuery = mysql_query( $Sql1 );
      /*var_dump($Sql1);
      var_dump($meQuery);
      echo "<br>";*/
        //if($meQuery){
          
        //}
        //lose_detail
         $Sql2 = "SELECT ItemCode,
                         Qty,
                         Price,
                         Discount,
                         Total
                         FROM buffer_lose
                         WHERE Cus_Code = '$Cus_Code'";
         $meQuery = mysql_query($Sql2);

/*var_dump($Sql2);
echo "<br>";*/
         while ($Result = mysql_fetch_assoc($meQuery)) {
           $Sql3 = "INSERT INTO  lose_detail(
                                 DocNo,
                                 Item_Code,
                                 Qty,
                                 Price,
                                 Discount,
                               Total
                              )
                               VALUES(
                                 '".$dDocNo."',
                                 '".$Result['ItemCode']."',
                                 '".$Result['Qty']."',
                                '".$Result['Price']."',
                                '".$Result['Discount']."',
                               '".$Result['Total']."'
                               ) ";
           $meQuery_sub = mysql_query($Sql3);
/*var_dump($Sql3);
echo "<br>";*/
           }

          //delete buffer
           $Sql4 = "DELETE FROM buffer_lose WHERE Cus_Code = '$Cus_Code'";
          
           $meQuery = mysql_query($Sql4);
           $Sql5 = "SELECT
                  DATE_FORMAT(lose.DocDate,'%d-%m-%Y') AS DocDate5
                  FROM
                  lose
                  WHERE
                  DocNo = '$dDocNo'";
                  $meQuery = mysql_query($Sql5);
            while ($Result = mysql_fetch_assoc($meQuery)) {
       
              $DocDate = $Result["DocDate5"];
       
                } 
            array_push($array,
            array('flag'=>"true",
                  'DocNo'=>$dDocNo,
                  'Total'=>$Total,
                  'NameCus'=>$NameCus,
                  'Sumdiscount'=>$Sumdiscount,
                  'Sumprice'=>$Sumprice,
                  'DocDate'=>$DocDate
                ));

echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>