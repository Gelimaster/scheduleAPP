<?php
session_start();
$_SESSION["schID"]="";
$_SESSION["page"]="";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/login.css">
    <title></title>
  </head>
  <body>
  <form  action="config/loginsql.php" method="post">
    <h1>ログイン</h1>
    <br>
    <input type="text" name="username" value="" placeholder="Username"> <br>
    <input type="password" name="password" value="" placeholder="Password"> <br>
    <input id="button" type="submit" name="Login" value="Login">
    <br>
    <a  href="Createaccount.php">新しいアカウント作成</a>
  </form>

</html>
