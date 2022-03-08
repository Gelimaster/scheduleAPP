<?php
if (isset($_POST["taskid"])) {
  $taskid = $_POST["taskid"];
  $taskname = $_POST["title"];
  $tasks = $_POST["tasks"];
  $describe = $_POST["describe"];
  include("db_ini.php");
  //タスク状態の数を修正
  if (isset($_POST["taskcount"])) {

    $taskcount =$_POST["taskcount"];
    $sql="SELECT * FROM schedule_task_table where t_id=$taskid";
    $query=mysqli_query($conn,$sql);
    $status="";
    $statuscount="";
    while ($db_row=mysqli_fetch_array($query)) {
      $status=$db_row["t_task_status"];
      $statuscount=explode(",",$db_row["t_task_status"]);
    }
    $i=count($statuscount);
    if ($i<$taskcount) {
      while($i<$taskcount){
        $status= $status.",0";
        $i++;
      }
      $sql="update schedule_task_table set t_task_name='$taskname' ,t_task_info='$tasks',t_comme='$describe',t_task_status='$status' where t_id=$taskid";
      $query=mysqli_query($conn,$sql);
    }
    $x=0;
    $newstatus="";
    if ($i>$taskcount) {
      while ($x < $taskcount) {
        if ($x==($taskcount)-1) {
          $status =$statuscount[$x];
        }else{
          $status =$statuscount[$x].",";
        }
        $newstatus .=$status;
        $x++;
      }
      $sql="update schedule_task_table set t_task_name='$taskname' ,t_task_info='$tasks',t_comme='$describe',t_task_status='$newstatus' where t_id=$taskid";
      $query=mysqli_query($conn,$sql);
    }
  }else{
    $sql="update schedule_task_table set t_task_name='$taskname' ,t_task_info='$tasks',t_comme='$describe' where t_id=$taskid";
    $query=mysqli_query($conn,$sql);
  }
}

?>
