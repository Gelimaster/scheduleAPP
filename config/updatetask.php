<?php
include('db_ini.php');
//更新するタスクのデータを取得
$taskid=$_POST["taskid"];
$position=$_POST["order"];
$status=$_POST["status"];
//Arrayに使う変数
$updatedstatus="";
$taskstatus="";
//更新するタスクをデータベースに検索
$sqlselect ="select * from schedule_task_table where t_id='$taskid' ";
$query=mysqli_query($conn,$sqlselect);
$db_cnt = mysqli_num_rows($query);
if (!$db_cnt==0) {
  while ($db_row = mysqli_fetch_array($query)) {
    //StringにしてあるArrayを元に戻す
    $taskstatus=explode(",",$db_row["t_task_status"]);
    $taskstatus[$position]=$status;
  }
  mysqli_free_result($query);
  //ArrayをStringに戻しデータベースに更新する
  for ($x=0; $x <count($taskstatus) ; $x++) {
    if ($x==count($taskstatus)-1) {
      $updatedstatus .=$taskstatus[$x];
    }else{
        $updatedstatus .=$taskstatus[$x].",";
    }
  }
  $sql="update schedule_task_table set t_task_status='$updatedstatus' where t_id='$taskid'";
  $query= mysqli_query($conn,$sql);
}
?>
