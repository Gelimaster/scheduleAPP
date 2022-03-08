<?php session_start(); ?>
<!-- リロードするためのDIV -->
<div id="calendarreload">
<?php
//キャッシュを作らないようにするための処理
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//カレンダー出力用変数　初期化定義
$msg = "";
$db_cnt="";
$db_cnt1="";
$db_cnt2="";
$yyyyb="";
$yyyyn="";
$taskid= array();
$taskdate = array();
$taskid_before_month= array();
$taskdate_before_month = array();
$taskid_next_month= array();
$taskdate_next_month = array();
//年・月の取得 issetで前月に
if(isset($_POST["year"])){
	$this_year = $_POST["year"];
	$this_month = $_POST["month"];
	$this_day=date("d");
}else{
	//ない場合はコンピュータの日付を取得
	$this_year = date("Y");
	$this_month =date("m");
	$this_day = date("d");
}

//出力用月
$b_month = $this_month-1;
$n_month = $this_month+1;
//出力用月の制御
if ($b_month== 0) {
	$b_month= 12;
}
if ($n_month == 13) {
	$n_month=1;
}

//先月の日付制御
//前の月が0になった場合
$mmb="";
if ($this_month-1 == 0) {
	//年に-1をして月を12に戻す
	$yyyyb=$this_year-1;
	$mm=12;
	$date_before_m=$yyyyb."-".($mm);
	$mmb=strval($mm);
	}else{
			$yyyyb=$this_year;
			$date_before_m=$this_year."-0".($this_month-1);
			if (($this_month-1)==10||($this_month)-1==11) {
				$mmb=strval($this_month-1);
			}else{
					$mmb="0".strval($this_month-1);
			}
		}
//来月の日付制御
//来月の月が13になった場合
$mmn="";
if ($this_month+1==13) {
	//年に+1をして月を1に戻す
	$yyyyn=$this_year+1;
	$mm="01";
	$date_next_m=$yyyyn."-".($mm);
	$mmn=strval($mm);
	}else{
		$yyyyn=$this_year;
		$date_next_m=$this_year."-0".($this_month+1);
		if (($this_month-1)==10||($this_month)-1==11) {
			$mmn=strval($this_month+1);
		}else{
			$mmn="0".strval($this_month+1);
		}
	}

//PostされたスケジュールIDをSessionに登録
if(isset($_POST["schID"])){
	$_SESSION["schID"]=$_POST["schID"];
}


$this_month1=$this_month;

if ($this_month=="10"||$this_month=="11"||$this_month=="12") {
}else {
	$this_month=$this_month[1];

}
//スケジュールのタスクを出力処理
if (isset($_SESSION["schID"])) {
 	$schId= $_SESSION["schID"];
	$date = $this_year."-".$this_month1."-%";
	include('config/db_ini.php');
	//前月のタスク検索
	$sql1="select * from schedule_task_table where s_id='$schId' and  t_date between '$date_before_m-20' and '$date_before_m-31'";
	$query1= mysqli_query($conn,$sql1);
	$db_cnt1 = mysqli_num_rows($query1);
	if ($db_cnt1 != 0) {
		while ($db_row1 = mysqli_fetch_array($query1)) {
			$cnt[(int)substr($db_row1["t_date"],-2)]=0;
			if (!empty($taskdate_before_month[$cnt[(int)substr($db_row1["t_date"],-2)]][(int)substr($db_row1["t_date"],-2)])) {
				$cnt[(int)substr($db_row1["t_date"],-2)]++;
				$taskdate_before_month[$cnt[(int)substr($db_row1["t_date"],-2)]][(int)substr($db_row1["t_date"],-2)]= $db_row1["t_task_name"];
				$taskid_before_month[$cnt[(int)substr($db_row1["t_date"],-2)]][(int)substr($db_row1["t_date"],-2)]=$db_row1["t_id"];
			}else{
				$taskdate_before_month[$cnt[(int)substr($db_row1["t_date"],-2)]][(int)substr($db_row1["t_date"],-2)]= $db_row1["t_task_name"];
				$taskid_before_month[$cnt[(int)substr($db_row1["t_date"],-2)]][(int)substr($db_row1["t_date"],-2)]=$db_row1["t_id"];
			}
		}
	}else{
	}
	//今月のタスク検索
	$sql="select * from schedule_task_table where s_id='$schId' and  t_date LIKE '$date'";
	$query= mysqli_query($conn,$sql);
	$db_cnt = mysqli_num_rows($query);
	if ($db_cnt != 0) {
		while ($db_row = mysqli_fetch_array($query)) {
			$cnt[(int)substr($db_row["t_date"],-2)]=0;
			if (!empty($taskdate[$cnt[(int)substr($db_row["t_date"],-2)]][(int)substr($db_row["t_date"],-2)])) {
				// code...
				$cnt[(int)substr($db_row["t_date"],-2)]++;
				$taskdate[$cnt[(int)substr($db_row["t_date"],-2)]][(int)substr($db_row["t_date"],-2)]= $db_row["t_task_name"];
				$taskid[$cnt[(int)substr($db_row["t_date"],-2)]][(int)substr($db_row["t_date"],-2)]=$db_row["t_id"];
			}else{
				$taskdate[$cnt[(int)substr($db_row["t_date"],-2)]][(int)substr($db_row["t_date"],-2)]= $db_row["t_task_name"];
				$taskid[$cnt[(int)substr($db_row["t_date"],-2)]][(int)substr($db_row["t_date"],-2)]=$db_row["t_id"];
			}
		}
	}else{
	}
	//来月のタスク検索
	$sql2="select * from schedule_task_table where s_id='$schId' and  t_date between '$date_next_m-01' and '$date_next_m-15'";
	$query2= mysqli_query($conn,$sql2);
	$db_cnt2 = mysqli_num_rows($query2);
	if ($db_cnt2 != 0) {
		while ($db_row2 = mysqli_fetch_array($query2)) {
			$cnt[(int)substr($db_row2["t_date"],-2)]=0;
			if (!empty($taskdate_next_month[$cnt[(int)substr($db_row2["t_date"],-2)]][(int)substr($db_row2["t_date"],-2)])) {
				$cnt[(int)substr($db_row2["t_date"],-2)]++;
				$taskdate_next_month[$cnt[(int)substr($db_row2["t_date"],-2)]][(int)substr($db_row2["t_date"],-2)]= $db_row2["t_task_name"];
				$taskid_next_month[$cnt[(int)substr($db_row2["t_date"],-2)]][(int)substr($db_row2["t_date"],-2)]=$db_row2["t_id"];
			}else{
				$taskdate_next_month[$cnt[(int)substr($db_row2["t_date"],-2)]][(int)substr($db_row2["t_date"],-2)]= $db_row2["t_task_name"];
				$taskid_next_month[$cnt[(int)substr($db_row2["t_date"],-2)]][(int)substr($db_row2["t_date"],-2)]=$db_row2["t_id"];
			}
		}
	}else{
	}
	//release all query data
	mysqli_free_result($query);
	mysqli_free_result($query1);
	mysqli_free_result($query2);
}

//前月の算出
$before_ymd = mktime(0,0,0,$this_month - 1,1,$this_year);

$before_y = date("Y",$before_ymd);
$before_m = date("n",$before_ymd);
//前月の最終日
$before_m_l_d = (date("t", $before_ymd ));

//前月の算出
$after_ymd = mktime(0,0,0,$this_month + 1,1,$this_year);

$after_y = date("Y",$after_ymd);
$after_m = date("n",$after_ymd);

$msg .= "<br />";
//表形式の開始
$msg .= "<table id='calender' border=1 >";
//曜日のヘッダー
$msg .= "<tr>";
$msg .= "<th><font color='#f00'>日</font></th>";
$msg .= "<th>月</th>";
$msg .= "<th>火</th>";
$msg .= "<th>水</th>";
$msg .= "<th>木</th>";
$msg .= "<th>金</th>";
$msg .= "<th><font color='#00f'>土</font></th>";
$msg .= "</tr>";
//1～31日までの繰り返し文
for($i = 1; $i <= 31; $i++){
	if (checkdate($this_month,$i,$this_year) == true) {
		//曜日を取得する
		$youbi = date("w",mktime(0,0,0,$this_month,$i,$this_year));
		//1日の曜日による余白設定
		if ($i == 1) {
			//１日の曜日に到達まで繰り返し
			$y = 0;
			$msg .= "<tr>";
			while ($y < $youbi) {
				//その分の前月の日をいれる
				//先月
 				$x=$youbi-$y;
				$u=$y+1;
				if(checkdate($before_m,$i,$yyyyb)== true){
					$v=$x-1;
					$b=$before_m_l_d-$v;
					if ($u==1) {
						$msg .= "<td>";
						$msg .= "<div  id='".sprintf($before_m_l_d-$v)."' class='settasksize notmonth' onmouseover=addsetttask(".sprintf($before_m_l_d-$v).",$yyyyb,$before_m) onclick=settask($yyyyb,$before_m,".sprintf($before_m_l_d-$v).") >";
						$msg .= "<font class='calendar-date' color='#ffcccb'>".sprintf("%02d",$before_m_l_d-$v)."</font>";
						$msg .="<div class='taskbox'>";
						for ($m=0;$m<$db_cnt1; $m++) {
							if(isset($taskdate_before_month[$m][$before_m_l_d-$v])) {
								$taskdate_before=$taskdate_before_month[$m][$before_m_l_d-$v];
								$taskid_before =$taskid_before_month[$m][$before_m_l_d-$v];
								// code...
								$msg .= "<div class='progressbar'>";
								$msg .= "<div  onmouseover=removersetttask(".sprintf($before_m_l_d-$v).")  onmouseout=addsetttask($yyyyb,$before_m,".sprintf($before_m_l_d-$v).") onclick=showtask('$taskdate_before','$taskid_before') class='taskbar'>".$taskdate_before_month[$m][$before_m_l_d-$v]."</div>";
								$msg .= "<div class='outer call'>";
								$msg .="<div class='inner'>";
								$msg .="<a class='callclose' onclick=deletetask('$taskdate_before','$taskid_before')>delete</a>";
								$msg .= "</div>";
								$msg .= "</div>";
								$msg .= "</div>";
							}
						}
						$msg.="</div>";
						$msg .="</div>";
						$msg .= "</td>";
					}else{
						$msg .= "<td>";
						$msg .= "<div id='".sprintf($before_m_l_d-$v)."' class='settasksize notmonth' onmouseover=addsetttask(".sprintf($before_m_l_d-$v).",$yyyyb,$before_m)  onclick=settask($yyyyb,$before_m,".sprintf($before_m_l_d-$v).") >";
						$msg .= "<font class='calendar-date' color='lightgray'>".sprintf("%02d",$before_m_l_d-$v)."</font>";
						$msg .="<div class='taskbox'>";
						for ($m=0;$m<$db_cnt1; $m++) {
							if(isset($taskdate_before_month[$m][$before_m_l_d-$v])) {
								$taskdate_before =$taskdate_before_month[$m][$before_m_l_d-$v];
								$taskid_before =$taskid_before_month[$m][$before_m_l_d-$v];
								// code...
								$msg .= "<div class='progressbar'>";
								$msg .= "<div onmouseover=removersetttask(".sprintf($before_m_l_d-$v).") onmouseout=addsetttask($yyyyb,$before_m,".sprintf($before_m_l_d-$v).")  onclick=showtask('$taskdate_before','$taskid_before') class='taskbar'>".$taskdate_before_month[$m][$before_m_l_d-$v]."</div>";
								$msg .= "<div class='outer call'>";
								$msg .="<div class='inner'>";
								$msg .="<a class='callclose' onclick=deletetask('$taskdate_before','$taskid_before')>delete</a>";
								$msg .= "</div>";
								$msg .= "</div>";
								$msg .= "</div>";
							}
						}
						$msg .="</div>";
						$msg .="</div>";
						$msg .= "</td>";
					}
				}
				$y++;
			}
		}
		if($youbi == 6){
			//土曜日の色設定
			$color = "#00f";
		}else if($youbi == 0){
			//日曜日の色設定
			$color = "#f00";
			$msg .= "<tr>";
		}else{
			//平日は黒
			$color = "#000";
		}
		//今日
		if ($i==$this_day && $this_month == date("m") && $this_year == date("Y")) {
			$msg .= "<td>";
			$msg .= "<div id='$i' class='today settasksize'  onclick=settask($this_year,$this_month,$i) >";
			$msg .= "<font class='calendar-date' color='{$color}'>".sprintf("%02d",$i)."</font>";
			$msg .="<div class='taskbox'>";
			for ($x=0;$x<$db_cnt; $x++) {
				if(isset($taskdate[$x][$i])) {
					$taskname =$taskdate[$x][$i];
					$taskid1= $taskid[$x][$i];
					// code...
					$msg .= "<div class='progressbar'>";
					$msg .= "<div onmouseover=removersetttask($i) onmouseout=addsetttask($this_year,$this_month,$i) onclick=showtask('$taskname','$taskid1') class='taskbar'>".$taskdate[$x][$i]."</div>";
					$msg .= "<div class='outer call'>";
					$msg .="<div class='inner'>";
					$msg .="<a class='callclose' onclick=deletetask('$taskname','$taskid1')>delete</a>";
					$msg .= "</div>";
					$msg .= "</div>";
					$msg .= "</div>";
				}
			}
			$msg .="</div>";
			$msg .="</div>";
			$msg .= "</td>";
		}else{
		  $msg .= "<td>";
			$msg .= "<div id='$i' class='settasksize' onmouseover=addsetttask($i,$this_year,$this_month) onclick=settask($this_year,$this_month,$i) >";
		  $msg .= "<font class='calendar-date' color='{$color}'>".sprintf("%02d",$i)."</font>";
			$msg .="<div class='taskbox'>";
			for ($x=0;$x<$db_cnt; $x++) {
				if(isset($taskdate[$x][$i])) {
					$taskname =$taskdate[$x][$i];
					$taskid1= $taskid[$x][$i];
					$msg .= "<div class='progressbar'>";
					$msg .= "<div onmouseover=removersetttask($i) onmouseout=addsetttask($this_year,$this_month,$i) onclick=showtask('$taskname','$taskid1') class='taskbar'>".$taskdate[$x][$i]."</div>";
					$msg .= "<div class='outer call'>";
					$msg .="<div class='inner'>";
					$msg .="<a class='callclose' onclick=deletetask('$taskname','$taskid1')>delete</a>";
					$msg .= "</div>";
					$msg .= "</div>";
					$msg .= "</div>";
				}
			}
			$msg .="</div>";
			$msg .="</div>";
	  	$msg .= "</td>";
		}
		//土曜日（$youbi=6）だったら折り返し
		if($youbi == 6){
			$msg .= "</tr>";
		}
	}
}
//月末日以降の日付
$x=$youbi+1;
$d=1;
while ($x < 7) {
	if ($x==6) {
		$msg .= "<td>";
		$msg .= "<div id='n$d' class='settasksize notmonth' onmouseover=addsetttask($d,$yyyyn,$after_m) onclick=settask($yyyyn,$after_m,$d) >";
		$msg .= "<font class='calendar-date' color='lightblue'>".sprintf("%02d",$d)."</font>";
		$msg .="<div class='taskbox'>";
		for ($j=0;$j<$db_cnt2; $j++) {
			if(isset($taskdate_next_month[$j][$d])) {
				$task_next =$taskdate_next_month[$j][$d];
				$taskid_next =$taskid_next_month[$j][$d];
				$msg .= "<div class='progressbar'>";
				$msg .= "<div onmouseover=removersetttask(n$d) onmouseout=addsetttask($yyyyn,$after_m,$d) onclick=showtask('$task_next','$taskid_next') class='taskbar'>".$taskdate_next_month[$j][$d]."</div>";
				$msg .= "<div class='outer call'>";
				$msg .="<div class='inner'>";
				$msg .="<a class='callclose' onclick=deletetask('$task_next','$taskid_next')>delete</a>";
				$msg .= "</div>";
				$msg .= "</div>";
				$msg .= "</div>";
			}
		}
		$msg .="</div>";
		$msg .="</div>";
		$msg .= "</td>";
	}elseif($x==0) {
		$msg .= "<td>";
		$msg .= "<div id='n$d' class='settasksize notmonth' onmouseover=addsetttask($d,$yyyyn,$after_m)  onclick=settask($yyyyn,$after_m,$d) >";
		$msg .= "<font class='calendar-date' color='lightred'>".sprintf("%02d",$d)."</font>";
		$msg .="<div class='taskbox'>";
		for ($j=0;$j<$db_cnt2; $j++) {
			if(isset($taskdate_next_month[$j][$d])) {
				$task_next =$taskdate_next_month[$j][$d];
				$taskid_next =$taskid_next_month[$j][$d];
				// code...
				$msg .= "<div class='progressbar'>";
				$msg .= "<div onmouseover=removersetttask(n$d) onmouseout=addsetttask($yyyyn,$after_m,$d) onclick=showtask('$task_next','$taskid_next') class='taskbar'>".$taskdate_next_month[$j][$d]."</div>";
				$msg .= "<div class='outer call'>";
				$msg .="<div class='inner'>";
				$msg .="<a class='callclose' onclick=deletetask('$task_next','$taskid_next')>delete</a>";
				$msg .= "</div>";
				$msg .= "</div>";
				$msg .= "</div>";
			}
		}
		$msg .="</div>";
		$msg .="</div>";
		$msg .= "</td>";
	}else{
		$msg .= "<td>";
		$msg .= "<div id='n$d' class='settasksize notmonth'  onmouseover=addsetttask($d,$yyyyn,$after_m) onclick=settask($yyyyn,$after_m,$d) >";
		$msg .= "<font class='calendar-date' color='lightgray'>".sprintf("%02d",$d)."</font>";
		$msg .="<div class='taskbox'>";
		for ($j=0;$j<$db_cnt2; $j++) {
			if(isset($taskdate_next_month[$j][$d])) {
				$task_next =$taskdate_next_month[$j][$d];
				$taskid_next =$taskid_next_month[$j][$d];
				// code...
				$msg .= "<div class='progressbar'>";
				$msg .= "<div onmouseover=removersetttask(n$d) onmouseout=addsetttask($yyyyn,$after_m,$d) onclick=showtask('$task_next','$taskid_next') class='taskbar'>".$taskdate_next_month[$j][$d]."</div>";
				$msg .= "<div class='outer call'>";
				$msg .="<div class='inner'>";
				$msg .="<a class='callclose' onclick=deletetask('$task_next','$taskid_next')>delete</a>";
				$msg .= "</div>";
				$msg .= "</div>";
				$msg .= "</div>";
			}
		}
		$msg .="</div>";
		$msg .="</div>";
		$msg .= "</td>";
	}
	$x++;
	$d++;
}
if ($youbi != 6) {
	$msg .= "</tr>";
}
//表形式の終了
$msg .= "</table>";
?>
  <link rel="stylesheet" href="css/calendar.css">
		<!-- タスク追加画面 -->
		<div id="taskwindow"  style="display:none;">
			<div class="outer clsch">
				<div class="inner">
					<a class="closebutton"   onclick="closetask()">close</a>
				</div>
			</div>
			<h2>タスク追加 </h2>
				<form  method="post">
					<input id="taskyear"  type="hidden" name="year"   value="">
					<input id="taskmonth" type="hidden" name="month"  value="">
					<input id="taskday"   type="hidden" name="day"    value="">
					<input id="schedID"   type="hidden" name="schID"  value="<?php print $schId ?>">
					<br id="tsbr_err">
					<p id="ts_err"></p>
					<p class="dialog-p"><span>必須</span>タスク名:
					<input id="tn"  class="input-box"      type="text"   name="taskName" ></p><br>
					<p class="dialog-p">タスクリスト</p><br>
					<input id="task1" type="text" class="tasks input-box" name="task1" value="">
					<div id="createnewtaskwindow"></div>
					<input class="taskplusbutton " type="button" onclick="createtask()" value="+"><br>
					<br>
					<p class="dialog-p">タスクの詳細
					<input id="tc"   class="input-box"     type="text"   name="taskComment" ></p><br>
					<br>
					<input type="button" class="button" id="ts" onclick="return addtask()"  name="作成" value="作成">
			</form>
			<div id="taskaddphp">
				<iframe  src="config/taskadd.php" style="display:none;"></iframe>
			</div>
		</div>
		<!-- タスク内容画面 -->
		<div id="taskdisplay"  style="display:none;">
			<div class="outer cal">
				<div class="inner">
					<a class="calclose" class="closebutton" onclick="taskshowclose()" type="button">close</a>
				</div>
			</div>
			<h2 class="center" id="taskcheckname"></h2>
			<div id="taskcheckbox"></div>
			<div id="taskupdate">
				<iframe  src="config/updatetask.php" style="display:none;"></iframe>
			</div>
		</div>
		<!-- タスクの編集画面 -->
		<div id="taskedit" style="display:none;">
			<div class="outer rec">
				<div class="inner">
					<a class="reclose" onclick="taskeditclose()" type="button">close</a>
				</div>
			</div>
			<div id="taskeditbox"></div>
			<div id="taskeditupdate">
				<iframe  src="config/taskeditupdate.php" style="display:none;"></iframe>
			</div>
		</div>
		<!--   前月きと来月   -->
		<form    method="post" >
			<input id="beforemonth" type="button" onclick="beforem('<?php echo $yyyyb ?>','<?php echo $mmb ?>')" name="" value="<?php echo $mmb ?>">
			<input id="nextmonth"type="button" onclick="nextm('<?php echo $yyyyn ?>','<?php echo $mmn ?>')"  name="" value="<?php echo $mmn ?>">
		</form>
		<h1 class="center"><?php print $this_year ?>年<?php print $this_month1 ?>月 </h1>
			<!-- カレンダー表示 -->
      <?php print $msg?>

			<div id="taskdelete">
				<iframe src="config/taskdelete.php" style="display:none;"></iframe>
			</div>
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/calendar.js"></script>
	<script type="text/javascript">

	</script>
	</div>
