<?php
session_start();

if (isset($_POST['open_day'])) {
  $_SESSION['open_day']=$_POST['open_day'];
}
if (isset($_POST['open_time'])) {
  $_SESSION['open_time']=$_POST['open_time'];
}
if (isset($_POST['close_time'])) {
  $_SESSION['close_time']=$_POST['close_time'];
}
require_once("user_header.php");
 ?>
<html>
    <head>
    	<link href="css/bootstrap.css" rel="stylesheet">
        <title>ユーザー新規予約登録画面</title>
    </head>
    <body>
      <?php
      if (!empty($_SESSION['error_status']) == 1) {
        echo '<h2 class="text-center" style="color:red">予約内容を入力してください。</h2>';
      }
      $_SESSION['error_status'] = 0;
       ?>
      <div class="text-center mt-5 d-flex justify-content-center">
        <div class="">
          <form action="16'.booking_register_check.php" onsubmit="return confirm_test()" method="post">
            <table class="text-center mt-5 mb-5">
              <tr>
                <td class="text-start">店舗</td>
                <td><?php echo htmlspecialchars($_SESSION['shop_name'], ENT_QUOTES, 'UTF-8') ?></td>
              </tr>
              <tr>
                <td class="text-start">予約日</td>
                <td><?php echo htmlspecialchars($_SESSION['open_day'], ENT_QUOTES, 'UTF-8') ?></td>
              </tr>
             <tr>
                <td class="text-start">予約時間</td>
                <td><?php echo htmlspecialchars($_SESSION['open_time']."～".$_SESSION['close_time'], ENT_QUOTES, 'UTF-8') ?></td>
              </tr>
             <tr>
                <td class="text-start">内容</td>
                <td><textarea class="form-control mt-2 mb-5" name="content" rows="8" cols="50"><?php if (isset($_SESSION['content']))echo htmlspecialchars($_SESSION['content'])?></textarea> </td>
              </tr>

            </table>
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['id']  , ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="shop_id" value="<?php echo htmlspecialchars($_SESSION['shop_id']  , ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="open_day" value="<?php echo htmlspecialchars($_SESSION['open_day']  , ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="open_time" value="<?php echo htmlspecialchars($_SESSION['open_time']  , ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="close_time" value="<?php echo htmlspecialchars($_SESSION['close_time']  , ENT_QUOTES, 'UTF-8') ?>">
            <div class="text-center form-group row justify-content-center">
            <div class="">
                <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" name='back' type="button" value="戻る" onclick="history.back()">
                <input class="btn btn-outline-primary mx-3 my-1" type="submit" name='submit' value="登録する"/>
            </div>
            </div>
          </form>
        </div>


      </div>
      <script>
function confirm_test() {
    var select = confirm("下記の内容で予約しますか？「OK」で送信,「キャンセル」で送信中止");
    return select;
}
</script>
      </body>

</html>
