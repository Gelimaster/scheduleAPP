<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/register.css">
    <title></title>
  </head>
  <body>
    <form  action="config/createsql.php" method="post">
      <h1>新規アカウント作成</h1>
      <p id="user_err"></p>
      <br id="userbr">
      <input id="user" type="text" name="username" value="" maxlength="20" placeholder="ユーザー名"> <br>
      <p id="pass_err"></p>
      <br id="passbr">
      <input id="pas1"  type="password" name="password" value="" placeholder="パスワード"> <br>
      <input id="pas2"  type="password" name="cpassword" value="" placeholder="確認パスワード"> <br>
      <input id="btn" type="submit" name="" onclick=" return passcheck()" value="登録">
      <p>アカウントをお持ちですか? <a href="Login.php">ログイン</a></p>
    </form>
  </body>
  <script src="js/createaccount.js"></script>
</html>
