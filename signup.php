<?php
// セッション開始
session_start();
$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bookingsystem";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessagename = "";
$errorMessagekana = "";
$errorMessagetel = "";
$errorMessageemail = "";
$errorMessagepassword = "";
$errorMessagepassword2 = "";


if (isset($_POST["back"])) {
  header("Location: login.php");  // メイン画面へ遷移

}
// 登録ボタンが押された場合
if (isset($_POST["submit"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["name"])) {
      $errorMessagename = '名前が未入力です。';

    }
     if (empty($_POST["kana"])) {
      $errorMessagekana = 'カナが未入力です。';
    }
     if (empty($_POST["tel"])) {
      $errorMessagetel = '電話番号が未入力です。';
    }
     if (empty($_POST["email"])) {  // 値が空のとき
        $errorMessageemail = 'メールアドレスが未入力です。';
    }
     if (empty($_POST["password"])) {
        $errorMessagepassword = 'パスワードが未入力です。';
    }
     if (empty($_POST["password2"])) {
        $errorMessagepassword2 = 'パスワードが未入力です。';
    }
     if($_POST["password"] != $_POST["password2"]) {
      $errorMessage = 'パスワードに誤りがあります。';}

    if (!empty($_POST["name"]) && !empty($_POST["kana"]) && !empty($_POST["tel"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {

        // 入力したユーザIDとパスワードを格納
        $name = $_POST["name"];
        $kana = $_POST["kana"];
        $tel = $_POST["tel"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // 2. ユーザIDとパスワードが入力されていたら認証する

                    // 入力したIDのユーザー名を取得
                    //DBのユーザー情報をセッションに保存
                     $_SESSION['name'] = $name;
                     $_SESSION['kana'] = $kana;
                     $_SESSION['tel'] = $tel;
                     $_SESSION['email'] = $email;
                     $_SESSION['password'] = $password;

            header("Location: signup_confirm.php");  // メイン画面へ遷移
            exit();

            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();


    }
}

?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <title>新規登録</title>
    </head>
    <body>
        <h1 class="text-center" >新規登録画面</h1>
        <form class="w-25 mx-auto" id="loginForm" name="signup" action="" method="POST">

                <label class="mt-5" for="name">名前</label>
                <input class="form-control" type="text" id="name" name="name" placeholder="名前を入力" value="<?php if (!empty($_SESSION["name"])) {echo htmlspecialchars($_SESSION["name"], ENT_QUOTES);} ?>">
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessagename, ENT_QUOTES); ?>
                </div>
                <label for="kana">カナ</label>
                <input class="form-control" type="text" id="kana" name="kana" placeholder="カナを入力" value="<?php if (!empty($_SESSION["kana"])) {echo htmlspecialchars($_SESSION["kana"], ENT_QUOTES);} ?>">
                <div c<div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessagekana, ENT_QUOTES); ?>
                </div>
                <label for="tel">電話番号</label>
                <input class="form-control" type="text" id="tel" name="tel" placeholder="電話番号を入力" value="<?php if (!empty($_SESSION["tel"])) {echo htmlspecialchars($_SESSION["tel"], ENT_QUOTES);} ?>">
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessagetel, ENT_QUOTES); ?>
                </div>
                <label for="email">メールアドレス</label>
                <input class="form-control" type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_SESSION["email"])) {echo htmlspecialchars($_SESSION["email"], ENT_QUOTES);} ?>">
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessageemail, ENT_QUOTES); ?>
                </div>
                <label for="password">パスワード</label>
                <input class="form-control" type="password" id="password" name="password" placeholder="パスワードを入力" value="<?php if (!empty($_SESSION["password"])) {echo htmlspecialchars($_SESSION["password"], ENT_QUOTES);} ?>">
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessagepassword, ENT_QUOTES); ?>
                </div>
                <input class="form-control" type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessagepassword2, ENT_QUOTES); ?>
                </div>
                <div class="form-group row justify-content-center">
                <div class>
                    <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" name='back' type="submit" value="戻る"/>
                    <input class="btn btn-outline-primary mx-3 my-1" type="submit" name='submit' value="登録する"/>
                </div>
              </div>

        </form>

    </body>
</html>
