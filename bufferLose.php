<?php
require 'connect.php';
//require 'xFunction.php';
//============ Start Function ===========
	function chkItem( $Cus_Code,$ItemCode){
		$i = 0;
		$Sql = "SELECT COUNT(*) AS Cnt FROM buffer_lose WHERE Cus_Code = '".$Cus_Code."' AND ItemCode = '".$ItemCode."'";
		$meQuery = mysql_query( $Sql );
		while ($Result = mysql_fetch_assoc($meQuery)){
			$i = $Result["Cnt"];
		}
		return $i;
	}
//============ End Function ===========

	$array = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
	//if($_SERVER['REQUEST_METHOD']=='POST'){
	$Cnt = $_POST["Cnt"];
	$Cus_Code = $_POST["Cus_Code"];
	$ItemCode = $_POST["ItemCode"];
	$Qty = $_POST["Qty"];
	/*$Cnt = 3;
	$Cus_Code = "1035";
	$ItemCode = "0101010025,0101010026,0101010027";
	$Qty = '3,2,2';*/
	$ItemCode = explode(",", $ItemCode);
	$Qty = explode(",", $Qty);
	
	
	
			for($i=0;$i<$Cnt;$i++) {
			if(chkItem( $Cus_Code,$ItemCode[$i] )== 0){

//var_dump($ItemCode[$i]);

		$Sqlp = "SELECT SalePrice FROM item WHERE Item_Code ='$ItemCode[$i]' ";
		$meQuery = mysql_query( $Sqlp );
		while ($Result = mysql_fetch_assoc($meQuery)) {
      		$Sp = $Result["SalePrice"];
  			}
		
//var_dump($Sp);
//var_dump($Sqlp);

		$Sqld = "SELECT ((SUBSTR(customer.Discount,2,3))/100) AS Discount FROM customer WHERE Cus_Code ='$Cus_Code' ";
		$meQuery = mysql_query( $Sqld );
		while ($Result = mysql_fetch_assoc($meQuery)) {
      		$Dis = $Result["Discount"];
  			}

						$Discount = ($Qty[$i]*$Sp)*$Dis;

						$Total = (($Qty[$i]*$Sp)-($Qty[$i]*$Sp)*$Dis);

//var_dump($Dis);
//die;


						$Sql1 = "INSERT INTO buffer_lose 
					(Cus_Code,ItemCode,Qty,Price,Discount,Total) 
					VALUES 
					('$Cus_Code','$ItemCode[$i]','$Qty[$i]','$Sp','$Discount','$Total')";
					$meQuery2 = mysql_query( $Sql1 );
		}else{

				$Sql3 = "SELECT
				buffer_lose.ItemCode,
				item.NameTH,
				item.SalePrice,
				buffer_lose.Qty,
				SUM(((buffer_lose.Qty+'$Qty[$i]')*item.SalePrice)*(((SUBSTR(customer.Discount,2,3))/100))) AS Discount,
				SUM(((buffer_lose.Qty+'$Qty[$i]')*item.SalePrice)-((buffer_lose.Qty+'$Qty[$i]')*item.SalePrice)*(((SUBSTR(customer.Discount,2,3))/100))) AS Total
					FROM
				buffer_lose
				INNER JOIN item ON item.Item_Code = buffer_lose.ItemCode
				INNER JOIN customer ON customer.Cus_Code = buffer_lose.Cus_Code
					WHERE
				buffer_lose.Cus_Code = '".$Cus_Code."' AND buffer_lose.ItemCode = '".$ItemCode[$i]."'
					GROUP BY ItemCode ";

						$meQuery = mysql_query( $Sql3 );
						while ($Result = mysql_fetch_assoc($meQuery)) {
      					$Discount = $Result["Discount"];
						$Total = $Result["Total"];

  						}
/*var_dump($Discount);
var_dump($Total);*/
						

			$Sql4 = "UPDATE buffer_lose
			SET Qty= Qty + '".$Qty[$i]."',Discount='".$Discount."',Total='".$Total."'
			WHERE ItemCode ='".$ItemCode[$i]."' AND Cus_Code = '".$Cus_Code."'";
			$meQuery2 = mysql_query( $Sql4 );
		}


				
		}
	while ($Result = mysql_fetch_assoc($meQuery)) {
      		
      array_push($array,
        array('Scc'=>"true")
      );
  }
}else {
  array_push($array,
    array('Scc'=>"false")
  );
}
echo json_encode(array("result"=>$array));
	mysql_close($meConnect);
?>