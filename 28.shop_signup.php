
<?php
  session_start();
  require_once('login_function.php');
  header('Content-type: text/html; charset=utf-8');
  $_SESSION['token'] = get_csrf_token(); // CSRFのトークンを取得する
  $_SESSION["sun"]="";
  $_SESSION["mon"]="";
  $_SESSION["tue"]="";
  $_SESSION["wed"]="";
  $_SESSION["thu"]="";
  $_SESSION["fri"]="";
  $_SESSION["sat"]="";

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="passwordchecker.js" type="text/javascript"></script>
    <script src="common.js" type="text/javascript"></script>
    <script type="text/javascript">
      /*
      * 登録前チェック
      */
      function conrimMessage() {
        var name = document.getElementById("name").value;
        var adress = document.getElementById("adress").value;
        var tel = document.getElementById("tel").value;
        var email = document.getElementById("email").value;
        var pass = document.getElementById("password").value;
        var conf = document.getElementById("password2").value;
        var open = document.getElementById("open_time").value;
        var close = document.getElementById("close_time").value;
       //必須チェック
       if((name == "") || (adress == "") || (tel == "") || (email == "") || (pass == "") || (conf == "") || (open == "") || (close == "")) {
          alert("必須項目が入力されていません。");
          return false;
       }
        //パスワードチェック
        if (pass != conf) {
            alert("パスワードが一致していません。");
            return false;
        }
        if (passwordLevel < 3) {
          return confirm("パスワード強度が弱いですがよいですか？");
        }
        return true;
      }
    </script>
  </head>
  <body>
    <h1 class="text-center" >新規登録画面</h1>
    <?php
      if ($_SESSION['error_status'] == 1) {
        echo '<h2 style="color:red;">必須項目が入力されてません。</h2>';
      }
      if ($_SESSION['error_status'] == 2) {
        echo '<h2 style="color:red;">パスワードが不一致です。</h2>';
      }
      if ($_SESSION['error_status'] == 3) {
        echo '<h2 style="color:red;">emailは既に登録されています。</h2>';
      }
      if ($_SESSION['error_status'] == 4) {
        echo '<h2 style="color:red;">不正なリクエストです。</h2>';
      }
      if ($_SESSION['error_status'] == 5) {
        echo '<h2 style="color:red;">登録処理に失敗しました。</h2>';
      }
      if ($_SESSION['error_status'] == 6) {
        echo '<h2 style="color:red;">タイムアウトか不正な URL です。</h2>';
      }
      //エラー情報リセット
      $_SESSION['error_status'] = 0;
    ?>
    <form class="w-25 mx-auto" id="loginForm" name="signup" action="28'.shop_signup_check.php" method="POST">

            <label class="mt-5" for="name">店舗名</label>
            <input class="form-control" type="text" id="name" name="shop_name" placeholder="名前を入力" value="<?php if (!empty($_SESSION["shop_name"])) {echo htmlspecialchars($_SESSION["shop_name"], ENT_QUOTES);} ?>">

            <label for="kana">店舗住所</label>
            <input class="form-control" type="text" id="adress" name="adress" placeholder="住所を入力" value="<?php if (!empty($_SESSION["adress"])) {echo htmlspecialchars($_SESSION["adress"], ENT_QUOTES);} ?>">

            <label for="tel">店舗電話番号</label>
            <input class="form-control" type="text" id="tel" name="tel" placeholder="電話番号を入力" value="<?php if (!empty($_SESSION["tel"])) {echo htmlspecialchars($_SESSION["tel"], ENT_QUOTES);} ?>">

            <label for="email">店舗メールアドレス</label>
            <input class="form-control" type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_SESSION["email"])) {echo htmlspecialchars($_SESSION["email"], ENT_QUOTES);} ?>">

            <label for="password">店舗パスワード</label>
            <input class="form-control" type="password" id="password" name="password" placeholder="パスワードを入力" value="<?php if (!empty($_SESSION["password"])) {echo htmlspecialchars($_SESSION["password"], ENT_QUOTES);} ?>">
            <input class="form-control" type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">

            <label for="open_time">店舗開店時間</label>
            <input class="form-control" type="time" id="open_time" name="open_time" placeholder="開店時間を入力" value="<?php if (!empty($_SESSION["open_time"])) {echo htmlspecialchars($_SESSION["open_time"], ENT_QUOTES);} ?>">

            <label for="open_time">店舗閉店時間</label>
            <input class="form-control" type="time" id="close_time" name="close_time" placeholder="開店時間を入力" value="<?php if (!empty($_SESSION["close_time"])) {echo htmlspecialchars($_SESSION["close_time"], ENT_QUOTES);} ?>">

            <tr>
              <td><p class="mt-3">定休日</p></td>
              <td>
                <input class="" type="hidden" name="sun" value="">
                <input class="" type="checkbox" name="sun" <?= $_SESSION["sun"] ? 'checked' : '' ?> value="日曜日">日</td>
              <td>
                <input class="" type="hidden" name="mon" value="">
                <input class="" type="checkbox" name="mon" <?= $_SESSION["mon"] ? 'checked' : '' ?> value="月曜日">月</td>
              <td>
                <input class="" type="hidden" name="tue" value="">
                <input class="" type="checkbox" name="tue" <?= $_SESSION["tue"] ? 'checked' : '' ?> value="火曜日">火</td>
              <td>
                <input class="" type="hidden" name="wed" value="">
                <input class="" type="checkbox" name="wed" <?= $_SESSION["wed"] ? 'checked' : '' ?> value="水曜日">水</td>
              <td>
                <input class="" type="hidden" name="thu" value="">
                <input class="" type="checkbox" name="thu" <?= $_SESSION["thu"] ? 'checked' : '' ?> value="木曜日">木</td>
              <td>
                <input class="" type="hidden" name="fri" value="">
                <input class="" type="checkbox" name="fri" <?= $_SESSION["fri"] ? 'checked' : '' ?> value="金曜日">金</td>
              <td>
                <input class="" type="hidden" name="sat" value="">
                <input class="" type="checkbox" name="sat" <?= $_SESSION["sat"] ? 'checked' : '' ?> value="土曜日">土</td>
              <td>
                <input class="" type="hidden" name="non" value="">
                <input class="" type="checkbox" name="non" value="不定休">なし</td>
            </tr>
            <div class="text-center form-group row justify-content-center">
            <div class>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8") ?>">
                <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" name='back' type="submit" value="戻る"/>
                <input class="btn btn-outline-primary mx-3 my-1" type="submit" name='submit' value="登録する"/>
            </div>
          </div>

    </form>


  </body>
</html>
