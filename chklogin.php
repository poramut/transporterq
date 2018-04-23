<?php
require 'connect.php';
$array = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
  $uName = $_POST['uname'];
  $pWord = $_POST['pword'];

/*$uName = '1';
  $pWord = '1234';*/

  $Sql = "SELECT transporter.User FROM transporter WHERE User = '$uName' AND Pass = '$pWord' ";
  $meQuery = mysql_query($Sql);
  while ($Result = mysql_fetch_assoc($meQuery)) {
    $User = $Result["User"];
      array_push($array,
        array('Scc'=>"true",
        'User'=>$User)
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