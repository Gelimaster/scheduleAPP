<?php
//変数の初期化
$err="";
$cnt=0;
//Createaccount.phpのデータを取得
$s_user = $_POST["username"];
$s_pass = $_POST["password"];
//パスワードを暗号化する
$hpass = password_hash($s_pass,PASSWORD_DEFAULT);
//エラーなければユーザー登録処理に移動する
if ($cnt==0) {
  //データに接続する
  include("db_ini.php");
  //同じユーザー名がデータベースにすでに登録してるかどうかを確認
  $sql="select * from user_table where u_user='$s_user'";
  $query= mysqli_query($conn,$sql);
  $db_cnt=mysqli_num_rows($query);
  if (!$db_cnt==0) {}else {
    //なかったら登録する
    //アカウント登録
    $sql = "insert into user_table(u_user,u_pass)values('$s_user','$hpass')";
    $query = mysqli_query($conn,$sql);
  }
  mysqli_free_result($query);
}
?>
<script>
  window.location.replace('createdone.php');
</script>
