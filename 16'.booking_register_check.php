<?php
session_start();
require_once('login_function.php');
header('Content-type: text/html; charset=utf-8');

if (empty($_POST['content'])) {
  $_SESSION['error_status'] = 1;
  header('Location: 16.booking_register.php');
}
$booking_day = $_POST['open_day'];
$booking_open_time = $_POST['open_time'];
$booking_close_time = $_POST['close_time'];
$booking_content = $_POST['content'];
$user_id = $_SESSION['id'];
$shop_id = $_SESSION['shop_id'];

try {
  $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
  //プレースホルダで SQL 作成
  $pdo->beginTransaction();
  $date=date('Y-m-d H:i:s');
  $sql_1 = "SELECT * FROM booking WHERE shop_id = ? AND open_day = ? AND open_time = ? AND close_time = ?";
  $stmt_1 = $pdo->prepare($sql_1);
  $stmt_1->bindValue(1,$shop_id, PDO::PARAM_STR);
  $stmt_1->bindValue(2,$booking_day, PDO::PARAM_STR);
  $stmt_1->bindValue(3,$booking_open_time, PDO::PARAM_STR);
  $stmt_1->bindValue(4,$booking_close_time, PDO::PARAM_STR);

  $stmt_1->execute([$shop_id,$booking_day,$booking_open_time,$booking_close_time]);
  $row_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
  
  if ($row_1[0]['booking_rest']>0) {
    $sql_2 = "UPDATE booking SET booking_rest = booking_rest -1,updated_at = ? WHERE shop_id = ? AND open_day = ? AND open_time = ? AND close_time = ? AND booking_rest > ?";
    $stmt_2 = $pdo->prepare($sql_2);
    $stmt_2->bindValue(1,$date, PDO::PARAM_STR);
    $stmt_2->bindValue(2,$shop_id, PDO::PARAM_STR);
    $stmt_2->bindValue(3,$booking_day, PDO::PARAM_STR);
    $stmt_2->bindValue(4,$booking_open_time, PDO::PARAM_STR);
    $stmt_2->bindValue(5,$booking_close_time, PDO::PARAM_STR);
    $stmt_2->bindValue(6,'0', PDO::PARAM_STR);

    $stmt_2->execute([$date,$shop_id,$booking_day,$booking_open_time,$booking_close_time,'0']);

    $sql_3  = "INSERT INTO booking_detail(shop_id,user_id,booking_id,booking_day,booking_open_time,booking_close_time,content,created_time)
    	          VALUES (?,?,?,?,?,?,?,?)";
    $stmt_3 = $pdo->prepare($sql_3);
    $stmt_3->bindValue(1,$shop_id, PDO::PARAM_STR);
    $stmt_3->bindValue(2,$user_id, PDO::PARAM_STR);
    $stmt_3->bindValue(3,$row_1[0]['id'], PDO::PARAM_STR);
    $stmt_3->bindValue(4,$booking_day, PDO::PARAM_STR);
    $stmt_3->bindValue(5,$booking_open_time, PDO::PARAM_STR);
    $stmt_3->bindValue(6,$booking_close_time, PDO::PARAM_STR);
    $stmt_3->bindValue(7,$booking_content, PDO::PARAM_STR);
    $stmt_3->bindValue(8,$date, PDO::PARAM_STR);
    $stmt_3->execute([$shop_id,$user_id,$row_1[0]['id'],$booking_day,$booking_open_time,$booking_close_time,$booking_content,$date]);

  }else if($row_1[0]['booking_rest'] <= 0){
    $pdo->rollBack();
    exit($e);
  }
  $sql_4 = "SELECT * FROM booking WHERE shop_id = ? AND open_day = ? AND open_time = ? AND close_time = ?";
  $stmt_4 = $pdo->prepare($sql_4);
  $stmt_4->bindValue(1,$shop_id, PDO::PARAM_STR);
  $stmt_4->bindValue(2,$booking_day, PDO::PARAM_STR);
  $stmt_4->bindValue(3,$booking_open_time, PDO::PARAM_STR);
  $stmt_4->bindValue(4,$booking_close_time, PDO::PARAM_STR);
  $stmt_4->execute([$shop_id,$booking_day,$booking_open_time,$booking_close_time,1,1]);
  $row_4 = $stmt_4->fetchAll(PDO::FETCH_ASSOC);
  if ($row_4[0]['booking_rest'] <= 0) {
    $sql_5 = "UPDATE booking SET updated_at = ? WHERE booking_rest <= ?;";
    $stmt_5 = $pdo->prepare($sql_5);

    $stmt_5->bindValue(1,$date, PDO::PARAM_STR);
    $stmt_5->bindValue(2,'0', PDO::PARAM_INT);
    $stmt_5->execute([$date,'0']);
  }
  $pdo->commit();
  $_SESSION['content']=$booking_content;
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 17.booking_complete.php');
} catch (\Exception $e) {
  $pdo->rollBack();
  exit($e);
}

 ?>
