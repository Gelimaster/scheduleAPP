<?php
include('db_ini.php');
if( isset($_POST['groupid']) ){
 $scheduleid =$_POST['groupid'];
 $sql="SELECT * FROM schedule_group WHERE g_inv ='$scheduleid'";
 $query=mysqli_query($conn,$sql);
 $db_cnt=mysqli_num_rows($query);
 echo $db_cnt;
 exit;
}
?>
