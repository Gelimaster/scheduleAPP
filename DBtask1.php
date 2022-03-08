<?php
$taskcountainer="";
$des="";
if (isset($_POST["taskid"])) {
  //データベースからタスク検索
  include('config/db_ini.php');
  $taskid=$_POST["taskid"];
  $sql="select * from schedule_task_table where  t_id='$taskid'";
  $query= mysqli_query($conn,$sql);
  $db_cnt = mysqli_num_rows($query);
  $taskname="";
  if (!$db_cnt==0) {
    while ($db_row = mysqli_fetch_array($query)) {
      $taskname=$db_row["t_task_name"];
      $des=$db_row["t_comme"];
      $tasks=explode(",",$db_row["t_task_info"]);
      $taskstatus=explode(",",$db_row["t_task_status"]);
      for ($i=0;$i<count($tasks);$i++) {
       if (!$taskstatus[$i] == "0") {
         $taskcountainer .= "$tasks[$i]<input type='checkbox' id='$tasks[$i]' onclick=updatestatus('$taskid',$taskstatus[$i],$i) value='$taskstatus[$i]' checked ><br>";
       }else{
         $taskcountainer .= "$tasks[$i]<input  type='checkbox' id='$tasks[$i]' onclick=updatestatus('$taskid',$taskstatus[$i],$i)  value='$taskstatus[$i]' ><br>";
       }
      }
    }
  }
}
 echo $taskcountainer;
?>
<br>
<h3 class="center">詳細</h3>
<p><?php echo $des;?></p><br>
