<?php
session_start();
if (!isset($_SESSION['id'])){
    $_SESSION['error_status'] = 2;
    redirect_to_login();
    exit();
  }

$SESSION['open_day']="";
if (isset($_POST['open_day'])) {
  $SESSION['open_day']=$_POST['open_day'];
}
$open_day=$SESSION['open_day'];
require_once('login_function.php');
require_once("user_header.php");
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
    try {
      $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
      //プレースホルダで SQL 作成
      try {
			if (isset($_POST['cancel'])) {

					$pdo->beginTransaction();
					$sql_5 = "SELECT * FROM booking_detail WHERE id = ?";
			    $stmt_5 = $pdo->prepare($sql_5);
			    $stmt_5->bindValue(1, $_POST['cancel_id'], PDO::PARAM_STR);
			    $stmt_5->execute();
					$row_5 = $stmt_5->fetchAll(PDO::FETCH_ASSOC);
					// var_dump($row_2);
					$sql_6 = "UPDATE booking SET booking_rest = booking_rest +1 WHERE	shop_id	=	?	AND open_day = ?	AND open_time = ?	AND close_time = ?";
					$stmt_6 = $pdo->prepare($sql_6);
					$stmt_6->bindValue(1,$row_5[0]['shop_id'], PDO::PARAM_STR);
					$stmt_6->bindValue(2,$row_5[0]['booking_day'], PDO::PARAM_STR);
					$stmt_6->bindValue(3,$row_5[0]['booking_open_time'], PDO::PARAM_STR);
					$stmt_6->bindValue(4,$row_5[0]['booking_close_time'], PDO::PARAM_STR);
					$stmt_6->execute(array($row_5[0]['shop_id'],$row_5[0]['booking_day'],$row_5[0]['booking_open_time'],$row_5[0]['booking_close_time']));
					$sql_7 = "DELETE FROM booking_detail WHERE id=?";
			    $stmt_7 = $pdo->prepare($sql_7);
			    $stmt_7->bindValue(1, $_POST['cancel_id'], PDO::PARAM_STR);
			    $stmt_7->execute();

					$pdo->commit();
          header('HTTP/1.1 301 Moved Permanently');
          header('Location: 14.booking.php');
				}
			} catch (\Exception $e) {
					$pdo->rollBack();
					exit($e);
				}
      $sql_1 = "SELECT * FROM booking_detail WHERE user_id = ? AND shop_id = ?;";
      $stmt_1 = $pdo->prepare($sql_1);
      $stmt_1->bindValue(1, $_SESSION['id'], PDO::PARAM_STR);
      $stmt_1->bindValue(2, $_SESSION['shop_id'], PDO::PARAM_STR);
      $stmt_1->execute();
      $row_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
      $lists_1 = [];
      $list_1 = "";
      for ($i=0; $i <count($row_1) ; $i++) {
        $cancel_id=$row_1[$i]['id'];
        $list_1 .= "<td>".$row_1[$i]['booking_day']."</td>".
                    "<td>".$row_1[$i]['booking_open_time']."</td>".
                    "<td>".$row_1[$i]['booking_close_time']."</td>".
                    "<td>".$row_1[$i]['content']."</td>".
                    "<td>"."<form action='' onsubmit='return confirm_test()' method='post'>"."<div class='text-center form-group row justify-content-center'>".
                    "<div class>"."<input  type='hidden'	name='cancel_id' value='$cancel_id'>".
										"<input class='mt-2 btn btn-outline-primary mx-3' type='submit'	name='cancel' value='キャンセル'>".
										"</div>"."</div>"."</form>"."</td>";
        $lists_1[] = '<tr>' . $list_1 . '</tr>';

        $list_1 = '';

      }

    } catch (\Exception $e) {

    }






     ?>
      <div class="mt-5 container d-flex justify-content-around">
        <div class=" d-flex justify-content-center">
          <div class="">

            <table class="table  table-bordered table-striped table-detail">
      <thead>
        <h5>予約リスト</h5>
      <tr>
        <th>日付</th>
        <th>開始時間</th>
        <th>終了時間</th>
        <th>内容</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
        <?php foreach ($lists_1 as $list_1) {
          echo $list_1;
        }
        ?>
          </tbody>
      </table>
          </div>
      </div>
      <!--ここより下記右側部分 -->
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
  $sql_2 = "SELECT * FROM booking WHERE open_day = ?;";
  $stmt_2 = $pdo->prepare($sql_2);
  $stmt_2->bindValue(1, $date, PDO::PARAM_STR);
  $stmt_2->execute();
  $row_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);

  $sql_3 = "SELECT * FROM booking_master WHERE open_day = ?;";
  $stmt_3 = $pdo->prepare($sql_3);
  $stmt_3->bindValue(1, $date, PDO::PARAM_STR);
  $stmt_3->execute();
  $row_3 = $stmt_3->fetchAll(PDO::FETCH_ASSOC);
  // var_dump($row);
  // }
  $sql_4 = "SELECT MAX(open_flame) FROM booking_master  WHERE open_day = ?;";
  $stmt_4 = $pdo->prepare($sql_4);
  $stmt_4->bindValue(1, $date, PDO::PARAM_STR);
  $stmt_4->execute();
  $row_4 = $stmt_4->fetchAll(PDO::FETCH_ASSOC);

  $lists = [];
  $list = '';

  // var_dump($row);
  for ($i=0; $i < count($row_2); $i++) {
    $timestamp = strtotime($ymd);
    $open_day=date('Y-m-d', $timestamp);
    $open_time_2=$row_2[$i]['open_time'];
    $close_time_2=$row_2[$i]['close_time'];
    $open_time_3=$row_3[$i]['open_time'];
    $close_time_3=$row_3[$i]['close_time'];
    $list .= '<td>'. $open_time_3."<br/>".'～'."<br/>". $close_time_3.'</td>';
    $list .= str_repeat('<td>'."〇".
              "<br/>"."<form method='POST' name='a_form' action='16.booking_register.php'>".
              "<input type = 'hidden' name = 'open_day' value = '$open_day' class='green'>".
              "<input type = 'hidden' name = 'open_time' value = '$open_time_2' class='green'>".
              "<input type = 'hidden' name = 'close_time' value = '$close_time_2' class='green'>".
              "<br/>"."<input type = 'submit' name = 'submit' value = '予約する' class='green'>"."</form>".'</td>', $row_2[$i]['booking_rest'] );



    $list .= str_repeat('<td>✕</td>', $row_3[$i]['open_flame'] - $row_2[$i]['booking_rest'] );

    $lists[] = '<tr>' . $list . '</tr>';

    $list = '';
  }

  ?>
      <div class="container col-5">
        <div class="text-center d-flex justify-content-around">
          <h5 class="mb-5 text-center">
            <?php
            $today = strtotime(date('Y-m-d'));
            if ($timestamp>$today):
             ?>
            <a class="text-decoration-none" href="?ymd=<?php echo $prev; ?>">&lt;</a>
          <?php endif; ?>
             <?php echo $html_title; ?>
             <a class="text-decoration-none"s href="?ymd=<?php echo $next; ?>">&gt;</a></h3>
        </div>


        <table class="text-center table table-bordered">
          <tr>
            <?php
            if (empty($row_3)) {
                echo "<h3 class='text-danger text-center'>"."店舗休業日"."</h3>";
            }
            if (!empty($row_3)) {
                echo "<th>"."予約時間"."</th>";
            }
            for ($i=1; $i <=$row_4[0]["MAX(open_flame)"] ; $i++) {

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
        <?php
        if (empty($row_3)) {
            echo "";
        }
        if (!empty($row_3)) {
            echo "<p class='text-center'>"."✕:予約済み、受付不可"."</p>";
        }
         ?>

    </div>
       </div>
       <script>
     function confirm_test() {
     var select = confirm("左記の予約をキャンセルしますか？「OK」でキャンセル,「キャンセル」で中止");
     return select;
     }
     </script>
  </body>
</html>
