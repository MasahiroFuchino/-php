<?php
session_start();
require_once('login_function.php');

require_once("user_header.php");


$year = date("Y");

function getHolidays($year) {//その年の祝日を全て取得する関数を作成

	$api_key = 'AIzaSyAyXH1klEML8b6jH8Spkdc82LQuT5US0lo'; //取得したAPIを入れる
	$holidays = array(); //祝日を入れる配列の箱を用意しておく
	$holidays_id = 'japanese__ja@holiday.calendar.google.com';
	$url = sprintf(
        //sprintf関数を使用しURLを設定
        //このURLはGoogleカレンダー独自のURL
        //Googleカレンダーから祝日を調べるURL
        'https://www.googleapis.com/calendar/v3/calendars/%s/events?'.
		'key=%s&timeMin=%s&timeMax=%s&maxResults=%d&orderBy=startTime&singleEvents=true',
		$holidays_id,
		$api_key,
		$year.'-01-01T00:00:00Z' , // 取得開始日
		$year.'-12-31T00:00:00Z' , // 取得終了日
		150 // 最大取得数
	);

	if ( $results = file_get_contents($url, true )) {
        //file_get_contents関数を使用
        //URLの中に情報が入っていれば（trueなら）以下を実行する
		$results = json_decode($results);
        //JSON形式で取得した情報を配列に格納
		foreach ($results->items as $item ) {
			$date = strtotime((string) $item->start->date);
			$title = (string) $item->summary;
			$holidays[date('Y-m-d', $date)] = $title;
            //年月日をキー、祝日名を配列に格納
		}
		ksort($holidays);
        //祝日の配列を並び替え
        //ksort関数で配列をキーで逆順に（１月からの順番にした）
	}
	return $holidays;
}


$Holidays_array = getHolidays($year);
//getHolidays関数を$Holidays_arrayに代入して使用しやすいようにしておく


//その日の祝日名を取得
function display_to_Holidays($date,$Holidays_array) {
    //※引数1は日付"Y-m-d"型、引数に2は祝日の配列データ
    //display_to_Holidays("Y-m-d","Y-m-d") →引数1の日付と引数2の日付が一致すればその日の祝日名を取得する

	if(array_key_exists($date,$Holidays_array)){
        //array_key_exists関数を使用
        //$dateが$Holidays_arrayに存在するか確認
        //各日付と祝日の配列データを照らし合わせる

		$holidays = "<br/>".$Holidays_array[$date];
        //祝日が見つかれば$holidaysに入れておく
		return $holidays;
	}
}



//
// $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
//
// $sql="SELECT open_day,open_flame FROM booking_master";
//
// $res = $pdo->query($sql);
//
// $data = $res->fetchAll();
//
// print_r($data);

// $open_flame = array_column($data, $data['open_flame'],$data['open_day']);
// var_dump($open_flame);
function getreservation($date){

$pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
$sql = "SELECT open_day,booking_rest FROM booking WHERE shop_id = ?;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $_SESSION['shop_id'], PDO::PARAM_STR);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($data);
$reservation_member = array();

foreach($data as $out){
		if ($out['open_day']==$date) {
			$count[]=$out['booking_rest'];
			$member_out = array_sum($count);
			// var_dump($member_out);
			$day_out = strtotime((string) $out['open_day']);
			//
	    // $member_out = $out['open_flame'];
			//
	    $reservation_member[date('Y-m-d', $day_out)] = $member_out;

		}
}
		// var_dump($member_out);

    ksort($reservation_member);

    return $reservation_member;

}


// $reservation_array = getreservation();

//getreservation関数を$reservation_arrayに代入しておく
function reservation($date,$reservation_array){
    //カレンダーの日付と予約された日付を照合する関数
		$pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
		$sql_2 = "SELECT open_day,open_flame FROM booking_master WHERE shop_id = ?;";
		$stmt_2 = $pdo->prepare($sql_2);
		$stmt_2->bindValue(1, $_SESSION['shop_id'], PDO::PARAM_STR);
		$stmt_2->execute();
		$data_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);
		// var_dump($data);
		$reservation_member_2 = array();

		foreach($data_2 as $out_2){
				if ($out_2['open_day']==$date) {
					$count_2[]=$out_2['open_flame'];
					$member_out_2 = array_sum($count_2);
					// var_dump($member_out);
					$day_out_2 = strtotime((string) $out_2['open_day']);
					//
			    // $member_out = $out['open_flame'];
					//
			    $reservation_member_2[date('Y-m-d', $day_out_2)] = $member_out_2;

				}
}

    if(array_key_exists($date,$reservation_array)){
        //もし"カレンダーの日付"と"予約された日"が一致すれば以下を実行する
				$today = strtotime(date('Y-m-d'));
				$target = strtotime($date);
				if ($target>=$today) {
					if($reservation_array[$date] == 0){
	            //予約枠人数が0人以下の場合は以下を実行する

	        $reservation_list = "<br/>"."<span class='green'>"."✕"."</span>";
	        return $reservation_list;

	    }

	        elseif($reservation_array[$date] < $reservation_member_2[$date]*0.5){
	            //予約人数が１０人より少なければ以下を実行する

	           $reservation_list = "<br/>"."<span class='green'>△</span>";
						 $reservation_list .= "<br/>"."<form method='POST' name='a_form' action='15.booking_detail.php'>";
						 $reservation_list .=	"<input type = 'hidden' name = 'open_day' value = '$date' class='green'>";
						 $reservation_list .=	"<br/>"."<input type = 'submit' name = 'submit' value = '予約' class='green'>"."</form>";

	        return $reservation_list;

	        }
	        elseif($reservation_array[$date] < $reservation_member_2[$date]*0.7){
	            //予約人数が１０人より少なければ以下を実行する

	           $reservation_list = "<br/>"."<span class='green'>〇</span>";
						 $reservation_list .= "<br/>"."<form method='POST' name='a_form' action='15.booking_detail.php'>";
						 $reservation_list .=	"<input type = 'hidden' name = 'open_day' value = '$date' class='green'>";
						 $reservation_list .=	"<br/>"."<input type = 'submit' name = 'submit' value = '予約' class='green'>"."</form>";


	        return $reservation_list;

	        }
	        elseif($reservation_array[$date] >= $reservation_member_2[$date]*0.7){
	            //予約人数が１０人より少なければ以下を実行する

	           $reservation_list = "<br/>"."<span class='green'>◎</span>";
	           $reservation_list .= "<br/>"."<form method='POST' name='a_form' action='15.booking_detail.php'>";
						 $reservation_list .=	"<input type = 'hidden' name = 'open_day' value = '$date' class='green'>";
						 $reservation_list .=	"<br/>"."<input type = 'submit' name = 'submit' value = '予約' class='green'>"."</form>";


	        return $reservation_list;

	        }
	    }
				}

}

  ?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<link rel="stylesheet" href="css/bootstrap.css">
<title>ユーザーページ予約管理画面</title>

<style>
.container {
 font-family: 'Noto Sans', sans-serif;
}
 h3 {
     margin-bottom: 30px;
 }
 th {
     height: 30px;
     text-align: center;
 }
 td {
     height: 100px;
 }
 .today {
     background: orange;
 }
 th:nth-of-type(1), td:nth-of-type(1) {
     color: red;
 }
 th:nth-of-type(7), td:nth-of-type(7) {
     color: blue;
 }
 .holiday{
     color: red;
 }
</style>

</head>
<body>
  <h3 class="text-center">当月予約状況</h3>
    <div class="mt-5 container d-flex justify-content-around">
      <div class=" d-flex justify-content-center">
        <div class="">

          <table class="table  table-bordered table-striped table-detail">
    <thead>
			<?php
	    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
	    //プレースホルダで SQL 作成
			try {
			if (isset($_POST['cancel'])) {

					$pdo->beginTransaction();
					$sql_3 = "SELECT * FROM booking_detail WHERE id = ?";
			    $stmt_3 = $pdo->prepare($sql_3);
			    $stmt_3->bindValue(1, $_POST['cancel_id'], PDO::PARAM_STR);
			    $stmt_3->execute();
					$row_3 = $stmt_3->fetchAll(PDO::FETCH_ASSOC);
					// var_dump($row_2);
					$sql_4 = "UPDATE booking SET booking_rest = booking_rest +1 WHERE	shop_id	=	?	AND open_day = ?	AND open_time = ?	AND close_time = ?";
					$stmt_4 = $pdo->prepare($sql_4);
					$stmt_4->bindValue(1,$row_3[0]['shop_id'], PDO::PARAM_STR);
					$stmt_4->bindValue(2,$row_3[0]['booking_day'], PDO::PARAM_STR);
					$stmt_4->bindValue(3,$row_3[0]['booking_open_time'], PDO::PARAM_STR);
					$stmt_4->bindValue(4,$row_3[0]['booking_close_time'], PDO::PARAM_STR);
					$stmt_4->execute(array($row_3[0]['shop_id'],$row_3[0]['booking_day'],$row_3[0]['booking_open_time'],$row_3[0]['booking_close_time']));
					$sql_5 = "DELETE FROM booking_detail WHERE id=?";
			    $stmt_5 = $pdo->prepare($sql_5);
			    $stmt_5->bindValue(1, $_POST['cancel_id'], PDO::PARAM_STR);
			    $stmt_5->execute();
					$pdo->commit();

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
	      $list_1 .= "<td	class='text-dark'>".$row_1[$i]['booking_day']."</td>".
	                  "<td>".$row_1[$i]['booking_open_time']."</td>".
	                  "<td>".$row_1[$i]['booking_close_time']."</td>".
	                  "<td>".$row_1[$i]['content'].
										"<td>"."<form action='' onsubmit='return confirm_test()' method='post'>"."<div class='text-center form-group row justify-content-center'>".
                    "<div class>"."<input  type='hidden'	name='cancel_id' value='$cancel_id'>".
										"<input class='mt-2 btn btn-outline-primary mx-3' type='submit'	name='cancel' value='キャンセル'>".
										"</div>"."</div>"."</form>"."</td>";
	      $lists_1[] = '<tr>' . $list_1 . '</tr>';

	      $list_1 = '';

	    }




	     ?>
      <h3>予約リスト</h3>
    <tr>
      <th	class="text-dark">日付</th>
      <th>開始時間</th>
      <th>終了時間</th>
      <th>内容</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
			<?php foreach ($lists_1 as $list_1){
				echo $list_1;
			}

				?>
    </tbody>
		</table>
        </div>
    </div>
    <?php
//タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');


//前月・次月リンクが選択された場合は、GETパラメーターから年月を取得
if(isset($_GET['ym'])){
    $ym = $_GET['ym'];
}else{
    //今月の年月を表示
    $ym = date('Y-m');
}

//タイムスタンプ（どの時刻を基準にするか）を作成し、フォーマットをチェックする
//strtotime('Y-m-01')
$timestamp = strtotime($ym . '-01');
if($timestamp === false){//エラー対策として形式チェックを追加
    //falseが返ってきた時は、現在の年月・タイムスタンプを取得
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

//今月の日付　フォーマット　例）2020-10-2
$today = date('Y-m-j');
//カレンダーのタイトルを作成　例）2020年10月
$html_title = date('Y年n月', $timestamp);//date(表示する内容,基準)

//前月・次月の年月を取得
//strtotime(,基準)
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));


//該当月の日数を取得
$day_count = date('t', $timestamp);

//１日が何曜日か
$youbi = date('w', $timestamp);

//カレンダー作成の準備
$weeks = [];
$week = '';

//第１週目：空のセルを追加
//str_repeat(文字列, 反復回数)
$week .= str_repeat('<td></td>', $youbi);

for($day = 1; $day <= $day_count; $day++, $youbi++){

    $date = $ym . '-' . $day;
    //それぞれの日付をY-m-d形式で表示例：2020-01-23
    //$dayはfor関数のおかげで１日づつ増えていく
    $Holidays_day = display_to_Holidays(date("Y-m-d",strtotime($date)),$Holidays_array);
    //display_to_Holidays($date,$Holidays_array)の$dateに1/1~12/31の日付を入れる

		$reservation_array = getreservation(date("Y-m-d",strtotime($date)));
		// var_dump($reservation_array);

    $reservation = reservation(date("Y-m-d",strtotime($date)),$reservation_array);

    if($today == $date){
        //もしその日が今日なら
        $week .= '<td class="bg-warning">' . $day . $reservation;//今日の場合はclassにtodayをつける
    }elseif(display_to_Holidays(date("Y-m-d",strtotime($date)),$Holidays_array)){
        //もしその日に祝日が存在していたら
        //その日が祝日の場合は祝日名を追加しclassにholidayを追加する
        $week .= '<td class="text-danger">' . $day. $reservation ;
    }elseif(reservation(date("Y-m-d",strtotime($date)),$reservation_array)){
        $week .= '<td>' . $day . $reservation;
    }else{
        //上２つ以外なら
        $week .= '<td>' . $day;
    }
    $week .= '</td>';

    if($youbi % 7 == 6 || $day == $day_count){//週終わり、月終わりの場合
        //%は余りを求める、||はまたは
        //土曜日を取得

        if($day == $day_count){//月の最終日、空セルを追加
            $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
        }

        $weeks[] = '<tr>' . $week . '</tr>'; //weeks配列にtrと$weekを追加

        $week = '';//weekをリセット
    }
}

?>
<!-- ここより下記右側部分 -->
    <div class="container col-5">
      <div class="text-center d-flex justify-content-around">
         <h3 class="mb-5 text-center"><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
      </div>
      <table class="text-center table table-bordered">
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
        <div class="text-center d-flex justify-content-around">
          <div class="">
            <p>◎:非常に空いている</p>
          </div>
          <div class="">
            <p>〇:空いている</p>
          </div>
          <div class="">
            <p>△:混んでいる</p>
          </div>
        </div>
        <p class="text-center">✕:非常に混んでいる、受付不可</p>
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
