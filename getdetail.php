<?php
require 'connect.php';
$array = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
  $DocNo = $_POST["DocNo"];
  $detail = $_POST["detail"];
  //$Login_Code = '2';


  $Sql = "UPDATE transportqueue
            SET detail = '$detail'
            WHERE transportqueue.DocNo = '$DocNo'";
  $meQuery = mysql_query($Sql);

      array_push($array,
        array('Scc'=>"true")
      );
}else {
  array_push($array,
    array('Scc'=>"false")
  );
}
echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>