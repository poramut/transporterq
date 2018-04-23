<?php
require 'connect.php';
$array = array();

  $DocNo = $_POST["DocNo"];
  //$Login_Code = '2';


  $Sql = "UPDATE transportqueue
            SET IsSend = 0
            WHERE transportqueue.DocNo = '$DocNo'";
  $meQuery = mysql_query($Sql);

      array_push($array,
        array('Scc'=>"true")
      );

echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>