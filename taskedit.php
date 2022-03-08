<?php
if (isset($_POST["taskid"])) {
  $taskid=$_POST["taskid"];
  $taskname=$_POST["taskname"];
  include('config/db_ini.php');
  $sql="select * from schedule_task_table where  t_id='$taskid'";
  $query= mysqli_query($conn,$sql);
  $db_cnt = mysqli_num_rows($query);
  $taskcountainer ="";
  $count="";
  $x="";
  if (!$db_cnt==0) {
    while ($db_row = mysqli_fetch_array($query)) {
      $des=$db_row["t_comme"];
      $tasks=explode(",",$db_row["t_task_info"]) ;
      $count=count($tasks);
      for ($i=0;$i<count($tasks);$i++) {
        $x=$i+1;
        if ($x==1) {
           $taskcountainer .= " <label id='label0$x' for='task0$x'>タスク $x :</label><input class='input-box tasks' type='text' placeholder='$tasks[$i]'  id='task0$x'   value='$tasks[$i]'><br>";
        }else{
           $taskcountainer .= " <label id='label0$x' for='task0$x'>タスク $x :</label><input class='input-box tasks' type='text' placeholder='$tasks[$i]'  id='task0$x'   value='$tasks[$i]'><input class='button2' type='button' value='x' id='remove0$x' onclick=deleteedittasklist1('task0$x','remove0$x','br0$x','label0$x','$x')></input>   <br id='br0$x'>";
        }

      }
    }
  }
}
?>
<h3 class="center">編集モード</h3><br>
<label for="title">タイトル :</label>
<input class="input-box tasks"  type="text" id="title" name="title" value="<?php echo $taskname;?>"><br>
<?php
echo $taskcountainer;
?>
<div id="createnewedittask"></div>
<input class="taskplusbutton2" type="button" onclick="createedittask(<?php echo $count?>)" value="+"><br>
<br>
<label for="describe">詳細　:</label>
<input class="input-box" type="text" name="describe" id="taskdes"  placeholder="<?php echo $des;?>"  value="<?php echo $des;?>"><br><br>
<input class="button3" type="button" onclick="DBtaskedit(<?php echo $i;?>,'taskdes','title',<?php echo $taskid;?>)" value="変更を確定">
