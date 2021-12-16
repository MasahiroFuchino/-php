<?php
session_start();
if (!isset($_SESSION['id'])){
    $_SESSION = array();
    session_destroy();
    session_start();
    $_SESSION['error_status'] = 2;
    redirect_to_login_admin();
    exit();
  }
if (!isset($_SESSION['shop_id'])){
    $_SESSION['error_status'] = 2;
    redirect_to_welcome();
    exit();
  }

if (!empty($_SESSION)) {
  $_SESSION['contact_name'] = "";
  $_SESSION['contact_kana'] = "";
  $_SESSION['contact_tel'] = "";
  $_SESSION['contact_email'] = "";
  $_SESSION['contact_content'] = "";
require_once("user_header.php");
} ?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset='utf-8'>
    	<link rel="stylesheet" href="css/bootstrap.css">
      <title>ユーザーページお問い合わせ完了画面</title>
    </head>
    <body>
        <p class="text-center  m-5 font-weight-normal">お問い合わせありがとうございました！</p>
        <div class="text-center m-5">
          <a href="13.main.php">トップに戻る</a>
        </div>
    </body>
</html>
