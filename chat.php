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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        window.setTimeout(update,100);
        $('.box').animate({ scrollTop: $('.box').prop("scrollHeight")}, 100);
      });
    }
    update();
    </script>
    <div class="container">
      <b id="p">Chatroom</b>
      <button id="logout" type="button" onclick="myfxn()">L</button>
    <div class="box">
      <script>
      $(document).ready(function()
        {
        $(document).bind('keypress', function(e) {
            if(e.keyCode==13){
              var selectedValue = $("input").val();
              $.post("chatupdate.php",{sv : selectedValue});
              $("input").val('');
             }
        });
      });
      function chat(){
        var selectedValue = $("input").val();
        $.post("chatupdate.php",{sv : selectedValue});
        $("input").val('');
        }
      </script>
    </div>
      <input id="txt" type="text" placeholder="Type a message" autocomplete="off" autofocus>
      <button class="btn" type="button" onclick="chat()">Send</button>
    </div>
    <script type="text/javascript">
      function myfxn(){
        window.location="login.php";
      }
    </script>
  </body>
</html>
