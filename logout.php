<?php
  session_start();
  require_once('login_function.php');

  // CSRF チェック

  //セッション破棄
  $_SESSION = array();
  session_destroy();
  //リダイレクト
  session_start();
  $_SESSION['logout'] = 1;
  redirect_to_login();
  ?>
