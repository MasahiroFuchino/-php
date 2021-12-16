<?php
session_start();
require_once('login_function.php');
header('Content-type: text/html; charset=utf-8');
$user_id = $_SESSION['id'];
$shop_id = $_SESSION['shop_id'];
$booking_day = $_SESSION['open_day'];
$booking_open_time = $_SESSION['open_time'];
$booking_close_time = $_SESSION['close_time'];
$booking_content = $_SESSION['content'];
$shop_name = $_SESSION['shop_name'];
if (isset($_POST['back'])) {
  $SESSION['open_day']="";
  $SESSION['open_time']="";
  $SESSION['close_time']="";
  $SESSION['content']="";
  $SESSION['shop_name']="";
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: main.php');

}

try {
  $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
  //プレースホルダで SQL 作成
  $sql = "SELECT * FROM booking_detail WHERE shop_id = ? AND user_id = ? AND booking_day = ? AND booking_open_time = ? AND booking_close_time = ? ;";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1,$shop_id, PDO::PARAM_STR);
  $stmt->bindValue(2,$user_id, PDO::PARAM_STR);
  $stmt->bindValue(3,$booking_day, PDO::PARAM_STR);
  $stmt->bindValue(4,$booking_open_time, PDO::PARAM_STR);
  $stmt->bindValue(5,$booking_close_time, PDO::PARAM_STR);
  $stmt->execute([$shop_id,$user_id,$booking_day,$booking_open_time,$booking_close_time]);
  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);


} catch (\Exception $e) {
  exit($e);
}
require_once("user_header.php");
 ?>
<html>
    <head>
    	<link href="css/bootstrap.css" rel="stylesheet">
        <title>ユーザー新規予約完了画面</title>
    </head>
    <body>
      <p class="text-center mt-5">ご予約ありがとうございました！</p>
      <div class="d-flex justify-content-center">
        <div class="">
          <table class="table  table-bordered table-striped table-detail">
    <thead>
    <tr>
      <th>予約内容</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <th>予約日</th>
      <td><?php echo htmlspecialchars($row[0]['booking_day'], ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
      <th>予約時間</th>
      <td><?php echo htmlspecialchars($row[0]['booking_open_time']."～".$row[0]['booking_close_time'], ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
      <th>内容</th>
      <td><?php echo htmlspecialchars($row[0]['content'], ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
        </tbody>
    </table>
    <div class="text-center m-5">
      <a href="14.booking.php">戻る</a>
    </div>

  </div>
        </div>

      </body>
      </div>

</html>
