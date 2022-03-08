<div id="group">
  <?php
  session_start();
  include("config/db_ini.php");
  $groupid="";
  $groupname="";
  $groupinv="";
  if (isset($_POST["groupid"])) {
    $_SESSION["groupid"]=$_POST["groupid"];
    $_SESSION["groupname"]=$_POST["groupname"];
    $_SESSION["groupinv"]=$_POST["groupinv"];
    $groupid=$_POST["groupid"];
    $groupname=$_POST["groupname"];
    $groupinv=$_POST["groupinv"];
  }else{
    $groupid=$_SESSION["groupid"];
    $groupname=$_SESSION["groupname"];
    $groupinv=$_SESSION["groupinv"];
  }



  ?>
  <h1 class="center"><?php echo $groupname; ?>のプロジェクト一覧</h1>

  <button class="button4" type="button" onclick="opentab1(projectadd)" name="button">プロジェクトを作成</button><br>
  <br>
  <div class="grouplist">
    <?php
    $sql="select * from schedule_project where  g_id='$groupid'";//********************
    $query= mysqli_query($conn,$sql);
    $projectlist="";
    while ($db_row = mysqli_fetch_array($query)) {
       $projectlist .="<button class='projectbutton' type='button' onclick=showproject('$db_row[p_id]','$db_row[p_name]')>".$db_row['p_name']."</button>";
    }
    echo $projectlist;
    mysqli_free_result($query);
    ?>

  </div>

  <div id="projectadd" class="windows prwindows" style="display:none">
    <div class="outer gr">
      <div class="inner">
        <a class="closegroup" onclick="closetab(projectadd)">close</a>
      </div>
    </div>
    <h2 class="center">プロジェクト作成</h2>
    <br id="pbr_err">
    <p id="pp_err"></p>
    <p class="dialog-p"> <span>必須</span> プロジェクト名:
    <input class="input-box" type="text" id="pn"  name="projectname" value="" maxlength="20"></p>
    <br id="p2br_err">
    <p id="p2p_err"></p>
    <p class="dialog-p"> <span>必須</span>プロジェクトの説明・内容:
    <input class="input-box" type="text" id="pd"  name="projectdescribe" value="" maxlength="20"></p><br>
    <label class="dialog-p" for="projectgit">GitHubリンク</label>
    <input class="input-box" type="text" id="github" name="projectgit" ><br>
    <label class="dialog-p" for="projectschedule">利用するスケジュールID</label>
    <input class="input-box" type="text" id="ps" name="projectschedule" ><br>
    <br>
    <input class="button bleft" type="button" onclick="addproject('<?php echo $groupid?>')" value="作成">
  </div>

  <div id="projectwindows" class="windows" style="display:none">
    <div class="outer prw">
      <div class="inner">
        <a class="projectclosewindow" onclick="closetab(projectwindows)" type="button">close</a>
      </div>
    </div>
    <h2 class="center" id="p_name"></h2>
    <div id="p_describe"></div>
  </div>

  <div id="memberwindows" class="windows" style="display:none">
    <div class="outer mw">
      <div class="inner">
        <a class="projectclosewindow" onclick="closetab(memberwindows)" type="button">close</a>
      </div>
    </div>
    <p id="membernames"></p>
  </div>

  <div id="createproject">
    <iframe src="config/createproject.php" style="display:none"></iframe>
  </div>
  <div id="leaveproject">
    <iframe src="config/leaveproject.php" style="display:none"></iframe>
  </div>
  <div id="deleteproject">
    <iframe src="config/deleteproject.php" style="display:none"></iframe>
  </div>
  <div id="enterproject">
    <iframe src="config/enterproject.php" style="display:none"></iframe>
  </div>
</div>
