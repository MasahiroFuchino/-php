<?php
  session_start();
  require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
  $name = $_POST['shop_name'];
  $adress = $_POST['adress'];
  $tel = $_POST['tel'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $open_time = $_POST['open_time'];
  $close_time = $_POST['close_time'];
  $holiday = [];
  if (isset($_POST['non'])) {
    if (isset($_POST['sun']) || isset($_POST['mon']) ||
     isset($_POST['tue']) || isset($_POST['wed']) ||
     isset($_POST['thu']) || isset($_POST['fri']) ||
     isset($_POST['sat'])) {

    }
  }
  if (isset($_POST['sun'])) {
    $holiday[]=$_POST['sun'];
  }
  if (isset($_POST['mon'])) {
    $holiday[]=$_POST['mon'];
  }
  if (isset($_POST['tue'])) {
    $holiday[]=$_POST['tue'];
  }
  if (isset($_POST['wed'])) {
    $holiday[]=$_POST['wed'];
  }
  if (isset($_POST['thu'])) {
    $holiday[]=$_POST['thu'];
  }
  if (isset($_POST['fri'])) {
    $holiday[]=$_POST['fri'];
  }
  if (isset($_POST['sat'])) {
    $holiday[]=$_POST['sat'];
  }
  if (isset($_POST['non'])) {
    $holiday[]=$_POST['non'];
  }
  $holiday=array_filter($holiday);
  $holiday=array_merge($holiday);
  $token = $_POST['token'];
  // CSRF チェック
  if ($token != $_SESSION['token']) {
    $_SESSION['error_status'] = 4;
    redirect_to_shop_signup();
    exit();
  }
  // 必須項目チェック
  if (empty($name) || empty($adress) || empty($tel) || empty($email) || empty($password) || empty($password2) || empty($open_time) || empty($close_time)) {
    $_SESSION['error_status'] = 1;
    redirect_to_shop_signup();
    exit();
  }
  //パスワード不一致
  if ($password != $password2) {
    $_SESSION['error_status'] = 2;
    redirect_to_shop_signup();
    exit();
  }
  // var_dump($holiday) ;
  //IDチェック
  try {
    // DB接続
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //プレースホルダで SQL 作成
    $sql = "SELECT COUNT(*) AS cnt FROM shop WHERE email = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //既にemailが登録されていた
    if (!empty($row) && $row['cnt'] > 0) {
      $_SESSION['error_status'] = 3;
      redirect_to_shop_signup();
      exit();
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
  <h3 class="text-center">確認画面</h3>
  <h5 class="text-center">登録しますか？</h5>
  <div class="text-center d-flex justify-content-center">
    <div class="">
      <form action="28''.shop_signup_submit.php" method="post">
        <table class="mt-5 mb-5">
          <tr>
            <td>店舗名</td>
            <td><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
         <tr>
            <td>店舗住所</td>
            <td><?php echo htmlspecialchars($adress, ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
         <tr>
            <td>店舗電話番号</td>
            <td><?php echo htmlspecialchars($tel, ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
         <tr>
            <td>店舗メールアドレス</td>
            <td><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
         <tr>
            <td>店舗開店時間</td>
            <td><?php echo htmlspecialchars($open_time, ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
         <tr>
            <td>店舗閉店時間</td>
            <td><?php echo htmlspecialchars($close_time, ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
         <tr>
            <td>定休日</td>
            <td><?php foreach ($holiday as $key => $value) {
                echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            } ?></td>
          </tr>
          <?php
          $holiday=implode(',',$holiday);
           ?>
        </table>
        <input type="hidden" name="shop_name" value="<?php echo htmlspecialchars($name  , ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="adress" value="<?php echo htmlspecialchars($adress  , ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="tel" value="<?php echo htmlspecialchars($tel  , ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email  , ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="password" value="<?php echo htmlspecialchars($password  , ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="open_time" value="<?php echo htmlspecialchars($open_time  , ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="close_time" value="<?php echo htmlspecialchars($close_time  , ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="holiday" value="<?php echo htmlspecialchars($holiday  , ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']  , ENT_QUOTES, 'UTF-8') ?>">
        <div class="text-center form-group row justify-content-center">
        <div class="">
            <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" name='back' type="button" value="戻る" onclick="document.location.href='28.shop_signup.php';"/>
            <input class="btn btn-outline-primary mx-3 my-1" type="submit" name='submit' value="登録する"/>
        </div>
        </div>
      </form>
    </div>


  </div>
  </body>
</html>
