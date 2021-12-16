<?php
// セッション開始
session_start();

require_once("login_function.php");
if (!isset($_SESSION['id'])){
    $_SESSION = array();
    session_destroy();
    session_start();
    $_SESSION['error_status'] = 2;
    redirect_to_login();
    exit();
  }
if (!isset($_SESSION['shop_id'])){
    $_SESSION['error_status'] = 2;
    redirect_to_welcome();
    exit();
  }
require_once("user_header.php");

if (isset($_POST["back"])) {
  header("Location: 13.main.php");  // メイン画面へ遷移

}
// 登録ボタンが押された場合
if (isset($_POST["submit"])) {


        // 入力したユーザIDとパスワードを格納
        $name = $_POST["contact_name"];
        $kana = $_POST["contact_kana"];
        $tel = $_POST["contact_tel"];
        $email = $_POST["contact_email"];
        $content = $_POST["contact_content"];

        // 2. ユーザIDとパスワードが入力されていたら認証する

                    // 入力したIDのユーザー名を取得
                    //DBのユーザー情報をセッションに保存
                     $_SESSION['contact_name'] = $name;
                     $_SESSION['contact_kana'] = $kana;
                     $_SESSION['contact_tel'] = $tel;
                     $_SESSION['contact_email'] = $email;
                     $_SESSION['contact_content'] = $content;

            header("Location: 21.contact_confirm.php");  // メイン画面へ遷移
            exit();

            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();



}

?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset='utf-8'>
    	<link rel="stylesheet" href="css/bootstrap.css">
      <title>ユーザーページお問い合わせ画面</title>
    </head>
    <body>
      <p class="text-center mt-5">下記ご記入の上、送信ボタンを押してください</p>
      <p class="text-center mt-5">ご送信いただいた内容に関しては、当店より折り返しご連絡いたします。<br>
        なお、ご連絡までにお時間をいただく場合もございますのでご了承ください。</p>
      <p class="text-center">*は必須項目となります。</p>
        <form class="w-25 mx-auto" action="" method="post">
           	<label class="mt-5" for="username">名前</label>
           	<input class="form-control" id="username" value="<?php if (!empty($_SESSION["contact_name"])) {echo htmlspecialchars($_SESSION["contact_name"], ENT_QUOTES);} ?>" type="text" name="contact_name" placeholder="名前">
            <p class="text-danger"><?php if (!empty($_SESSION["error"]["contact_name"])) {echo htmlspecialchars($_SESSION["error"]["contact_name"], ENT_QUOTES);} ?></p>
            <label for="username">カナ</label>
            <input class="form-control" id="kana" value="<?php if (!empty($_SESSION["contact_kana"])) {echo htmlspecialchars($_SESSION["contact_kana"], ENT_QUOTES);} ?>" type="text" name="contact_kana" placeholder="カナ">
            <p class="text-danger"><?php if (!empty($_SESSION["error"]["contact_kana"])) {echo htmlspecialchars($_SESSION["error"]["contact_kana"], ENT_QUOTES);} ?></p>
            <label for="username">電話番号</label>
            <input class="form-control" id="tel" value="<?php if (!empty($_SESSION["contact_tel"])) {echo htmlspecialchars($_SESSION["contact_tel"], ENT_QUOTES);} ?>" type="tel" name="contact_tel" placeholder="電話番号">
            <p class="text-danger"><?php if (!empty($_SESSION["error"]["contact_tel"])) {echo htmlspecialchars($_SESSION["error"]["contact_tel"], ENT_QUOTES);} ?></p>
            <label for="username">メールアドレス</label>
            <input class="form-control" id="username"	type="mail" name="contact_email" placeholder="メールアドレス" value="<?php if (!empty($_SESSION["contact_email"])) {echo htmlspecialchars($_SESSION["contact_email"], ENT_QUOTES);} ?>">
            <p class="text-danger"><?php if (!empty($_SESSION["error"]["contact_email"])) {echo htmlspecialchars($_SESSION["error"]["contact_email"], ENT_QUOTES);} ?></p>
            <label for="username">内容</label>
                <textarea name="contact_content" rows="5" cols="42"value="content"><?php if (!empty($_SESSION["contact_content"])) {echo htmlspecialchars($_SESSION["contact_content"], ENT_QUOTES);} ?></textarea>
                <p class="text-danger"><?php if (!empty($_SESSION["error"]["contact_content"])) {echo htmlspecialchars($_SESSION["error"]["contact_content"], ENT_QUOTES);} ?></p>
                <div class="text-center form-group row justify-content-center">
                <div class>
                    <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" name="back" type="submit" value="戻る"/>
                    <input class="btn btn-outline-primary mx-3 my-1" type="submit" name="submit" value="送信する"/>
                </div>
              </div>

        </form>
    </body>
</html>
