<?php
  session_start();
  require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
  $email = $_SESSION['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['password2'];
  $token = $_POST['token'];
  //CSRF エラー
  if ($token != $_SESSION['token']) {
     $_SESSION['error_status'] = 2;
     redirect_to_login();
     exit();
  }
  //パスワード不一致
  if ($password != $confirm_password) {
    $_SESSION['error_status'] = 1;
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: 26.password_reset_admin.php?' . $_SESSION['url_pass']);
    exit();
  }
  //パスワード更新
  try {
    // DB接続
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //プレースホルダで SQL 作成
    $sql = "SELECT * FROM shop WHERE email = ? AND reset = 1;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($row)) {
      $_SESSION['error_status'] = 3;
      redirect_to_password_reset_admin();
      exit();
    }
    $email = $row['email'];
    //プレースホルダで SQL 作成
    $sql = "UPDATE shop SET reset = 0, is_shop = 1, password = ?, last_change_pass_time = ? WHERE email = ?;";
    $stmt = $pdo->prepare($sql);
    // パスワードハッシュ化
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // トランザクションの開始
    $pdo->beginTransaction();
    try {
      $stmt->bindValue(1, $hashed_password, PDO::PARAM_STR);
      $stmt->bindValue(2, date('Y-m-d H:i:s'), PDO::PARAM_STR);
      $stmt->bindValue(3, $email, PDO::PARAM_STR);
      $stmt->execute();
      // コミット
      $pdo->commit();
    } catch (PDOException $e) {
      // ロールバック
      $pdo->rollBack();
      throw $e;
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
  //メール送信
  $mail = str_replace(array('\r\n','\r','\n'), '', $email);  //メールヘッダーインジェクション対策
  $msg = 'パスワードがリセットされました。' ;
  $header= "From: littlebusterz935@gmail.com";
  mb_send_mail($mail, 'パスワードのリセット完了', $msg,$header);
?>
<html>
    <head>
    	<link href="css/bootstrap.css" rel="stylesheet">
        <title>ユーザーページパスワードリセット完了画面</title>
    </head>
    <body>
        <p class="text-center  m-5 font-weight-normal">パスワードのリセットが完了しました。</p>
        <div class="text-center m-5">
          <a href="23.login_admin.php">ログインする</a>
        </div>
    </body>
</html>
