<?php session_start();
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
  require_once("user_header.php");
  require_once("login_function.php");

$error = "";
$error = array();

// 氏名のバリデーション
if( empty($_SESSION['contact_name']) ) {
  $error['contact_name'] = "※「氏名」は必ず入力してください。";

} elseif( 20 < mb_strlen($_SESSION['contact_name']) ) {
  $error['contact_name'] = "※「氏名」は20文字以内で入力してください。";
}
if( empty($_SESSION['contact_kana']) ) {
  $error['contact_kana'] = "※「カナ」は必ず入力してください。";

} elseif( 20 < mb_strlen($_SESSION['contact_kana']) ) {
  $error['contact_kana'] = "※「カナ」は20文字以内で入力してください。";
} elseif (!preg_match("/^[ァ-ヶー]+$/u", $_SESSION['contact_kana'])) {
  $error['contact_kana'] = "※「カナ」はカタカナのみで入力してください。";
}
if ( empty($_SESSION['contact_tel']) ) {
  $error['contact_tel'] = "※「電話番号」は必ず入力してください。";
} elseif( !preg_match( '/^0[0-9]{9,10}\z/', $_SESSION['contact_tel'] ) ) {
  $error['contact_tel'] = "※「電話番号」はハイフンなし、電話番号で入力してください。";
}

// メールアドレスのバリデーション
if( empty($_SESSION['contact_email']) ) {
  $error['contact_email'] = "※「メールアドレス」は必ず入力してください。";

} elseif( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $_SESSION['contact_email']) ) {
  $error['contact_email'] = "※「メールアドレス」は正しい形式で入力してください。";
}

  // お問い合わせ内容のバリデーション
if( empty($_SESSION['contact_content']) ) {
  $error['contact_content'] = "※「お問い合わせ内容」は必ず入力してください。";
}
if(!empty($error)) {
    $_SESSION['error'] = $error;
    header("Location: contact.php");
  }else {
    $_SESSION['error'] = "";
  }

if (isset($_POST["back"])) {
  header("Location: contact.php");}  // メイン画面へ遷移

if (isset($_POST["submit"])) {


  // 3. エラー処理
  try {
      $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
      $name = $_SESSION["contact_name"];
      $kana = $_SESSION["contact_kana"];
      $tel = $_SESSION["contact_tel"];
      $email = $_SESSION["contact_email"];
      $content = $_SESSION["contact_content"];
      $date = date("Y/m/d H:i:s");

        $sql = "INSERT INTO contact(name,kana,tel,email,content,created_at) VALUES (?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute(array($name,$kana,$tel,$email,$content,$date));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
    } catch (PDOException $e) {
        $error = 'データベースエラー';
        // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
        // echo $e->getMessage();
    }



      // 2. ユーザIDとパスワードが入力されていたら認証する

                  // 入力したIDのユーザー名を取得
                  //DBのユーザー情報をセッションに保存
                   $_SESSION['contact_name'] = $name;
                   $_SESSION['contact_kana'] = $kana;
                   $_SESSION['contact_tel'] = $tel;
                   $_SESSION['contact_email'] = $email;
                   $_SESSION['contact_content'] = $content;
                   $header = null;

	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');


	$header = "MIME-Version: 1.0\n";
	$header .= "From: 窓口運営 <littlebusterz935@gmail.com>\n";
	$header .= "Reply-To: 窓口運営 <littlebusterz935@gmail.com>\n";


	$auto_reply_subject = 'お問い合わせありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お問い合わせ頂き誠にありがとうございます。
下記の内容でお問い合わせを受け付けました。\n\n";
	$auto_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$auto_reply_text .= "氏名：" . $_SESSION['contact_name'] . "\n";
	$auto_reply_text .= "メールアドレス：" . $_SESSION['contact_email'] . "\n";
  $auto_reply_text .= "内容：".$_SESSION['contact_content']."\n\n";
	$auto_reply_text .= "窓口運営";

	// メール送信
	mb_send_mail( $_SESSION['contact_email'], $auto_reply_subject, $auto_reply_text, $header);
          header("Location: 22.contact_complete.php");  // メイン画面へ遷移
          exit();

}


?>
<!DOCTYPE html>
<html>
<html>
    <head>
      <meta charset='utf-8'>
    	<link rel="stylesheet" href="css/bootstrap.css">
      <title>ユーザーページお問い合わせ確認画面</title>
    </head>
    <body>
      <p class="text-center mt-5">以下の内容でよろしければ「送信する」をクリックしてください。<br>
      内容を変更する場合は「戻る」をクリックして入力画面にお戻りください。</p>
        <div class="d-flex justify-content-center">
          <table ~~~ style="table-layout:fixed;width:50%;" class="table  table-bordered table-striped table-detail">
    <thead>
    <tr>
      <th>ご入力内容</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <th>名前</th>
      <td><?php echo $_SESSION['contact_name'] ?></td>
    </tr>
    <tr>
      <th>カナ</th>
      <td><?php echo $_SESSION['contact_kana'] ?></td>
    </tr>
    <tr>
      <th>電話番号</th>
      <td><?php echo $_SESSION['contact_tel'] ?></td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td><?php echo $_SESSION['contact_email'] ?></td>
    </tr>
    <tr>
      <th>お問い合わせ内容</th>
      <td ~~~ style="word-wrap:break-word;"><?php echo $_SESSION['contact_content'] ?></td>
    </tr>
        </tbody>
    </table>

  </div>
  <div class="text-center">
    <form class="" action="" method="post">
      <input class="form-control" type="hidden" id="name" name="contactname" placeholder="名前を入力" value="<?php if (!empty($_SESSION["contact_name"])) {echo htmlspecialchars($_SESSION["contact_name"], ENT_QUOTES);} ?>">
      <input class="form-control" type="hidden" id="kana" name="contactkana" placeholder="カナを入力" value="<?php if (!empty($_SESSION["contact_kana"])) {echo htmlspecialchars($_SESSION["contact_kana"], ENT_QUOTES);} ?>">
      <input class="form-control" type="hidden" id="tel" name="contacttel" placeholder="電話番号を入力" value="<?php if (!empty($_SESSION["contact_tel"])) {echo htmlspecialchars($_SESSION["contact_tel"], ENT_QUOTES);} ?>">
      <input class="form-control" type="hidden" id="email" name="contactemail" placeholder="メールアドレスを入力" value="<?php if (!empty($_SESSION["contact_email"])) {echo htmlspecialchars($_SESSION["contact_email"], ENT_QUOTES);} ?>">
      <input class="form-control" type="hidden" id="password" name="contactcontent" placeholder="パスワードを入力" value="<?php if (!empty($_SESSION["contact_content"])) {echo htmlspecialchars($_SESSION["contact_content"], ENT_QUOTES);} ?>">
      <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" type="submit" name="back"  value="戻る"/>
      <input class="btn btn-outline-primary mx-3 my-1" type="submit" name="submit" value="登録する"/>
    </form>
  </div>


      </body>


</html>
