<?php
require 'connect.php';
$array = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
  $Login_Code = $_POST["Login_Code"];
  //$Login_Code = '2';


  $Sql = "SELECT   
	    		 TransportQueue.DocNo,customer.FName,TransportQueue.DueDate,CONCAT(TransportQueue.transportID,' ',transporter.Fname) AS xName,transportqueue.IsSend,transportqueue.detail,transportqueue.transportID   
	    		 FROM TransportQueue   
	    		 INNER JOIN customer ON TransportQueue.Cus_Code = customer.Cus_Code   
	    		 LEFT JOIN transporter ON TransportQueue.transportID = transporter.User   
	    		 WHERE DueDate = DATE(NOW()) AND transporter.`User`= '$Login_Code'";
  $meQuery = mysql_query($Sql);
  while ($Result = mysql_fetch_assoc($meQuery)) {
    $DocNo = $Result["DocNo"];
    $FName = $Result["FName"];
    $DueDate = $Result["DueDate"];
    $xName = $Result["xName"];
    $IsSend = $Result["IsSend"];
    $detail = $Result["detail"];
    $transportID = $Result["transportID"];
      array_push($array,
        array('Scc'=>"true",
        		  'DocNo'=>$DocNo,
                  'FName'=>$FName,
                  'DueDate'=>$DueDate,
                  'xName'=>$xName,
                  'IsSend'=>$IsSend,
                  'detail'=>$detail,
                  'transportID'=>$transportID)
      );
  }
}else {
  array_push($array,
    array('Scc'=>"false")
  );
}
echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>