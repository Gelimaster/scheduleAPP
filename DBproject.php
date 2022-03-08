<?php
session_start();
$user_id=$_SESSION["user_id"];

if (isset($_POST["projectid"])) {
  $projectid=$_POST["projectid"];
  include('config/db_ini.php');
  $sql="select * from schedule_project where  p_id='$projectid'";
  $query= mysqli_query($conn,$sql);
  $db_cnt = mysqli_num_rows($query);
  $projectdescribe="";
  $projectadmin="";
  $participate="";
  $flg=FALSE;
  $github="";
  $schedule="";
  if (!$db_cnt==0) {
    while ($db_row = mysqli_fetch_array($query)) {
      $projectdescribe="<p>".$db_row["p_des"]."</p>";
      $projectadmin=$db_row["p_admin"];
      $participate= explode(",",$db_row["u_id"]);
      $github=$db_row["p_git"];
      $schedule=$db_row["g_schedule"];
    }
    for ($i=0; $i <count($participate) ; $i++) {
      if ($user_id==$participate[$i]) {
        $flg=TRUE;
      }
    }
  }
}
if ($user_id==$projectadmin) {
  echo "<input class='deleprojectbutton' type='button' onclick=deleteproject('$projectid') value='プロジェクト削除'></input>";
}else{
  if ($flg==TRUE) {
    echo "<input class='deleprojectbutton' type='button' onclick=leaveproject('$projectid') value='プロジェクトから抜ける'></input>";
  }
}


?>
<input type="button" id="memberbutton" onclick="members(<?php echo $projectid ; ?>)" value="メンバー">
<h3 class="center">プロジェクトについて</h3>
<?php
echo $projectdescribe;
if ($flg==true) {
  echo "<a class='button5' href='$github'>プロジェクトのGitHubページへ</a>";
}

if ($flg==FALSE) {
?>
<input type="button" class="button5"  onclick="participate('<?php echo $projectid?>')" value="参加">
<?php
}

?>
