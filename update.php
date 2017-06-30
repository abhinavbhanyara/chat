<?php
$servername="localhost";
$username="root";
$pswd="abhi123.";
try{
  $conn= new PDO("mysql:host=$servername;dbname=myDB", $username, $pswd);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $q = $conn->query("select message from users where id=1");
  $f = $q->fetch();
  $h = $f['message'];
  echo $h;
  }
catch(PDOException $e){
  echo "Connection failed: ".$e->getMessage();
  }
 $conn=null;
  ?>
