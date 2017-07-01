<?php
session_start();
$message = $_POST['sv'];
$servername="localhost";
$username="root";
$pswd="abhi123.";
try{
$conn= new PDO("mysql:host=$servername;dbname=myDB", $username, $pswd);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$name=$_SESSION["user"];
if($message!=""){
  $message="<b>".$name."</b>".": ".$message."<br>";
  $sql = "update users set message=CONCAT(message,'$message') where id=1";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $q = $conn->query("select message from users where id=1");
  $f = $q->fetch();
  $h = $f['message'];
  if(strlen($h)>55000){
    $sql = "update users set message='' where id=1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
  }
}
else{
$q = $conn->query("select message from users where id=1");
$f = $q->fetch();
$h = $f['message'];
if($h==null){
  $sql = "update users set message='' where id=1";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  }
}
//echo $h;
}
catch(PDOException $e){
echo "Connection failed: ".$e->getMessage();
}
$conn=null;
?>
