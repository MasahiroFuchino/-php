<?php
// セッション開始
session_start();
$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bookingsystem";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessagename = "";
$errorMessageadress = "";
$errorMessagetel = "";
$errorMessageemail = "";
$errorMessagepassword = "";
$errorMessagepassword2 = "";
$errorMessageflame = "";
$errorMessageopen = "";
$errorMessageclose = "";
$errorMessageholiday = "";


if (isset($_POST["back"])) {
  header("Location: login.php");  // メイン画面へ遷移

}
// 登録ボタンが押された場合
if (isset($_POST["submit"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["name"])) {
      $errorMessagename = '名前が未入力です。';

    }
     if (empty($_POST["adress"])) {
      $errorMessageadress = '住所が未入力です。';
    }
     if (empty($_POST["tel"])) {
      $errorMessagetel = '電話番号が未入力です。';
    }

     if (empty($_POST["email"])) {  // 値が空のとき
        $errorMessageemail = 'メールアドレスが未入力です。';
    }
     if (empty($_POST["password"])) {
        $errorMessagepassword = 'パスワードが未入力です。';
    }
     if (empty($_POST["password2"])) {
        $errorMessagepassword2 = 'パスワードが未入力です。';
    }
     if($_POST["password"] != $_POST["password2"]) {
      $errorMessage = 'パスワードに誤りがあります。';}
     if (empty($_POST["monday"] && $_POST["tuesday"] && $_POST["wednesday"] && $_POST["thursday"] && $_POST["friday"] && $_POST["saturday"] && $_POST["sunday"] )) {
       $errorMessageholiday = "定休日を選んでください";
     }
    if (!empty($_POST["name"]) && !empty($_POST["kana"]) && !empty($_POST["tel"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {

        // 入力したユーザIDとパスワードを格納
        $name = $_POST["name"];
        $kana = $_POST["kana"];
        $tel = $_POST["tel"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // 2. ユーザIDとパスワードが入力されていたら認証する

                    // 入力したIDのユーザー名を取得
                    //DBのユーザー情報をセッションに保存
                     $_SESSION['name'] = $name;
                     $_SESSION['kana'] = $kana;
                     $_SESSION['tel'] = $tel;
                     $_SESSION['email'] = $email;
                     $_SESSION['password'] = $password;

            header("Location: signup_confirm.php");  // メイン画面へ遷移
            exit();

            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();


    }
}

?>

<html>
    <head>
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>管理者新規店舗登録画面</title>
    </head>
    <body>
      <div class="container w-100">
        <form class="w-100 mx-auto d-flex  flex-wrap mb-2" action="" method="post">
          <div class="w-50 px-5">
            <label class="" for="username">店舗名</label>
           	<input class="form-control" id="username"
           			type="text" name="username" placeholder="名前"
           			required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessagename, ENT_QUOTES); ?>
                </div>
          </div>
          <div class="w-50 px-5">
            <label for="username">住所</label>
            <input class="form-control" id="adress"
               	type="text" name="adress" placeholder="住所"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessageadress, ENT_QUOTES); ?>
                </div>
          </div>
          <div class="w-50 px-5">
            <label for="username">電話番号</label>
            <input class="form-control" id="tel"
               	type="tel" name="tel" placeholder="電話番号"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessagetel, ENT_QUOTES); ?>
                </div>
          </div>
          <div class="w-50 px-5">
            <label for="username">店舗メールアドレス</label>
            <input class="form-control" id="mail"
               	type="mail" name="email" placeholder="メールアドレス"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessageemail, ENT_QUOTES); ?>
                </div>
          </div>
          <div class="w-50 px-5">
            <label for="username">店舗パスワード</label>
            <input class="form-control" id="password"
               	type="password" name="password" placeholder="パスワード"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessagepassword, ENT_QUOTES); ?>
                </div>
          </div>
          <div class="w-50 px-5">
            <label for="username">確認用パスワード</label>
            <input class="form-control" id="password"
               	type="password" name="password2" placeholder="確認用パスワード"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    <?php echo htmlspecialchars($errorMessagepassword2, ENT_QUOTES); ?>
                </div>
          </div>
          <div class="w-100 px-5 ">
            <label for="time_shift">対応時間枠</label>
            <div id="time_shift" class="d-flex  flex-wrap mb-2">

              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-1" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-1">7:00~8:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-2" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-2">8:00~9:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-3" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-3">9:00~10:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-4" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-4">10:00~11:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-5" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-5">11:00~12:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-6" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-6">12:00~13:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-7" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-7">13:00~14:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-8" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-8">14:00~15:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-9" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-9">15:00~16:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-10" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-10">16:00~17:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-11" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-11">17:00~18:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-12" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-12">18:00~19:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-13" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-13">19:00~20:00</label>
              </div>
              <div class="w-20 px-5">
                <input class="custom-control-input" id="check-14" type="checkbox" name="flame"  required autofocus/>
                <label class="custom-control-label" for="check-14">20:00~21:00</label>
              </div>

            </div>
          </div>

          <div class="">
            <label for="username">店舗開店時間</label>
            <input class="form-control" id="open"
                type="password" name="opren" placeholder="開店時間"
                required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    ※開店時間を入力してください
                </div>
          </div>
          <div class="">
            <label for="username">店舗閉店時間</label>
            <input class="form-control" id="close"
                type="password" name="close" placeholder="閉店時間"
                required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    ※閉店時間を入力してください
                </div>
          </div>
          <div class="">
            <label for="username">店舗定休日</label>
            <div class="text-center custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name='monday' id="custom-check-1">
              <label class="custom-control-label" for="custom-check-1">月</label>
            </div>
            <div class="text-center custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name='tuesday' id="custom-check-2">
              <label class="custom-control-label" for="custom-check-2">火</label>
            </div>
            <div class="text-center custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name='wednesday' id="custom-check-3">
              <label class="custom-control-label" for="custom-check-3">水</label>
            </div>
            <div class="text-center custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name='thursday' id="custom-check-4">
              <label class="custom-control-label" for="custom-check-3">木</label>
            </div>
            <div class="text-center custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name='friday' id="custom-check-5">
              <label class="custom-control-label" for="custom-check-3">金</label>
            </div>
            <div class="text-center custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name='saturday' id="custom-check-6">
              <label class="custom-control-label" for="custom-check-3">土</label>
            </div>
            <div class="text-center custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name='sunday' id="custom-check-7">
              <label class="custom-control-label" for="custom-check-3">日</label>
            </div>
            <div class="mt-5 form-group row justify-content-center">
            <div class>
                <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" type="submit" value="戻る"/>
                <input class="btn btn-outline-primary mx-3 my-1" type="submit" value="登録する"/>
            </div>
          </div>

          </div>

        </form>
      </div>

    </body>
</html>
