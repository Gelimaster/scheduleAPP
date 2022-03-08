<?php
//招待コードを作成
include("db_ini.php");
//変数初期化
//新しいグループを作成

  if (isset($_POST["schID"])) {
    $scheduleID= $_POST["schID"];
    $taskname= $_POST["taskname"];
    $taskComment=$_POST["taskComment"];
    $year= $_POST["year"];
    $month= $_POST["month"];
    $day= $_POST["day"];
    $tasks=$_POST["tasks"];
    $task_status=$_POST["task_status"];
    $date = $year."-".$month."-".$day;
    $sql="insert into schedule_task_table(s_id,t_task_name,t_task_info,t_task_status,t_date,t_comme)values('$scheduleID','$taskname','$tasks','$task_status','$date','$taskComment')";
    $query = mysqli_query($conn,$sql);
  }
?>
