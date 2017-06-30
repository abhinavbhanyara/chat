<?php session_start();
  session_unset();
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="signup.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <title>Login Page</title>
  </head>

<body id="bdy">
<div class="container" id="frm">
<?php
  $email = $password="";
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $emailErr = $passwordErr="";

  function checkPassword($password) {
    if (strlen($password) < 8) {
        $error = "Password too short!";
    }

    else if (!preg_match("#[0-9]+#", $password)) {
        $error = "Password must include at least one number!";
    }

    else if (!preg_match("#[a-zA-Z]+#", $password)) {
        $error = "Password must include at least one letter!";
    }
    return $error;
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["femail"])) {
      $emailErr = "Email is required";
    }
    else {
      $email = test_input($_POST["femail"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
      }
    }
    if (empty($_POST["fpassword"])) {
      $passwordErr = "Password is required";
    }
    else {
      $password=$_POST["fpassword"];
      $passwordErr=checkPassword($password);
    }
  }
?>

<div class="container" id="div1">

  <div id="div4">
    <p id="name">Login</p>
  </div>

  <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <div id="div2">
      <br>
    <input type="text" name="femail" placeholder="Email">
    <span class="error">* </span><br>
    <span class="error"><?php echo $emailErr;?></span>
    <br>
    <input type="password" name="fpassword" placeholder="Password">
    <span class="error">*</span><br>
    <span class="error"> <?php echo $passwordErr;?></span>
    <br><br><br>
    <button id="butn" class="btn btn-primary btn-block" type="submit">Login</button>
  </div>
  </form>

  <div id="div3">
    <img src="user1.png">
  </div>
<p style="margin-left:7%;" class="nxt">Don't have an account?</p><a class="nxt" id="n" href="signup.php">Signup here</a>
</div>

</div>

  <div class="container" id="div2">
  <?php
  if($emailErr==""&&$passwordErr==""&&$email!=""){
    $servername="localhost";
    $username="root";
    $pswd="abhi123.";
    try{
      $conn= new PDO("mysql:host=$servername;dbname=myDB", $username, $pswd);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $result =$conn->query("select count(*) from users where email='$email'");
      if($result->fetchColumn()>0){
        $q = $conn->query("select hash from users where email='$email'");
        $f = $q->fetch();
        $h = $f['hash'];
        if(password_verify($password, $h)){
          $q = $conn->query("select fullname from users where email='$email'");
          $f = $q->fetch();
          $_SESSION["user"]=$f['fullname'];
          $_SESSION["prvmsg"]="";
          ?>
          <script type="text/javascript">
            window.location="chat.php";
          </script>
          <?php
        }
        else{
          ?>
          <script type="text/javascript">
            alert("Incorrect Password");
          </script>
          <?php
        }
      }
      else{
        ?>
        <script type="text/javascript">
          alert("Email not registered");
        </script>
        <?php
      }
    }
    catch(PDOException $e){
      echo "Connection failed: ".$e->getMessage();
    }
    $conn=null;
  }
  ?>
  </div>
</body>
</html>
