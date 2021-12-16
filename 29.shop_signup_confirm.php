<?php
  session_start();
  require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
  //URLからパラメータ取得
  $url_pass = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  //ユーザー正式登録
  try {
    // DB接続
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //プレースホルダで SQL 作成
    $sql = "SELECT * FROM shop WHERE temp_pass = ? AND register_time >= ?;";
    $stmt = $pdo->prepare($sql);
    //10分前の時刻を取得
    $datetime = new DateTime('- 10 min');
    $stmt->bindValue(1, $url_pass, PDO::PARAM_STR);
    $stmt->bindValue(2, $datetime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //URLが不正か期限切れ
    if (empty($row)) {
      $_SESSION['error_status'] = 6;
      redirect_to_shop_signup();
      exit();
    }
    $email = $row['email'];
    $sql = "UPDATE shop SET is_shop = 1 WHERE email = ?;";
    $stmt = $pdo->prepare($sql);
    // トランザクションの開始
    $pdo->beginTransaction();
    try {
      $stmt->bindValue(1, $email, PDO::PARAM_STR);
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
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<h3 class="text-center  m-5 font-weight-normal">登録完了</h3>
<p class="text-center  m-5 font-weight-normal">店舗の登録が完了しました。</p>
<div class="text-center m-5">
  <a href="23.login_admin.php">ログインする</a>
</div>
</body>
</html>
