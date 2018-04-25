<?php
require 'connect.php';
$array = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
  $DocNo = $_POST["DocNo"];
  $Lati = $_POST["Lati"];
  $Longti = $_POST["Longti"];
  $Location = $_POST["Location"];
  // $DocNo = 'S0011804-00498';
  // $Lati = '18.7070583';
  // $Longti = '99.0470533';
  // $Location = '389 11 ตำบล ยางเนิ้ง อำเภอ สารภี เชียงใหม่ 50140 ประเทศไทย';
  //$Login_Code = '2';
  $Lati = doubleval($Lati);
  $Longti = doubleval($Longti);

  $Sql = "UPDATE transportqueue
            SET IsSend = 1,
            Latitude = $Lati,
            Longtitude = $Longti,
            Location = '$Location'
            WHERE transportqueue.DocNo = '$DocNo'";
            echo $Sql;
  $meQuery = mysql_query($Sql);

  if($meQuery){
      array_push($array,
        array('Scc'=>"true")
      );
    }else {
      array_push($array,
        array('Scc'=>"false")
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
