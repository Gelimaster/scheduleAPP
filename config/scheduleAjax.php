<?php
include('db_ini.php');
if( isset($_POST['scheduleid']) ){
 $scheduleid =$_POST['scheduleid'];
 $sql="SELECT * FROM schedule_table WHERE s_inv ='$scheduleid'";
 $query=mysqli_query($conn,$sql);
 $db_cnt=mysqli_num_rows($query);
 echo $db_cnt;
 exit;
}
?>
