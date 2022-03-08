<?php
include("db_ini.php");
//削除するスケジュールIDを取得
$s_id=$_POST["schID"];
//スケジュールのタスクを削除
$sql="delete from schedule_task_table where s_id ='$s_id'";
$query=mysqli_query($conn,$sql);
//スケジュールを削除
$sql1="delete from schedule_table where s_inv ='$s_id'";
$query1=mysqli_query($conn,$sql1);
?>
