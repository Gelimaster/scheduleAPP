<?php
session_start();
//変数の初期化
$err;


//Login.phpデータを取得
$username= $_POST["username"];
$password= $_POST["password"];
$_SESSION['user_name']= $username;//******************************
//データベース接続
include("db_ini.php");
//ユーザー名が登録されてるかどうかの処理
$sql="select * from user_table where u_user='$username'";
$query= mysqli_query($conn,$sql);
$db_cnt = mysqli_num_rows($query);
if ($db_cnt == 0) {
  //ユーザー名がデータベースに存在しない場合
  $err="ユーザー名が間違っています。";
}else{
  //ユーザー名が見つかった場合、そのユーザー名とパスワードが一致してるかどうかの処理
  while ($db_row = mysqli_fetch_array($query)) {
    if ($verify = password_verify($password, $db_row["u_pass"])){
      // パスワードが一致してる場合
        //セッションスタートでログインしたユーザのIDを保存
        $_SESSION["user_id"]= $db_row["u_id"];//******************************
      ?>
      <script type="text/javascript">
      location.href = '../Schedulev2.php';
    </script>
      <?php
    }else {
      // パスワードが一致してない場合い
      $err= "パスワードが間違っています。";
    }
  }
  mysqli_free_result($query);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/login.css">
    <title></title>
  </head>
  <body>
    <input type="hidden" id="error_message" value="<?php print $err ?>">
    <?php
    if (!$err=="") {
    ?>
<form  action="loginsql.php" method="post">

  <h1>ログイン</h1>
  <br id="br_err">
  <p id="pass_err"></p>
  <input type="text" name="username" value="<?php echo $username?>" placeholder="Username"> <br>
  <input type="password" name="password" value="" placeholder="Password"> <br>
  <input id="button" type="submit" name="Login" value="Login">
  <a href="../Createaccount.php">新しいアカウント作成</a>
</form>

<?php
}
?>
<script>
//エラーメッセージの表示処理
if (!document.getElementById('error_message').value=="") {
  document.getElementById('pass_err').innerHTML=document.getElementById('error_message').value
  document.getElementById('br_err').style.display="none"
}else {
  window.location.replace('createdone.php');
}


</script>

  </body>
</html>
