<?php
session_start();
if (!empty($_SESSION)) {
  $_SESSION = array();
  session_destroy();

} ?>
<html>
    <head>
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>パスワードリセットリクエスト画面</title>
    </head>
    <body>
        <p class="text-center  m-5 font-weight-normal">ご登録ありがとうございました！</p>
        <div class="text-center m-5">
          <a href="login.php">早速始める！</a>
        </div>
    </body>
</html>
