<?php
session_start();
require_once('login_function.php');
$_SESSION['shop_id']="";
$_SESSION['shop_name']="";
if (!isset($_SESSION['id'])){
    $_SESSION['error_status'] = 2;
    redirect_to_login_admin();
    exit();
  }
  // $_SESSION['token'] = get_csrf_token(); // CSRFのトークンを取得する

if (isset($_POST['main'])) {
  $_SESSION['shop_id']=$_POST['shop_id'];
  $_SESSION['shop_name']=$_POST['shop_name'];
  header("Location: 13.main.php");
}
if (isset($_POST['booking'])) {
  $_SESSION['shop_id']=$_POST['shop_id'];
  $_SESSION['shop_name']=$_POST['shop_name'];
  header("Location: 14.booking.php");
}
if (isset($_POST['contact'])) {
  $_SESSION['shop_id']=$_POST['shop_id'];
  $_SESSION['shop_name']=$_POST['shop_name'];
  header("Location: contact.php");
}
if (isset($_POST['logout'])) {
  header("Location: logout.php");
}


$pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());

$ps = $pdo->query("SELECT * FROM shop");
$data = $ps->fetchAll(PDO::FETCH_ASSOC);


$box = [];
$list = '';
if (!isset($_POST['submit'])) {
  for ($i=0; $i < count($data) ; $i++) {
    //

      $shop_name = $data[$i]['shop_name'];
      $shop_id = $data[$i]['id'];
      $token = htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8");
      $list = "<div class='text-center'>"."<input style='padding: 10% 30%;' class='btn mb-3' type='submit' name='main' value='$shop_name'>"."</div>";
      $list .= "<input  type='hidden' name='shop_id' value='$shop_id'>";
      $list .= "<input  type='hidden' name='shop_name' value='$shop_name'>";
      $list .= "<input  type='hidden' name='token' value='$token'>";
      $list .= "<table>"."<tr>"."<td>"."住所:"."</td>"."<td>".$data[$i]['adress']."</td>"."</tr>";
      $list .= "<tr height='70'>"."<td>"."営業時間:"."</td>"."<td>".$data[$i]['open_time']."～".$data[$i]['close_time']."</td>"."</tr>";
      $list .= "<tr height='70'>"."<td>"."定休日:"."</td>"."<td>".$data[$i]['holiday']."</td>"."</tr>"."</table>";
      $list .= "<div class='d-flex m-3'>";
      $list .= "<input class='btn btn-outline-primary px-10 mx-3 my-1 text-center' type='submit' name='booking' value='予約する'>";
      $list .= "<input class='btn btn-outline-primary px-10 mx-3 my-1 text-center' type='submit' name='contact' value='お問い合わせ'>"."</div>";

      $box[] =  "<div class='box border'>"."<form method='POST' name='a_form' action=''>".$list."</div>"."</form>";


    //
  }
}
if (isset($_POST['submit'])) {

  $key_word = $_POST['key_word'];

  $sql_1 = "SELECT * FROM shop WHERE shop_name LIKE ? OR adress LIKE ? OR tel LIKE ? OR open_time LIKE ? OR close_time LIKE ? OR holiday LIKE ?";
  $stmt_1 = $pdo->prepare($sql_1);
  $stmt_1->bindValue(1, '%'.$key_word.'%', PDO::PARAM_STR);
  $stmt_1->bindValue(2, '%'.$key_word.'%', PDO::PARAM_STR);
  $stmt_1->bindValue(3, '%'.$key_word.'%', PDO::PARAM_STR);
  $stmt_1->bindValue(4, '%'.$key_word.'%', PDO::PARAM_STR);
  $stmt_1->bindValue(5, '%'.$key_word.'%', PDO::PARAM_STR);
  $stmt_1->bindValue(6, '%'.$key_word.'%', PDO::PARAM_STR);
  $stmt_1->execute(array('%'.$key_word.'%','%'.$key_word.'%','%'.$key_word.'%','%'.$key_word.'%','%'.$key_word.'%','%'.$key_word.'%',));
  $row_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
  if (empty($row_1)) {
    echo "<h5 class='text-end text-danger'>キーワードが未入力か存在する店舗がありません</h5>";
    for ($i=0; $i < count($data) ; $i++) {
      //

        $shop_name = $data[$i]['shop_name'];
        $shop_id = $data[$i]['id'];
        $token = htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8");
        $list = "<div class='text-center'>"."<input style='padding: 10% 30%;' class='btn mb-3' type='submit' name='main' value='$shop_name'>"."</div>";
        $list .= "<input  type='hidden' name='shop_id' value='$shop_id'>";
        $list .= "<input  type='hidden' name='shop_name' value='$shop_name'>";
        $list .= "<input  type='hidden' name='token' value='$token'>";
        $list .= "<table>"."<tr>"."<td>"."住所:"."</td>"."<td>".$data[$i]['adress']."</td>"."</tr>";
        $list .= "<tr height='70'>"."<td>"."営業時間:"."</td>"."<td>".$data[$i]['open_time']."～".$data[$i]['close_time']."</td>"."</tr>";
        $list .= "<tr height='70'>"."<td>"."定休日:"."</td>"."<td>".$data[$i]['holiday']."</td>"."</tr>"."</table>";
        $list .= "<div class='d-flex m-3'>";
        $list .= "<input class='btn btn-outline-primary px-10 mx-3 my-1 text-center' type='submit' name='booking' value='予約する'>";
        $list .= "<input class='btn btn-outline-primary px-10 mx-3 my-1 text-center' type='submit' name='contact' value='お問い合わせ'>"."</div>";

        $box[] =  "<div class='box border'>"."<form method='POST' name='a_form' action=''>".$list."</div>"."</form>";


      //
    }
  }
  for ($i=0; $i < count($row_1) ; $i++) {
    //

      $shop_name = $row_1[$i]['shop_name'];
      $shop_id = $row_1[$i]['id'];
      $token = htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8");
      $list = "<div class='text-center'>"."<input style='padding: 10% 30%;' class='btn mb-3' type='submit' name='main' value='$shop_name'>"."</div>";
      $list .= "<input  type='hidden' name='shop_id' value='$shop_id'>";
      $list .= "<input  type='hidden' name='shop_name' value='$shop_name'>";
      $list .= "<input  type='hidden' name='token' value='$token'>";
      $list .= "<table>"."<tr>"."<td>"."住所:"."</td>"."<td>".$row_1[$i]['adress']."</td>"."</tr>";
      $list .= "<tr height='70'>"."<td>"."営業時間:"."</td>"."<td>".$row_1[$i]['open_time']."～".$row_1[$i]['close_time']."</td>"."</tr>";
      $list .= "<tr height='70'>"."<td>"."定休日:"."</td>"."<td>".$row_1[$i]['holiday']."</td>"."</tr>"."</table>";
      $list .= "<div class='d-flex m-3'>";
      $list .= "<input class='btn btn-outline-primary px-10 mx-3 my-1 text-center' type='submit' name='booking' value='予約する'>";
      $list .= "<input class='btn btn-outline-primary px-10 mx-3 my-1 text-center' type='submit' name='contact' value='お問い合わせ'>"."</div>";

      $box[] =  "<div class='box border'>"."<form method='POST' name='a_form' action=''>".$list."</div>"."</form>";


    //
  }
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ユーザーページ店舗選択画面</title>
    <link href="css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
    <div align="right"  class="mr-4">
        <form class="" action="" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8") ?>">
        <input type="text"  placeholder="キーワード" name="key_word" value="">
        <input width="" class="btn  text-right" type="submit" name="submit" value="検索する">
        </form>
        <form class="" action="logout.php" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8") ?>">
        <input width="" class="btn  text-right" type="submit" name="logout" value="ログアウト">
        </form>
    </div>
    <div class="container d-flex flex-wrap mb-2 justify-content-around">
      <?php foreach ($box as $list)
          echo $list;
      ?>
    </div>
  </body>
</html>
