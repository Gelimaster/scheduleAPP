<?php
session_start();
include('db_ini.php');
$u_id = $_SESSION["user_id"];
$idgroup =$_POST["groupid"];
$projectname =$_POST["projectname"];
$projectdescribe =$_POST["projectdescribe"];
$github =$_POST["github"];
$projectschedule=$_POST["projectschedule"];

if (isset($projectname)) {
  //プロジェクトをプロジェクトテーブルに登録
  $sql="insert into schedule_project(p_name,p_admin,g_id,u_id,p_des,p_git,g_schedule)values('$projectname','$u_id','$idgroup',',$u_id,','$projectdescribe','$github','$projectschedule')";
  $query=mysqli_query($conn,$sql);

  //作成されたプロジェクトIDを取得
  $sql1="SELECT * FROM schedule_project where p_name='$projectname' and p_admin='$u_id'";
  $query1=mysqli_query($conn,$sql1);
  $projectid="";
  while ($db_row=mysqli_fetch_array($query1)) {
    $projectid=$db_row["p_id"];
  }
  mysqli_free_result($query1);

  //グループに登録されてるプロジェクトIDを取得
  $sql2 ="SELECT * FROM schedule_group where g_id='$idgroup' ";
  $query2=mysqli_query($conn,$sql2);
  $projectsids="";
  $projectcount="";
  while($db_row=mysqli_fetch_array($query2)){
    $projectsids =$db_row["p_id"];
    $projectcount=explode(",",$db_row["p_id"]);
  }
  mysqli_free_result($query2);
  //もし何も登録されてなかった場合
  $p_id="";
  if (count($projectcount)==0) {
      $p_id =",".$projectid.",";
  }else{
    $p_id =$projectsids.$projectid.",";
  }
  //プロジェクトをグループに登録
  $sql3 ="UPDATE schedule_group set p_id='$p_id' where g_id='$idgroup' ";
  $query3=mysqli_query($conn,$sql3);

}
?>
