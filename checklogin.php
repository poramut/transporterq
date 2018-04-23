<?php
require 'connect.php';
$array = array();
$data = file_get_contents('php://input');
$data = json_decode($data);
var_dump($data);
$pword = $data->pword;
$uname = $data->uname;

/*if($_SERVER['REQUEST_METHOD']=='POST'){*/
  /*$uname = $_POST['uname'];
  $pword = $_POST['pword'];*/
  var_dump($uname."-".$pword);
/*  $uname = "pong";
  $pword = "1234";*/

  $Sql = "SELECT login.username,login.password FROM login WHERE username = '$uname' AND password = '$pword'";
  $meQuery = mysql_query($Sql);
  while ($Result = mysql_fetch_assoc($meQuery)) {
  		$Scc ="true";
      /*array_push($array,
        array('Scc'=>"true")
      );*/
  }
/*}else {
  array_push($array,
    array('Scc'=>"false")
  );*/
//}
echo json_encode(array("Scc"=>$Scc));
mysql_close($meConnect)
 ?>
