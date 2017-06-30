<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="signup.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <title>Signup Page</title>
  </head>

<body id="bdy">
<div class="container" id="frm">
<?php
  $name = $email = $password="";
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $nameErr = $emailErr = $passwordErr="";

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
    if (empty($_POST["fname"])) {
      $nameErr = "Name is required";
    }
    else {
      $name = test_input($_POST["fname"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $nameErr = "Only letters and spaces allowed";
      }
    }
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
    <p id="name">Create an account</p>
  </div>

  <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <div id="div2">
    <input type="text" name="fname" placeholder="Enter your fullName">
    <span class="error">* </span><br>
    <span class="error"><?php echo $nameErr;?></span>
    <br>
    <input type="text" name="femail" placeholder="Enter your email">
    <span class="error">* </span><br>
    <span class="error"><?php echo $emailErr;?></span>
    <br>
    <input type="password" name="fpassword" placeholder="Create new password">
    <span class="error">*</span><br>
    <span class="error"> <?php echo $passwordErr;?></span>
    <br><br>
    <button id="butn" class="btn btn-primary btn-block" type="submit">Signup</button>
  </div>
  </form>

  <div id="div3">
    <img src="user1.png">
  </div>
<!--Adding a photo upload section
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <button id="upload" class="btn btn-primary btn-xs" type="submit">Upload</button>
</form>
-->
<p class="nxt">Already a user?</p><a class="nxt" id="n" href="login.php">Login here</a>
</div>

</div>

  <div class="container" id="div2">
  <?php
    //Write data in a file
    /*
      if($nameErr==""&&$emailErr==""){
        $fileptr = fopen("file.txt", "a") or die("Unable to open file!");
        fwrite($fileptr, $name."\n");
        fwrite($fileptr, $email."\n");
        fwrite($fileptr, $password."\n");
        fclose($fileptr);
      }
    */
  if($nameErr==""&&$emailErr==""&&$passwordErr==""&&$name!=""){
    $servername="localhost";
    $username="root";
    $pswd="abhi123.";
    try{
      $conn= new PDO("mysql:host=$servername;dbname=myDB", $username, $pswd);
      //set PDO error to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //using prepared statements
      $result =$conn->query("select count(*) from users where email='$email'");
      if($result->fetchColumn()>0){
        ?>
        <script type="text/javascript">
          alert("Email already registered");
        </script>
        <?php
      }
      else{
        $statement=$conn->prepare("insert into users (fullname, email, hash) values (:fullname, :email, :hash)");
        $hash=password_hash($password, PASSWORD_DEFAULT);
        $statement->bindParam(':fullname', $name);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':hash', $hash);
        $statement->execute();
      ?>
      <script>
      alert("Account created successfully");
      window.location="login.php";
      </script>
      <?php
      }
      //header("Location: login.php");
      //exit;
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
