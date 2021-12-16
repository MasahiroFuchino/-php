<?php session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bookingsystem";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

if (isset($_POST["back"])) {
  header("Location: signup.php");}  // メイン画面へ遷移

if (isset($_POST["submit"])) {
  $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

  // 3. エラー処理
  try {
      $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        $errorMessage = 'データベースエラー';
        // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
        // echo $e->getMessage();
    }
    $name = $_POST["name"];
    $kana = $_POST["kana"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $password = $_POST["password"];

      $sql = "INSERT INTO users(name,kana,tel,email,password) VALUES (?, ?, ?, ?, ?)";
      $stmt = $pdo->prepare($sql);

      $stmt->execute(array($name,$kana,$tel,$email, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）


      // 2. ユーザIDとパスワードが入力されていたら認証する

                  // 入力したIDのユーザー名を取得
                  //DBのユーザー情報をセッションに保存
                   $_SESSION['name'] = $name;
                   $_SESSION['kana'] = $kana;
                   $_SESSION['tel'] = $tel;
                   $_SESSION['email'] = $email;
                   $_SESSION['password'] = $password;

          header("Location: signup_complete.php");  // メイン画面へ遷移
          exit();

}


?>

<html>
    <head>
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>ユーザーページ新規登録画面</title>
    </head>
    <body>
      <p class="text-center mt-5">登録情報に間違いはありませんか？</p>
      <div class="d-flex justify-content-center">
        <div class="">
          <table class="table  table-bordered table-striped table-detail">
    <thead>
    <tr>
      <th>新規ユーザー登録情報</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <th>名前</th>
      <td><?php echo $_SESSION['name'] ?></td>
    </tr>
    <tr>
      <th>カナ</th>
      <td><?php echo $_SESSION['kana'] ?></td>
    </tr>
    <tr>
      <th>電話番号</th>
      <td><?php echo $_SESSION['tel'] ?></td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td><?php echo $_SESSION['email'] ?></td>
    </tr>
    <tr>
      <th>パスワード</th>
      <td style="password"><?php echo $_SESSION['password'] ?></td>
    </tr>
        </tbody>
    </table>
    <div class="form-group row justify-content-center">
    <div>
      <form class="" action="" method="post">
        <input class="form-control" type="hidden" id="name" name="name" placeholder="名前を入力" value="<?php if (!empty($_SESSION["name"])) {echo htmlspecialchars($_SESSION["name"], ENT_QUOTES);} ?>">
        <input class="form-control" type="hidden" id="kana" name="kana" placeholder="カナを入力" value="<?php if (!empty($_SESSION["kana"])) {echo htmlspecialchars($_SESSION["kana"], ENT_QUOTES);} ?>">
        <input class="form-control" type="hidden" id="tel" name="tel" placeholder="電話番号を入力" value="<?php if (!empty($_SESSION["tel"])) {echo htmlspecialchars($_SESSION["tel"], ENT_QUOTES);} ?>">
        <input class="form-control" type="hidden" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_SESSION["email"])) {echo htmlspecialchars($_SESSION["email"], ENT_QUOTES);} ?>">
        <input class="form-control" type="hidden" id="password" name="password" placeholder="パスワードを入力" value="<?php if (!empty($_SESSION["password"])) {echo htmlspecialchars($_SESSION["password"], ENT_QUOTES);} ?>">
        <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" type="submit" name="back"  value="戻る"/>
        <input class="btn btn-outline-primary mx-3 my-1" type="submit" name="submit" value="登録する"/>
      </form>
    </div>
  </div>
        </div>

      </body>
      </div>

</html>
