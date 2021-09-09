<?php

/*$servername = "us-cdbr-east-03.cleardb.com";
$username = "b4556e0ce0f10d";
$password = "788fd875";
$database = "heroku_85ffbe977f09ea2";*/

$servername = "localhost";
$username = "anshul";
$password = "777111";

try {
  $mysql = new PDO("mysql:host=$servername;dbname=PicxelWorld", $username, $password);
  $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
  echo "Connection Failed: ".$e->getMessage();
}

 ?>
