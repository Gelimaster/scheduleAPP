<?php
include('db_ini.php');
//削除したいタスク名を取得
$delete_this_task=$_POST["taskName"];
$delete_this_task_id=$_POST["taskid"];
//データベースに削除クエリ
$sql= "DELETE FROM schedule_task_table WHERE t_task_name='$delete_this_task' and t_id='$delete_this_task_id'";
//実行
$query=mysqli_query($conn,$sql);
?>
