<?php
session_start();
require_once('login_function.php');
require_once('shop_header.php');



// if ($_POST['non']) {
//   if ($_POST['days']>0) {
//     echo "aaaa";
//   }
// }
$date = $_POST['date'];

$day= $_POST['day'];

$open_time = $_POST['open_time'];
$close_time = $_POST['close_time'];
$number = $_POST['number'];

// var_dump($target);
$sun =$_POST['sun'];
$mon = $_POST['mon'];
$tue = $_POST['tue'];
$wed = $_POST['wed'];
$thu = $_POST['thu'];
$fri = $_POST['fri'];
$sat = $_POST['sat'];
$non = $_POST['non'];

if ($sun) {
  $target[]=0;
}
if ($mon) {
  $target[]=1;
}
if ($tue) {
  $target[]=2;
}
if ($wed) {
  $target[]=3;
}
if ($thu) {
  $target[]=4;
}
if ($fri) {
  $target[]=5;
}
if ($sat) {
  $target[]=6;
}

if ($day=="選択してください") {
  $days=null;
}
if ($day=="当日のみ") {
  $days=0;
}
if ($day=="30日後まで") {
  $days=30;
}
if ($day=="60日後まで") {
  $days=60;
}
if ($day=="90日後まで") {
  $days=90;
}

$token = $_POST['token'];


if (empty($date) || empty($day)) {
    $_SESSION["date"]=$date;
    $_SESSION["day"]=$day;
    $_SESSION["sun"]=$sun;
    $_SESSION["mon"]=$mon;
    $_SESSION["tue"]=$tue;
    $_SESSION["wed"]=$wed;
    $_SESSION["thu"]=$thu;
    $_SESSION["fri"]=$fri;
    $_SESSION["sat"]=$sat;
    $_SESSION["open_time"]=$open_time;
    $_SESSION["close_time"]=$close_time;
    $_SESSION["number"]=$number;
    $_SESSION['error_status'] = 1;
    redirect_to_vacancy_signup();
    exit();
  }


if (empty($sun) && empty($mon) && empty($tue) && empty($wed) && empty($thu)
 && empty($fri) && empty($sat)) {
   if ($days>0) {
     $_SESSION["date"]=$date;
     $_SESSION["day"]=$day;
     $_SESSION["sun"]=$sun;
     $_SESSION["mon"]=$mon;
     $_SESSION["tue"]=$tue;
     $_SESSION["wed"]=$wed;
     $_SESSION["thu"]=$thu;
     $_SESSION["fri"]=$fri;
     $_SESSION["sat"]=$sat;
     $_SESSION["open_time"]=$open_time;
     $_SESSION["close_time"]=$close_time;
     $_SESSION["number"]=$number;
     $_SESSION['error_status'] = 9;
     redirect_to_vacancy_signup();
     exit();
      }

}
if ($sun || $mon || $tue || $wed || $thu || $fri || $sat) {
   if ($days==0) {
     $_SESSION["date"]=$date;
     $_SESSION["day"]=$day;
     $_SESSION["sun"]=$sun;
     $_SESSION["mon"]=$mon;
     $_SESSION["tue"]=$tue;
     $_SESSION["wed"]=$wed;
     $_SESSION["thu"]=$thu;
     $_SESSION["fri"]=$fri;
     $_SESSION["sat"]=$sat;
     $_SESSION["open_time"]=$open_time;
     $_SESSION["close_time"]=$close_time;
     $_SESSION["number"]=$number;
     $_SESSION['error_status'] = 10;
     redirect_to_vacancy_signup();
     exit();
      }

}

if (empty($open_time[0]) && empty($open_time[1]) && empty($open_time[2])
&& empty($open_time[3]) && empty($open_time[4]) && empty($open_time[5])
&& empty($open_time[6]) && empty($open_time[7]) && empty($open_time[8])
&& empty($open_time[9]) && empty($open_time[10])&& empty($open_time[11])
&& empty($open_time[12])&& empty($open_time[13])) {
  $_SESSION["date"]=$date;
  $_SESSION["day"]=$day;
  $_SESSION["sun"]=$sun;
  $_SESSION["mon"]=$mon;
  $_SESSION["tue"]=$tue;
  $_SESSION["wed"]=$wed;
  $_SESSION["thu"]=$thu;
  $_SESSION["fri"]=$fri;
  $_SESSION["sat"]=$sat;
  $_SESSION["open_time"]=$open_time;
  $_SESSION["close_time"]=$close_time;
  $_SESSION["number"]=$number;
  $_SESSION['error_status'] = 2;
  redirect_to_vacancy_signup();
  exit();
}
for ($i=0; $i < count($open_time); $i++) {
  for ($j=$i+1; $j <count($open_time) ; $j++) {
    if ($open_time[$i] < $close_time[$j] && $open_time[$j] < $close_time[$i]) {
      $_SESSION["date"]=$date;
      $_SESSION["day"]=$day;
      $_SESSION["sun"]=$sun;
      $_SESSION["mon"]=$mon;
      $_SESSION["tue"]=$tue;
      $_SESSION["wed"]=$wed;
      $_SESSION["thu"]=$thu;
      $_SESSION["fri"]=$fri;
      $_SESSION["sat"]=$sat;
      $_SESSION['error_status'] = 11;
      redirect_to_vacancy_signup();
      exit();
    }
  }
}
for ($i=0; $i < count(array_filter($open_time)); $i++) {
    if ($open_time[$i] == $close_time[$i] ) {
      $_SESSION["date"]=$date;
      $_SESSION["day"]=$day;
      $_SESSION["sun"]=$sun;
      $_SESSION["mon"]=$mon;
      $_SESSION["tue"]=$tue;
      $_SESSION["wed"]=$wed;
      $_SESSION["thu"]=$thu;
      $_SESSION["fri"]=$fri;
      $_SESSION["sat"]=$sat;
      $_SESSION['error_status'] = 11;
      redirect_to_vacancy_signup();
      exit();

  }
}

if (empty($close_time[0]) && empty($close_time[1])&& empty($close_time[2])
&& empty($close_time[3])&& empty($close_time[4])&& empty($close_time[5])
&& empty($close_time[6])&& empty($close_time[7])&& empty($close_time[8])
&& empty($close_time[9])&& empty($close_time[10])&& empty($close_time[11])
&& empty($close_time[12])&& empty($close_time[13])) {
  $_SESSION["date"]=$date;
  $_SESSION["day"]=$day;
  $_SESSION["sun"]=$sun;
  $_SESSION["mon"]=$mon;
  $_SESSION["tue"]=$tue;
  $_SESSION["wed"]=$wed;
  $_SESSION["thu"]=$thu;
  $_SESSION["fri"]=$fri;
  $_SESSION["sat"]=$sat;
  $_SESSION["open_time"]=$open_time;
  $_SESSION["close_time"]=$close_time;
  $_SESSION["number"]=$number;
  $_SESSION['error_status'] = 3;
  redirect_to_vacancy_signup();
  exit();
}
if (empty($number[0]) && empty($number[1]) && empty($number[2])
 && empty($number[3]) && empty($number[4]) && empty($number[5])
 && empty($number[6]) && empty($number[7]) && empty($number[8])
 && empty($number[9]) && empty($number[10]) && empty($number[11])
 && empty($number[12]) && empty($number[13])) {
   $_SESSION["date"]=$date;
   $_SESSION["day"]=$day;
   $_SESSION["sun"]=$sun;
   $_SESSION["mon"]=$mon;
   $_SESSION["tue"]=$tue;
   $_SESSION["wed"]=$wed;
   $_SESSION["thu"]=$thu;
   $_SESSION["fri"]=$fri;
   $_SESSION["sat"]=$sat;
   $_SESSION["open_time"]=$open_time;
   $_SESSION["close_time"]=$close_time;
   $_SESSION["number"]=$number;
   $_SESSION['error_status'] = 4;
   redirect_to_vacancy_signup();
   exit();
}
for ($i=0; $i<count($open_time); $i++){
  if (!empty($open_time[$i])) {
    if (empty($close_time[$i]) || empty($number[$i])) {
      $_SESSION["date"]=$date;
      $_SESSION["day"]=$day;
      $_SESSION["sun"]=$sun;
      $_SESSION["mon"]=$mon;
      $_SESSION["tue"]=$tue;
      $_SESSION["wed"]=$wed;
      $_SESSION["thu"]=$thu;
      $_SESSION["fri"]=$fri;
      $_SESSION["sat"]=$sat;
      $_SESSION["open_time"]=$open_time;
      $_SESSION["close_time"]=$close_time;
      $_SESSION["number"]=$number;
      $_SESSION['error_status'] = 5;
      redirect_to_vacancy_signup();
      exit();
    }
  }
}
for ($i=0; $i<count($close_time); $i++){
  if (!empty($close_time[$i])) {
    if (empty($open_time[$i]) || empty($number[$i])) {
      $_SESSION["date"]=$date;
      $_SESSION["day"]=$day;
      $_SESSION["sun"]=$sun;
      $_SESSION["mon"]=$mon;
      $_SESSION["tue"]=$tue;
      $_SESSION["wed"]=$wed;
      $_SESSION["thu"]=$thu;
      $_SESSION["fri"]=$fri;
      $_SESSION["sat"]=$sat;
      $_SESSION["open_time"]=$open_time;
      $_SESSION["close_time"]=$close_time;
      $_SESSION["number"]=$number;
      $_SESSION['error_status'] = 6;
      redirect_to_vacancy_signup();
      exit();
    }
  }
}
for ($i=0; $i<count($number); $i++){
  if (!empty($number[$i])) {
    if (empty($open_time[$i]) || empty($close_time[$i])) {
      $_SESSION["date"]=$date;
      $_SESSION["day"]=$day;
      $_SESSION["sun"]=$sun;
      $_SESSION["mon"]=$mon;
      $_SESSION["tue"]=$tue;
      $_SESSION["wed"]=$wed;
      $_SESSION["thu"]=$thu;
      $_SESSION["fri"]=$fri;
      $_SESSION["sat"]=$sat;
      $_SESSION["open_time"]=$open_time;
      $_SESSION["close_time"]=$close_time;
      $_SESSION["number"]=$number;
      $_SESSION['error_status'] = 7;
      redirect_to_vacancy_signup();
      exit();
    }
  }
}

// CSRF チェック
if ($token != $_SESSION['token']) {
  // リダイレクト
  $_SESSION["date"]=$date;
  $_SESSION["day"]=$day;
  $_SESSION["sun"]=$sun;
  $_SESSION["mon"]=$mon;
  $_SESSION["tue"]=$tue;
  $_SESSION["wed"]=$wed;
  $_SESSION["thu"]=$thu;
  $_SESSION["fri"]=$fri;
  $_SESSION["sat"]=$sat;
  $_SESSION["open_time"]=$open_time;
  $_SESSION["close_time"]=$close_time;
  $_SESSION["number"]=$number;
  $_SESSION['error_status'] = 8;
  redirect_to_login();
  exit();
}

$open_time = array_filter($open_time);
$close_time = array_filter($close_time);
$number = array_filter($number);


//複数日の場合
if ($days>=30) {
  $year   = date('Y');


  $datetime = new DateTime();
  $datetime->setTimezone( new DateTimeZone('Asia/Tokyo') );
  $datetime->setDate($year, 1, 1);

  // 間隔
  $interval =  new DateInterval('P1D');

  // 閏年をチェック
  $uru = $datetime->format('L') == '1' ? 366 : 365;

  $result = array();

  for($i=0;$i<$uru;$i++){
      if( in_array( (int)$datetime->format('w'), $target) ){
          $result[] = clone $datetime;
      }
      $datetime->add($interval);
  }

  foreach($result as $value){

      $list[]=$value->format("Y-m-d ");
  }
  $end = date("Y-m-d",strtotime('+' .$days."day",strtotime($date)));
  sort($list);

  $list=array_filter($list,function($x) use($date,$end){
    return $x>=$date and  $x<=$end;
  });
  $list = array_merge($list);

}
// 当日のみの場合
if ($days==0){
  $list[]=$date;
};




// pdo接続
$pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());


try {
  // トランザクション開始
  $pdo->beginTransaction();
  // SQL実行
  $sql_1 = "INSERT INTO booking_master
   (shop_id,open_day,day_of_week,open_time,close_time,open_flame) VALUES (:shop_id,:open_day,:day_of_week,:open_time,:close_time,:open_flame)";
   // プリペアステートメント
  $stmt_1 = $pdo->prepare($sql_1);



  // bookingテーブルにインサート
  $sql_2 = "INSERT INTO booking
   (shop_id,booking_master_id,open_day,day_of_week,open_time,close_time,booking_rest) VALUES (:shop_id,:booking_master_id,:open_day,:day_of_week,:open_time,:close_time,:booking_rest)";
  $stmt_2 = $pdo->prepare($sql_2);



  foreach ($list as $key => $tmp) {
    for ($j=0; $j < count($open_time); $j++) {
      $datetime = new DateTime($tmp);
    	$weekList = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
    	$w = (int)$datetime->format('w');

      // bindvalue開始
      $stmt_1->bindValue(':shop_id', $_SESSION['shop_id'], PDO::PARAM_STR);
      $stmt_1->bindValue(':open_day', $tmp, PDO::PARAM_STR);
      $stmt_1->bindValue(':day_of_week', $weekList[$w], PDO::PARAM_STR);
      $stmt_1->bindValue(':open_time', $open_time[$j], PDO::PARAM_STR);
      $stmt_1->bindValue(':close_time', $close_time[$j], PDO::PARAM_STR);
      $stmt_1->bindValue(':open_flame', $number[$j], PDO::PARAM_STR);
      // excute開始
      $stmt_1->execute([$_SESSION['shop_id'],$tmp, $weekList[$w], $open_time[$j], $close_time[$j], $number[$j]]);
      $booking_master_id = $pdo->lastInsertId();
      $stmt_2->bindValue(':shop_id', $_SESSION['shop_id'], PDO::PARAM_STR);
      $stmt_2->bindValue(':booking_master_id', $booking_master_id, PDO::PARAM_STR);
      $stmt_2->bindValue(':open_day', $tmp, PDO::PARAM_STR);
      $stmt_2->bindValue(':day_of_week', $weekList[$w], PDO::PARAM_STR);
      $stmt_2->bindValue(':open_time', $open_time[$j], PDO::PARAM_STR);
      $stmt_2->bindValue(':close_time', $close_time[$j], PDO::PARAM_STR);
      $stmt_2->bindValue(':booking_rest', $number[$j], PDO::PARAM_STR);

      $stmt_2->execute([$_SESSION['shop_id'], $booking_master_id, $tmp, $weekList[$w], $open_time[$j], $close_time[$j], $number[$j]]);
      // 値テスト
      // echo $tmp.",";
      // echo $weekList[$w].",";
      // echo $open_time[$j].",";
      // echo $close_time[$j].",";
      // echo $number[$j].",";
    }

  }

  $pdo->commit();
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: 39.booking_vacancy_signup_complete.php');
             }catch (PDOException $e) {
  $pdo->rollBack();
  exit($e);
}

 ?>
