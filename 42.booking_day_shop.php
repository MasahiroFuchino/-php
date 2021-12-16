<?php
session_start();
$SESSION['open_day']="";
if (isset($_POST['open_day'])) {
  $SESSION['open_day']=$_POST['open_day'];
}
$open_day=$SESSION['open_day'];
require_once('login_function.php');
require_once('shop_header.php');
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<link rel="stylesheet" href="css/bootstrap.css">
<title>ユーザー予約詳細画面</title>


</head>
<body>
  <h3 class="text-center">当日予約状況</h3>
<?php
//カレンダーのタイトルを作成　例）2020年10月
$day = strtotime((string) $open_day); //date(表示する内容,基準)
$ymd =  date('Y-m-d',$day) ;

//前月・次月リンクが選択された場合は、GETパラメーターから年月を取得
if(isset($_GET['ymd'])){
    $ymd = $_GET['ymd'];
}else{
    //今月の年月を表示
    $ymd =  date('Y-m-d',$day) ;
}
//タイムスタンプ（どの時刻を基準にするか）を作成し、フォーマットをチェックする
//strtotime('Y-m-01')
$timestamp = strtotime($ymd);
if($timestamp === false){//エラー対策として形式チェックを追加
    //falseが返ってきた時は、現在の年月・タイムスタンプを取得
    $timestamp = strtotime($ymd);
}
$html_title = date('Y年m月d日', $timestamp);
$date = date('Y-m-d', $timestamp);

//前月・次月の年月を取得
//strtotime(,基準)


$prev = date('Y-m-d', strtotime('-1 day', $timestamp));
$next = date('Y-m-d', strtotime('+1 day', $timestamp));

// function get_open_flame(){
$pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
//プレースホルダで SQL 作成
$sql_1 = "SELECT * FROM booking_detail WHERE booking_day = ?;";
$stmt_1 = $pdo->prepare($sql_1);
$stmt_1->bindValue(1, $date, PDO::PARAM_STR);
$stmt_1->execute();
$row_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);

$sql_2 = "SELECT * FROM booking_master WHERE open_day = ?;";
$stmt_2 = $pdo->prepare($sql_2);
$stmt_2->bindValue(1, $date, PDO::PARAM_STR);
$stmt_2->execute();
$row_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);

$sql_3 = "SELECT MAX(open_flame) FROM booking_master  WHERE open_day = ?;";
$stmt_3 = $pdo->prepare($sql_3);
$stmt_3->bindValue(1, $date, PDO::PARAM_STR);
$stmt_3->execute();
$row_3 = $stmt_3->fetchAll(PDO::FETCH_ASSOC);

$sql_5 = "SELECT * FROM booking  WHERE open_day = ?;";
$stmt_5 = $pdo->prepare($sql_5);
$stmt_5->bindValue(1, $date, PDO::PARAM_STR);
$stmt_5->execute();
$row_5 = $stmt_5->fetchAll(PDO::FETCH_ASSOC);


// var_dump($row_5);
// }
$lists = [];
$list = '';

// var_dump($row);
for ($i=0; $i < count($row_5); $i++) {
  $timestamp = strtotime($ymd);
  $open_day=date('Y-m-d', $timestamp);
  if (isset($row_1[$i])) {
    $open_time_1=$row_1[$i]['booking_open_time'];
    $close_time_1=$row_1[$i]['booking_close_time'];
    $user_id=$row_1[$i]['user_id'];
    $content=$row_1[$i]['content'];
    $open_time_2=$row_2[$i]['open_time'];
    $close_time_2=$row_2[$i]['close_time'];
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //プレースホルダで SQL 作成
    $sql_4 = "SELECT * FROM users WHERE id = ?;";
    $stmt_4 = $pdo->prepare($sql_4);
    $stmt_4->bindValue(1, $user_id, PDO::PARAM_STR);
    $stmt_4->execute();
    $row_4 = $stmt_4->fetchAll(PDO::FETCH_ASSOC);

    $list .= '<td>'. $open_time_1."<br/>".'～'."<br/>". $close_time_1.'</td>';
    $list .= '<td>'."予約者:".$row_4[0]['name']."<br/>"."内容:"."<br/>".$content.'</td>';
    $list .= str_repeat('<td>-</td>', $row_2[0]["open_flame"] - $row_5[0]['booking_rest'] );

  }



  elseif(!isset($row_1[$i])){
    $open_time_2=$row_2[$i]['open_time'];
    $close_time_2=$row_2[$i]['close_time'];
    $list .= '<td>'. $open_time_2."<br/>".'～'."<br/>". $close_time_2.'</td>';
    $list .= str_repeat('<td>-</td>', $row_3[0]["MAX(open_flame)"] - $row_5[0]['booking_rest'] );
  }


  $lists[] = '<tr>' . $list . '</tr>';

  $list = '';
}

?>
<div class="container ">
  <div class="text-center d-flex justify-content-around">
    <h3 class="mb-5 text-center"><a href="?ymd=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ymd=<?php echo $next; ?>">&gt;</a></h3>
  </div>


  <table class="text-center table table-bordered table-striped">
    <tr>
        <th>予約時間</th>
        <?php


        for ($i=1; $i <=$row_3[0]["MAX(open_flame)"] ; $i++) {
            echo "<th>".$i."</th>";
        }
        ?>
    </tr>
    <?php
        foreach ($lists as $list) {
            echo $list;
        }
    ?>
  </table>

  <p class="text-center">✕:予約済み、受付不可</p>
</div>
 </div>


</div>
</body>
</html>
