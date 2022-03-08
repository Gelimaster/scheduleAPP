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
$s_inv ="S".generateRandomString();
include("db_ini.php");
//変数初期化
$schedulename="";
$scheduleid="";
$u_id=$_SESSION["user_id"];//********************
//新しいグループを作成
if (!$_POST["schedulename"]=="") {
  //新グループの情報を取得
  $schedulename= $_POST["schedulename"];
  $scheduletype= $_POST["scheduleType"];
  //作成されたスケジュールIDがすでに存在しないかを確認
  $sql="select * from schedule_table where s_inv ='$s_inv'";
  $query=mysqli_query($conn,$sql);
  $db_cnt = mysqli_num_rows($query);
  while (!$db_cnt==0) {
    //招待コードがユニック確認できるまで繰り返す
    $s_inv ="S".generateRandomString();
  }
  //新グループを登録
  $sql1 = "insert into schedule_table(s_name,s_inv,u_id,s_shared)values('$schedulename','$s_inv',',$u_id,',$scheduletype)";
  $query1 = mysqli_query($conn,$sql1);
}else{
  //招待コードから追加 スケジュールIDとユーザーIDを取得
  $scheduleid = $_POST["scheduleID"];
  //スケジュールはどのタイプ
  $sql2= "select * from schedule_table where s_inv ='$scheduleid'";
  $query2=mysqli_query($conn,$sql2);
  $scheduletype="";
  $schedulename="";
  while ($db_row = mysqli_fetch_array($query2)) {
   //スケジュール名と種類を取得
   $scheduletype= $db_row["s_shared"];
   $schedulename = $db_row["s_name"];
   if ($db_row["s_shared"]=="1") {
     //共通スケジュールにu_idを追加
     $update_u_id=$db_row["u_id"].$u_id.",";
     $sql3= "UPDATE schedule_table SET u_id = '$update_u_id' WHERE s_inv = '$scheduleid'";
     $query3 = mysqli_query($conn,$sql3);
   }else{
     //コピースケジュールに新ID作成
     $new_s_inv="S".generateRandomString();
     //新IDが存在してないの確認
     $sql4="select * from schedule_table where s_inv ='$new_s_inv'";
     $query4=mysqli_query($conn,$sql4);
     $db_cnt = mysqli_num_rows($query4);
     while (!$db_cnt==0) {
       //招待コードがユニック確認できるまで繰り返す
       $new_s_inv ="S".generateRandomString();
      }
      mysqli_free_result($query4);
      //新スケジュールをSchedule_tableに追加
      $sql5 = "insert into schedule_table(s_name,s_inv,u_id,s_shared)values('$schedulename','$new_s_inv',',$u_id,',$scheduletype)";
      $query5 = mysqli_query($conn,$sql5);
      //新スケジュールに中身にコピースケジュールを転送
      $sql6= "SELECT * FROM schedule_task_table WHERE s_id ='$scheduleid'";
      $query6= mysqli_query($conn,$sql6);
      while($db_row= mysqli_fetch_array($query6)){
        $sql7="insert into schedule_task_table(s_id,t_task_name,t_task_info,t_task_status,t_date,t_comme)values('$new_s_inv','$db_row[t_task_name]','$db_row[t_task_info]','$db_row[t_task_status]','$db_row[t_date]','$db_row[t_comme]')";
        $query7 = mysqli_query($conn,$sql7);
      }
   }
 }
 mysqli_free_result($query2);
}
?>
<script type="text/javascript">
location.href = '../Schedulev2.php';
</script>
</script>
