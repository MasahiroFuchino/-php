<?php
  session_start();
  require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
  //URLからパラメータ取得
  $url_pass = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  //CSRF
  $_SESSION['token'] = get_csrf_token();
  //ユーザー正式登録
  try {
    // DB接続
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //10分前の時刻を取得
    $datetime = new DateTime('- 10 min');
    //プレースホルダで SQL 作成
    $sql = "SELECT * FROM shop WHERE temp_pass = ? AND temp_limit_time >= ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $url_pass, PDO::PARAM_STR);
    $stmt->bindValue(2, $datetime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //URLが不正か期限切れ
    if (empty($row)) {
      $_SESSION['error_status'] = 4;
      redirect_to_password_reset();
      exit();
    }
    $_SESSION['email'] = $row['email'];
    $_SESSION['url_pass'] = $url_pass; // エラー制御のため格納
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>
<html>
    <head>
    	<link href="css/bootstrap.css" rel="stylesheet">
        <title>ユーザーページパスワードリセット画面</title>
        <script src="passwordchecker.js" type="text/javascript"></script>
   <script src="common.js" type="text/javascript"></script>
   <script type="text/javascript">
   function confirmMessage() {
        var pass = document.getElementById("password").value;
        var conf = document.getElementById("password2").value;
       //必須チェック
       if((pass == "") || (conf == "")) {
          alert("必須項目が入力されていません。");
          return false;
       }
        //パスワードチェック
        if (pass != conf) {
            alert("パスワードが一致していません。");
            return false;
        }
        if (passwordLevel < 3) {
          return confirm("パスワード強度が弱いですがよいですか？");
        }
        return true;
      }
   </script>
    </head>
    <body>
        <div class="text-center m-10">
          <p class="mt-4">新しいパスワードを入力してください。</p>
        </div>
        <?php
      if (!empty($_SESSION['error_status'])==1) {
       echo '<h2 style="color:red;">パスワードが一致しません。</h2>';
     }
   ?>
        <form class="w-25 mx-auto" action="27.pass_reset_complete_admin.php" method="post" onsubmit="return confirmMessage();">
           	<label for="email">メールアドレス</label>
           	<input class="form-control" id="email"
           			type="text" name="email" placeholder="メールアドレス"
           			required autofocus/>

           	<label for="password">パスワード</label>
           	<input class="form-control" id="password"
           			type="password" name="password" onkeyup="setMessage(this.value);" placeholder="パスワード"
           			required/>

                <label for="password">確認用パスワード</label>
               	<input class="form-control" id="password2"
               			type="password" name="password2" onkeyup="setMessage(this.value);" placeholder="確認用パスワード"
               			required/>

                <div class="text-center">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']  , ENT_QUOTES, "UTF-8") ?>">
                    <input class="btn btn-outline-primary my-1" type="submit" value="パスワードをリセットする"/>
                </div>

        </form>
    </body>
</html>
