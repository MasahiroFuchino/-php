<?php
  require_once('login_function.php');
  session_start();
  header('Content-type: text/html; charset=utf-8');
  //CSRF トークン
  $_SESSION['token']  = get_csrf_token();
?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
    	<link href="css/bootstrap.css" rel="stylesheet">
        <title>パスワードリセットリクエスト画面</title>
        <script type="text/javascript">
        //$_SESSION['error_status']のエラーが出た場合javascript部分の編集
      function conrimMessage() {
        var email = document.getElementById("email").value;
       //必須チェック
       if(id == "") {
          alert("必須項目が入力されていません。");
          return false;
       }
        return true;
      }
   </script>
    </head>
    <body>
        <div class="text-end">
            <a href="4.login.php">ログイン画面へ</a>
        </div>
        <p class="text-center  m-5 font-weight-normal">メールアドレスを入力してください</p>
        <?php
      if (!$_SESSION['error_status']) {
        echo "";
      }
      if ($_SESSION['error_status'] == 1) {
        echo "<h2 style='color:red;'>パスワードをリセットしてください。</h2>";
      }
       if ($_SESSION['error_status'] == 2) {
        echo "<h2 class='text-center' style='color:red;'>入力内容に誤りがあります。</h2>";
      }
      if ($_SESSION['error_status'] == 3) {
        echo "<h2 style='color:red;'>不正なリクエストです。</h2>";
      }
      if ($_SESSION['error_status'] == 4) {
        echo '<h2 style="color:red;">タイムアウトか不正なURLです。</h2>';
      }
      //エラー情報のリセット
      $_SESSION['error_status'] = 0;
    ?>
        <form class="w-25 mx-auto" action="25.pass_request_complete_admin.php" method="post">
           	<label for="username">メールアドレス</label>
           	<input class="form-control" id="email"
           			type="text" name="email" placeholder="メールアドレス"
           			required autofocus/>
                <div class="text-center">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']  , ENT_QUOTES, "UTF-8") ?>">
                    <input class="btn btn-outline-primary my-1" type="submit" value="送信"/>
                </div>

        </form>
    </body>
</html>
