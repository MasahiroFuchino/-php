<html>
    <head>
    	<link href="css/bootstrap.css" rel="stylesheet">
        <title>管理店舗情報編集画面</title>
    </head>
    <body>
        <form class="w-25 mx-auto" th:action="@{/login}" method="post">
           	<label class="mt-5" for="username">店舗名</label>
           	<input class="form-control" id="username"
           			type="text" name="username" placeholder="名前"
           			required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    ※店舗名を入力してください
                </div>
            <label for="username">住所</label>
            <input class="form-control" id="adress"
               	type="text" name="kana" placeholder="住所"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    ※店舗住所を入力してください
                </div>
            <label for="username">電話番号</label>
            <input class="form-control" id="tel"
               	type="tel" name="tel" placeholder="電話番号"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    ※店舗電話番号を入力してください
                </div>
            <label for="username">店舗メールアドレス</label>
            <input class="form-control" id="mail"
               	type="mail" name="mail" placeholder="メールアドレス"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    ※店舗メールアドレスを入力してください
                </div>
            <label for="username">店舗パスワード</label>
            <input class="form-control" id="password"
               	type="password" name="password" placeholder="パスワード"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    ※店舗パスワードが未入力です
                </div>
            <label for="username">確認用パスワード</label>
            <input class="form-control" id="password"
               	type="password" name="password" placeholder="確認用パスワード"
               	required autofocus/>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    ※確認用パスワードが未入力です
                </div>
                <div class="alert alert-danger" role="alert" th:if="${param.error}">
                    ※パスワードが確認用パスワードと違います
                </div>
                <label for="username">店舗レーン数</label>
                <input class="form-control" id="lane"
                   	type="password" name="password" placeholder="レーン数"
                   	required autofocus/>
                    <div class="alert alert-danger" role="alert" th:if="${param.error}">
                        ※レーン数を入力してください
                    </div>
                <label for="username">店舗開店時間</label>
                <input class="form-control" id="open"
                   	type="password" name="password" placeholder="開店時間"
                   	required autofocus/>
                    <div class="alert alert-danger" role="alert" th:if="${param.error}">
                        ※開店時間を入力してください
                    </div>
                <label for="username">店舗閉店時間</label>
                <input class="form-control" id="close"
                   	type="password" name="password" placeholder="閉店時間"
                   	required autofocus/>
                    <div class="alert alert-danger" role="alert" th:if="${param.error}">
                        ※閉店時間を入力してください
                    </div>
                <label for="username">店舗定休日</label>
                <div class="text-center custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="custom-check-1">
                  <label class="custom-control-label" for="custom-check-1">月<span class="text-danger">※編集後の日付に予約があります</span></label>
                </div>
                <div class="text-center custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="custom-check-2">
                  <label class="custom-control-label" for="custom-check-2">火<span class="text-danger">※編集後の日付に予約があります</span></label>
                </div>
                <div class="text-center custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="custom-check-3">
                  <label class="custom-control-label" for="custom-check-3">水<span class="text-danger">※編集後の日付に予約があります</span></label>
                </div>
                <div class="text-center custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="custom-check-4">
                  <label class="custom-control-label" for="custom-check-3">木<span class="text-danger">※編集後の日付に予約があります</span></label>
                </div>
                <div class="text-center custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="custom-check-5">
                  <label class="custom-control-label" for="custom-check-3">金<span class="text-danger">※編集後の日付に予約があります</span></label>
                </div>
                <div class="text-center custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="custom-check-6">
                  <label class="custom-control-label" for="custom-check-3">土<span class="text-danger">※編集後の日付に予約があります</span></label>
                </div>
                <div class="text-center custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="custom-check-7">
                  <label class="custom-control-label" for="custom-check-3">日<span class="text-danger">※編集後の日付に予約があります</span></label>
                </div>
                <div class="text-center mt-5 form-group row justify-content-center">
                <div class>
                    <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" type="submit" value="戻る"/>
                    <input class="btn btn-outline-primary mx-3 my-1" type="submit" value="編集する"/>
                </div>
              </div>

        </form>
    </body>
</html>
