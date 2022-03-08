<?php
session_start();

$u_id=$_SESSION["user_id"];
include('db_ini.php');
 if (isset($_POST["projectid"])) {

  $projectid = $_POST["projectid"];
  $sql="SELECT * FROM schedule_project where p_id='$projectid'";
  $query=mysqli_query($conn,$sql);
  $users="";
  while ($db_row=mysqli_fetch_array($query)) {
    $users=$db_row["u_id"];
  }
  mysqli_free_result($query);
  $updatedusers="";
  $updatedusers=$users.$u_id.",";
   $sql1="UPDATE schedule_project set u_id='$updatedusers' where p_id='$projectid'";
   $query1=mysqli_query($conn,$sql1);
}
?>
