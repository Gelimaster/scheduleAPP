//前月処理
function beforem(year,month){
  // if(month== 1||month== 2||month== 3||month== 4||month== 5||month== 6||month== 7||month== 8||month== 9){
  //   month= String(0)+String(month);
  // }
  $.post("calendar.php", { month: month,year: year},
  function(data) {
    $('#calendarreload').html(data);
  });
}
//次月処理
function nextm(year,month){
  //
  // if(month== 1||month== 2||month== 3||month== 4||month== 5||month== 6||month== 7||month== 8||month== 9){
  //   month= String(0)+String(month);
  // }
  $.post("calendar.php", { month: month,year: year},
  function(data) {
    $('#calendarreload').html(data);
  });
}


//画面を開く・閉じる処理
function settask(y,m,d) {
  taskyear.value = y;
  taskmonth.value = m;
  taskday.value = d;
  x= document.getElementById('taskwindow');
  x.style.display="block";
  windows = document.getElementById('taskdisplay');
  windows.style.display="none";
  u = document.getElementById('taskedit');
  u.style.display="none";
}
function closetask(){
  x= document.getElementById('taskwindow');
  x.style.display="none";
}
//カレンダーのタスク内容を表示する
function showtask(taskname,taskid){
  windows = document.getElementById('taskdisplay');
  windows.style.display="block";
  x= document.getElementById('taskwindow');
  x.style.display="none";
  u = document.getElementById('taskedit');
  u.style.display="none";
  taskcheckname.innerHTML=taskname;
  $.post("DBtask.php",{taskid:taskid},
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
    $.post("config/updatetask.php",{taskid:taskid,status:status,order:order},
    function(data) {
      $("#taskupdate").html(data);
    });
  }

}
//タスクの編集表示・閉じる
function editstatus(taskid,taskname){
  y = document.getElementById('taskdisplay');
  y.style.display="none";
  x = document.getElementById('taskedit');
  x.style.display="block";
  $.post("taskedit.php",{taskid:taskid,taskname:taskname},
  function(data) {
    $("#taskeditbox").html(data);
  });
  return v=0
}
function taskeditclose(){
  x = document.getElementById('taskedit');
  x.style.display="none";
  y = document.getElementById('taskdisplay');
  y.style.display="block";
  return v = 0;
}
//変更されたタスクをＤＢにアップする
function DBtaskedit(x,describe,name,id){
  if (v==0) {
    //新しいタスク作られてない場合
    let tasks=[];
    let editedtask="";
    let des = document.getElementById(describe).value;
    let title = document.getElementById(name).value;
    if (!title) {
      alert("aaaaaaaa");
    }
    for (let i = 1; i <= x; i++) {
      taskname= "task0"+i;
      tasks[i]=document.getElementById(taskname).value;
      if (i==x) {
        editedtask = editedtask+tasks[i];
      }else{
        editedtask = editedtask+tasks[i]+",";
      }
    }
    $.post("config/taskeditupdate.php",{taskid:id,title:title,tasks:editedtask,describe:des},
    function(data) {
      $("#taskeditbox").html(data);
    });
    taskedit.style.display="none";
  }else{
    //新しいタスク作られた場合
    let tasks=[];
    let editedtask="";
    let des = document.getElementById(describe).value;
    let title = document.getElementById(name).value;
    for (let i = 1; i <= v; i++) {
      taskname= "task0"+i;
      tasks[i]=document.getElementById(taskname).value;
      if (i==v) {
        editedtask = editedtask+tasks[i];
      }else{
        editedtask = editedtask+tasks[i]+",";
      }
    }
    $.post("config/taskeditupdate.php",{taskid:id,title:title,tasks:editedtask,describe:des,taskcount:v},
    function(data) {
      $("#taskeditbox").html(data);
    });
    taskedit.style.display="none";
  }
}

// タスク編集の追加のタスクリスト
let c = 0;
let m = 0;
let v = 0;
function createedittask(c){
  c++;
  if (v==0) {
    let input = document.createElement("input");
    let label = document.createElement("label");
    let button = document.createElement("input");
    let br = document.createElement("br");
    input.type = "text";
    input.className = "tasks input-box"; // set the CSS class
    input.name= "task0" + c;
    input.id="task0"+c;
    br.id = "br0" + c;
    button.type ="button";
    button.className="button2";
    button.value = "x";
    button.id = "remove0"+c;
    label.setAttribute("for",input.id);
    label.id= "label0"+c;
    label.innerHTML="タスク "+c+" :";
    button.onclick = function(){deleteedittasklist(input.id,button.id,br.id,label.id,c)}//c--
    createnewedittask.appendChild(label);
    createnewedittask.appendChild(input); // put it into the DOM
    createnewedittask.appendChild(button);
    createnewedittask.appendChild(br); // put it into the DOM
    v = c;
    return v;
  }else{
    v++;
    let input = document.createElement("input");
    let label = document.createElement("label");
    let button = document.createElement("input");
    let br = document.createElement("br");
    input.type = "text";
    input.className = "tasks"; // set the CSS class
    input.name= "task0" + v;
    input.id="task0"+v;
    br.id = "br0" + v;
    button.type ="button";
    button.value = "x";
    button.id = "remove0"+v;
    label.setAttribute("for",input.id);
    label.id= "label0"+v;
    label.innerHTML="タスク "+v+" :";
    button.onclick = function(){deleteedittasklist(input.id,button.id,br.id,label.id,v)}//c--
    createnewedittask.appendChild(label);
    createnewedittask.appendChild(input) ;// put it into the DOM
    createnewedittask.appendChild(button);
    createnewedittask.appendChild(br); // put it into the DOM
    return v;
  }
}
//タスク編集リストの削除
function deleteedittasklist(input,button,br,label,pos) {
  br = document.getElementById(br);
  input = document.getElementById(input);
  button = document.getElementById(button);
  label = document.getElementById(label);
  input.parentNode.removeChild(input);
  button.parentNode.removeChild(button);
  br.parentNode.removeChild(br);
  label.parentNode.removeChild(label);
  return v = pos-1;
}
//タスク編集リストの削除
function deleteedittasklist1(input,button,br,label,pos) {
  br = document.getElementById(br);
  input = document.getElementById(input);
  button = document.getElementById(button);
  label = document.getElementById(label);
  input.parentNode.removeChild(input);
  button.parentNode.removeChild(button);
  br.parentNode.removeChild(br);
  label.parentNode.removeChild(label);
  c= pos-1;
  return v = c;
}
//データベースにタスク追加処理
function addtask(){
  let tasks ="";
  let task_status="";
  let year = taskyear.value;
  let month = taskmonth.value;
  let day = taskday.value;
  let taskName = tn.value;
  let taskComment=tc.value;
  let scheduleID = schedID.value;
  if (!taskName) {
    tsbr_err.style.display="none";
    ts_err.innerHTML="タスク名が空白です。";
    ts_err.style.color="red";
    tn.style.border="1px solid red";
    return false;
  }

  for (let i = 1; i < count; i++) {
      let task = document.getElementById('task'+i);
    if (i==count-1) {
      tasks=tasks+task.value;
      task_status=task_status+0;
    }else{
      tasks=tasks+task.value+",";
      task_status=task_status+0+",";
    }
  }
if (month <10) {
  // console.log(month);
  month = 0+ month;
}
if (day <10) {
  day= 0 + day;
}
  $.post("config/taskadd.php",{ year: year,month: month,day: day,taskname:taskName,tasks:tasks,task_status:task_status,schID:scheduleID,taskComment:taskComment},
  function(data) {
    $("#taskaddphp").html(data);
  });
  x= document.getElementById('taskwindow');
  x.style.display="none";
  $("#calendarreload").delay(2000).load('calendar.php? #calendarreload');
}
// タスク追加のタスクリスト
let count = 2;
function createtask(){
  let input = document.createElement("input");
  let button = document.createElement("input");
  let br = document.createElement("br");
  input.type = "text";
  input.className = "tasks input-box"; // set the CSS class
  input.name= "task" + count;
  input.id="task"+count;
  br.id = "br" + count;
  button.type ="button";
  button.className="button2"
  button.value = "x";
  button.id = "remove"+count;
  button.onclick = function(){deletetasklist(input.id,button.id,br.id,count)}//count--
  createnewtaskwindow.appendChild(input); // put it into the DOM
  createnewtaskwindow.appendChild(button);
  createnewtaskwindow.appendChild(br); // put it into the DOM
  count++;
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



function addsetttask(x,y,z){
  document.getElementById(z).onclick = function(){settask(x,y,z)};
}


function removersetttask(x){
  document.getElementById(x).onclick = null;
}
