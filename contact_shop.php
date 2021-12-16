<?php
session_start();
$server = "localhost";
$userName = "root";
$password = "";
$dbName = "bookingsystem";

$mysqli = new mysqli($server, $userName, $password,$dbName);
require_once('shop_header.php');
if (isset($_POST["submit"])) {

  $_SESSION['contact_id'] =   $_POST["contact_id"];
  $_SESSION['contact_name'] =   $_POST["contact_name"];
  $_SESSION['contact_kana'] =   $_POST["contact_kana"];
  $_SESSION['contact_tel'] =   $_POST["contact_tel"];
  $_SESSION['contact_email'] =   $_POST["contact_email"];
  $_SESSION['contact_content'] =   $_POST["contact_content"];


header("Location: contact_detail_shop.php");  // メイン画面へ遷移
exit();
}

if ($mysqli->connect_error){
	echo $mysqli->connect_error;
	exit();
}else{
	$mysqli->set_charset("utf-8");
}

$sql = "SELECT * FROM contact";

$result = $mysqli -> query($sql);

//クエリー失敗
if(!$result) {
	echo $mysqli->error;
	exit();
}

//レコード件数
$row_count = $result->num_rows;

//連想配列で取得
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$rows[] = $row;
}

//結果セットを解放
$result->free();

// データベース切断
$mysqli->close();

?>

<html>
    <head>
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>店舗ページお問い合わせ一覧確認画面</title>
    </head>
    <body>
      <p class="text-center mt-5">お問い合わせ一覧</p>
      レコード件数：<?php echo $row_count; ?>

<table class="table  table-bordered table-striped table-detail">
<tr>
  <th>番号</th>
  <th>名前</th>
  <th>カナ</th>
  <th>電話番号</th>
  <th>メールアドレス</th>
  <th>お問い合わせ内容</th>
  <th>送信日時</th>
</tr>

<?php
foreach($rows as $row){
?>
<tr>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?></td>
	<td><?php echo htmlspecialchars($row['kana'],ENT_QUOTES,'UTF-8'); ?></td>
	<td><?php echo htmlspecialchars($row['tel'],ENT_QUOTES,'UTF-8'); ?></td>
	<td><?php echo htmlspecialchars($row['email'],ENT_QUOTES,'UTF-8'); ?></td>
	<td><?php echo htmlspecialchars($row['content'],ENT_QUOTES,'UTF-8'); ?></td>
	<td><?php echo htmlspecialchars($row['created_at'],ENT_QUOTES,'UTF-8'); ?></td>

  <td>
    <form class="" action="" method="post">
      <input type="hidden" name="contact_id" value="<?php echo $row['id']; ?>">
      <input type="hidden" name="contact_name" value="<?php echo $row['name']; ?>">
      <input type="hidden" name="contact_kana" value="<?php echo $row['kana']; ?>">
      <input type="hidden" name="contact_tel" value="<?php echo $row['tel']; ?>">
      <input type="hidden" name="contact_email" value="<?php echo $row['email']; ?>">
      <input type="hidden" name="contact_content" value="<?php echo $row['content']; ?>">
      <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" type="submit" name="submit" value="確認する"/></td>
    </form>

</tr>
<?php
}
?>

</table>
      </body>


</html>
