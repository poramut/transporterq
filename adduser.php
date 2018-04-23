<?php
require 'connect.php';
$array = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
  $uname = $_POST['uname'];
  $pword = $_POST['pword'];

  $Sql = "INSERT INTO login(username,password) VALUES ('$uname','$pword')";
  $meQuery = mysql_query($Sql);
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
mysql_close($meConnect)
 ?>
