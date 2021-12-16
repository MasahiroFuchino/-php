<?php
  session_start();
  require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
  $name = $_POST['shop_name'];
  $adress = $_POST['adress'];
  $tel = $_POST['tel'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $open_time = $_POST['open_time'];
  $close_time = $_POST['close_time'];
  $holiday = $_POST['holiday'];
    $token = $_POST['token'];
  // CSRF チェック
  if ($token != $_SESSION['token']) {
    $_SESSION['error_status'] = 4;
    redirect_to_shop_signup();
    exit();
  }
  //ユーザーの仮登録
  //一時URLパスワード作成
  $url_pass = get_url_password();
  // パスワードハッシュ化
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  // 現在日時
  $datetime = date('Y-m-d H:i:s');
  try {
    // DB接続
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //プレースホルダで SQL 作成
    $sql = "INSERT INTO shop (shop_name,adress,tel,email,password,open_time,close_time,holiday,temp_pass,temp_limit_time,register_time) ";
    $sql .=  "VALUES (?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = $pdo->prepare($sql);
    // トランザクションの開始
    $pdo->beginTransaction();
    try {
      $stmt->bindValue(1, $name, PDO::PARAM_STR);
      $stmt->bindValue(2, $adress, PDO::PARAM_STR);
      $stmt->bindValue(3, $tel, PDO::PARAM_STR);
      $stmt->bindValue(4, $email, PDO::PARAM_STR);
      $stmt->bindValue(5, $hashed_password, PDO::PARAM_STR);
      $stmt->bindValue(6, $open_time, PDO::PARAM_STR);
      $stmt->bindValue(7, $close_time, PDO::PARAM_STR);
      $stmt->bindValue(8, $holiday, PDO::PARAM_STR);
      $stmt->bindValue(9, $url_pass, PDO::PARAM_STR);
      $stmt->bindValue(10, $datetime, PDO::PARAM_STR);
      $stmt->bindValue(11, $datetime, PDO::PARAM_STR);
      $stmt->execute();
      // コミット
      $pdo->commit();
    } catch (PDOException $e) {
      // ロールバック
      $pdo->rollBack();
      throw $e;
    }
  } catch (PDOException $e) {
    // ID重複の可能性
    $_SESSION['error_status'] = 5;
    redirect_to_shop_signup();
    exit();
  }
  //ユーザーにメールの送信
  //メールヘッダーインジェクション対策
  $email = str_replace(array('\r\n','\r','\n'), '', $email);
  $msg = '以下のアドレスからアカウトを有効にしてください。' . PHP_EOL;
  $msg .= 'アドレスの有効時間は１０分間です。' . PHP_EOL;
  $msg .= '有効時間後はパスワードのリセットを行ってください。' . PHP_EOL . PHP_EOL;
  $msg .= 'https:// '. SERVER .'/29.shop_signup_confirm.php?' . $url_pass;
  $header= "From: littlebusterz935@gmail.com";
  mb_send_mail($email, 'ユーザー登録', $msg, $header);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<h3 class="text-center  m-5 font-weight-normal">仮登録完了</h3>
<p class="text-center  m-5 font-weight-normal"><?php echo $email ?></p>
<p class="text-center  m-5 font-weight-normal">上記のアドレスにURLを送りました。<br>ご確認ください。</p>
<div class="text-center m-5">
  <a href="23.login_admin.php">ログイン画面に戻る</a>
</div>
</body>
</html>
