<?php
session_start();
$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bookingsystem";  // データベース名
require_once('shop_header.php');
// エラーメッセージ、登録完了メッセージの初期化
$errorMessagename = "";
$errorMessagekana = "";
$errorMessagetel = "";
$errorMessageemail = "";
$errorMessagecontent = "";

if (isset($_POST["back"])) {
  header("Location: contact_shop.php");  // メイン画面へ遷移
  exit();

}
if (isset($_POST["submit"])) {
  if (empty($_POST["contactcontent"])) {
    $errorMessagecontent = '返信内容が未入力です。';

  }
  if (!empty($_POST["contactcontent"])) {
    $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

    // 3. エラー処理
    try {
        $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
      } catch (PDOException $e) {
          $errorMessage = 'データベースエラー';
          // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
          // echo $e->getMessage();
      }
      $name = $_SESSION["contact_name"];
      $kana = $_SESSION["contact_kana"];
      $tel = $_SESSION["contact_tel"];
      $email = $_SESSION["contact_email"];
      $content = $_POST["contactcontent"];



      $header = null;

  	$auto_reply_subject = null;
  	$auto_reply_text = null;
  	date_default_timezone_set('Asia/Tokyo');


  	$header = "MIME-Version: 1.0\n";
  	$header .= "From: 窓口運営 <littlebusterz935@gmail.com>\n";
  	$header .= "Reply-To:".$name."<".$email.">\n";


  	$auto_reply_subject = 'お問い合わせありがとうございます。';

  	// 本文を設定
  	$auto_reply_text =  $content;
  	$auto_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
  	$auto_reply_text .= "氏名：" . $name . "\n";
  	$auto_reply_text .= "メールアドレス：" . $email . "\n\n";
  	$auto_reply_text .= "窓口運営";

  	// メール送信
  	mb_send_mail( $email, $auto_reply_subject, $auto_reply_text, $header);
            header("Location: contact_form_complete_shop.php");  // メイン画面へ遷移
            exit();

  }

  }



 ?>
<html>
    <head>
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>店舗ページお問い合わせ詳細画面</title>
    </head>
    <body>
      <div class="mt-5 d-flex justify-content-center">
        <div class="">
          <table class="table  table-bordered table-striped table-detail">
    <table>
    <thead>
    <tr>
      <th>お客様お問い合わせ詳細</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <th>名前</th>
      <td><?php echo $_SESSION["contact_name"]  ?></td>
    </tr>
    <tr>
      <th>カナ</th>
      <td><?php echo $_SESSION["contact_kana"]  ?></td>
    </tr>
    <tr>
      <th>電話番号</th>
      <td><?php echo $_SESSION["contact_tel"]  ?></td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td><?php echo $_SESSION["contact_email"]  ?></td>
    </tr>
    <tr>
      <th>お問い合わせ内容</th>
      <td><?php echo $_SESSION["contact_content"]  ?></td>
    </tr>
        </tbody>
    </table>
        </div>
      </div>
      <form class="w-25 mx-auto" action="" method="post">

          <label class="ml-1" for="username">返信内容</label>
              <textarea  name="contactcontent" rows="8" cols="42" value="<?php if (!empty($_SESSION["contactcontent"])) {echo htmlspecialchars($_SESSION["contactcontent"], ENT_QUOTES);} ?>"></textarea>
              <div class="alert-danger">
                  <?php echo htmlspecialchars($errorMessagecontent, ENT_QUOTES); ?>
              </div>
              <div class="text-center  form-group row justify-content-center">
              <div class>
                  <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" name="back" type="submit" value="戻る"/>
                  <input class="btn btn-outline-primary mx-3 my-1" type="submit" name="submit" value="送信する"/>
              </div>
            </div>

      </form>
      </body>

</html>
