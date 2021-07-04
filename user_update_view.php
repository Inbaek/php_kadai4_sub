<?php

//1.外部ファイル読み込みしてDB接続(funcs2.phpを呼び出して)
require_once('funcs2.php');
$pdo = db_conn2();

//2.対象のIDを取得
$id = $_GET["id"];

//3．データ取得SQLを作成（SELECT文）
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id=:id"); //:はSQL Injection対策
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();


//4．データ表示
$view = "";
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();
    }

?>



<!-- 以下はindex.phpのHTMLをまるっと持ってくる -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
    <link href="css/toroku.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="user_list.php">ユーザー一覧</a></div>
            </div>
        </nav>
    </header>

<form method="POST" action="user_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ユーザー登録</legend>
     <div id="a"><p>ユーザー名：</p><input type="text" name="name" value="<?= $result['name']?>"></div>
     <div id="a"><p>ユーザーID：</p><input type="text" name="lid" value="<?= $result['lid']?>"></div>
     <div id="a"><p>ユーザーPW：</p><input type="text" name="lpw" value="<?= $result['lpw']?>"></div>
     <div id="a"><p>管理者ステータス：</p><input type="text" name="kanri_flg" value="<?= $result['kanri_flg']?>"></div>
     <div id="a"><p>退社・入社：</p><input type="text" name="life_flg" value="<?= $result['life_flg']?>"></div>
     <input type="hidden" name="id" value="<?= $result ['id']?>">
     <input id="b" type="submit" value="更新">
    </fieldset>
  </div>
</form>

</body>

</html>