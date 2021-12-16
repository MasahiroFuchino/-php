<?php
session_start();
require_once('login_function.php');
// パラメーター取得
$email = $_POST['email'];
$password = $_POST['password'];
$token = $_POST['token'];
// CSRF チェック
if ($token != $_SESSION['token']) {
  // リダイレクト
  $_SESSION['error_status'] = 2;
  redirect_to_login();
  exit();
}
try {
  // DB接続
  $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
  //プレースホルダで SQL 作成
  $sql = "SELECT * FROM users WHERE email = ?;";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $email, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  // ログイン失敗
  if (empty($row)) {
    $_SESSION['error_status'] = 1;
    redirect_to_login();
    exit();
  }
  // 値取得
  $id = $row['id'];
  $name = $row['name'];
  $db_password = $row['password'];
  $reset = $row['reset'];
  $is_user = $row['is_user'];
  //パスワードリセット対応
  if ($reset == 1) {
    $_SESSION['error_status'] = 1;
   redirect_to_password_reset();
   exit();
  }
  // ログイン判定
  if ($is_user == 1 && password_verify($password, $db_password)) {
    // ログイン成功
    // セッション ID の振り直し
    session_regenerate_id(true);
    // セッションに ID を格納
    $_SESSION['id'] = $id;
    $_SESSION['name'] = $name;

    // ログイン日時更新
    $sql = "UPDATE users SET last_login_time = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    // トランザクションの開始
    $pdo->beginTransaction();
    try {
      $stmt->bindValue(1, date('Y-m-d H:i:s'), PDO::PARAM_STR);
      $stmt->bindValue(2, $id, PDO::PARAM_STR);
      $stmt->execute();
      // コミット
      $pdo->commit();
    } catch (PDOException $e) {
      // ロールバック
      $pdo->rollBack();
      throw $e;
    }
    // リダイレクト
    redirect_to_welcome();
  } else {
    // ログイン失敗
    $_SESSION['error_status'] = 1;
    // リダイレクト
    redirect_to_login();
    exit();
  }
} catch (PDOException $e) {
  die($e->getMessage());
}
