<?php
  session_start();
  require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
  $email = $_POST['email'];
  $token = $_POST['token'];
  // CSRFチェック
  if ($_SESSION['token'] != $token) {
    $_SESSION['error_status'] = 3;
    redirect_to_password_reset();
    exit();
  }
  try {
    // DB接続
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //プレースホルダで SQL 作成
    $sql = "SELECT * FROM shop WHERE email = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // IDが存在しない
    if (empty($row)) {
      $_SESSION['error_status'] = 2;
      redirect_to_password_reset();
      exit();
    }
    //リセット処理
    $email = $row['email'];
    //URLパスワードを作成
    $url_pass = get_url_password();
    //プレースホルダで SQL 作成
    $sql = "UPDATE shop SET reset = 1, temp_pass = ?, temp_limit_time = ? WHERE email = ?;";
    $stmt = $pdo->prepare($sql);
    // トランザクションの開始
    $pdo->beginTransaction();
    try {
      $stmt->bindValue(1, $url_pass, PDO::PARAM_STR);
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
  //メールヘッダーインジェクション対策
  $mail = str_replace(array('\r\n','\r','\n'), '', $email);
  $msg = '以下のアドレスからパスワードのリセットを行ってください。' . PHP_EOL;
  $msg .=  'アドレスの有効時間は１０分間です。' . PHP_EOL . PHP_EOL;
  $msg .= 'https:// '. SERVER .'/26.pass_reset_admin.php?' . $url_pass;
  $header= "From: littlebusterz935@gmail.com";
  mb_send_mail($email, 'パスワードのリセット', $msg, $header);
?>
<html>
    <head>
    	<link href="css/bootstrap.css" rel="stylesheet">
        <title>パスワードリセットリクエスト完了画面</title>
    </head>
    <body>
        <p class="text-center  m-5 font-weight-normal"><?php echo $email ?></p>
        <p class="text-center  m-5 font-weight-normal">上記のアドレスにURLを送りました。<br>ご確認ください。</p>
        <div class="text-center m-5">
          <a href="23.login_admin.php">ログイン画面に戻る</a>
        </div>
    </body>
</html>
