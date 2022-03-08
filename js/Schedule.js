//カレンダーを読み込み
function loadcalendar(x){
  var schID = x;
  setid.style.display="block";
  setid.innerHTML = "スケジュールID: "+ x;
  $.post("calendar1.php", { schID: schID},
  function(data) {
 $('#results').html(data);

  });
}
//追加スケジュール処理
//送信を初期で無効化
//submitの中身を確認する処理
//作成の時
function sub1(x){
  pname=x.id+"_err";
  brname = x.id+"br_err";
  if (x.value == "") {
    document.getElementById(brname).style.display="none";
    document.getElementById(pname).innerHTML="以下の項目が空白です";
    document.getElementById(pname).style.color="red";
    x.style.border="1px solid red";
    return false;
  }
}
//参加の時
function sub(x){
  pname=x.id+"_err";
  brname = x.id+"br_err";
  if (x.value == "") {
    document.getElementById(brname).style.display="none";
    document.getElementById(pname).innerHTML="以下の項目が空白です";
    document.getElementById(pname).style.color="red";
    x.style.border="1px solid red";
  }else{
    //スケジュール
    if (x.id=="si") {
      checkid = x.value;
      $.ajax({
        url: 'config/scheduleAjax.php',
        type: 'post',
        data: {scheduleid: checkid},
        success: function(response){
          if (response == 0) {
            document.getElementById(pname).innerHTML="スケジュールが存在しない";
            document.getElementById(pname).style.color="red";
          }else{
            schadd.submit();
          }
        }
      });
    }else{
      //グループ
      checkid = x.value;
      $.ajax({
        url: 'config/groupAjax.php',
        type: 'post',
        data: {groupid: checkid},
        success: function(response){
          if (response == 0) {
            document.getElementById(pname).innerHTML="グループが存在しない";
            document.getElementById(pname).style.color="red";
          }else{
            groupadd1.submit();
          }
        }
      });
    }
  }
}
//画面を開く・閉じる処理
function opentab(x,z) {
  x.style.display="block";
  z.style.display="none";
}
function closetab(x){
  x.style.display="none";
}
//スケジュール選択した時にスケジュールIDを設定
function setschedule(x){
  setid.style.display="block";
  setid.innerHTML = "スケジュールID: "+ x;
  var schID = x;
  $.post("calendar.php", { schID: schID},
  function(data) {
 $('#results').html(data);
  });
}
//全体のスケジュールを表示
function setall(x){
  var schID = x;
  setid.style.display="block";
  setid.innerHTML = "スケジュールID: "+ x;
  $.post("calendar1.php", { schID: schID},
  function(data) {
 $('#results').html(data);
  });
}
//スケジュールを削除
function deleteschedule(schedule){
  del = schedule;
  $.post("config/scheduledel.php", { schID: del},
  function(data) {
 $('#scheduledelete').html(data);
  });
  setTimeout(window.location.reload(), 3000);
}

//グループ処理
//画面を開く
function opentab1(x) {
  x.style.display="block";
  u = document.getElementById('projectwindows');
  u.style.display="none";
}
//グループを選択したらグループ画面を表示処理
function setgroup(groupinv,groupname,groupid){
  setid.style.display="block";
  setid.innerHTML = "グループID: "+ groupinv;
  $.post("group.php", { groupinv:groupinv,groupid: groupid,groupname:groupname},
  function(data) {
    $('#results').html(data);
  });
}

//グループから出る・削除
function leavegroup(group,userid){
  del = group;
  $.post("config/groupdel.php", { groupID: del,userid:userid},
  function(data) {
 $('#groupdelete').html(data);
  });
  setTimeout(window.location.reload(), 3000);
}

//プロジェクト処理
//プロジェクト作成
function addproject(groupid){
  projectname = pn.value;
  projectdescribe = pd.value;
  projectschedule = ps.value;
  git = github.value;
  perror1=document.getElementById('pp_err');
  perror2=document.getElementById('p2p_err');
  brerror1=document.getElementById('pbr_err');
  brerror2=document.getElementById('p2br_err');
  perror1.style.display="none";
  perror2.style.display="none";
  perror1.style.color="red";
  perror2.style.color="red";
  flg=true;
  if (projectname == "") {
    perror1.innerHTML="プロジェクト名が空白です。";
    perror1.style.display="block";
    brerror1.style.display="none";
    pn.style.border="1px solid red";
    flg =false;
  }else {
    perror1.style.display="none";
    brerror1.style.display="block";
    pn.style.border="1px solid lightgray";
  }
  if (projectdescribe == "") {
    perror2.innerHTML="プロジェクト説明が空白です。";
    perror2.style.display="block";
    brerror2.style.display="none";
    pd.style.border="1px solid red";
    flg =false;

  }else {
    perror2.style.display="none";
    brerror2.style.display="block";
    pn.style.border="1px solid lightgray";
  }

  if (flg) {
    $.post("config/createproject.php", { groupid: groupid,projectname:projectname,projectdescribe:projectdescribe,github:git,projectschedule:projectschedule},
    function(data) {
      $('#createproject').html(data);
    });

    $("#group").load('group.php? #group');
  }
}

//プロジェクト表示
function showproject(projectid,projectname){
  windows = document.getElementById('projectwindows');
  windows.style.display="block";
  x= document.getElementById('projectadd');
  x.style.display="none";
  p_name.innerHTML=projectname;
  $.post("DBproject.php",{projectid:projectid},
  function(data) {
    $("#p_describe").html(data);
  });

}

//プロジェクトに参加
function participate(projectid) {
  $.post("config/enterproject.php",{projectid:projectid},
  function(data) {
    $("#enterproject").html(data);
  });
  $("#group").delay(3000).load('group.php? #group');
}

//プロジェクト削除
function deleteproject(projectid){
  $.post("config/deleteproject.php",{projectid:projectid},
  function(data) {
    $("#deleteproject").html(data);
  });
  $("#group").delay(3000).load('group.php? #group');
}
//プロジェクトから出る
function leaveproject(projectid){
  $.post("config/leaveproject.php",{projectid:projectid},
  function(data) {
    $("#leaveproject").html(data);
  });
  $("#group").delay(3000).load('group.php? #group');
}




//プロジェクトメンバー
function members(x) {
  memberwindows.style.display="block";
  $.ajax({
    url: 'member.php',
    type: 'post',
    data: {scheduleid: x},
    success: function(response){
      membernames.innerHTML=response;
    }
  });
}
