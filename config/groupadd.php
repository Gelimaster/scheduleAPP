<?php
//招待コードを作成
session_start();
function generateRandomString($length = 10) {
  $characters = '0123456789';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
$g_inv ="G".generateRandomString();
include("db_ini.php");
//変数初期化
$groupname="";
$groupid="";
$u_id=$_SESSION["user_id"];//********************
//新しいグループを作成
if (!$_POST["groupname"]=="") {
  //新グループの情報を取得
  $groupname= $_POST["groupname"];
  //作成されたグループIDがすでに存在しないかを確認
  $sql="select * from schedule_group where g_inv ='$g_inv'";
  $query=mysqli_query($conn,$sql);
  $db_cnt=mysqli_num_rows($query);
  while (!$db_cnt==0) {
    //招待コードがユニック確認できるまで繰り返す
    $g_inv ="G".generateRandomString();
  }
  //新グループを登録
  $sql1 = "insert into schedule_group(g_name,g_inv,u_id,g_admin)values('$groupname','$g_inv',',$u_id,',$u_id)";
  $query1 = mysqli_query($conn,$sql1);
}else{
  //招待コードから追加 スケジュールIDとユーザーIDを取得
  $groupid = $_POST["groupID"];
  //スケジュールはどのタイプ
  $sql2= "select * from schedule_group where g_inv ='$groupid'";
  $query2=mysqli_query($conn,$sql2);
  while ($db_row = mysqli_fetch_array($query2)) {
     //グループにu_idを追加
     $update_u_id=$db_row["u_id"].$u_id.",";
     $sql3= "UPDATE schedule_group SET u_id = '$update_u_id' WHERE g_inv = '$groupid'";
     $query3 = mysqli_query($conn,$sql3);
   }
   mysqli_free_result($query2);
 }
?>
<script type="text/javascript">
location.href = '../Schedulev2.php';
</script>



</script>
