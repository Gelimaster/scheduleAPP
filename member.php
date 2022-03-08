<?php
include('config/db_ini.php');
if(isset($_POST['scheduleid']) ){
 $scheduleid =$_POST['scheduleid'];
 $sql="SELECT * FROM schedule_project WHERE p_id ='$scheduleid'";
 $query=mysqli_query($conn,$sql);
 $db_cnt=mysqli_num_rows($query);
 $member="";
 $names="";
 $members="";
 $u_id;
 while ($db_row = mysqli_fetch_array($query)) {
   $member=$db_row["u_id"];
   }
   $members = explode(",",$member);
     for ($i=1;$i<count($members)-1;$i++) {
     $sql1="SELECT * FROM user_table WHERE u_id =$members[$i]";
     $query1=mysqli_query($conn,$sql1);
     while ($db_row = mysqli_fetch_array($query1)) {
       $names .=$db_row["u_user"]."<br>";
       }
   }
 echo $names;
 exit;
}
?>
