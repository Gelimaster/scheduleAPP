<?php
include("db_ini.php");
//削除するスケジュールIDを取得
$g_inv=$_POST["groupID"];
$u_id=$_POST["userid"];
// $g_inv="G6934520199";
// $u_id="1";
$flag = true;

while ($flag==true) {
  //グループから出る・削除
  $sql="SELECT * FROM schedule_group where  g_inv='$g_inv'";
  $query=mysqli_query($conn,$sql);
  while ($db_row=mysqli_fetch_array($query)) {
    $users =explode(",",$db_row["u_id"]);
    $projects=explode(",",$db_row["p_id"]);
  }
    if((count($users)-1)<3) {
      //最後にグループからぬける時はグループごと削除（その中に含むプロジェクトも削除される）
      if (count($projects)<=1) {
        //プロジェクトを削除
        for ($i=0; $i<count($projects)-1 ; $i++) {
          $del =$projects[$i];
          $sql1 = "DELETE FROM schedule_project where p_id ='$del'";
          $query1= mysqli_query($conn,$sql1);
        }
      }
      //最後にグループを削除
      $sql2="DELETE FROM schedule_group where g_inv ='$g_inv'";
      $query2=mysqli_query($conn,$sql2);
      $flag=false;
    }else{
      //グループに一人以上参加してたらグループからぬける
      $newusers="";
      for ($i=0; $i <count($users)-1 ; $i++) {
        if ($u_id==$users[$i]) {
          //登録されてるIDと抜けたい人のID一致した場合削除
      }else{
        //一致しない場合
        $newusers .= $users[$i].",";
      }
      }
      //グループの参加を更新かける
      $sql3="UPDATE schedule_group set u_id ='$newusers'  where g_inv = '$g_inv'";
      $query3=mysqli_query($conn,$sql3);
      $flag=false;
    }
  }

?>
