<?php
  session_start();
  require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
  $_SESSION['token'] = get_csrf_token(); // CSRFのトークンを取得する

?>
<!doctype html>
<html>

    <head>
            <meta charset="UTF-8">
            <link href="css/bootstrap.css" rel="stylesheet">
            <title>ログイン</title>
    </head>
    <body>
        <?php
        // if ($_SESSION['logout'] == 1) {
        //   echo "<div class='text-end alert alert-primary' role='alert'>ログアウトしました。</div>";
        //   $_SESSION['logout'] = 0;
        // }
        ?>
        <div class="text-end">
            <a href="9.signup.php">新規登録はこちら</a>
        </div>

      <h1 class="text-center h3 mt-2 mb-3 font-weight-normal">ログイン</h1>
      <?php
           if (!isset($_SESSION['error_status'])) {
             echo "";
           }
           if (isset($_SESSION['error_status']) && $_SESSION['error_status']== 1) {
             echo '<h2 class="text-center" style="color:red">IDまたはパスワードが異なります。</h2>';
           }
            if (isset($_SESSION['error_status']) && $_SESSION['error_status']== 2) {
             echo '<h2 class="text-center" style="color:red">不正なリクエストです。</h2>';
           }
           //エラー情報のリセット
           $_SESSION['error_status'] = 0;
         ?>
        <form class="w-25 mx-auto" action="4'.login_check.php" id="login" name="loginForm" action="" method="POST">


                <label for="email">メールアドレス</label>
                <input class="form-control" type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email"])) {echo htmlspecialchars($_POST["email"], ENT_QUOTES);} ?>">
                <label for="password">パスワード</label>
                <input class="form-control  mb-5" type="password" id="password" name="password" value="" placeholder="パスワードを入力">

                <a class="text-center" href="5.pass_request.php">パスワードをお忘れの方、変更されたい方はこちら</a>

                <div class="text-center mt-5">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8") ?>">
                    <input class="btn btn-outline-primary my-1" type="submit" id="submit" name="login" value="ログインする"/>
                    <input class="btn btn-outline-primary my-1" type="reset" value="リセット">
                </div>
        </form>

    </body>
</html>
