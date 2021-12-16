<?php
session_start();
require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
require_once('shop_header.php');
if (!isset($_SESSION['shop_id'])){
    $_SESSION['error_status'] = 2;
    redirect_to_login_admin();
    exit();
  }
  $_SESSION['token'] = get_csrf_token(); // CSRFのトークンを取得する
if (isset($_POST["booking_vacancy_signup"])) {
  header("Location: 38.booking_vacancy_signup.php");  // 管理者予約登録画面へ遷移
  exit();
}
if (isset($_POST["booking_confirm"])) {
    header("Location: 41.booking_shop.php");  // 管理者問い合わせ画面へ遷移
    exit();
}


if (isset($_POST["contact"])) {
    header("Location: contact_shop.php");  // 管理者問い合わせ画面へ遷移
    exit();
}

 ?>
<html>
    <head>
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>店舗ページメイン画面</title>
    </head>
    <body>
      <form class="" action="" method="post">



                <div class="text-center my-5">
                    <input class="btn btn-outline-primary my-1" name="booking_vacancy_signup" type="submit" value="予約枠登録"/>
                </div>
                
                <div class="text-center my-5">
                    <input class="btn btn-outline-primary my-1" name="booking_confirm" type="submit" value="予約状況確認"/>
                </div>
                <div class="text-center my-5">
                    <input class="btn btn-outline-primary my-1" name="contact" type="submit" value="お問い合わせ確認"/>
                </div>

        </form>
    </body>
</html>
