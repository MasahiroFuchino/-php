<?php

define('DNS','mysql:host=localhost;dbname=bookingsystem;charset=utf8');
define('USER_NAME', 'root');
define('PASSWORD', '');
define('SERVER', '192.168.10.105');
define('SENDER_EMAIL', 'littlebusterz935@gmail.com');


function get_pdo_options() {
  return array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
               PDO::ATTR_EMULATE_PREPARES => false);
}
/*
* CSRF トークン作成
*/
function get_csrf_token() {
 $token_legth = 16;//16*2=32byte
 $bytes = openssl_random_pseudo_bytes($token_legth);
 return bin2hex($bytes);
}
/*
* URL の一時パスワードを作成
*/
function get_url_password() {
  $token_legth = 16;//16*2=32byte
  $bytes = openssl_random_pseudo_bytes($token_legth);
  return hash('sha256', $bytes);
}

/*
* ログイン画面へのリダイレクト
*/
function redirect_to_login() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 4.login.php');
}
function redirect_to_login_admin() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 23.login_admin.php');
}
/*
* パスワードリセット画面へのリダイレクト
*/
function redirect_to_password_reset() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 5.pass_request.php');
}
function redirect_to_password_reset_admin() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 24.pass_request_admin.php');
}
/*
* Welcome画面へのリダイレクト
*/
function redirect_to_welcome() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 12.shop_select.php');
}
function redirect_to_welcome_admin() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 37.main_shop.php');
}
/*
* 登録画面へのリダイレクト
*/
function redirect_to_register() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: register.php');
}
function redirect_to_shop_signup() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 28.shop_signup.php');
}
function redirect_to_vacancy_signup() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 38.booking_vacancy_signup.php');
}
