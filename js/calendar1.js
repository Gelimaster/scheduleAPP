

//前月処理
function beforem(year,month){
  // if(month== 1||month== 2||month== 3||month== 4||month== 5||month== 6||month== 7||month== 8||month== 9){
  //   month= String(0)+String(month);
  // }
  $.post("calendar1.php", { month: month,year: year},
  function(data) {
    $('#calendarreload').html(data);
  });
}
//次月処理
function nextm(year,month){
  // if(month== 1||month== 2||month== 3||month== 4||month== 5||month== 6||month== 7||month== 8||month== 9){
  //   month= String(0)+String(month);
  // }
  $.post("calendar1.php", { month: month,year: year},
  function(data) {
    $('#calendarreload').html(data);
  });
}


//カレンダーのタスク内容を表示する
function showtask(taskname,taskid){
  windows = document.getElementById('taskdisplay');
  windows.style.display="block";
  taskcheckname.innerHTML=taskname;
  $.post("DBtask1.php",{taskid:taskid},
  function(data) {
    $("#taskcheckbox").html(data);
  });
}
//タスク画面を閉じる
function taskshowclose() {
  windows =document.getElementById('taskdisplay');
  windows.style.display="none";
}
//タスクのステータスを変更する処理
function updatestatus(taskid,status,order){
  if (status ==0) {
    status = 1;
    $.post("config/updatetask.php",{taskid:taskid,status:status,order:order},
    function(data) {
      $("#taskupdate").html(data);
    });
  }else{
    status =0;
    $.post("config/updatetask.php",{taskname:taskname,status:status,order:order},
    function(data) {
      $("#taskupdate").html(data);
    });
  }

}
//タスクリストの削除
function deletetasklist(input,button,br,pos) {
  br = document.getElementById(br);
  input = document.getElementById(input);
  button = document.getElementById(button);
  input.parentNode.removeChild(input);
  button.parentNode.removeChild(button);
  br.parentNode.removeChild(br);
  return count = pos-1;
}
//タスクの削除処理
function deletetask(taskName,taskid){
  $.post("config/taskdelete.php",{ taskName: taskName,taskid:taskid},
  function(data) {
    $("#taskdelete").html(data);
  });
  $("#calendarreload").delay(2000).load('calendar.php? #calendarreload');
}
