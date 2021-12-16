<html>
    <head>
    	<link href="css/bootstrap.css" rel="stylesheet">
        <title>ユーザー新規予約変更画面</title>
    </head>
    <body>
      <form class="w-25 mx-auto" th:action="@{/login}" method="post">
          <label class="mt-3">予約日</label>
          <input class="form-control mt-2 text-center"
              type="text" name="day" value="2021/11/11"
              required autofocus/>
          <label class="mt-3">予約時間</label>
          <input class="form-control mt-2 text-center"
              type="text" name="time" value="11:00"
              required/>
          <label class="mt-3">内容</label>
          <textarea class="form-control mt-2 mb-5" name="content" rows="8" cols="50"></textarea>
          <div class="text-center form-group row justify-content-center">
          <div class>
              <input class="btn btn-outline-primary px-10 mx-3 my-1 text-center" type="submit" value="戻る"/>
              <input class="btn btn-outline-primary mx-3 my-1" type="submit" value="変更する"/>
          </div>
        </div>


      </form>
      </body>

</html>
