<?php

// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bookingsystem";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";
if (isset($_POST["signup"])) {
    header("Location: signup.php");  // メイン画面へ遷移
    exit();
}
// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["email"])) {  // emptyは値が空のとき
        $errorMessage = 'メールアドレスが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $email = $_POST["email"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
          }catch (PDOException $e) {
              $errorMessage = 'データベースエラー';
              //$errorMessage = $sql;
              // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
              // echo $e->getMessage();
          }
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email',$email );
            $stmt->execute();
            $member = $stmt->fetch();
            $password_hash = password_hash($member['password'],PASSWORD_DEFAULT);

            if (password_verify($_POST['password'], $password_hash)) {
                    session_regenerate_id(true);

                      $_SESSION['id'] = $member['id'];

                      $_SESSION['name'] = $member['name'];


                     header("Location: main.php");  // メイン画面へ遷移
                     exit();  // 処理終了
                 } else {
                    // 認証失敗
                    $errorMessage = 'メールアドレスまたはパスワードに誤りがあります。';
                }

    }
}

?>

<!doctype html>
<html>

    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <title>ログイン</title>
    </head>
    <body>
      <form class="" action="signup.php" method="post">
        <div class="text-right">
            <input class="btn text-right mr-4"  type="submit" name="signup" value="新規登録はこちら">
        </div>

      </form>

      <h1 class="text-center h3 mt-2 mb-3 font-weight-normal">ログイン</h1>
        <form class="w-25 mx-auto" th:action="@{/login}" method="post" id="login" name="loginForm" action="" method="POST">


                <label for="userid">メールアドレス</label>
                <input class="form-control" type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email"])) {echo htmlspecialchars($_POST["email"], ENT_QUOTES);} ?>">
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?>
                </div>
                <label for="password">パスワード</label>
                <input class="form-control" type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?>
                </div>
                <div class="text-center">
                    <input class="btn btn-outline-primary my-1" type="submit" id="login" name="login" value="ログインする"/>
                </div>
        </form>
          
    </body>
</html>
