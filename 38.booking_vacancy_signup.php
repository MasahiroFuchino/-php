<?php
session_start();
require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
require_once('shop_header.php');
if (!isset($_SESSION['shop_id'])){
    $_SESSION['error_status'] = 2;
    redirect_to_login_admin();
    exit();
  }
  $_SESSION['token'] = get_csrf_token(); // CSRFのトークンを取得する
if (isset($_POST["booking_vacancy_signup"])) {
  header("Location: 38.booking_vacancy_signup.php");  // 管理者予約登録画面へ遷移
  exit();
}
$_SESSION["sun"]="";
$_SESSION["mon"]="";
$_SESSION["tue"]="";
$_SESSION["wed"]="";
$_SESSION["thu"]="";
$_SESSION["fri"]="";
$_SESSION["sat"]="";

$days = '';

// セレクトボックスの値を格納する配列
$dayslist = array(
  "選択してください",
  "当日のみ",
  "30日後まで",
  "60日後まで",
  "90日後まで",
);

// 戻ってきた場合
if(isset($_SESSION['day'])){
  $day = $_SESSION['day'];
}?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="css/bootstrap.css" rel="stylesheet">
    <title></title>
  </head>
  <body>
    <h3 class="text-center">予約枠登録画面</h3>
    <?php
         if ($_SESSION['error_status'] == 1) {
           echo '<h5 class="text-center" style="color:red">営業日、予約作成期間のいずれかに入力がありません。</h5>';
         }
          if ($_SESSION['error_status'] == 2) {
           echo '<h5 class="text-center" style="color:red">予約時間の開始が未入力です。</h5>';
         }
          if ($_SESSION['error_status'] == 3) {
           echo '<h5 class="text-center" style="color:red">予約時間の終了が未入力です。</h5>';
         }
          if ($_SESSION['error_status'] == 4) {
           echo '<h5 class="text-center" style="color:red">時間枠数が未入力です。</h5>';
         }
          if ($_SESSION['error_status'] == 5) {
           echo '<h5 class="text-center" style="color:red">予約時間の終了、時間枠数いずれかが未入力です。</h5>';
         }
          if ($_SESSION['error_status'] == 6) {
           echo '<h5 class="text-center" style="color:red">予約時間の開始、時間枠数いずれかが未入力です。</h5>';
         }
          if ($_SESSION['error_status'] == 7) {
           echo '<h5 class="text-center" style="color:red">予約時間の開始、予約時間の終了いずれかが未入力です。</h5>';
         }
          if ($_SESSION['error_status'] == 8) {
           echo '<h5 class="text-center" style="color:red">不正なリクエストです。</h5>';
         }
          if ($_SESSION['error_status'] == 9) {
           echo '<h5 class="text-center" style="color:red">繰り返しがない場合は、予約作成期間「当日のみ」を選択ください。</h5>';
         }
          if ($_SESSION['error_status'] == 10) {
           echo '<h5 class="text-center" style="color:red">繰り返しがある場合は、予約作成期間「30日後まで」「60日後まで」「90日後まで」のいずれかを選択ください。</h5>';
         }
          if ($_SESSION['error_status'] == 11) {
           echo '<h5 class="text-center" style="color:red">予約時間の開始、予約時間の終了いずれかが重複しています。</h5>';
         }
         //エラー情報のリセット
         $_SESSION['error_status'] = 0;
       ?>
    <div class="container">
      <div class="text-center d-flex justify-content-center">
        <div class="">
          <form class="" action="38'.booking_vacancy_signup_check.php" method="post">
            <table>
              <tbody>
                <tr>
                  <td><p class="mx-5 mt-3">営業日</p></td>
                  <td><input class="ml-5" type="date" name="date" value="<?php if (!empty($_SESSION["date"])) echo date($_SESSION["date"]) ?>"></td>
                </tr>
                <tr>
                  <table>
                    <tbody>
                      <tr>
                        <td><p class="mx-5 mt-3">繰り返し</p></td>
                        <td>
                          <input class="" type="hidden" name="sun" value="">
                          <input class="" type="checkbox" name="sun" <?= $_SESSION["sun"] ? 'checked' : '' ?> value="sunday">日</td>
                        <td>
                          <input class="" type="hidden" name="mon" value="">
                          <input class="" type="checkbox" name="mon" <?= $_SESSION["mon"] ? 'checked' : '' ?> value="monday">月</td>
                        <td>
                          <input class="" type="hidden" name="tue" value="">
                          <input class="" type="checkbox" name="tue" <?= $_SESSION["tue"] ? 'checked' : '' ?> value="tuesday">火</td>
                        <td>
                          <input class="" type="hidden" name="wed" value="">
                          <input class="" type="checkbox" name="wed" <?= $_SESSION["wed"] ? 'checked' : '' ?> value="wednesday">水</td>
                        <td>
                          <input class="" type="hidden" name="thu" value="">
                          <input class="" type="checkbox" name="thu" <?= $_SESSION["thu"] ? 'checked' : '' ?> value="thursday">木</td>
                        <td>
                          <input class="" type="hidden" name="fri" value="">
                          <input class="" type="checkbox" name="fri" <?= $_SESSION["fri"] ? 'checked' : '' ?> value="friday">金</td>
                        <td>
                          <input class="" type="hidden" name="sat" value="">
                          <input class="" type="checkbox" name="sat" <?= $_SESSION["sat"] ? 'checked' : '' ?> value="saturday">土</td>
                        <td>
                          <input class="" type="hidden" name="non" value="">
                          <input class="" type="checkbox" name="non" value="non">なし</td>
                      </tr>
                    </tbody>
                  </table>
                </tr>
                <tr>
                  <table>
                    <tbody>
                      <tr>
                        <td><p class="ml-5 mt-3">予約枠作成期間</p></td>
                        <td><p class="px-3 mt-3">営業開始日</p></td>
                        <td><p class="mx-3 mt-3">から</p></td>
                        <td>
                          <select class="" value="" name="day">
                            <?php
                                   foreach($dayslist as $value){
                                     if($value === $day){
                                       // ① POST データが存在する場合はこちらの分岐に入る
                                       echo "<option value='$value' selected>".$value."</option>";
                                     }else{
                                       // ② POST データが存在しない場合はこちらの分岐に入る
                                       echo "<option value='$value'>".$value."</option>";
                                     }
                                   }
                                 ?>
                          </select> </td>
                        <td><p class="ml-3 mt-3">予約枠を作成する</p></td>
                      </tr>
                    </tbody>
                  </table>
                </tr>


              </tbody>
            </table>


        </div>
      </div>
      <div class="mt-3 d-flex justify-content-around">
        <div class="">
            <table>
              <th width="100"><p>予約時間</p></th>
              <th width="50"></th>
              <th width="100"></th>
              <th width="50"><p>時間枠数</p></th>

              <tbody>
                <tr>
                  <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][0])) echo $_SESSION["open_time"][0] ?>"></td>
                  <td><p class="text-center mt-3">～</p></td>
                  <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][0])) echo $_SESSION["close_time"][0] ?>"></td>
                  <td><input type="number" step="1" name="number[]" value="<?php if (!empty($_SESSION["number"][0])) echo $_SESSION["number"][0] ?>"> </td>
                </tr>
                <tr>
                  <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][1])) echo $_SESSION["open_time"][1] ?>"></td>
                  <td><p class="text-center mt-3">～</p></td>
                  <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][1])) echo $_SESSION["close_time"][1] ?>"></td>
                  <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][1])) echo $_SESSION["number"][1] ?>"> </td>
                </tr>
                <tr>
                  <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][2])) echo $_SESSION["open_time"][2] ?>"></td>
                  <td><p class="text-center mt-3">～</p></td>
                  <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][2])) echo $_SESSION["close_time"][2] ?>"></td>
                  <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][2])) echo $_SESSION["number"][2] ?>"> </td>
                </tr>
                <tr>
                  <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][3])) echo $_SESSION["open_time"][3] ?>"></td>
                  <td><p class="text-center mt-3">～</p></td>
                  <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][3])) echo $_SESSION["close_time"][3] ?>"></td>
                  <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][3])) echo $_SESSION["number"][3] ?>"> </td>
                </tr>
                <tr>
                  <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][4])) echo $_SESSION["open_time"][4] ?>"></td>
                  <td><p class="text-center mt-3">～</p></td>
                  <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][4])) echo $_SESSION["close_time"][4] ?>"></td>
                  <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][4])) echo $_SESSION["number"][4] ?>"> </td>
                </tr>
                <tr>
                  <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][5])) echo $_SESSION["open_time"][5] ?>"></td>
                  <td><p class="text-center mt-3">～</p></td>
                  <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][5])) echo $_SESSION["close_time"][5] ?>"></td>
                  <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][5])) echo $_SESSION["number"][5] ?>"> </td>
                </tr>
                <tr>
                  <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][6])) echo $_SESSION["open_time"][6] ?>"></td>
                  <td><p class="text-center mt-3">～</p></td>
                  <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][6])) echo $_SESSION["close_time"][6] ?>"></td>
                  <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][6])) echo $_SESSION["number"][6] ?>"> </td>
                </tr>
              </tbody>
            </table>
        </div>
        <div class="">
          <table>
            <th width="100"><p>予約時間</p></th>
            <th width="50"></th>
            <th width="100"></th>
            <th width="50"><p>時間枠数</p></th>

            <tbody>
              <tr>
                <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][7])) echo $_SESSION["open_time"][7] ?>"></td>
                <td><p class="text-center mt-3">～</p></td>
                <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][7])) echo $_SESSION["close_time"][7] ?>"></td>
                <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][7])) echo $_SESSION["number"][7] ?>"> </td>
              </tr>
              <tr>
                <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][8])) echo $_SESSION["open_time"][8] ?>"></td>
                <td><p class="text-center mt-3">～</p></td>
                <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][8])) echo $_SESSION["close_time"][8] ?>"></td>
                <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][8])) echo $_SESSION["number"][8] ?>"> </td>
              </tr>
              <tr>
                <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][9])) echo $_SESSION["open_time"][9] ?>"></td>
                <td><p class="text-center mt-3">～</p></td>
                <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][9])) echo $_SESSION["close_time"][9] ?>"></td>
                <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][9])) echo $_SESSION["number"][9] ?>"> </td>
              </tr>
              <tr>
                <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][10])) echo $_SESSION["open_time"][10] ?>"></td>
                <td><p class="text-center mt-3">～</p></td>
                <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][10])) echo $_SESSION["close_time"][10] ?>"></td>
                <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][10])) echo $_SESSION["number"][10] ?>"> </td>
              </tr>
              <tr>
                <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][11])) echo $_SESSION["open_time"][11] ?>"></td>
                <td><p class="text-center mt-3">～</p></td>
                <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][11])) echo $_SESSION["close_time"][11] ?>"></td>
                <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][11])) echo $_SESSION["number"][11] ?>"> </td>
              </tr>
              <tr>
                <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][12])) echo $_SESSION["open_time"][12] ?>"></td>
                <td><p class="text-center mt-3">～</p></td>
                <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][12])) echo $_SESSION["close_time"][12] ?>"></td>
                <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][12])) echo $_SESSION["number"][12] ?>"> </td>
              </tr>
              <tr>
                <td><input type="time" step="3600" name="open_time[]" value="<?php if (!empty($_SESSION["open_time"][13])) echo $_SESSION["open_time"][13] ?>"></td>
                <td><p class="text-center mt-3">～</p></td>
                <td><input width="100" type="time" step="3600" name="close_time[]" value="<?php if (!empty($_SESSION["close_time"][13])) echo $_SESSION["close_time"][13] ?>"></td>
                <td><input type="number" name="number[]" value="<?php if (!empty($_SESSION["number"][13])) echo $_SESSION["number"][13] ?>"> </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="text-center mt-3 form-group row justify-content-center">
      <div class>
          <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8") ?>">
          <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" type="submit" value="戻る"/>
          <input class="btn btn-outline-primary mx-3 my-1" type="submit" value="まとめて登録する"/>
      </div>
    </div>
    </div>
    </form>
  </body>
</html>
