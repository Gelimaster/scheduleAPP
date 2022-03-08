<?php
//セッションスタート
session_start();

include("config/db_ini.php");

if (isset($_POST["schID"])) {
  $_SESSION["schID"]=$_POST["schID"];
  $schId=$_SESSION["schID"];
}else{
  $schId="";
}
if (isset($_SESSION["schID"])) {
  $schId=$_SESSION["schID"];
}
//全体を検索
$invs="";
$sql="select * from schedule_table where  u_id like'%,$_SESSION[user_id],%'";//********************
$query= mysqli_query($conn,$sql);
while ($db_row = mysqli_fetch_array($query)) {
  $invs .=$db_row["s_inv"].",";
}
mysqli_free_result($query);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/schedule.css">
    <title></title>
  </head>
  <body onload="loadcalendar('<?php echo $invs?>')">
    <!-- スケジュール追加画面 -->

    <div id="dialog"  class="windows schegroupadd"  style="display:none;">
      <div class="outer clsch">
        <div class="inner">
          <a class="closebutton " onclick="closetab(dialog)">close</a>
        </div>
      </div>
			<h2>スケジュール追加</h2>
		  <form action='config/scheduleadd.php' id="schadd" method="post">
          <br id="snbr_err">
          <p id="sn_err"></p>
		      <p class="dialog-p"> <span>必須</span>スケジュール名:
		      <input class="input-box" type="text" id="sn"  name="schedulename" value="" maxlength="20"></p><br>
          <p>このスケジュールは複数人で使われますか？</p>
          <input type="radio"  name="scheduleType" value="0" checked>
          <label for="0">いいえ</label>
          <input type="radio" name="scheduleType" value="1">
          <label for="1">はい</label><br>
					<input class="button" type="submit" onclick="return sub1(sn)" id="snm" name="作成" value="作成">
					<br><br>
					<h2>スケジュールIDから参加・コピー</h2>
          <br id="sibr_err">
          <p id="si_err"></p>
		      <p class="dialog-p"><span>必須</span>スケジュールID:
		      <input class="input-box" type="text" id="si" name="scheduleID" value=""></p><br>
					<input class="button" type="button" onclick="return sub(si)"  id="sid" name="作成" value="参加・コピー"><br>
			</form>
		</div>
    <!-- グループ追加画面 -->
    <div id="groupadd"  class="windows schegroupadd" style="display:none;">
      <div class="outer clsch">
        <div class="inner">
          <a class="closebutton " onclick="closetab(groupadd)">close</a>
        </div>
      </div>
			<h2>グループの作成</h2>
		  <form action='config/groupadd.php' id="groupadd1" method="post">
          <br id="gnbr_err">
          <p id="gn_err"></p>
		      <p class="dialog-p" ><span>必須</span>グループ名:
		      <input type="text" id="gn"  name="groupname" value="" maxlength="20"></p><br>
					<input class="button" type="submit" onclick="return sub1(gn)" id="gnm" name="作成" value="作成">
					<br><br>
			    <h2>グループに参加する</h2>
          <br id="gibr_err">
          <p id="gi_err"></p>
		      <p class="dialog-p"><span>必須</span>グループID:
		      <input type="text" id="gi" name="groupID" value=""></p><br>
					<input class="button" type="button" onclick="return sub(gi)" id="gid" name="参加" value="参加">
			</form>
		</div>
    <!-- スケジュール -->
    <nav>
      <h1>スケジュール</h1>
      <ul>

        <li>
          <input  class="navli" type="button" onclick="setall('<?php echo $invs?>','calendar1')" value="全体">
        </li>
				<!-- schedule  loop -->
        <?php
        //スケジュール名を検索
        $sql="select * from schedule_table where  u_id like'%,$_SESSION[user_id],%'";//********************
        $query= mysqli_query($conn,$sql);
        while ($db_row = mysqli_fetch_array($query)) {
          ?>
          <li>
            <form  method="post" >
              <input class="navli" type="button" onclick="setschedule('<?php echo $db_row["s_inv"];?>','calendar')"  value="<?php echo $db_row["s_name"]; ?>">
            </form>
            <div class="outer">
              <div class="inner">
                <a class="schpgdele" onclick=deleteschedule('<?php echo $db_row["s_inv"]?>')>delete</a>
              </div>
            </div>
          </li>
          <?php
        }
        //schedule group loop end
        mysqli_free_result($query);
        ?>
        <div id="scheduledelete">
          <iframe src="config/scheduledel.php" style="display:none;"></iframe>
        </div>
				<li>
					<input id="navplus" class="plus-css" type="button"  onclick="opentab(dialog,groupadd)" value="+">
				</li>
        <!-- グループ -->
        <h1>グループ</h1>
        <!-- group  loop -->
        <?php
        //グループ名を検索
        $sql="select * from schedule_group where  u_id like'%,$_SESSION[user_id],%'";//********************
        $query= mysqli_query($conn,$sql);
        while ($db_row = mysqli_fetch_array($query)) {
          ?>
          <li>
            <form  method="post" >
              <input class="navli" type="button"  onclick="setgroup('<?php echo $db_row["g_inv"];?>','<?php echo $db_row["g_name"]; ?>','<?php echo $db_row["g_id"]; ?>','group')"  value="<?php echo $db_row["g_name"]; ?>">
            </form>
            <div class="outer">
              <div class="inner">
                <a class="schpgdele" onclick=leavegroup('<?php echo $db_row["g_inv"]?>','<?php echo $_SESSION["user_id"]?>')>delete</a>
              </div>
            </div>
          </li>
          <?php
        }
        //schedule group loop end
        mysqli_free_result($query);
        ?>
        <div id="groupdelete">
          <iframe src="config/groupdel.php" style="display:none;"></iframe>
        </div>
        <li>
          <input id="grouplus" class="plus-css" type="button"  onclick="opentab(groupadd,dialog)" value="+">
        </li>
    	</ul>
    </nav>
    <main>
      <div>
        <!--ユーザー名、スケジュールID表示 -->
        <div class="toppage">
          <p class="topinline" id="setid">スケジュールID: <?php echo $schId?></p>
          <p class="topinline" id="topusername"><?php echo $_SESSION["user_name"]?></p>    <!--//******************** -->
          <a class="topinline" id="logout" href="Login.php">Log out</a>
          <br>
        </div>
        <!-- カレンダー表示 -->
  			<div class="display-window" id="results"></div>

      </div>
    </main>
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/Schedule.js"></script>
  </body>
</html>
