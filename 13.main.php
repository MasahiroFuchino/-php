<?php
session_start();

if (!isset($_SESSION['id'])){
    $_SESSION = array();
    session_destroy();
    session_start();
    $_SESSION['error_status'] = 2;
    redirect_to_login();
    exit();
  }
if (!isset($_SESSION['shop_id'])){
    $_SESSION['error_status'] = 2;
    redirect_to_welcome();
    exit();
  }
require_once('login_function.php');
// CSRF チェック

require_once("user_header.php");

try {
  $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
  //プレースホルダで SQL 作成
  $sql_1 = "SELECT * FROM shop WHERE id = ?;";
  $stmt_1 = $pdo->prepare($sql_1);
  $stmt_1->bindValue(1, $_SESSION['shop_id'], PDO::PARAM_STR);
  $stmt_1->execute();
  $row_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);

} catch (\Exception $e) {

}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <title>メイン</title>
    </head>
    <body>
      <p>ようこそ<?php echo htmlspecialchars($_SESSION["name"], ENT_QUOTES); ?>さん</p>
      <div class="text-cennter container ">
        <img src="https://media.istockphoto.com/vectors/stamprsimp2red-vector-id1096052566?s=612x612" alt="">
        <p><?php echo $row_1[0]['shop_name']?></p>
        <p><?php echo $row_1[0]['tel']?></p>
        <p><?php echo $row_1[0]['adress']?></p>
        <p><?php echo $row_1[0]['open_time']."～".$row_1[0]['close_time']?></p>
      </div>
    </body>
  </html>
