function passcheck(){
  p1=pas1.value;
  p2=pas2.value;
  username=user.value;

  flg=false;
  if (!username) {
    user_err.style.display="block";
    user_err.innerHTML="Usernameが空白です";
    userbr.style.display="none";
    flg=true;
  }else{
    userbr.style.display="block";
    user_err.style.display="none";
  }
  if (!p1||!p2) {
    pass_err.innerHTML="パスワードが空白です";
    passbr.style.display="none";
    flg=true;
  }else{
    passbr.style.display="block";
    pass_err.style.display="none";
  }
  if (p1!=p2) {
    pass_err.style.display="block";
    pass_err.innerHTML="パスワードが一致していません";
    passbr.style.display="none";
    flg=true;
  }
  if (flg) {
    return false;
  }
}
