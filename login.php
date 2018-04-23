<?php
require 'connect.php';
$array = array();

$Sql = "SELECT login.username,login.password FROM login";
$meQuery = mysql_query($Sql);
while ($Result = mysql_fetch_assoc($meQuery)) {
    $username = $Result["username"];
    $password = $Result["password"];
    array_push($array,
      array('username'=>$username,
      'password'=>$password)
    );
}

echo json_encode(array("result"=>$array));
mysql_close($meConnect)
 ?>
