<?php

// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bookingsystem";  // データベース名

// エラーメッセージの初期化
$errorMessagename = "";
$errorMessagepassword = "";

$con = mysqli_connect("localhost","root","","bookingsystem");


$sql = "SELECT name FROM `shop`";
$all_categories = mysqli_query($con,$sql);




if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["name"])) {
      $errorMessagename = '店名が未入力です。';
    }
     if (empty($_POST["password"])) {
        $errorMessagepassword = 'パスワードが未入力です。';
    }

    if (!empty($_POST["name"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $name = $_POST["name"];

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
            $sql = 'SELECT * FROM shop WHERE name = :name';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name',$name );
            $stmt->execute();
            $shop = $stmt->fetch();
            $password_hash = password_hash($shop['password'],PASSWORD_DEFAULT);

            if (password_verify($_POST['password'], $password_hash)) {
                    session_regenerate_id(true);
                      $_SESSION['id'] = $shop['id'];

                      $_SESSION['name'] = $shop['name'];


                     header("Location: main_shop.php");  // メイン画面へ遷移
                     exit();  // 処理終了
                 } else {
                    // 認証失敗
                  echo  $errorMessage = 'メールアドレスまたはパスワードに誤りがあります。';
                }

    }
}

?>
<html>
    <head>
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>ログイン画面</title>
    </head>
    <body>
        <p class="text-center m-5">店舗名を選択してください</p>
                <form class="w-25 mx-auto" action="" method="post" name="loginForm" action="" method="POST">
                  <div class="col-xs-3">
                     <select class="form-control" id="number" name="name">
                       <?php
                            // use a while loop to fetch data
                            // from the $all_categories variable
                            // and individually display as an option
                            while ($category = mysqli_fetch_array(
                              $all_categories,MYSQLI_ASSOC)):;
                           ?>
                            <option value="<?php echo $category["name"];?>">
                             <?php echo $category["name"];
                              // To show the category name to the user
                             ?>
                            </option>
                           <?php
                            endwhile;
                            // While loop must be terminated
                           ?>

                     </select>
                   </div>
                   <div class="alert alert-danger" role="alert" th:if="${param.error}">
                       <?php echo htmlspecialchars($errorMessagename, ENT_QUOTES); ?>
                   </div>

                        <label for="password">パスワード</label>
                        <input class="form-control" type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                        <div class="alert alert-danger" role="alert" th:if="${param.error}">
                            <?php echo htmlspecialchars($errorMessagepassword, ENT_QUOTES); ?>
                        </div>
                        <div class="text-center">
                            <input class="btn btn-outline-primary my-1" type="submit" id="login" name="login" value="ログインする"/>
                        </div>
                </form>



    </body>
</html>
