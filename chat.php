<?php
session_start();
if(!$_SESSION["user"]){
  ?>
  <script type="text/javascript">
    window.location="login.php";
  </script>
  <?php
}
//session_destroy();
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="chat.css">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <script type="text/javascript" src="jquery.js"></script>
    <title>Chatroom</title>
  </head>
  <body>
    <script type="text/javascript">
    function update(){
      $.get('update.php', function(data){
        $(".box").html(data);
        window.setTimeout(update,1000);
      });
    }
    update();
    </script>
    <div class="container">
      <b id="p">Chatroom</b>
    <div class="box">
      <?php
      $message="";
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
      $message = test_input($_POST["chatBox"]);
      $servername="localhost";
      $username="root";
      $pswd="abhi123.";
      try{
        $conn= new PDO("mysql:host=$servername;dbname=myDB", $username, $pswd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $name=$_SESSION["user"];
        if($message!=""){
          $message="<b>".$name."</b>".": ".$message."<br>";
          $sql = "update users set message=CONCAT('$message',message) where id=1";
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
        echo $h;
        }
      catch(PDOException $e){
        echo "Connection failed: ".$e->getMessage();
        }
       $conn=null;
      ?>
    </div>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
      <input id="txt" type="text" name="chatBox" placeholder="Type a message" autofocus>
      <button class="btn" type="submit">Send</button>
    </form>
    </div>
    <script type="text/javascript">
      function myfxn(){
        window.location="login.php";
      }
    </script>
    <button id="btn" class="btn" type="button" onclick="myfxn()">Logout</button>
  </body>
</html>
