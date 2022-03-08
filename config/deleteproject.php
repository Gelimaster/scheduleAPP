<?php
include('db_ini.php');
if (isset($_POST["projectid"])) {
  $projectid = $_POST["projectid"];
  $sql="DELETE FROM schedule_project where p_id='$projectid'";
  $query=mysqli_query($conn,$sql);
}
?>
