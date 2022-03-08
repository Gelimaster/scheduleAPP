<?php
  //データベース接続情報

  //自分のPCのデータベースに接続する情報
  //ホストの情報
  $host = "localhost";
  //ユーザ情報
  $user = "kobayashi";
  //パスワード情報
  $pass = "kilo1302";
  //データベースの名前
  $db_name = "scheduleapp";


  //MySqlサーバ接続
  $conn = mysqli_connect
  ($host,$user,$pass,$db_name);

if($conn == false){
print "MySqlサーバー接続に失敗しました。";
exit;
}

?>
